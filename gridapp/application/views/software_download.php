<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>���������</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>   
</head>
<body class="homebg">
 <?php $this->load->view('header') ?>
 <div id="content">
     <ul class="title-box">
			<li class="active" style="margin-left:102px;">PSWAT������<span style="font-size:13px;">���ṩ������Ϣ�������أ��Թ�������ͳ�ƣ�</span></li>
	 </ul>
   <form class="form-horizontal settings-form" role="form" id="info-form" action="<?=site_url('home/download/PSWAT.zip')?>" method="post" onsubmit="return checkdownloadinfo()">
    <input type="hidden" name="redirect" value="/account/settings">
    <div class="form-group ">
        <label for="user-name" class="control-label">�ǳ�:</label>
        <div class="input">
            <input type="text" value="<?php echo $this->session->userdata('username');?>" class="form-control input-count" name="user-name" id="user-name" disabled="disabled" style="background-color:rgb(240, 240, 240);" placeHolder="���Լ�ȡ������" min="0.5" max="8" chartype="2">
        </div>
    </div>
    <div class="form-group">
        <label for="city" class="control-label">����:</label>
        <div class="input">
            <input type="text" value="" class="form-control input-count" name="realname" id="realname" placeHolder="�����ʵ����" min="0" max="10" chartype="2">
        </div>
    </div>
    <div class="form-group">
        <label for="age" class="control-label">����:</label>
        <div class="input">
            <input type="text" value="" class="form-control" name="mailbox" id="mailbox" placeHolder="�������">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label">�Ա�:</label>
        <div class="input">
        	<label for="gender-male" class="radio-inline">
            	<input type="radio" value="��" name="gender" id="gender-male" checked> ��
            </label>
            <label for="gender-female" class="radio-inline">
            	<input type="radio" value="Ů" name="gender" id="gender-female" > Ů
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="current-desc" class="control-label">��λ:</label>
        <div class="input">
            <input type="text" value="" class="form-control input-count" name="department" id="department" placeHolder="��ĵ�λ" min="0" max="10" chartype="2">
        </div>
    </div>
    <div class="form-group">
        <label for="future-desc" class="control-label">ְ��:</label>
        <div class="input">
            <input type="text" value="" class="form-control input-count" name="academic-title" id="academic-title" placeHolder="���ְ��" min="0" max="10" chartype="2">
        </div>
    </div>
    <div class="form-group">
    	<label class="control-label"></label>
        <div class="input">
            <button id="submit-info" type="submit" class="submit-btn">����</button>
        </div>
    </div>
 </form>
 </div>
 <?php $this->load->view('footer') ?>
</body>
</html>