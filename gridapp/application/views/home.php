<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>��ҳ-�������ѧ����</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/picslider.js"></script>
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
   //alert("test:"+corenum);
   var chosedAppStr="gaussian";
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
			<li><a href=""><img src="<?=base_url()?>img/bg1.jpg"  border=0 alt="scgg" title="�������ѧ����--SCGG"/></a><span class="wordsonpic" style="top:20%; left:23%;">�������ѧ����Supercomputing Geography Grid</span></li>
			<li><a href="http://cscgrid.cas.cn/sydt/201311/t20131115_134645.html" target="_blank"><img src="<?=base_url()?>img/shenteng7000.jpg"  border=0 alt="����7000" title="����7000" /></a><span class="wordsonpic">����7000</span></li>
			<li><a href="http://cscgrid.cas.cn/sydt/201311/t20131115_134639.html" target="_blank"><img src="<?=base_url()?>img/centerloc.jpg"  border=0 alt="�������ķֲ�" title="�п�Ժ��������ֲ�" /></a><span class="wordsonpic" style="color:black;left:10%;">�п�Ժ������������Ⱥ�ֲ�</span></li>
		    <li><a href=""><img src="<?=base_url()?>img/SWAT.jpg"  border=0 alt="SWATӦ��" title="SWATӦ��" /></a><span class="wordsonpic" style="color:black;">SWATӦ��</span></li>
		 </ul>
     </div>
     <div style="margin:10px 0px 30px 20px;height:auto;min-height:330px"> 
         <div class="homeitem" style="margin-right:21px;">
            <h3 class="item-info">ƽ̨����</h3>
            <p class="item-desc">�������ѧ����Supercomputing Geography Grid,���SCGG�������������й���ѧԺ������㻷������
              P-SWATӦ�ý��е�һ��ҵ�ύ�������Լ����ܵ��ε�һ���ۺϹ���ƽ̨��</p>
            <a href="<?=site_url('home/introduce_platform')?>" class="item-btn">�������</a>
         </div>
         <div class="homeitem" style="margin-right:21px;">
            <h3 class="item-info">PSWAT</h3>
            <p class="item-desc">PSWAT��Parallel SWAT������SWAT�ļ�ơ����Ӧ������ԭ��SWATӦ�õĻ����ϣ�ͨ�����벢���㷨��������
                       ������ɵ��ֶΣ�ʹ�ô�Ӧ���ܸ��졢��׼ȷ�Ļ�ý����</p>
            <a href="<?=site_url('home/submit_pswat')?>" class="item-btn">�������</a>
         </div>
         <div class="homeitem">
            <h3 class="item-info">��ʷ����</h3>
            <p class="item-desc">��ʷ�����������ģ����Ҫ��չʾ�û�֮ǰ���ύ��������ҵ��ͨ����ģ�飬���Է���Ĳ鿴�������������
              Ҳ���Բ鿴�����ظ�����ҵ������ļ���Ҳ������ֹ��ɾ������</p>
            <a href="<?=site_url('home/inquriy_Historyjob')?>" class="item-btn">�������</a>
         </div>
     </div>
     <div style="margin:20px 0px 50px 20px;height:auto;min-height:130px;"></div>
 </div>
 <?php $this->load->view('footer') ?>
</body>
</html>