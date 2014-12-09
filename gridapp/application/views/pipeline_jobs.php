<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>Pipeline Jobs</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>-->
    <script type="text/javascript">
       function seeOutputfile(dom){
         var gid =dom.getAttribute("name");
         //alert(gid); 
   	     $.ajax({  
          type:"GET" 
         ,url:"<?=base_url()?>index.php/inquiryqueue/inquiry_eachjob/"+gid  
         ,data:{id:gid}                                
         ,contentType:'text/html;charset=utf-8'//�����ʽ  
         ,beforeSend:function(data){  
            //$('.contentline').after('<p>loading...</p>');  
          }//��������ǰ  
         ,success:function(data){  
           //$('.contentline').after(data); 
           $('.centerstyle').empty();//ÿ�μ���ǰ�������֮ǰ��ӵ�
           $(dom).parent().parent().after(data);   
          }//����ɹ���  
         ,error:function(data){  
           $('.contentline').html('failed to show output file.')  
         }//�������  
        });  	
        		
       }
    </script>
</head>
<body>
 <div id='header'>
   <div class="logoimg">
   <a href="<?=site_url('home')?>"><img src="<?=base_url()?>img/sc.jpg" style="float:left;width:60px;height:60px;"/></a>
    <h2 style="color:white;margin-top:10px;">�п�Ժ����������������Ӧ��</h2>
   </div>
   <div style="color:white;padding-top:30px;">��ӭ����<?php echo $this->session->userdata('username');?>   &nbsp;&nbsp;<a href="<?=site_url('login/logout')?>" class="linkstyle">�˳���¼��Logout</a></div>
 </div>
 
<div class='loginPage' style="margin-top:-80px;margin-bottom:20px;width:880px;height:auto;">
  <h2 class="submitfont">��ˮ����ҵ��ʷ��¼</h2> 
  <div class="headline">
    <div class="jobheadstyle">task_id</div><div class="jobheadstyle" style="width:220px;">job_type</div><div class="jobheadstyle">job_num</div><div class="jobheadstyle" style="width:220px;">create_time</div><div class="jobheadstyle" style="width:220px;">operation</div> 
  </div>
  <?php foreach($jobs_list_arr as $_job): ?>
  <div class="contentline">
    <div class="jobheadstyle"><?php echo $_job['ujid']; ?></div><div class="jobheadstyle" style="width:220px;"><?php echo $_job['applicationname']; ?></div><div class="jobheadstyle"><?php echo $_job['corenum']; ?></div><div class="jobheadstyle" style="width:220px;"><?php echo date("Y-m-d H:i:s",$_job['submit_time']+28800); ?></div><div class="jobheadstyle" style="width:220px;"><a name="<?php echo $_job['gid']; ?>" style="cursor:pointer;color:blue;" onclick="seeOutputfile(this)" class="linkstyle">�鿴</a>&nbsp;| <a href="<?=site_url('inquiryqueue/terminate_eachjob/'.$_job['gid'])?>" class="linkstyle">ɾ��</a>&nbsp;| <a style="cursor:pointer;color:blue;" class="linkstyle">�������ؽ���ļ�</a></div> 
  </div>
  <?php endforeach; ?>
</div>
</body>
</html>
