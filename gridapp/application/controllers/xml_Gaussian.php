<?php
//生成jsdl文件,Gaussian

$json_resources= json_decode($_POST['resources'], true);
$filename = $this->session->userdata['filename'];
$corenum = $this->session->userdata['corenum'];
$walltime = $this->session->userdata['walltime'];

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
/*$itemApplicationName = $dom->createElement("ApplicationName");
 $itemJobDescription->appendChild($itemApplicationName);
 
 $itemApplicationName->appendChild($text_ApplicationName);*/
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

/*$itemArgument= $dom->createElement("Argument");
 $itemPOSIXApplication->appendChild($itemArgument);
 $text_Argument = $dom->createTextNode("stdout");
 $itemArgument->appendChild($text_Argument);
 */

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

// save tree to file
//$dom->save("order.xml");
// save tree to string
//$order = $dom->save("order.xml");

//另外一种保存方式
$xmlpath='C:\tmp\order.xml';

$dom->save($xmlpath);
$order = $dom->save($xmlpath);

?>