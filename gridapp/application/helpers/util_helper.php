<?php

function tran_status_code($status_code) {
	$status = array(
        1 => 'SUBMITTED',
        2 => 'STAGINGIN',
        4 => 'SCHEDULING',
        8 => 'SCHEDULED',
        16 => 'PENDING',
        17 => 'RUNNING',
        18 => 'STAGINGOUT',
        20 => 'FINISHED',
        24 => 'FINISHED',
        32 => 'TERMINATED',
        33 => 'NET_DELAY',
        34 => 'SUB_ERROR',
        38 => 'EXIT'
    );
    $result = array_key_exists($status_code,$status); //24 => 'FAILED'
    if($result == true){
        return $status[$status_code];
    }else{
        return "ENDED";
    }
    
}

function tran_job_name($job_name){
	if (strpos($job_name, 'job') !== false){
	   $str= substr($job_name,0,strpos($job_name,"job"));
	   $resultStr =trim($str," \t\n\r\0\x0B._").".job";
       return $resultStr;
	}else{
		return $job_name;
	}
}

?>
