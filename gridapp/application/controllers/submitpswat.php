<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submitpswat extends CI_Controller {
	
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
	
	public function getParsVarStr($parsVarStr){
		//$this->session->set_userdata('parsStr',$parsVarStr);
		//��ֵ�������ļ���	
	}
	
	//��ѯ���õĿ��ж���
    public function inquiryavailablequeue($walltime,$corenum,$appname){
    	
    	//��ȡcookie��md5secret
        $md5secret =  $this->session->userdata('md5secret');
        $cookiefile =  $this->session->userdata('cookiefile');
        //echo "<p>test:".$walltime.$md5secret."</p>";
        
        //session���ݲ���
        $this->session->set_userdata('corenum',$corenum);
        $this->session->set_userdata('walltime',$walltime);
        $this->session->set_userdata('appname',$appname);
        
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
        $url_queue_PSWAT='http://rest.scgrid.cn:80/sceapi-rest/restv0/resources/applications/'.$appname.'?'.$md5;

        $req_queue_PSWAT = curl_init($url_queue_PSWAT);
        curl_setopt($req_queue_PSWAT, CURLOPT_HEADER, false);
        curl_setopt($req_queue_PSWAT, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
        curl_setopt($req_queue_PSWAT, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req_queue_PSWAT , CURLOPT_COOKIEJAR,  $cookiefile);  //���棬������һ��Ҫ�ȱ����ڶ�ȡ����Ȼ����
        curl_setopt($req_queue_PSWAT, CURLOPT_COOKIEFILE, $cookiefile);
        $exec_queue_PSWAT = curl_exec($req_queue_PSWAT);
        $returncode_queue_PSWAT = curl_getinfo($req_queue_PSWAT, CURLINFO_HTTP_CODE);
        curl_close($req_queue_PSWAT) ;
        $json_exec_queue = json_decode($exec_queue_PSWAT, true);
        //echo $exec_queue_PSWAT;
        
        $arr=$json_exec_queue['apps_list'];
        foreach($arr as $val){

	       $a=array('queuename'=>$val['queuename'],'hostname'=>$val['hpcname']);
	       $b=$val['hpcname'];
	       $c=$val['queuename'];
	       $jsonTest=json_encode($a);
	       echo "<input type='radio' name='resources' class='marginTopRight' value='$jsonTest'/>".$a['queuename'];
        }
     
    }
    
    //�ύPSWAT����
    public function submitjob(){
    	$md5secret = $this->session->userdata['md5secret'];
	    $cookiefile = $this->session->userdata['cookiefile'];
	    $path = $this->session->userdata['path'];
	    $filename = $this->session->userdata['filename'];
	
	    $json_resources= json_decode($_POST['resources'], true);	    
        $explodefilename = explode('.',$_POST['outputfilename']);
        $areaName = $explodefilename[0];
        $jobName = $areaName."_job";
        $hostName = $json_resources['hostname'];
        $queueName = $json_resources['queuename'];
        $cpuCount = intval($_POST['CPUNum']);
        $walltime = intval($_POST['RunTime']);
        $arguments = $this->session->userdata('parsStr')." ".$_POST['Percent']." ".$_POST['SeedNum']." ".$_POST['outputfilename'];
        
        if(isset($_POST["submitjob"])){   //�ж��Ƿ��ύ����  ������ñ������ʱ��Ҫ��\"  ��˫����ת��
            $jsdlContentPar ='{"jobName":'."\"".$jobName."\"".',
	            "execName":"PSWAT",' .
	            '"appName":"PSWAT",
	            "stdout":"stdoutP",
	            "stderr":"stderrP",
	            "hostName":'."\"".$hostName."\"".',
	            "cpuCount":'.$cpuCount.',
	            "queue":'."\"".$queueName."\"".',
	            "wallTime":'.$walltime.',
	            "arguments":['."\"".$arguments."\"".'],"targetFiles":[{"fileName":'."\"".$_POST['outputfilename']."\"".',
"url":'."\"".$_POST['outputfilename']."\"".',"delFlag":true}]
                }';
           
            //$jsdlContent_arr=array('jsdlContent'=>$jsdlContentPar);
	        //$jsdlContent=json_encode($jsdlContentPar); "sourceFiles":[{"fileName":"testinput","url":"testinput","delFlag":true}],
            $time=time();	
            $timestamp = "timestamp=$time"."000";
            $B4md5=$timestamp.$md5secret;
            $Domd5=md5($B4md5);
            $md5=$timestamp."&md5sum=".$Domd5;
            
            //��ҵ�ύ����
            $url_json_PSWAT='http://rest.scgrid.cn:80/sceapi-rest/restv0/jobs?'.$md5;
            $req_json_PSWAT= curl_init($url_json_PSWAT);
            curl_setopt($req_json_PSWAT, CURLOPT_HEADER, false);
            curl_setopt($req_json_PSWAT, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req_json_PSWAT , CURLOPT_COOKIEJAR, $cookiefile);  //����
            curl_setopt($req_json_PSWAT, CURLOPT_COOKIEFILE, $cookiefile);;
            curl_setopt($req_json_PSWAT, CURLOPT_HTTPHEADER, array("Content-Type:application/json","accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
            curl_setopt($req_json_PSWAT, CURLOPT_POST, 1);
            curl_setopt($req_json_PSWAT, CURLOPT_POSTFIELDS, $jsdlContentPar);
            $exec_json_PSWAT = curl_exec($req_json_PSWAT);
            $returncode_json_PSWAT = curl_getinfo($req_json_PSWAT, CURLINFO_HTTP_CODE);
            curl_close($req_json_PSWAT);
            
            //������ȡ����guid��uid
            $json_exec_json= json_decode($exec_json_PSWAT, true); 
            //echo $exec_json_PSWAT;
            $gid=$json_exec_json ['gidujid']['gid'];
            $ujid=$json_exec_json ['gidujid']['ujid'];
            
            //�ϴ������ļ���api������
            $file=realpath($path.$filename);
            $fields['f'] = '@'.$file;
            
            //APIbug��ֻ�ܴ���gid����ȥ
            $url_upload_PSWAT='http://rest.scgrid.cn:80/sceapi-rest/restv0/data/jobs/'.$gid.'/cs?'.$md5;
            $req_upload_PSWAT = curl_init($url_upload_PSWAT);
            
            curl_setopt($req_upload_PSWAT, CURLOPT_HEADER, false);
            curl_setopt($req_upload_PSWAT, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
            curl_setopt($req_upload_PSWAT, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req_upload_PSWAT , CURLOPT_COOKIEJAR,  $cookiefile);  //����
            curl_setopt($req_upload_PSWAT, CURLOPT_COOKIEFILE, $cookiefile);
            curl_setopt($req_upload_PSWAT, CURLOPT_POSTFIELDS, $fields);
            
            $exec_upload_PSWAT = curl_exec($req_upload_PSWAT);
            $returncode_upload_PSWAT = curl_getinfo($req_upload_PSWAT, CURLINFO_HTTP_CODE);
            curl_close($req_upload_PSWAT) ;
            //echo $exec_upload_PSWAT. "<br />";
            
            //�޸���ҵ״̬��������ҵִ��
            $time=time();
            $timestamp = "timestamp=$time"."000";
            $job_start='job_status=start';
            $B4md5=$job_start.$timestamp.$md5secret;
            $Domd5=md5($B4md5);
            $md5=$job_start.'&'.$timestamp."&md5sum=".$Domd5;
            
            $url_changeState_PSWAT='http://rest.scgrid.cn:80/sceapi-rest/restv0/jobs/'.$ujid.'/status?'.$md5;
            $req_changeState_PSWAT = curl_init($url_changeState_PSWAT);
            curl_setopt($req_changeState_PSWAT, CURLOPT_HEADER, false);
            curl_setopt($req_changeState_PSWAT, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
            curl_setopt($req_changeState_PSWAT, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req_changeState_PSWAT, CURLOPT_COOKIEJAR, $cookiefile);  //����
            curl_setopt($req_changeState_PSWAT, CURLOPT_COOKIEFILE, $cookiefile);
            curl_setopt($req_changeState_PSWAT, CURLOPT_CUSTOMREQUEST, 'PUT'); //��������ʽ
            $exec_changeState_PSWAT = curl_exec($req_changeState_PSWAT);
            curl_close($req_changeState_PSWAT);
            //�����������ȡ��ȡ�ķ�����Ϣ����ʾ���û��ύ�ɹ����
            //echo $exec_changeState_PSWAT. "<br />";
            
            $json_start_job = json_decode($exec_changeState_PSWAT, true);
            $start_job_status=$json_start_job['status_code'];
            
            if($start_job_status=="0"){
	            echo '<script type="text/javascript" language="javascript">alert("��ҵ�ύ�ɹ���");location.href="index";</script>';
            }else{ 
	            echo '<script type="text/javascript" language="javascript">alert("��ҵ�ύʧ�ܣ�");location.href="index";</script>';
            }
            
        }
    }
    
    
	
}
