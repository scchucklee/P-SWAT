<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquiryqueue extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('util');
    }
    
    public function index()
	{
		$this->load->view('home');
	}
	
	//��ѯ���õĿ��ж���
    public function inquiryavailablequeue($walltime,$corenum,$chosedAppStr){
    	
    	//��ȡcookie��md5secret
        $md5secret =  $this->session->userdata('md5secret');
        $cookiefile =  $this->session->userdata('cookiefile');
        //echo "<p>test:".$walltime.$md5secret."</p>";
        
        //session���ݲ���
        $this->session->set_userdata('corenum',$corenum);
        $this->session->set_userdata('walltime',$walltime);
        $this->session->set_userdata('chosedAppStr',$chosedAppStr);
        
        if($chosedAppStr ==""){
        	echo "����ѡ��ĳ��Ӧ�ã�";
        }
        $appNameArr = explode("_",$chosedAppStr); 
        $appName = $appNameArr[0];
        $appName = 'gaussian';
        //��������ʱ������Ķ��в�ѯ���� 
        $corenum='corenum='.$corenum;
        $walltime='walltime='.$walltime;

        //����$md5
        $time=time();
        $timestamp = "timestamp=$time"."000";
        $B4md5=$corenum.$timestamp.$walltime.$md5secret;
        $Domd5=md5($B4md5);
        $md5=$corenum.'&'.$walltime.'&'.$timestamp."&md5sum=".$Domd5;


        //���Ͳ�ѯ������Դ������
        $url_queue_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/resources/applications/'.$appName.'?'.$md5;
        //$url_queue_Gaussian='http://159.226.49.157:8080/restapi2/restv0/resources/applications/gaussian?'.$md5;

        $req_queue_Gaussian = curl_init($url_queue_Gaussian);
        curl_setopt($req_queue_Gaussian, CURLOPT_HEADER, false);
        curl_setopt($req_queue_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
        curl_setopt($req_queue_Gaussian, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req_queue_Gaussian , CURLOPT_COOKIEJAR,  $cookiefile);  //���棬������һ��Ҫ�ȱ����ڶ�ȡ����Ȼ����
        curl_setopt($req_queue_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
        $exec_queue_Gaussian = curl_exec($req_queue_Gaussian);
        $returncode_queue_Gaussian = curl_getinfo($req_queue_Gaussian, CURLINFO_HTTP_CODE);
        curl_close($req_queue_Gaussian) ;
        $json_exec_queue = json_decode($exec_queue_Gaussian, true);
        //echo $exec_queue_Gaussian;
        
        $arr=$json_exec_queue['apps_list'];
        foreach($arr as $val){

	       $a=array('queuename'=>$val['queuename'],'hostname'=>$val['hpcname']);
	       $b=$val['hpcname'];
	       $c=$val['queuename'];
	       $jsonTest=json_encode($a);
	       echo "<input type='radio' name='resources' class='marginTopRight' value='$jsonTest'/>".$a['queuename'];
        }
     
    }
    
    //�ύ��������
    public function submitjob(){
    	
	    $md5secret = $this->session->userdata['md5secret'];
	    $cookiefile = $this->session->userdata['cookiefile'];
	    $path = $this->session->userdata['path'];
	    $filename = $this->session->userdata['filename'];
	
       if(isset($_POST["submitjob"])){   //�ж��Ƿ��ύ����

	   //include xml_Gaussian.php;
	   include_once("xml_Gaussian.php");
	   $XML_content = file_get_contents($xmlpath); //�õ��ļ�������--����һ���ַ�����
	   $jsdlContent_arr=array('jsdlContent'=>$XML_content);
	   $jsdlContent=json_encode($jsdlContent_arr);
       //echo $jsdlContent;
	   $time=time();	
	   $timestamp = "timestamp=$time"."000";
	   $B4md5=$timestamp.$md5secret;
	   $Domd5=md5($B4md5);
	   $md5=$timestamp."&md5sum=".$Domd5;
	
	   //��ҵ�ύ����xml�ļ�
	   $url_json_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/jobs?'.$md5;
	   $req_json_Gaussian= curl_init($url_json_Gaussian);
	   curl_setopt($req_json_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_json_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_json_Gaussian , CURLOPT_COOKIEJAR, $cookiefile);  //����
	   curl_setopt($req_json_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);;
	   curl_setopt($req_json_Gaussian, CURLOPT_HTTPHEADER, array("Content-Type:application/json","accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_json_Gaussian, CURLOPT_POST, 1);
	   curl_setopt($req_json_Gaussian, CURLOPT_POSTFIELDS, $jsdlContent);
	   $exec_json_Gaussian = curl_exec($req_json_Gaussian);
	   $returncode_json_Gaussian = curl_getinfo($req_json_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_json_Gaussian);

	   //������ȡ����guid��uid
	   $json_exec_json= json_decode($exec_json_Gaussian, true); 
	   //echo $exec_json_Gaussian;
	   $gid=$json_exec_json ['gidujid']['gid'];
	   $ujid=$json_exec_json ['gidujid']['ujid'];
	
	   //�ϴ������ļ���api������
	   $file=realpath($path.$filename);
	   $fields['f'] = '@'.$file;

	   //APIbug��ֻ�ܴ���gid����ȥ
	   $url_upload_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/data/jobs/'.$gid.'/cs?'.$md5;
	   $req_upload_Gaussian = curl_init($url_upload_Gaussian);
	
	   curl_setopt($req_upload_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_upload_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_upload_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_upload_Gaussian , CURLOPT_COOKIEJAR,  $cookiefile);  //����
	   curl_setopt($req_upload_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   //put��ʽ�����ݣ�POST��ʽ�����ݵ�ʱ��api�������Ǳ���bug,2013.8.23֮ǰ
	   //2013.8.23֮��ֻ����POST��ʽ�ˣ�������ע�͵�����һ��
	   //curl_setopt($req_upload_Gaussian, CURLOPT_CUSTOMREQUEST, 'PUT');
	   curl_setopt($req_upload_Gaussian, CURLOPT_POSTFIELDS, $fields);
	
	   $exec_upload_Gaussian = curl_exec($req_upload_Gaussian);
	   $returncode_upload_Gaussian = curl_getinfo($req_upload_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_upload_Gaussian) ;
	   //echo $exec_upload_Gaussian. "<br />";

       //�޸���ҵ״̬��������ҵִ��
	   $time=time();
	   $timestamp = "timestamp=$time"."000";
	   $job_start='job_status=start';
	   $B4md5=$job_start.$timestamp.$md5secret;
	   $Domd5=md5($B4md5);
	   $md5=$job_start.'&'.$timestamp."&md5sum=".$Domd5;

	   $url_changeState_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/jobs/'.$ujid.'/status?'.$md5;
	   $req_changeState_Gaussian = curl_init($url_changeState_Gaussian);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_changeState_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEJAR, $cookiefile);  //����
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_CUSTOMREQUEST, 'PUT'); //��������ʽ
	   $exec_changeState_Gaussian = curl_exec($req_changeState_Gaussian);
	   curl_close($req_changeState_Gaussian);
	   //�����������ȡ��ȡ�ķ�����Ϣ����ʾ���û��ύ�ɹ����
	   //echo $exec_changeState_Gaussian. "<br />";
	
	   $json_start_job = json_decode($exec_changeState_Gaussian, true);
	   $start_job_status=$json_start_job['status_code'];
	  
	   if($start_job_status=="0"){
		  echo '<script type="text/javascript" language="javascript">alert("��ҵ�ύ�ɹ���");location.href="index";</script>';
	   }else{ 
		  echo '<script type="text/javascript" language="javascript">alert("��ҵ�ύʧ�ܣ�");location.href="index";</script>';
       }
      } 
    
    }
    
    //�ύÿ�������˽�к���--�����ύ�õ���
    private function _submitJob($i){
    	$md5secret = $this->session->userdata['md5secret'];
	    $cookiefile = $this->session->userdata['cookiefile'];
	    $path = $this->session->userdata['path'];
	    $filename = $this->session->userdata['filename'];
        
        $filearr = explode(".",$filename);
        $filenamelast = $filearr[0].$i.".".$filearr[1];
	   //include xml_Gaussian.php;
	   include("xml_Gaussian.php");
	   $XML_content = file_get_contents($xmlpath); //�õ��ļ�������--����һ���ַ�����
	   $jsdlContent_arr=array('jsdlContent'=>$XML_content);
	   $jsdlContent=json_encode($jsdlContent_arr);
       //echo $jsdlContent;
	   $time=time();	
	   $timestamp = "timestamp=$time"."000";
	   $B4md5=$timestamp.$md5secret;
	   $Domd5=md5($B4md5);
	   $md5=$timestamp."&md5sum=".$Domd5;
	
	   //��ҵ�ύ����xml�ļ�
	   $url_json_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/jobs?'.$md5;
	   $req_json_Gaussian= curl_init($url_json_Gaussian);
	   curl_setopt($req_json_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_json_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_json_Gaussian , CURLOPT_COOKIEJAR, $cookiefile);  //����
	   curl_setopt($req_json_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);;
	   curl_setopt($req_json_Gaussian, CURLOPT_HTTPHEADER, array("Content-Type:application/json","accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_json_Gaussian, CURLOPT_POST, 1);
	   curl_setopt($req_json_Gaussian, CURLOPT_POSTFIELDS, $jsdlContent);
	   $exec_json_Gaussian = curl_exec($req_json_Gaussian);
	   $returncode_json_Gaussian = curl_getinfo($req_json_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_json_Gaussian);

	   //������ȡ����guid��uid
	   $json_exec_json= json_decode($exec_json_Gaussian, true); 
	   //echo $exec_json_Gaussian;
	   $gid=$json_exec_json ['gidujid']['gid'];
	   $ujid=$json_exec_json ['gidujid']['ujid'];
	
	   //�ϴ������ļ���api������
	   $file=realpath($path.$filenamelast);
	   $fields['f'] = '@'.$file;

	   //APIbug��ֻ�ܴ���gid����ȥ
	   $url_upload_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/data/jobs/'.$gid.'/cs?'.$md5;
	   $req_upload_Gaussian = curl_init($url_upload_Gaussian);
	
	   curl_setopt($req_upload_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_upload_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_upload_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_upload_Gaussian , CURLOPT_COOKIEJAR,  $cookiefile);  //����
	   curl_setopt($req_upload_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   //put��ʽ�����ݣ�POST��ʽ�����ݵ�ʱ��api�������Ǳ���bug,2013.8.23֮ǰ
	   //2013.8.23֮��ֻ����POST��ʽ�ˣ�������ע�͵�����һ��
	   //curl_setopt($req_upload_Gaussian, CURLOPT_CUSTOMREQUEST, 'PUT');
	   curl_setopt($req_upload_Gaussian, CURLOPT_POSTFIELDS, $fields);
	
	   $exec_upload_Gaussian = curl_exec($req_upload_Gaussian);
	   $returncode_upload_Gaussian = curl_getinfo($req_upload_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_upload_Gaussian) ;
	   //echo $exec_upload_Gaussian. "<br />";

       //�޸���ҵ״̬��������ҵִ��
	   $time=time();
	   $timestamp = "timestamp=$time"."000";
	   $job_start='job_status=start';
	   $B4md5=$job_start.$timestamp.$md5secret;
	   $Domd5=md5($B4md5);
	   $md5=$job_start.'&'.$timestamp."&md5sum=".$Domd5;

	   $url_changeState_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/jobs/'.$ujid.'/status?'.$md5;
	   $req_changeState_Gaussian = curl_init($url_changeState_Gaussian);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_changeState_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEJAR, $cookiefile);  //����
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_CUSTOMREQUEST, 'PUT'); //��������ʽ
	   $exec_changeState_Gaussian = curl_exec($req_changeState_Gaussian);
	   curl_close($req_changeState_Gaussian);
	   //�����������ȡ��ȡ�ķ�����Ϣ����ʾ���û��ύ�ɹ����
	   //echo $exec_changeState_Gaussian. "<br />";
	   $json_start_job = json_decode($exec_changeState_Gaussian, true);
	   $start_job_status=$json_start_job['status_code'];	
	   
	   sleep(2);
    }
    
    //�ύÿ�������˽�к���--�����ύʱ���첽�ύ���õ���
    private function _submitJobForAsy($md5secret,$cookiefile,$path,$json_resources,$filename,$corenum,$walltime,$xmlpath){
       /*	
       $filearr = explode(".",$filename);
       $filenamelast = $filearr[0].$i.".".$filearr[1]; */
	   
	   $this->load->model('xml_process_model');
	   $this->xml_process_model->generateXMLFile($json_resources,$filename,$corenum,$walltime,$xmlpath);//����XML�ļ� �������appName�ı��������д���ĸ�˹
	   $XML_content = file_get_contents($xmlpath); //�õ��ļ�������--����һ���ַ�����
	   $jsdlContent_arr=array('jsdlContent'=>$XML_content);
	   $jsdlContent=json_encode($jsdlContent_arr);
       //echo $jsdlContent;
	   $time=time();	
	   $timestamp = "timestamp=$time"."000";
	   $B4md5=$timestamp.$md5secret;
	   $Domd5=md5($B4md5);
	   $md5=$timestamp."&md5sum=".$Domd5;
	
	   //��ҵ�ύ����xml�ļ�
	   $url_json_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/jobs?'.$md5;
	   $req_json_Gaussian= curl_init($url_json_Gaussian);
	   curl_setopt($req_json_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_json_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_json_Gaussian , CURLOPT_COOKIEJAR, $cookiefile);  //����
	   curl_setopt($req_json_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);;
	   curl_setopt($req_json_Gaussian, CURLOPT_HTTPHEADER, array("Content-Type:application/json","accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_json_Gaussian, CURLOPT_POST, 1);
	   curl_setopt($req_json_Gaussian, CURLOPT_POSTFIELDS, $jsdlContent);
	   $exec_json_Gaussian = curl_exec($req_json_Gaussian);
	   $returncode_json_Gaussian = curl_getinfo($req_json_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_json_Gaussian);

	   //������ȡ����guid��uid
	   $json_exec_json= json_decode($exec_json_Gaussian, true); 
	   //echo $exec_json_Gaussian;
	   $gid=$json_exec_json ['gidujid']['gid'];
	   $ujid=$json_exec_json ['gidujid']['ujid'];
	
	   //�ϴ������ļ���api������
	   $file=realpath($path.$filename);
	   $fields['f'] = '@'.$file;

	   //APIbug��ֻ�ܴ���gid����ȥ
	   $url_upload_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/data/jobs/'.$gid.'/cs?'.$md5;
	   $req_upload_Gaussian = curl_init($url_upload_Gaussian);
	
	   curl_setopt($req_upload_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_upload_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_upload_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_upload_Gaussian , CURLOPT_COOKIEJAR,  $cookiefile);  //����
	   curl_setopt($req_upload_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   //put��ʽ�����ݣ�POST��ʽ�����ݵ�ʱ��api�������Ǳ���bug,2013.8.23֮ǰ
	   //2013.8.23֮��ֻ����POST��ʽ�ˣ�������ע�͵�����һ��
	   //curl_setopt($req_upload_Gaussian, CURLOPT_CUSTOMREQUEST, 'PUT');
	   curl_setopt($req_upload_Gaussian, CURLOPT_POSTFIELDS, $fields);
	
	   $exec_upload_Gaussian = curl_exec($req_upload_Gaussian);
	   $returncode_upload_Gaussian = curl_getinfo($req_upload_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_upload_Gaussian) ;
	   //echo $exec_upload_Gaussian. "<br />";

       //�޸���ҵ״̬��������ҵִ��
	   $time=time();
	   $timestamp = "timestamp=$time"."000";
	   $job_start='job_status=start';
	   $B4md5=$job_start.$timestamp.$md5secret;
	   $Domd5=md5($B4md5);
	   $md5=$job_start.'&'.$timestamp."&md5sum=".$Domd5;

	   $url_changeState_Gaussian='http://api.scgrid.cn:8080/sceapi-rest/restv0/jobs/'.$ujid.'/status?'.$md5;
	   $req_changeState_Gaussian = curl_init($url_changeState_Gaussian);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_changeState_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEJAR, $cookiefile);  //����
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_CUSTOMREQUEST, 'PUT'); //��������ʽ
	   $exec_changeState_Gaussian = curl_exec($req_changeState_Gaussian);
	   curl_close($req_changeState_Gaussian);
	   //echo $exec_changeState_Gaussian. "<br />";
	   //$json_start_job = json_decode($exec_changeState_Gaussian, true);
	   //$start_job_status=$json_start_job['status_code'];	
	   //sleep(2);
	   
	   return $json_exec_json ['gidujid'];
    }
       
    //���崦�������ύ����ĺ���
    public function process_multisubmitjob(){
    	ignore_user_abort(); 
    	set_time_limit(0); //��֤����ʱ
    	/*for($i=0;$i<5;$i++){
   	         sleep(1);
   	         $name =json_decode($_POST['json_resources'],true);
   	         $file = fopen("test.txt","a");
             fputs($file,"Hello World. Testing,zhiming!\r\n".$name['queuename']."\r\n");
             fclose($file);
        }*/   
        $md5secret = $_POST['md5secret'];
        $cookiefile = $_POST['cookiefile'];
        $path = $_POST['path'];
        $json_resources= json_decode($_POST['json_resources'], true);
        $filename = $_POST['filename'];
        $corenum = $_POST['corenum'];
        $walltime = $_POST['walltime'];
        $chosedAppStr = $_POST['chosedAppStr'];
        $xmlpath='C:\tmp\order.xml';
        
        $ujidArray =array();
        $gidArray  =array(); 
        $appNameArrTemp = explode("_",$chosedAppStr); 
        $appNameArr = array_reverse($appNameArrTemp);//��ת����
        
        for($i=0;$i<count($appNameArr);$i++){
	        $ujidgidarray = $this->_submitJobForAsy($md5secret,$cookiefile,$path,$json_resources,$filename,$corenum,$walltime,$xmlpath);//�������appName�ı���
	        $ujidArray[] = $ujidgidarray['ujid'];
	        $gidArray[] = $ujidgidarray['gid'];
	        do{       	
		        $status = $this->_inquiryJobStatus($ujidgidarray['ujid'],$md5secret,$cookiefile);
		        sleep(2);
	        }while($status<20);
	        $filearr = explode(".",$filename);
	        $inputfile = fopen($path.$filename,"r");
	        $filenamenew =$filearr[0].$appNameArr[$i+1].".".$filearr[1];
	        $newinputfile = fopen($path.$filenamenew,"w+");
	        while(! feof($inputfile)) 
	        {
		        $line=fgets($inputfile); 
		        if(strpos($line, 'O') !== false ||strpos($line, 'H') !== false){
			        $linearr =explode("	   ",$line);
			        $changeArg=$linearr[1]+0.0002;
			        //$linenew =$linearr[3]."\r\n";
			        $linenew =$linearr[0]."	   ".$changeArg.'00'."	   ".$linearr[2]."	   ".$linearr[3];//�µ�һ������
			        fputs($newinputfile,$linenew);
		        }else{
			        fputs($newinputfile,$line);
		        }
		        
	        } 
	        fclose($inputfile);
	        fclose($newinputfile);
	        $filename =$filenamenew;
        }
        /*
        $ujidArray =array();
        $gidArray  =array();
        $HFArray   =array();
    	$oldbound=2;
    	for($i=1;$i<=$oldbound;$i++){
    	  $ujidgidarray = $this->_submitJobForAsy($i,$md5secret,$cookiefile,$path,$json_resources,$filename,$corenum,$walltime,$xmlpath);
          $ujidArray[$i] = $ujidgidarray['ujid'];
          $gidArray[$i] = $ujidgidarray['gid'];
        }
        
        for($i=1;$i<=$oldbound;$i++){
        	$ujid =$ujidArray[$i];
        	$gid = $gidArray[$i];
	        do{       	
		        $status = $this->_inquiryJobStatus($ujid,$md5secret,$cookiefile);
		        sleep(2); */
		        /*$file = fopen("test.txt","a");//��ע�͵�
		        fputs($file,"status:".$status."\r\n");
		        fclose($file);*/
	        /*} while($status<20);
	        //�޸Ķ�Ӧ�������ļ�����ȡһ������$oldbound+1 �ȶ�ȡ����ȡ����Ӧ���У������£���д ͬʱ��2����һ������һ��д
            $filearr = explode(".",$filename);
            $outputfilename = $filearr[0].$i.'.log';
            
            $this->load->model('xml_process_model');
	        $this->xml_process_model->downloadOutputFile($md5secret,$cookiefile,$gid,$outputfilename);
            $outputfilepath=$path.$outputfilename;
            $file_content = file_get_contents($outputfilepath);
            if(strpos($file_content,"Normal termination") !== false){
	            if(strpos($file_content,"HF=") !== false){
		            $HFindex = strpos($file_content,"HF=");
		            $HFvalue = substr($file_content,$HFindex+3,11);
		            $HFArray[$i] = $HFvalue;
	            }
            }else{
	           $HFvalue="10000";
	           $HFArray[$i] = $HFvalue;
            }
    
            $filenamelast = $filearr[0].$i.".".$filearr[1];
            $inputfile = fopen($path.$filenamelast,"r");
            $newi=$i +$oldbound;
            $filenamenew =$filearr[0].$newi.".".$filearr[1];
            $newinputfile = fopen($path.$filenamenew,"w+");
		    while(! feof($inputfile)) 
            {
            	$line=fgets($inputfile); 
            	if(strpos($line, 'O') !== false ||strpos($line, 'H') !== false){
            		$linearr =explode("	   ",$line);
            		$changeArg=$linearr[1]+0.0002;
            		//$linenew =$linearr[3]."\r\n";
            		$linenew =$linearr[0]."	   ".$changeArg.'00'."	   ".$linearr[2]."	   ".$linearr[3];//�µ�һ������
            		fputs($newinputfile,$linenew);
            	}else{
                    fputs($newinputfile,$line);
                }
               
            } 
		    fclose($inputfile);
		    fclose($newinputfile);
		    //���������������ļ����������Բ�Ҫ��ע�͡��õ���dll�ķ��������������ļ���next_gen()
		    //$this->_submitJobForAsy($newi,$md5secret,$cookiefile,$path,$json_resources,$filename,$corenum,$walltime,$xmlpath);
        }
        asort($HFArray); //��HF��ֵ���������У�������key=>value�Ĺ�����ϵ
        $twoVArray =array();
        $i=1;
        foreach($HFArray as $keyv => $hfvalue){
	        $twoVArray[$i] = $hfvalue;
	        ++$i;
	        if($i==3){break;}
        }
        while( $twoVArray[1] != $twoVArray[2]){
	        //next_gen --�����������ļ����ύ
        }
        */
        echo '<script type="text/javascript" language="javascript">alert("��ˮ����ҵ��ȫ����ɣ�");location.href="index";</script>';
     }
    
    private function _inquiryJobStatus($ujid,$md5secret,$cookiefile){
	    $time=time();
	    $timestamp = "timestamp=$time"."000";
	    $B4md5=$timestamp.$md5secret;
	    $Domd5=md5($B4md5);
	    $md5=$timestamp."&md5sum=".$Domd5;
	    $url_jobStatus='http://api.scgrid.cn:8080/sceapi-rest/restv0/jobs/'.$ujid.'/status?'.$md5;
	    $this->load->model('url_request_model');
	    $exec_inquirJobStatus = $this->url_request_model->sendBasicURLRequest($url_jobStatus,$cookiefile);
	    $json_inquirJobStatus = json_decode($exec_inquirJobStatus, true);
	    $status = $json_inquirJobStatus['job_status'];
	    return $status;
    }
    
    //�����ύ����
    public function multi_submitjob(){
    	$md5secret = $this->session->userdata['md5secret'];
	    $cookiefile = $this->session->userdata['cookiefile'];
	    $path = $this->session->userdata['path'];
    	$json_resources= $_POST['resources']; //json_decode($_POST['resources'], true);
        $filename = $this->session->userdata['filename'];
        $corenum = $this->session->userdata['corenum'];
        $walltime = $this->session->userdata['walltime'];
        $chosedAppStr = $this->session->userdata['chosedAppStr'];
    	$content="md5secret=".$md5secret."&cookiefile=".$cookiefile."&path=".$path."&json_resources=".$json_resources."&filename=".$filename."&corenum=".$corenum."&walltime=".$walltime."&chosedAppStr=".$chosedAppStr;
        $fp = @fsockopen("172.30.1.164", 80, $errno, $errstr, 30);
        $header ="POST /gridapp/index.php/inquiryqueue/process_multisubmitjob HTTP/1.1\r\n";
        $header .="Host:172.30.1.164\r\n";
        $header .="Content-Type:application/x-www-form-urlencoded\r\n";
        $header .="Content-Length: ". strlen($content) ."\r\n";
        $header .="Connection:Close\r\n\r\n";
        $header .=$content;
        $header .="\r\n\r\n";
        fputs($fp,$header);
        fclose($fp);
    	echo '<script type="text/javascript" language="javascript">alert("�����ύ��ҵ�ɹ����Ժ�ɲ鿴��ҵ�����");location.href="index";</script>';

    }
    
    //��ѯ���е���ҵ
    public function inquriy_Historyjob(){
    	
    	$md5secret = $this->session->userdata['md5secret'];   	
        $cookiefile = $this->session->userdata['cookiefile'];        
        if(isset($_POST["inquiryJob"])){
	         $time=time();
	         $timestamp = "timestamp=$time"."000";
	         $offset='offset=0';
             $length='length=30';//������ʾ����ҵ��   ������Ϸ�ҳ����ujid�йأ�����ujid��Ϊ��ҵ��
	         $B4md5=$length.$offset.$timestamp.$md5secret;
	         $Domd5=md5($B4md5);
	         $md5=$length.'&'.$offset.'&'.$timestamp."&md5sum=".$Domd5;
	
	         $url_inquiryjob='http://api.scgrid.cn:80/sceapi-rest/restv0/jobs?'.$md5;
	         //$url_inquiryjob='http://159.226.49.157:8080/restapi2/restv0/jobs?'.$md5;
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
             }
   
        }
    }
    
    //��ʾĳ����ҵ������ļ�
    public function inquiry_eachjob($gid){
    	$md5secret = $this->session->userdata['md5secret'];
        $cookiefile = $this->session->userdata['cookiefile'];
        
        $time=time();
	    $timestamp = "timestamp=$time"."000";
	    $B4md5=$timestamp.$md5secret;
	    $Domd5=md5($B4md5);
	    $md5=$timestamp."&md5sum=".$Domd5;
	
	    $url_inquiryeachjob='http://rest.scgrid.cn/sceapi-rest/restv0/data/jobs/'.$gid.'/cs?'.$md5;
	    //$url_inquiryeachjob='http://api.scgrid.cn:8080/sceapi-rest/restv0/data/jobs/'.$ujid.'/cs/water.com/view?start_line=1&'.$md5;
	    //$url_inquiryeachjob='http://api.scgrid.cn:8080/sceapi-rest/restv0/data/jobs/'.$gid.'/cs/stdoutG?'.$md5;
	    $this->load->model('url_request_model');
	    $exec_inquiryeachjob = $this->url_request_model->sendBasicURLRequest($url_inquiryeachjob,$cookiefile);
	    $json_inquiryeachjob = json_decode($exec_inquiryeachjob, true);
	    
	    if ($exec_inquiryeachjob === false ) {
             echo "No cURL data returned!";
        }else {
        	$headoutput="<div class='centerstyle'>
        		         <div class='directoryback'>Directory List <span style='float:right;'><a id='seeGraph' style='cursor:pointer;' class='linkstyle'>see curve graph of NSE</a><span></div>
        			     <div class='headline'>
        			     	 <div class='jobheadstyle' style='width:280px;'>File</div><div class='jobheadstyle'>Type</div><div class='jobheadstyle'>Operation</div>	
        			     </div>";
        	echo $headoutput;
        	//echo $json_inquiryeachjob;
        	$items = $json_inquiryeachjob['items'];
        	for($i=1;$i<count($items);$i++){
		       $tmplast=strrpos($items[$i], ' '); //���ҿո��ַ�������һ�ַ����������ֵ�λ��
		       $fname=substr($items[$i],$tmplast+1);
			   $fileoutput = "<div class='contentline'>
        			     	     <div class='jobheadstyle' style='width:280px;'>".$fname."</div><div class='jobheadstyle'>file</div><div class='jobheadstyle'><a  style='cursor:pointer;' onclick=\"viewoutputfile('".$gid."','".$fname."')\" class='linkstyle'>view</a>  <a href='".site_url('inquiryqueue/viewORDownload_eachjob/download/'.$gid.'/'.$fname)."' class='linkstyle'>download</a></div>	
        			          </div>";
			   echo $fileoutput;
	        }
        	echo "</div>";
            
        }
  
    }
    
    //���ػ�鿴ĳ����ҵ������ļ�
    public function viewORDownload_eachjob($viewordownload,$gid,$filename){
    	
    	$md5secret = $this->session->userdata['md5secret'];
        $cookiefile = $this->session->userdata['cookiefile'];
        
        $time=time();
	    $timestamp = "timestamp=$time"."000";
	    $B4md5=$timestamp.$md5secret;
	    $Domd5=md5($B4md5);
	    $md5=$timestamp."&md5sum=".$Domd5;
	    $this->load->helper('download');
	    //$url_inquiryeachjob='http://api.scgrid.cn:8080/sceapi-rest/restv0/data/jobs/'.$ujid.'/cs/water.com/view?start_line=1&'.$md5;
	    $url_inquiryeachjob='http://rest.scgrid.cn/sceapi-rest/restv0/data/jobs/'.$gid.'/cs/'.$filename.'?'.$md5;
	    $this->load->model('url_request_model');
	    $exec_inquiryeachjob = $this->url_request_model->getFileContentRequest($url_inquiryeachjob,$cookiefile);
	    $json_inquiryeachjob = json_decode($exec_inquiryeachjob, true);
	    
	    if($viewordownload =="download"){//�����ļ�
		    //$data = file_get_contents($url_inquiryeachjob);
		    force_download($filename, $exec_inquiryeachjob);
	    }else{ //�鿴�ļ�
		    //$url_inquiryeachjob1='http://api.scgrid.cn:8080/sceapi-rest/restv0/data/jobs/'.$gid.'/cs/'.$filename.'/view?start_line=1&'.$md5;	    
		    //echo $exec_inquiryeachjob;
		    //�ȱ���
		    $filePath = $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/';
		    $file=fopen($filePath.$filename,'w');
		    fwrite($file,$exec_inquiryeachjob);
		    fclose($file);
		    //�鿴����
		    $fp = fopen($filePath.$filename, "r"); 
		    while(! feof($fp)) 
		    { 
			    echo fgets($fp). "<br />"; 
		    } 
		    fclose($fp);  
	    }
        	
    }
    
    //�õ�out����ļ����NSE��ֵ���Թ�����ͼ��
    public function getNSEValue($gid ,$filename){
    	header("content-type: application/json"); 
    	$gid=1408293380164840600;
    	$filename = 'xingjiang.out';
    	$filePath = $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/';
    	$fp = fopen($filePath.$filename, "r");
    	$array = array();
    	while(! feof($fp)) 
    	{
    		$line =fgets($fp);
    		if(strpos($line,'NSE')!==false){
    			$value = trim(substr($line,6)); 
    			//echo $value.'_';
    			 $array[] =floatval($value);
    		} 	
    	} 
    	fclose($fp); 
    	//echo $_GET['callback']. '('. json_encode($array) . ')'; 
    	echo json_encode($array);
    }
    
    //��ֹĳ����ҵ
    public function terminate_eachjob($gid){
    	$md5secret = $this->session->userdata['md5secret'];
        $cookiefile = $this->session->userdata['cookiefile'];

	    //�޸���ҵ״̬��������ҵִ��
	    $time=time();
	    $timestamp = "timestamp=$time"."000";
	    $job_end='job_status=end';
	    $B4md5=$job_end.$timestamp.$md5secret;
	    $Domd5=md5($B4md5);
	    $md5=$job_end.'&'.$timestamp."&md5sum=".$Domd5;

	    $url_terminateeachjob='http://rest.scgrid.cn/sceapi-rest/restv0/jobs/'.$gid.'/status?'.$md5;
	    
	    $this->load->model('url_request_model');
	    $exec_terminateeachjob = $this->url_request_model->changeJobStatusRequest($url_terminateeachjob,$cookiefile);
	    $json_terminateeachjob = json_decode($exec_terminateeachjob, true);
	    if ($exec_terminateeachjob === false ) {
             echo "No cURL data returned!";
        }else {
        	$end_job_status=$json_terminateeachjob['status_code'];
	        if($end_job_status=="0"){
		        echo '<script type="text/javascript" language="javascript">alert("��ֹ��ҵ�ɹ���");location.href="'.site_url('home').'";</script>';
	        }else{ 
		        echo '<script type="text/javascript" language="javascript">alert("��ֹ��ҵʧ�ܣ�");location.href="../inquriy_Historyjob";</script>';
            }
        }
    }
    
    //��ѯ������ˮ����ҵ
    public function inquriy_Pipelinejob(){
    	$md5secret = $this->session->userdata['md5secret'];   	
        $cookiefile = $this->session->userdata['cookiefile'];        
        if(isset($_POST["inquiryJob"])){
	         $time=time();
	         $timestamp = "timestamp=$time"."000";
	         $offset='offset=0';
             $length='length=30';//������ʾ����ҵ��   ������Ϸ�ҳ����ujid�йأ�����ujid��Ϊ��ҵ��
	         $B4md5=$length.$offset.$timestamp.$md5secret;
	         $Domd5=md5($B4md5);
	         $md5=$length.'&'.$offset.'&'.$timestamp."&md5sum=".$Domd5;
	
	         $url_inquiryjob='http://rest.scgrid.cn:80/sceapi-rest/restv0/jobs?'.$md5;
	         //$url_inquiryjob='http://159.226.49.157:8080/restapi2/restv0/jobs?'.$md5;
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
                 $data["jobs_list_arr"]=$json_inquiryjob['jobs_list'];
                 $this->load->view('pipeline_jobs',$data); 
             }
   
        }
    }
    
    
}
