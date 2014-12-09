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
		//�ϴ��ļ���ָ��·�����ͻ��˷������ϵ�λ��
        $path= $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/';
        if(is_uploaded_file($_FILES['fname']['tmp_name'])){
	       //move_uploaded_file($_FILES['fname']['tmp_name'], $path.$_FILES['fname']['name']);
	       $name=$_FILES['fname']['name'];
        }
        //session���ݲ���
        $this->session->set_userdata('path',$path);
        $this->session->set_userdata('filename',$name);       
        //echo '<script type="text/javascript" language="javascript">alert("�ϴ���ɣ�");</script>'; */
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
		
		$this->load->helper('download'); //CI�Դ��������ļ�����
		$url_download = $this->config->item('base_url').'tmp/'.$filename;//���url���������� //$this->config->item('base_url')
		$data = file_get_contents($url_download);
		force_download($filename, $data);

		/*$url_download = $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/'.$filename; //����CI�Դ�����ʱ���������URL
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
		//---------------------���ݷ�Χ�ļ����ɵ���ҳ��������-----------------------------
		$parsvalarr= array();
		$path =$this->config->item('base_url').'uploads/';
		$filename ='changepar.dat';
		$inputfile = fopen($path.$filename,"r");
		while(! feof($inputfile)) 
		{
			$line=fgets($inputfile);
			if(strpos($line, 'low') !== false ||strpos($line, 'up') !== false || empty($line)){
				
			}else{
				$linearr =preg_split("/[\s,]+/" ,$line); //��������ʽ���ָ��ַ���������" ", \r, \t, \n, \f����ҳ�����ָ�����
				//echo "low:".$linearr[6]."\r\n";
				srand(microtime(true) * 1000);
				$randvalue = rand($linearr[1],$linearr[2]);
				//$linenew = $linearr[1]."   ".$linearr[2]."   ".$randvalue."   ".$linearr[6]."\r\n";
				$parsvalarr[$linearr[6]] =$randvalue; //���Ԫ�ص�����
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
		$parsValArr = explode(" ",trim($parsValStr)); //��ȥ���ַ���ǰ��ո��ٽ�ֵ�ָ������
		$path = $this->config->item('base_url').'uploads/';
		$filename ='inputPar.dat';
        $inputfile = fopen($path.$filename,"r");
        $path1 = $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/';
        if(! is_dir($path1)){ //Ŀ¼�����ڣ��ʹ���
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
		$this->load->library('pagination');//���ط�ҳ��
        $config['base_url'] = base_url().'index.php/home/inquriy_Historyjob';//���÷�ҳ��url·��
        $config['total_rows'] = $maxujid;//�õ��������е���ҵ������
        $config['per_page'] = '20';//ÿҳ��¼��
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//��ҳ�ĳ�ʼ��
        $data["jobs_list_arr"] = $this->xml_process_model->find_job_by_offset($config['per_page'],$this->uri->segment(3));//�õ���ҵ��¼
        $this->load->view('history_jobs',$data); 
        
		/*$md5secret = $this->session->userdata['md5secret'];   	
        $cookiefile = $this->session->userdata['cookiefile'];        
        
        $time=time();
        $timestamp = "timestamp=$time"."000";
        $offset='offset=0';
        $length='length=30';//������ʾ����ҵ��   ������Ϸ�ҳ����ujid�йأ�����ujid��Ϊ��ҵ��
        $B4md5=$length.$offset.$timestamp.$md5secret;
        $Domd5=md5($B4md5);
        $md5=$length.'&'.$offset.'&'.$timestamp."&md5sum=".$Domd5;
        
        $url_inquiryjob='http://rest.scgrid.cn:8080/sceapi-rest/restv0/jobs?'.$md5;
        //$url_inquiryjob='http://159.226.49.157:8080/restapi2/restv0/jobs?'.$md5; api.scgrid.cn:8080/sceapi-rest/restv0
        $req_inquiryjob = curl_init($url_inquiryjob);
        curl_setopt($req_inquiryjob, CURLOPT_HEADER, false);
        curl_setopt($req_inquiryjob, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
        curl_setopt($req_inquiryjob, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req_inquiryjob , CURLOPT_COOKIEJAR,  $cookiefile);  //���棬������һ��Ҫ�ȱ����ڶ�ȡ����Ȼ����
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
	        //echo $exec_inquiryjob; //�����ӡ��API���������ص���ʷ��ҵ��Ϣ��ȫ������
	        //echo "md5secret:".$md5secret;
	        $data["jobs_list_arr"]=$json_inquiryjob['jobs_list'];
	        $this->load->view('history_jobs',$data); 
        }  */
       
	}
	
}
