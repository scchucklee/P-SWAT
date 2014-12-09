<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>批量提交任务</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>-->
    <script type="text/javascript">
function createXMLHttpRequest() {
   if(window.XMLHttpRequest) { //Mozilla 浏览器
    XMLHttpReq = new XMLHttpRequest();
   }
   else if (window.ActiveXObject) { // IE浏览器
    try {
     XMLHttpReq = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
     try {
      XMLHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
     } catch (e) {}
    }
   }
}
  //发送请求函数
  function sendRequest(){
   createXMLHttpRequest();
   var walltime=document.getElementById("RunTime").value;
   var corenum=document.getElementById("CPUNum").value;
   
   var chosedApp = document.getElementsByName("app"); //得到所勾选的应用名的相关操作
   var length = chosedApp.length;
   var chosedAppStr = "";
   for(i=length-1;i >=0;i--){
   	  if(chosedApp[i].checked == true)
      {
      	 if(i==0){ //最后一个应用名后，不需要下划线
      	 	chosedAppStr+=chosedApp[i].value;
      	 }else{
           chosedAppStr+=chosedApp[i].value+"_";
         }
      }
   }
   if(chosedAppStr.substr(-1,1) =="_"){
   	   chosedAppStr = chosedAppStr.substr(0,chosedAppStr.length-1); //去掉最后的下划线
   }
   //alert("test:"+chosedAppStr);
   var url = 'http://localhost/gridapp/index.php/inquiryqueue/inquiryavailablequeue/'+walltime+'/'+corenum+'/'+chosedAppStr;
   XMLHttpReq.open("GET", url,true);
   XMLHttpReq.onreadystatechange = processResponse;//指定响应函数
   XMLHttpReq.send(null);  // 发送请求   
  }
   // 处理返回信息函数
   function processResponse() {
      if (XMLHttpReq.readyState == 4) { // 判断对象状态
          if (XMLHttpReq.status == 200) { // 信息已经成功返回，开始处理信息
               //$('show').innerHTML = XMLHttpReq.responseText;
               $('txtHint').innerHTML = XMLHttpReq.responseText;
             } else { //页面不正常
                 window.alert("您所请求的页面有异常。");
             }
         }
    }
    function $(id)
    {
      return document.getElementById(id);
    }
</script>
</head>
<body>
 <div id='header'>
   <div class="logoimg">
   <a href="<?=site_url('home')?>"><img src="<?=base_url()?>img/sc.jpg" style="float:left;width:60px;height:60px;"/></a>
    <h2 style="color:white;margin-top:10px;">中科院超级计算中心网格应用</h2>
   </div>
   <div style="color:white;padding-top:30px;">欢迎您，<?php echo $this->session->userdata('username');?>   &nbsp;&nbsp;<a href="<?=site_url('login/logout')?>" class="linkstyle">退出登录，Logout</a></div>
 </div>
<?php if ($this->session->userdata('username')){  ?>
<div class='loginPage' style="margin-top:-70px">
  <h2 class="submitfont">流水线提交任务相关操作</h2>
<iframe name="quietUp" style="display :none">
</iframe>
  
 <div class="chooseAppRegion">
            选择应用:
       <!--<select id="chooseapp" name="chooseapp" class="selectstyle" onchange="changeappkind(this.value)">
             <option value="gaussian">gaussian</option>
             <option value="swat">swat</option>
             <option value="Vasp">VASP</option>
       </select> -->
       <input type="checkbox" id="app[]" name="app" value="A" class="label_check"/>&nbsp;<label  style="margin-right:15px;">A</label>
       <input type="checkbox" id="app[]" name="app" value="B" class="label_check"/>&nbsp;<label  style="margin-right:15px;">B</label> 
       <input type="checkbox" id="app[]" name="app" value="C" class="label_check"/>&nbsp;<label  style="margin-right:15px;">C</label>
       <input type="checkbox" id="app[]" name="app" value="D" class="label_check"/>&nbsp;<label  style="margin-right:15px;">D</label>   
 </div>
 <div style="margin-top:10px;"><a href="#" id="chooseall" class="linkstyle">全选</a>    <a href="#" id="cancelchooseall" class="linkstyle" style="margin-right:30px;">反选</a>  选择其他应用：
  <input type="text" class="signin_input txt" style="height:19px;margin-left:113px;" id="appName" name="appName" /><button class="btn" style="padding: 3px 15px 3px;margin-left:10px;" id="addNewApp">OK</button>
 </div>
 <div style="height:auto;padding-bottom:20px;">
 <ul class="selectappli">
   <li class="linkstyle pointer">Swat</li>
   <li class="linkstyle pointer">NAMD</li>
   <li class="linkstyle pointer">VASP</li>
   <li class="linkstyle pointer">Kamp</li>
 </ul>
 </div>
 <br/>
 
<form action="<?=site_url('home/uploadfile')?>" method="post" enctype="multipart/form-data" target="quietUp">
<label>   
<input name="fname" type="file" />   
</label>   
<label>   
<input type="submit" name="submit1" class="btn" value="上传"/>   
</label> 
</form>
<br/><br/>
 
  <h3>运行参数输入（每个任务的参数）:</h3>
  <div style="float:right;margin-right:140px;margin-bottom:15px;">
      时间（分钟）:<input type="text" class="signin_input txt" id="RunTime" name="RunTime" tabindex="1" value="" />
  </div>
  <div style="float:right;margin-right:140px;">
    CPU数:<input type="text" class="signin_input txt" id="CPUNum" name="CPUNum" tabindex="2" value="" />
  </div>
   <button class="btn" style="margin-top:20px;"  onclick="sendRequest()">查看可用队列</button>
<form action="<?=site_url('inquiryqueue/multi_submitjob')?>" method="post">
   <p style="margin-top:20px;">请选择要提交的队列: </p>
   <p><span id="txtHint"></span></p>
   <input type="submit" name="multisubmitjob" style="margin-top:20px;" class="btn" value="提交任务"/>
</form>

<form action="<?=site_url('inquiryqueue/inquriy_Pipelinejob')?>" method="post" enctype="multipart/form-data"> 
<input type="submit" name="inquiryJob" style="margin-top:20px;" class="btn" value="查询流水线作业"/>
</form>

</div>
<?php  }?>
</body>
</html>