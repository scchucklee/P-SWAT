<?php
/*
 * Created on 2013-12-19
 *
 * XML文件处理相关
 * 
 */
class xml_process_model extends CI_Model{
	
	function __construct()
    {
        parent::__construct();
    }
    
    //生成作业请求xml文件
    function generateXMLFile($json_resources,$filename,$corenum,$walltime,$xmlpath){
    	//生成jsdl文件,Gaussian

        $dom = new DOMDocument("1.0","UTF-8");
        $root = $dom->createElement("JobDefinition");
        $dom->appendChild($root);
        $dom->formatOutput=true;

        $xmlns = $dom->createAttribute("xmlns");
        $root->appendChild($xmlns);
        // create attribute value node
        $xmlnsValue = $dom->createTextNode("http://schemas.ggf.org/jsdl/2005/10/jsdl");
        $xmlns->appendChild($xmlnsValue);				

        //JobDefinition--JobDescription
        $itemJobDescription = $dom->createElement("JobDescription");
        $root->appendChild($itemJobDescription);
        
        //JobDefinition--JobDescription--JobIdentification
        $itemJobIdentification = $dom->createElement("JobIdentification");
        $itemJobDescription->appendChild($itemJobIdentification);
        
        //JobDefinition--JobDescription--JobIdentification--JobName
        $itemJobName = $dom->createElement("JobName");
        $itemJobIdentification->appendChild($itemJobName);
        $text_JobName = $dom->createTextNode($filename."job");
        $itemJobName->appendChild($text_JobName);	
			
        //JobDefinition--JobDescription--Application
        $itemApplication = $dom->createElement("Application");
        $itemJobDescription->appendChild($itemApplication);
        
        //JobDefinition--JobDescription--Application--ApplicationName
        $itemApplicationName = $dom->createElement("ApplicationName");
        $itemApplication->appendChild($itemApplicationName);
        $text_AppName = $dom->createTextNode("gaussian");
        $itemApplicationName->appendChild($text_AppName);
        
        //JobDefinition--JobDescription--Application--POSIXApplication
        $itemPOSIXApplication = $dom->createElement("POSIXApplication");
        $itemApplication->appendChild($itemPOSIXApplication);

        //JobDefinition--JobDescription--Application--POSIXApplication--Executable
        $itemExecutable = $dom->createElement("Executable");
        $itemPOSIXApplication->appendChild($itemExecutable);
        $text_AppName1 = $dom->createTextNode("gaussian");
        $itemExecutable->appendChild($text_AppName1);
        
        //JobDefinition--JobDescription--Application--POSIXApplication--Argument
        $itemArgument = $dom->createElement("Argument");
        $itemPOSIXApplication->appendChild($itemArgument);			
        $text_Arg = $dom->createTextNode($filename);
        $itemArgument->appendChild($text_Arg);				
        
        //JobDefinition--JobDescription--Application--POSIXApplication--Output
        $itemOutput = $dom->createElement("Output");
        $itemPOSIXApplication->appendChild($itemOutput);
        $text_Output = $dom->createTextNode("stdoutG");
        $itemOutput->appendChild($text_Output);
				
        //JobDefinition--JobDescription--Application--POSIXApplication--Error
        $itemError = $dom->createElement("Error");
        $itemPOSIXApplication->appendChild($itemError);
        $text_Error = $dom->createTextNode("stderrG");
        $itemError->appendChild($text_Error);			
        
        //JobDefinition--JobDescription--Application--POSIXApplication--WallTimeLimit
        $itemWallTimeLimit = $dom->createElement("WallTimeLimit");
        $itemPOSIXApplication->appendChild($itemWallTimeLimit);
        $text_WallTimeLimit = $dom->createTextNode($walltime);
        $itemWallTimeLimit->appendChild($text_WallTimeLimit);

		//JobDefinition--JobDescription--Resources
		$itemResources = $dom->createElement("Resources");
		$itemJobDescription->appendChild($itemResources);

		//JobDefinition--JobDescription--Resources--HostName
		$itemHostName = $dom->createElement("HostName");
		$itemResources->appendChild($itemHostName);
		//echo 'hostname'.$_POST['resources']['hostname'].'<br />';
		$text_HostName= $dom->createTextNode($json_resources['hostname']);
		$itemHostName->appendChild($text_HostName);
		
		//JobDefinition--JobDescription--Resources--CPUCount
		$itemCPUCount = $dom->createElement("CPUCount");
		$itemResources->appendChild($itemCPUCount);
		$text_CPUCount = $dom->createTextNode($corenum);
		$itemCPUCount->appendChild($text_CPUCount);
		
		//JobDefinition--JobDescription--Resources--queue
		$itemqueuet = $dom->createElement("queue");
		$itemResources->appendChild($itemqueuet);
		
		$text_queue = $dom->createTextNode($json_resources['queuename']);
		$itemqueuet->appendChild($text_queue);
		
		//JobDefinition--JobDescription--DataStaging
		$itemDataStaging1 = $dom->createElement("DataStaging");
		$itemJobDescription->appendChild($itemDataStaging1);

		$itemFileName1 = $dom->createElement("FileName");
		$itemDataStaging1->appendChild($itemFileName1);
		$text_Arg1 = $dom->createTextNode($filename);
		$itemFileName1->appendChild($text_Arg1);
		
		$itemDeleteOnTermination1 = $dom->createElement("DeleteOnTermination");
		$itemDataStaging1->appendChild($itemDeleteOnTermination1);
		$text_DeleteOnTermination1 = $dom->createTextNode("true");
		$itemDeleteOnTermination1->appendChild($text_DeleteOnTermination1);
		
		$itemSource = $dom->createElement("Source");
		$itemDataStaging1->appendChild($itemSource);
			
		//JobDefinition--JobDescription--DataStaging--Target--URI
		$itemURI1 = $dom->createElement("URI");
		$itemSource->appendChild($itemURI1);
		$text_Arg2 = $dom->createTextNode($filename);
		$itemURI1->appendChild($text_Arg2);
		
		$itemDataStaging2 = $dom->createElement("DataStaging");
		$itemJobDescription->appendChild($itemDataStaging2);
		
		$itemFileName2 = $dom->createElement("FileName");
		$itemDataStaging2->appendChild($itemFileName2);
		$text_stdout1 = $dom->createTextNode("stdoutG");
		$itemFileName2->appendChild($text_stdout1);
				
		//JobDefinition--JobDescription--DataStaging--DeleteOnTermination
		$itemDeleteOnTermination2 = $dom->createElement("DeleteOnTermination");
		$itemDataStaging2->appendChild($itemDeleteOnTermination2);
		$text_DeleteOnTermination2 = $dom->createTextNode("true");
		$itemDeleteOnTermination2->appendChild($text_DeleteOnTermination2);
		
		//JobDefinition--JobDescription--DataStaging--Target
		$itemTarget1 = $dom->createElement("Target");
		$itemDataStaging2->appendChild($itemTarget1);
		
		//JobDefinition--JobDescription--DataStaging--Target--URI
		$itemURI2 = $dom->createElement("URI");
		$itemTarget1->appendChild($itemURI2);
		$text_stdout2 = $dom->createTextNode("stdoutG");
		$itemURI2->appendChild($text_stdout2);
		
		$itemDataStaging3 = $dom->createElement("DataStaging");
		$itemJobDescription->appendChild($itemDataStaging3);
				
		$itemFileName3 = $dom->createElement("FileName");
		$itemDataStaging3->appendChild($itemFileName3);
		$text_stderr1 = $dom->createTextNode("stderrG");
		$itemFileName3->appendChild($text_stderr1);
		
		//JobDefinition--JobDescription--DataStaging--DeleteOnTermination
		$itemDeleteOnTermination3 = $dom->createElement("DeleteOnTermination");
		$itemDataStaging3->appendChild($itemDeleteOnTermination3);
		$text_DeleteOnTermination3 = $dom->createTextNode("true");
		$itemDeleteOnTermination3->appendChild($text_DeleteOnTermination3);
		
		//JobDefinition--JobDescription--DataStaging--Target
		$itemTarget2 = $dom->createElement("Target");
		$itemDataStaging3->appendChild($itemTarget2);
		
		//JobDefinition--JobDescription--DataStaging--Target--URI
		$itemURI3 = $dom->createElement("URI");
		$itemTarget2->appendChild($itemURI3);
		$text_stderr2 = $dom->createTextNode("stderrG");
		$itemURI3->appendChild($text_stderr2);

		//JobDefinition--JobDescription--DataStaging
		$itemDataStaging4 = $dom->createElement("DataStaging");
		$itemJobDescription->appendChild($itemDataStaging4);

		//JobDefinition--JobDescription--DataStaging--FileName
		//又一个filename
		$itemFileName4 = $dom->createElement("FileName");
		$itemDataStaging4->appendChild($itemFileName4);
		$text_all1 = $dom->createTextNode("*");
		$itemFileName4->appendChild($text_all1);
		
		//JobDefinition--JobDescription--DataStaging--DeleteOnTermination
		$itemDeleteOnTermination4 = $dom->createElement("DeleteOnTermination");
		$itemDataStaging4->appendChild($itemDeleteOnTermination4);
		$text_DeleteOnTermination4 = $dom->createTextNode("true");
		$itemDeleteOnTermination4->appendChild($text_DeleteOnTermination4);
		
		//JobDefinition--JobDescription--DataStaging--Target
		$itemTarget3 = $dom->createElement("Target");
		$itemDataStaging4->appendChild($itemTarget3);

		//JobDefinition--JobDescription--DataStaging--Target--URI
		$itemURI4= $dom->createElement("URI");
		$itemTarget3->appendChild($itemURI4);
		$text_all2 = $dom->createTextNode("*");
		$itemURI4->appendChild($text_all2);
		
		$dom->save($xmlpath);
		$order = $dom->save($xmlpath);						
    }

    function downloadOutputFile($md5secret,$cookiefile,$gid,$filename){

        $time=time();
	    $timestamp = "timestamp=$time"."000";
	    $B4md5=$timestamp.$md5secret;
	    $Domd5=md5($B4md5);
	    $md5=$timestamp."&md5sum=".$Domd5;
	
	    $url_inquiryeachjob='http://api.scgrid.cn:8080/sceapi-rest/restv0/data/jobs/'.$gid.'/cs/'.$filename.'?'.$md5;
	    $CI =& get_instance(); //这步很重要,调用其他model里的方法，就用这个
	    $CI->load->model('url_request_model');
        $exec_inquiryeachjob = $CI->url_request_model->getFileContentRequest($url_inquiryeachjob,$cookiefile);   
    	if ($exec_inquiryeachjob === false ) {
             echo "No cURL data returned!";
        }else {
	        //先保存
	        $filePath = 'C:/tmp/';
	        $file=fopen($filePath.$filename,'w');
	        fwrite($file,$exec_inquiryeachjob);
	        fclose($file);
        }
    }
    
    function find_job_by_offset($num,$offset1){
    	$md5secret = $this->session->userdata['md5secret'];   	
        $cookiefile = $this->session->userdata['cookiefile'];        
        
        $time=time();
        $timestamp = "timestamp=$time"."000";
        $offset='offset='.$offset1;
        $length='length='.$num; //设置显示的作业数   后面加上分页，和ujid有关，最大的ujid即为作业数
        $B4md5=$length.$offset.$timestamp.$md5secret;
        $Domd5=md5($B4md5);
        $md5=$length.'&'.$offset.'&'.$timestamp."&md5sum=".$Domd5;
        
        $url_inquiryjob='http://rest.scgrid.cn/sceapi-rest/restv0/jobs?'.$md5;
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
	        //return "No cURL data returned!";
	        if (curl_error($req_inquiryjob))
		        return "\n". curl_error($req_inquiryjob);
        }else {
	        return $json_inquiryjob['jobs_list'];	        
        } 
    }
    
}
