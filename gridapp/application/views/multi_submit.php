<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>�����ύ����</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>-->
    <script type="text/javascript">
function createXMLHttpRequest() {
   if(window.XMLHttpRequest) { //Mozilla �����
    XMLHttpReq = new XMLHttpRequest();
   }
   else if (window.ActiveXObject) { // IE�����
    try {
     XMLHttpReq = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
     try {
      XMLHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
     } catch (e) {}
    }
   }
}
  //����������
  function sendRequest(){
   createXMLHttpRequest();
   var walltime=document.getElementById("RunTime").value;
   var corenum=document.getElementById("CPUNum").value;
   
   var chosedApp = document.getElementsByName("app"); //�õ�����ѡ��Ӧ��������ز���
   var length = chosedApp.length;
   var chosedAppStr = "";
   for(i=length-1;i >=0;i--){
   	  if(chosedApp[i].checked == true)
      {
      	 if(i==0){ //���һ��Ӧ�����󣬲���Ҫ�»���
      	 	chosedAppStr+=chosedApp[i].value;
      	 }else{
           chosedAppStr+=chosedApp[i].value+"_";
         }
      }
   }
   if(chosedAppStr.substr(-1,1) =="_"){
   	   chosedAppStr = chosedAppStr.substr(0,chosedAppStr.length-1); //ȥ�������»���
   }
   //alert("test:"+chosedAppStr);
   var url = 'http://localhost/gridapp/index.php/inquiryqueue/inquiryavailablequeue/'+walltime+'/'+corenum+'/'+chosedAppStr;
   XMLHttpReq.open("GET", url,true);
   XMLHttpReq.onreadystatechange = processResponse;//ָ����Ӧ����
   XMLHttpReq.send(null);  // ��������   
  }
   // ��������Ϣ����
   function processResponse() {
      if (XMLHttpReq.readyState == 4) { // �ж϶���״̬
          if (XMLHttpReq.status == 200) { // ��Ϣ�Ѿ��ɹ����أ���ʼ������Ϣ
               //$('show').innerHTML = XMLHttpReq.responseText;
               $('txtHint').innerHTML = XMLHttpReq.responseText;
             } else { //ҳ�治����
                 window.alert("���������ҳ�����쳣��");
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
    <h2 style="color:white;margin-top:10px;">�п�Ժ����������������Ӧ��</h2>
   </div>
   <div style="color:white;padding-top:30px;">��ӭ����<?php echo $this->session->userdata('username');?>   &nbsp;&nbsp;<a href="<?=site_url('login/logout')?>" class="linkstyle">�˳���¼��Logout</a></div>
 </div>
<?php if ($this->session->userdata('username')){  ?>
<div class='loginPage' style="margin-top:-70px">
  <h2 class="submitfont">��ˮ���ύ������ز���</h2>
<iframe name="quietUp" style="display :none">
</iframe>
  
 <div class="chooseAppRegion">
            ѡ��Ӧ��:
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
 <div style="margin-top:10px;"><a href="#" id="chooseall" class="linkstyle">ȫѡ</a>    <a href="#" id="cancelchooseall" class="linkstyle" style="margin-right:30px;">��ѡ</a>  ѡ������Ӧ�ã�
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
<input type="submit" name="submit1" class="btn" value="�ϴ�"/>   
</label> 
</form>
<br/><br/>
 
  <h3>���в������루ÿ������Ĳ�����:</h3>
  <div style="float:right;margin-right:140px;margin-bottom:15px;">
      ʱ�䣨���ӣ�:<input type="text" class="signin_input txt" id="RunTime" name="RunTime" tabindex="1" value="" />
  </div>
  <div style="float:right;margin-right:140px;">
    CPU��:<input type="text" class="signin_input txt" id="CPUNum" name="CPUNum" tabindex="2" value="" />
  </div>
   <button class="btn" style="margin-top:20px;"  onclick="sendRequest()">�鿴���ö���</button>
<form action="<?=site_url('inquiryqueue/multi_submitjob')?>" method="post">
   <p style="margin-top:20px;">��ѡ��Ҫ�ύ�Ķ���: </p>
   <p><span id="txtHint"></span></p>
   <input type="submit" name="multisubmitjob" style="margin-top:20px;" class="btn" value="�ύ����"/>
</form>

<form action="<?=site_url('inquiryqueue/inquriy_Pipelinejob')?>" method="post" enctype="multipart/form-data"> 
<input type="submit" name="inquiryJob" style="margin-top:20px;" class="btn" value="��ѯ��ˮ����ҵ"/>
</form>

</div>
<?php  }?>
</body>
</html>