<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>PSWAT��ҵ�ύ-SCGG</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>  
    <script src="<?=base_url()?>js/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>js/uploadify/uploadify.css"> 
    <script src="<?=base_url()?>js/layer/layer.min.js" type="text/javascript"></script>
    <script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : '<?=base_url()?>js/uploadify/uploadify.swf',
				'uploader' : '<?=base_url()?>js/uploadify/uploadify.php',
				'buttonText':'��ѡ���ļ�', 
				'fileSizeLimit':'800MB', 
                'fileTypeDesc':'*.zip;',  
                'fileTypeExts':'*.zip;',
                'onUploadComplete' : function(fileObj){//��ʾ�ϴ��ɹ�����ļ���
                   var filename = fileObj.name;
                   $.ajax({  
                     type:"GET" 
                     ,url:"<?=base_url()?>index.php/home/uploadfile/"+filename  
                     ,data:{id:1}                                
                     ,contentType:'text/html;charset=utf-8'//�����ʽ  
                    ,beforeSend:function(data){  
                        
                    }
                   ,success:function(data){  
                         //alert(data);
                    } 
                  }); 
               }
               
			});
		});
	</script>
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
     var re = /^[1-9]+[0-9]*]*$/;
     if(walltime=="" || corenum =="" ||!re.test(walltime) || !re.test(corenum)){
     	alert("Please input the correct Runtime or CPUCount!");
     }else{
      var appname="PSWAT";
      var url = 'http://localhost/gridapp/index.php/submitpswat/inquiryavailablequeue/'+walltime+'/'+corenum+'/'+appname;
      XMLHttpReq.open("GET", url,true);
      XMLHttpReq.onreadystatechange = processResponse;//ָ����Ӧ����
      XMLHttpReq.send(null);  // ��������  
     } 
   }
   //��������Ϣ����
   function processResponse() {
      if (XMLHttpReq.readyState == 4) { // �ж϶���״̬
          if (XMLHttpReq.status == 200) { // ��Ϣ�Ѿ��ɹ����أ���ʼ������Ϣ
               $('#txtHint').html(XMLHttpReq.responseText);
          } else { //ҳ�治����
               window.alert("���������ҳ�����쳣��");
          }
      }
    }
	</script>
</head>
<body class="homebg">
 <?php $this->load->view('header') ?>
 <div id="content">
      <h2 class="submitfont" style="margin-top:30px;color:#999;">PSWAT��ҵ�ύ</h2>
      <fieldset>
         <legend>�����������</legend>
         <div class="allparsdiv">
             <div class="rowparsdiv">
                <div class="onepardiv"><h4 title="0.00000~1.00000">Alpha_Bf</h4><input type="text" name="Alpha_Bf" disabled value="<?php echo $allparsvalue['Alpha_Bf']; ?>"></div>
                <div class="onepardiv"><h4 title="0.00000~150.00">Ch_K2</h4><input type="text" name="Ch_K2" disabled value="<?php echo $allparsvalue['Ch_K2']; ?>"></div>
                <div class="onepardiv"><h4 title="0.00000~1.00000">Ch_N2</h4><input type="text" name="Ch_N2" disabled value="<?php echo $allparsvalue['Ch_N2']; ?>"></div>
                <div class="onepardiv"><h4 title="-25.00000~25.00000">Cn2</h4><input type="text" name="Cn2" disabled value="<?php echo $allparsvalue['Cn2']; ?>"></div>
                <div class="onepardiv"><h4 title="0.00000~1.00000">Epco</h4><input type="text" name="Epco" disabled value="<?php echo $allparsvalue['Epco']; ?>"></div>
             </div>
             <div class="rowparsdiv">
                <div class="onepardiv"><h4 title="0.00000~1.00000">Esco</h4><input type="text" name="Esco" disabled value="<?php echo $allparsvalue['Esco']; ?>"></div>
                <div class="onepardiv"><h4 title="-10.00000~10.00000">Gw_Delay</h4><input type="text" name="Gw_Delay" disabled value="<?php echo $allparsvalue['Gw_Delay']; ?>"></div>
                <div class="onepardiv"><h4 title="-0.03600~0.03600">Gw_Revap</h4><input type="text" name="Gw_Revap" disabled value="<?php echo $allparsvalue['Gw_Revap']; ?>"></div>
                <div class="onepardiv"><h4 title="-1000.00~1000.00">Gwqmn</h4><input type="text" name="Gwqmn" disabled value="<?php echo $allparsvalue['Gwqmn']; ?>"></div>
                <div class="onepardiv"><h4 title="-100.00~100.00">Revapmn</h4><input type="text" name="Revapmn" disabled value="<?php echo $allparsvalue['Revapmn']; ?>"></div>
             </div>
             <div class="rowparsdiv">
                <div class="onepardiv"><h4 title="0.00000~5.00000">Sftmp</h4><input type="text" name="Sftmp" disabled value="<?php echo $allparsvalue['Sftmp']; ?>"></div>
                <div class="onepardiv"><h4 title="-25.00000~25.00000">Slope</h4><input type="text" name="Slope" disabled value="<?php echo $allparsvalue['Slope']; ?>"></div>
                <div class="onepardiv"><h4 title="-25.00000~25.00000">Slsubbsn</h4><input type="text" name="Slsubbsn" disabled value="<?php echo $allparsvalue['Slsubbsn']; ?>"></div>
                <div class="onepardiv"><h4 title="0.00000~10.00000">Smfmn</h4><input type="text" name="Smfmn" disabled value="<?php echo $allparsvalue['Smfmn']; ?>"></div>
                <div class="onepardiv"><h4 title="0.00000~10.00000">Smfmx</h4><input type="text" name="Smfmx" disabled value="<?php echo $allparsvalue['Smfmx']; ?>"></div>
             </div>
             <div class="rowparsdiv">
                <div class="onepardiv"><h4 title="-25.00000~25.00000">Smtmp</h4><input type="text" name="Smtmp" disabled value="<?php echo $allparsvalue['Smtmp']; ?>"></div>
                <div class="onepardiv"><h4 title="-25.00000~25.00000">Sol_Awc</h4><input type="text" name="Sol_Awc" disabled value="<?php echo $allparsvalue['Sol_Awc']; ?>"></div>
                <div class="onepardiv"><h4 title="-25.00000~25.00000">Sol_K</h4><input type="text" name="Sol_K" disabled value="<?php echo $allparsvalue['Sol_K']; ?>"></div>
                <div class="onepardiv"><h4 title="0.00000~10.00000">Surlag</h4><input type="text" name="Surlag" disabled value="<?php echo $allparsvalue['Surlag']; ?>"></div>
                <div class="onepardiv"><h4 title="0.00000~1.00000">Timp</h4><input type="text" name="Timp" disabled value="<?php echo $allparsvalue['Timp']; ?>"></div>
             </div>
             <div class="rowparsdiv">
                <div class="onepardiv"><h4 title="0.00000~50.00000">Tlaps</h4><input type="text" name="Tlaps" disabled value="<?php echo $allparsvalue['Tlaps']; ?>"></div>
             </div>
         </div>
      </fieldset>
      <div class="editparsbtnregion"><a class="btn1 linkstyle" id="editval" style="margin-right:10px;">Edit Values</a><a href="" class="btn1 adisabledstyle" id="canceledit" style="margin-right:10px;">Cancel Edits</a><a class="btn1 adisabledstyle" id="saveedit" style="margin-right:10px;">Save Edits</a><a href="<?=site_url('home')?>" class="btn1 linkstyle">Exit</a></div>
      <div class="editparsbtnregion">
         <p style="width:575px;background-color:#247fcc;color:white;margin-bottom:10px;">�ϴ��ļ�</p>     
         <form action="<?=site_url('home/uploadfile')?>" method="post">            
               �뽫�ļ�����һ���ļ�������ѹ����zip���ϴ���*.zip��<input id="file_upload" name="file_upload" type="file" accept="application/x-zip-compressed" title="�뽫�ļ�ѹ����zip�����ϴ�" multiple="true">   
          <!--<input type="submit" name="submit1" class="btn1 linkstyle" style="padding:4px 10px 4px;" value="�ϴ�"/> -->  
         </form>
      </div>
      <form action="<?=site_url('submitpswat/submitjob')?>" method="post" onsubmit="return check()" id="submit_form" name="submit_form">
      <div class="editparsbtnregion">
         <p style="width:575px;background-color:#247fcc;color:white;margin-bottom:10px;">����ļ�</p>     
                 ����ļ�����<input type="text" id="outputfilename" name="outputfilename" value="" style="height: 24px;font-size: 14px;line-height: 1.428571429;" />
      </div>
      <fieldset>
          <legend>����ʱ�������</legend>
          <div class="runningparsregion">
                    ʱ��(>1����):<input type="text" id="RunTime" name="RunTime" tabindex="1" value="" style="margin-left:80px;"/>
          </div>
          <div class="runningparsregion" style="margin-bottom:10px;">
            CPU����(4~256): <input type="text" id="CPUNum" name="CPUNum" tabindex="2" value="" style="margin-left:47px;"/>
          </div>
          <div class="runningparsregion" style="margin-bottom:10px;">
                    ���������ٷֱ�(0~1): <input type="text" id="Percent" name="Percent" tabindex="3" value="0.1" style="margin-left:19px;"/>
          </div>
          <div class="runningparsregion" style="margin-bottom:10px;">
                     ������(1��1/2���ĺ���): <input type="text" id="SeedNum" name="SeedNum" tabindex="4" value="" />
          </div>
      </fieldset>
      <div class="editparsbtnregion">
       <button class="btn1 linkstyle" type="button" style="margin-top:5px;text-align:left;width:150px;"  onclick="sendRequest()">�鿴���ö���</button>
       
        <p style="margin-top:20px;">��ѡ��Ҫ�ύ�Ķ���: </p>
        <p><span id="txtHint"></span></p>
        <input type="submit" name="submitjob" style="margin-top:20px;width:150px;" class="btn1 linkstyle" value="�ύ����" />
       
      </div>
      </form>
 </div>
 <?php $this->load->view('footer') ?>
</body>
</html>