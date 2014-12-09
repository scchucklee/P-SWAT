<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>主页-超算地理学网格</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/picslider.js"></script>
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
   //alert("test:"+corenum);
   var chosedAppStr="gaussian";
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
<style type="text/css">
/* focus */
#focus{width:960px;height:340px;overflow:hidden;position:relative;}
#focus ul{height:380px;position:absolute;}
#focus ul li{float:left;width:960px;height:340px;overflow:hidden;position:relative;background:#000;}
#focus img{width:960px;height:340px;}
#focus ul li div{position:absolute;overflow:hidden;}
#focus .btnBg{position:absolute;width:960px;height:20px;left:0;bottom:0;background:#000;}
#focus .btn{position:absolute;width:960px;height:10px;padding:5px 10px;right:0;bottom:0;text-align:right;}
#focus .btn span{display:inline-block;_display:inline;_zoom:1;width:25px;height:10px;_font-size:0;margin-left:5px;cursor:pointer;background:#fff;}
#focus .btn span.on{background:#fff;}
#focus .preNext{width:45px;height:100px;position:absolute;top:90px;background:url('../img/sprite.png') no-repeat 0 0;cursor:pointer;}
#focus .pre{left:0;}
#focus .next{right:0;background-position:right top;}
</style>
</head>
<body class="homebg">
 <?php $this->load->view('header') ?>
 <div id="content">
     <div class="conTitle" id="focus">
         <ul>
			<li><a href=""><img src="<?=base_url()?>img/bg1.jpg"  border=0 alt="scgg" title="超算地理学网格--SCGG"/></a><span class="wordsonpic" style="top:20%; left:23%;">超算地理学网格Supercomputing Geography Grid</span></li>
			<li><a href="http://cscgrid.cas.cn/sydt/201311/t20131115_134645.html" target="_blank"><img src="<?=base_url()?>img/shenteng7000.jpg"  border=0 alt="深腾7000" title="深腾7000" /></a><span class="wordsonpic">深腾7000</span></li>
			<li><a href="http://cscgrid.cas.cn/sydt/201311/t20131115_134639.html" target="_blank"><img src="<?=base_url()?>img/centerloc.jpg"  border=0 alt="超算中心分布" title="中科院超算网格分布" /></a><span class="wordsonpic" style="color:black;left:10%;">中科院超级计算网格集群分布</span></li>
		    <li><a href=""><img src="<?=base_url()?>img/SWAT.jpg"  border=0 alt="SWAT应用" title="SWAT应用" /></a><span class="wordsonpic" style="color:black;">SWAT应用</span></li>
		 </ul>
     </div>
     <div style="margin:10px 0px 30px 20px;height:auto;min-height:330px"> 
         <div class="homeitem" style="margin-right:21px;">
            <h3 class="item-info">平台介绍</h3>
            <p class="item-desc">超算地理学网格（Supercomputing Geography Grid,简称SCGG），是依托于中国科学院网格计算环境，对
              P-SWAT应用进行单一作业提交、管理以及智能调参的一个综合管理平台。</p>
            <a href="<?=site_url('home/introduce_platform')?>" class="item-btn">点击进入</a>
         </div>
         <div class="homeitem" style="margin-right:21px;">
            <h3 class="item-info">PSWAT</h3>
            <p class="item-desc">PSWAT是Parallel SWAT即并行SWAT的简称。这个应用是在原有SWAT应用的基础上，通过加入并行算法，种子数
                       随机生成等手段，使得此应用能更快、更准确的获得结果。</p>
            <a href="<?=site_url('home/submit_pswat')?>" class="item-btn">点击进入</a>
         </div>
         <div class="homeitem">
            <h3 class="item-info">历史任务</h3>
            <p class="item-desc">历史任务这个功能模块主要是展示用户之前已提交的所有作业，通过此模块，可以方便的查看任务运行情况，
              也可以查看、下载各个作业的输出文件。也可以终止或删除任务。</p>
            <a href="<?=site_url('home/inquriy_Historyjob')?>" class="item-btn">点击进入</a>
         </div>
     </div>
     <div style="margin:20px 0px 50px 20px;height:auto;min-height:130px;"></div>
 </div>
 <?php $this->load->view('footer') ?>
</body>
</html>