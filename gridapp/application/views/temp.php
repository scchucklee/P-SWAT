
 <!--<div id='header'>
   <div class="logoimg">
   <a href="<?=site_url('home')?>"><img src="<?=base_url()?>img/sc.jpg" style="float:left;width:60px;height:60px;"/></a>
    <h2 style="color:white;margin-top:10px;">中科院超级计算中心网格应用</h2>
   </div>
   <div style="color:white;padding-top:30px;">欢迎您，<?php echo $this->session->userdata('username');?>   &nbsp;&nbsp;<a href="<?=site_url('login/logout')?>" class="linkstyle">退出登录，Logout</a></div>
 </div> -->

<?php if ($this->session->userdata('username')){  ?>
<div class='loginPage' style="margin-top:-80px">
  <h4 class="submitfont"><a href="<?=site_url('home/multi_submit')?>">点此进行批量提交任务</a></h4>
  <h2 class="submitfont">提交单一任务相关操作</h2>
<iframe name="quietUp" style="display :none">
</iframe>

<form action="<?=site_url('home/uploadfile')?>" method="post" enctype="multipart/form-data" target="quietUp"> 
<label>   
<input name="fname" type="file" />   
</label>   
<label>   
<input type="submit" name="submit1" class="btn" value="上传"/>   
</label> 
</form>
<br/><br/>
 
  <h3>运行参数输入:</h3>
  <div style="float:right;margin-right:140px;margin-bottom:15px;">
      时间（分钟）:<input type="text" class="signin_input txt" id="RunTime" name="RunTime" tabindex="1" value="" />
  </div>
  <div style="float:right;margin-right:140px;">
    CPU数:<input type="text" class="signin_input txt" id="CPUNum" name="CPUNum" tabindex="2" value="" />
  </div>
   <button class="btn" style="margin-top:20px;"  onclick="sendRequest()">查看可用队列</button>
<form action="<?=site_url('inquiryqueue/submitjob')?>" method="post">
   <p style="margin-top:20px;">请选择要提交的队列: </p>
   <p><span id="txtHint"></span></p>
   <input type="submit" name="submitjob" style="margin-top:20px;" class="btn" value="提交任务"/>
</form>
<!--<form action="<?=site_url('inquiryqueue/multi_submitjob')?>" method="post">
   <input type="submit" name="multisubmitjob" style="margin-top:20px;" class="btn" value="批量提交任务"/>
</form> -->

<form action="<?=site_url('inquiryqueue/inquriy_Historyjob')?>" method="post" enctype="multipart/form-data"> 
<input type="submit" name="inquiryJob" style="margin-top:20px;" class="btn" value="查询历史作业"/>
</form>
<!-- <a href="<?=site_url('inquiryqueue/changePassword')?>" class="linkstyle">修改密码</a> -->
</div>
<?php  }?> 
