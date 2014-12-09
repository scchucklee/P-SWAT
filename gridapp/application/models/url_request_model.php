<?php
/*
 * Created on 2013-11-25
 *
 * ��cURL����ķ�װ
 * 
 */
class url_request_model extends CI_Model
{
	
	function __construct()
    {
        parent::__construct();
    }
    
    //��ѯ���ж��кͲ�ѯ��ʷ��ҵʱ�õ�
    function sendBasicURLRequest($url,$cookiefile)
    {
	    $req_inquiryjob = curl_init($url);
	    curl_setopt($req_inquiryjob, CURLOPT_HEADER, false);
	    curl_setopt($req_inquiryjob, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	    curl_setopt($req_inquiryjob, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($req_inquiryjob , CURLOPT_COOKIEJAR,  $cookiefile);  //���棬������һ��Ҫ�ȱ����ڶ�ȡ����Ȼ����
	    curl_setopt($req_inquiryjob, CURLOPT_COOKIEFILE, $cookiefile);
	    $exec_inquiryjob  = curl_exec($req_inquiryjob);
	    //$returncode_inquiryjob = curl_getinfo($req_inquiryjob, CURLINFO_HTTP_CODE);
	    curl_close($req_inquiryjob) ;
	    return $exec_inquiryjob;
    }
    
    //��ҵ�ύ����xml�ļ�ʱ�õ�
    function submitJobXMLRequest($url,$cookiefile,$jsdlContent)
    {
	   $req_json_Gaussian= curl_init($url);
	   curl_setopt($req_json_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_json_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_json_Gaussian , CURLOPT_COOKIEJAR, $cookiefile);  //����
	   curl_setopt($req_json_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);;
	   curl_setopt($req_json_Gaussian, CURLOPT_HTTPHEADER, array("Content-Type:application/json","accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_json_Gaussian, CURLOPT_POST, 1);
	   curl_setopt($req_json_Gaussian, CURLOPT_POSTFIELDS, $jsdlContent);
	   $exec_json_Gaussian = curl_exec($req_json_Gaussian);
	   //$returncode_json_Gaussian = curl_getinfo($req_json_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_json_Gaussian);
	   return $exec_json_Gaussian;
    }
    
    //�ϴ������ļ�ʱ�õ�
    function uploadInputFileRequest($url,$cookiefile,$fields)
    {
       $req_upload_Gaussian = curl_init($url);
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
	   //$returncode_upload_Gaussian = curl_getinfo($req_upload_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_upload_Gaussian) ;
	   return $exec_upload_Gaussian;
    }
    
    //�޸���ҵ״̬��������ҵִ��ʱ�õ�
    function changeJobStatusRequest($url,$cookiefile)
    { 
	   $req_changeState_Gaussian = curl_init($url);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_changeState_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEJAR, $cookiefile);  //����
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_CUSTOMREQUEST, 'PUT'); //��������ʽ
	   $exec_changeState_Gaussian = curl_exec($req_changeState_Gaussian);
	   curl_close($req_changeState_Gaussian);
	   return $exec_changeState_Gaussian;
    }
    
    //��ȡ�ļ�����ʱ�õ�
    function getFileContentRequest($url,$cookiefile)
    { 
	   $req_getContent_Gaussian = curl_init($url);
	   curl_setopt($req_getContent_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_getContent_Gaussian, CURLOPT_HTTPHEADER, Array("Content-Type:text/*","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_getContent_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_getContent_Gaussian, CURLOPT_COOKIEJAR, $cookiefile);  //����
	   curl_setopt($req_getContent_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   //curl_setopt($req_getContent_Gaussian, CURLOPT_POST,1); //��������ʽ
	   $exec_getContent_Gaussian = curl_exec($req_getContent_Gaussian);
	   curl_close($req_getContent_Gaussian);
	   return $exec_getContent_Gaussian;
    }
}
