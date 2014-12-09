<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('util');
    }
	
	public function index()
	{
		if ($this->session->userdata('username')!=null){
		    $this->load->view('home');
		}else{
			$this->load->view('login');
		}
	}
	
	public function uploadfile($filename)
	{
		$path= $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/';
		$this->session->set_userdata('path',$path);
		$this->session->set_userdata('filename',$filename);
		/*
		//上传文件到指定路径，客户端服务器上的位置
        $path= $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/';
        if(is_uploaded_file($_FILES['fname']['tmp_name'])){
	       //move_uploaded_file($_FILES['fname']['tmp_name'], $path.$_FILES['fname']['name']);
	       $name=$_FILES['fname']['name'];
        }
        //session传递参数
        $this->session->set_userdata('path',$path);
        $this->session->set_userdata('filename',$name);       
        //echo '<script type="text/javascript" language="javascript">alert("上传完成！");</script>'; */
	}
	
	public function introduce_platform(){
		$this->load->view('about_platform');
	}
	
	public function download_software(){
		$this->load->view('software_download');
	}
	
	public function download($filename){		
		header('content-type:text/html; charset=gb2312');
		$str =$this->session->userdata('username')."      ".$_POST['realname']."      ".$_POST['mailbox']."      ".$_POST['gender']."      ".$_POST['department']."     ".$_POST['academic-title'];
		$path= $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/';
		$file=fopen($path.'downloadPSWATUser.txt','a');
		fwrite($file,$str.PHP_EOL);
		fclose($file);	
		
		$this->load->helper('download'); //CI自带的下载文件代码
		$url_download = $this->config->item('base_url').'tmp/'.$filename;//这个url不能在这用 //$this->config->item('base_url')
		$data = file_get_contents($url_download);
		force_download($filename, $data);

		/*$url_download = $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/'.$filename; //不用CI自带下载时，就用这个URL
		if (!file_exists($url_download)){
			header("Content-type: text/html; charset=utf-8");
			echo "File not found!";
			exit;
        }else{
	        $file = @fopen($url_download, 'r'); 
	        header("Content-Type:application/octet-stream");     
	        header("Accept-Ranges:bytes");   
	        header("Accept-Length:".filesize($url_download));   
	        header("Content-Disposition:attachment;filename=".$filename);   
	        echo fread($file,filesize($url_download));   
	        fclose($file);
		}*/
	}
	
	public function submit_pswat(){
		//---------------------根据范围文件生成调参页面的随机数-----------------------------
		$parsvalarr= array();
		$path =$this->config->item('base_url').'uploads/';
		$filename ='changepar.dat';
		$inputfile = fopen($path.$filename,"r");
		while(! feof($inputfile)) 
		{
			$line=fgets($inputfile);
			if(strpos($line, 'low') !== false ||strpos($line, 'up') !== false || empty($line)){
				
			}else{
				$linearr =preg_split("/[\s,]+/" ,$line); //用正则表达式来分割字符串，包含" ", \r, \t, \n, \f（换页符）分隔短语
				//echo "low:".$linearr[6]."\r\n";
				srand(microtime(true) * 1000);
				$randvalue = rand($linearr[1],$linearr[2]);
				//$linenew = $linearr[1]."   ".$linearr[2]."   ".$randvalue."   ".$linearr[6]."\r\n";
				$parsvalarr[$linearr[6]] =$randvalue; //添加元素到数组
			}
		}
		fclose($inputfile);
		$data['allparsvalue'] = $parsvalarr;
		$this->load->view('submit_pswat',$data);
	}
	
	public function multi_submit(){
		$this->load->view('multi_submit');
	}
	
	public function save_edits(){		
		$parsValStr = $_GET['parsStr'];
		$this->session->set_userdata('parsStr',trim($parsValStr));
		$parsValArr = explode(" ",trim($parsValStr)); //先去掉字符串前后空格，再将值分割成数组
		$path = $this->config->item('base_url').'uploads/';
		$filename ='inputPar.dat';
        $inputfile = fopen($path.$filename,"r");
        $path1 = $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/';
        if(! is_dir($path1)){ //目录不存在，就创建
        	mkdir($path1,0777,true);
        }
		$lastfilename ='inputParTest.dat';
        $lastinputfile = fopen($path1.$lastfilename,"w+");
        $num =0;
        while(! feof($inputfile)) 
        {
        	$line=fgets($inputfile);
	        if(empty($line)){
		        
	        }else{
		        $linearr = explode("   " ,$line);
		        $parvalue = $parsValArr[$num];
		        //echo "test".$linearr[1];
		        $linenew = $linearr[0]."   ".$linearr[1]."   ".$parvalue."   ".$linearr[3];
		        fputs($lastinputfile,$linenew);
		        $num++;
	        }
        }
        fclose($inputfile);
        fclose($lastinputfile);
		echo "Save Edits Successfully!"; 
	}
	
	private function _getMaxUjid(){
		$md5secret = $this->session->userdata['md5secret'];   	
        $cookiefile = $this->session->userdata['cookiefile'];        
        
        $time=time();
        $timestamp = "timestamp=$time"."000";
        $offset='offset=0';
        $length='length=30';
        $B4md5=$length.$offset.$timestamp.$md5secret;
        $Domd5=md5($B4md5);
        $md5=$length.'&'.$offset.'&'.$timestamp."&md5sum=".$Domd5;
        
        $url_inquiryjob='http://rest.scgrid.cn/sceapi-rest/restv0/jobs?'.$md5;
        $req_inquiryjob = curl_init($url_inquiryjob);
        curl_setopt($req_inquiryjob, CURLOPT_HEADER, false);
        curl_setopt($req_inquiryjob, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
        curl_setopt($req_inquiryjob, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req_inquiryjob , CURLOPT_COOKIEJAR,  $cookiefile);
        curl_setopt($req_inquiryjob, CURLOPT_COOKIEFILE, $cookiefile);
        $exec_inquiryjob  = curl_exec($req_inquiryjob);
        $returncode_inquiryjob = curl_getinfo($req_inquiryjob, CURLINFO_HTTP_CODE);
        curl_close($req_inquiryjob) ;
        $json_inquiryjob = json_decode($exec_inquiryjob, true); 
         
        if ($exec_inquiryjob === false || $returncode_inquiryjob != 200) {
	        return "No cURL data returned!";
        }else {
	        $jobsList=$json_inquiryjob['jobs_list'];
	        if((!empty($jobsList)) && count($jobsList) >0){
	        	$firstRecord =$jobsList[0];
	            return $firstRecord['ujid'];
	        }else{
	            return 0;
	        }
        } 
	}
	
	public function inquriy_Historyjob(){
		$maxujid =$this->_getMaxUjid();
		if(!is_numeric($maxujid)){
			$maxujid =0;
		}
		$this->load->model('xml_process_model');
		$this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/home/inquriy_Historyjob';//设置分页的url路径
        $config['total_rows'] = $maxujid;//得到服务器中的作业的总数
        $config['per_page'] = '20';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data["jobs_list_arr"] = $this->xml_process_model->find_job_by_offset($config['per_page'],$this->uri->segment(3));//得到作业记录
        $this->load->view('history_jobs',$data); 
        
		/*$md5secret = $this->session->userdata['md5secret'];   	
        $cookiefile = $this->session->userdata['cookiefile'];        
        
        $time=time();
        $timestamp = "timestamp=$time"."000";
        $offset='offset=0';
        $length='length=30';//设置显示的作业数   后面加上分页，和ujid有关，最大的ujid即为作业数
        $B4md5=$length.$offset.$timestamp.$md5secret;
        $Domd5=md5($B4md5);
        $md5=$length.'&'.$offset.'&'.$timestamp."&md5sum=".$Domd5;
        
        $url_inquiryjob='http://rest.scgrid.cn:8080/sceapi-rest/restv0/jobs?'.$md5;
        //$url_inquiryjob='http://159.226.49.157:8080/restapi2/restv0/jobs?'.$md5; api.scgrid.cn:8080/sceapi-rest/restv0
        $req_inquiryjob = curl_init($url_inquiryjob);
        curl_setopt($req_inquiryjob, CURLOPT_HEADER, false);
        curl_setopt($req_inquiryjob, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
        curl_setopt($req_inquiryjob, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req_inquiryjob , CURLOPT_COOKIEJAR,  $cookiefile);  //保存，这里面一定要先保存在读取，不然出错
        curl_setopt($req_inquiryjob, CURLOPT_COOKIEFILE, $cookiefile);
        $exec_inquiryjob  = curl_exec($req_inquiryjob);
        $returncode_inquiryjob = curl_getinfo($req_inquiryjob, CURLINFO_HTTP_CODE);
        curl_close($req_inquiryjob) ;
        $json_inquiryjob = json_decode($exec_inquiryjob, true); 
         
        if ($exec_inquiryjob === false || $returncode_inquiryjob != 200) {
	        echo "No cURL data returned!";
	        if (curl_error($req_inquiryjob))
		        echo "\n". curl_error($req_inquiryjob);
        }else {
	        //echo $exec_inquiryjob; //这里打印出API服务器返回的历史作业信息的全部内容
	        //echo "md5secret:".$md5secret;
	        $data["jobs_list_arr"]=$json_inquiryjob['jobs_list'];
	        $this->load->view('history_jobs',$data); 
        }  */
       
	}
	
}
