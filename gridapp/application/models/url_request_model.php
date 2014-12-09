<?php
/*
 * Created on 2013-11-25
 *
 * 对cURL请求的封装
 * 
 */
class url_request_model extends CI_Model
{
	
	function __construct()
    {
        parent::__construct();
    }
    
    //查询空闲队列和查询历史作业时用到
    function sendBasicURLRequest($url,$cookiefile)
    {
	    $req_inquiryjob = curl_init($url);
	    curl_setopt($req_inquiryjob, CURLOPT_HEADER, false);
	    curl_setopt($req_inquiryjob, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	    curl_setopt($req_inquiryjob, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($req_inquiryjob , CURLOPT_COOKIEJAR,  $cookiefile);  //保存，这里面一定要先保存在读取，不然出错
	    curl_setopt($req_inquiryjob, CURLOPT_COOKIEFILE, $cookiefile);
	    $exec_inquiryjob  = curl_exec($req_inquiryjob);
	    //$returncode_inquiryjob = curl_getinfo($req_inquiryjob, CURLINFO_HTTP_CODE);
	    curl_close($req_inquiryjob) ;
	    return $exec_inquiryjob;
    }
    
    //作业提交请求xml文件时用到
    function submitJobXMLRequest($url,$cookiefile,$jsdlContent)
    {
	   $req_json_Gaussian= curl_init($url);
	   curl_setopt($req_json_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_json_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_json_Gaussian , CURLOPT_COOKIEJAR, $cookiefile);  //保存
	   curl_setopt($req_json_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);;
	   curl_setopt($req_json_Gaussian, CURLOPT_HTTPHEADER, array("Content-Type:application/json","accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_json_Gaussian, CURLOPT_POST, 1);
	   curl_setopt($req_json_Gaussian, CURLOPT_POSTFIELDS, $jsdlContent);
	   $exec_json_Gaussian = curl_exec($req_json_Gaussian);
	   //$returncode_json_Gaussian = curl_getinfo($req_json_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_json_Gaussian);
	   return $exec_json_Gaussian;
    }
    
    //上传输入文件时用到
    function uploadInputFileRequest($url,$cookiefile,$fields)
    {
       $req_upload_Gaussian = curl_init($url);
	   curl_setopt($req_upload_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_upload_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_upload_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_upload_Gaussian , CURLOPT_COOKIEJAR,  $cookiefile);  //保存
	   curl_setopt($req_upload_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   //put方式传数据，POST方式传数据的时候，api服务器那边有bug,2013.8.23之前
	   //2013.8.23之后，只能用POST方式了，这样就注释掉下面一行
	   //curl_setopt($req_upload_Gaussian, CURLOPT_CUSTOMREQUEST, 'PUT');
	   curl_setopt($req_upload_Gaussian, CURLOPT_POSTFIELDS, $fields);
	
	   $exec_upload_Gaussian = curl_exec($req_upload_Gaussian);
	   //$returncode_upload_Gaussian = curl_getinfo($req_upload_Gaussian, CURLINFO_HTTP_CODE);
	   curl_close($req_upload_Gaussian) ;
	   return $exec_upload_Gaussian;
    }
    
    //修改作业状态，触发作业执行时用到
    function changeJobStatusRequest($url,$cookiefile)
    { 
	   $req_changeState_Gaussian = curl_init($url);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_changeState_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEJAR, $cookiefile);  //保存
	   curl_setopt($req_changeState_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   curl_setopt($req_changeState_Gaussian, CURLOPT_CUSTOMREQUEST, 'PUT'); //设置请求方式
	   $exec_changeState_Gaussian = curl_exec($req_changeState_Gaussian);
	   curl_close($req_changeState_Gaussian);
	   return $exec_changeState_Gaussian;
    }
    
    //获取文件内容时用到
    function getFileContentRequest($url,$cookiefile)
    { 
	   $req_getContent_Gaussian = curl_init($url);
	   curl_setopt($req_getContent_Gaussian, CURLOPT_HEADER, false);
	   curl_setopt($req_getContent_Gaussian, CURLOPT_HTTPHEADER, Array("Content-Type:text/*","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
	   curl_setopt($req_getContent_Gaussian, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($req_getContent_Gaussian, CURLOPT_COOKIEJAR, $cookiefile);  //保存
	   curl_setopt($req_getContent_Gaussian, CURLOPT_COOKIEFILE, $cookiefile);
	   //curl_setopt($req_getContent_Gaussian, CURLOPT_POST,1); //设置请求方式
	   $exec_getContent_Gaussian = curl_exec($req_getContent_Gaussian);
	   curl_close($req_getContent_Gaussian);
	   return $exec_getContent_Gaussian;
    }
}
