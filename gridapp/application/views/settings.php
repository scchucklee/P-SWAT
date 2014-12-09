<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>账户设置-SCGG</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>   
</head>
<body class="homebg">
 <?php $this->load->view('header') ?>
 <div id="content">
     <ul class="title-box">
			<li class="active">个人档案</li><li class="unactive"><a href="<?=site_url('account/password')?>" target="_self">修改密码</a></li>
	 </ul>
   <form class="form-horizontal settings-form" role="form" id="info-form" action="/account/fillInfo" method="post">
    <input type="hidden" name="redirect" value="/account/settings">
    <div class="form-group ">
        <label for="user-name" class="control-label">昵称:</label>
        <div class="input">
            <input type="text" value="<?php echo $this->session->userdata('username');?>" class="form-control input-count" name="user-name" id="user-name" disabled="disabled" style="background-color:rgb(240, 240, 240);" placeHolder="给自己取个名字" min="0.5" max="8" chartype="2">
        </div>
    </div>
    <div class="form-group">
        <label for="city" class="control-label">地点:</label>
        <div class="input">
            <input type="text" value="北京市" class="form-control input-count" name="city" id="city" placeHolder="你所处的地方" min="0" max="10" chartype="2">
        </div>
    </div>
    <div class="form-group">
        <label for="age" class="control-label">年龄:</label>
        <div class="input">
            <input type="text" value="24" class="form-control" name="age" id="age" placeHolder="你多大了">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label">性别:</label>
        <div class="input">
        	<label for="gender-male" class="radio-inline">
            	<input type="radio" value="MALE" name="gender" id="gender-male" checked> 男
            </label>
            <label for="gender-female" class="radio-inline">
            	<input type="radio" value="FEMALE" name="gender" id="gender-female" > 女
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="current-desc" class="control-label">单位:</label>
        <div class="input">
            <input type="text" value="中科院超算中心" class="form-control input-count" name="department" id="department" placeHolder="你的单位名" min="0" max="10" chartype="2">
        </div>
    </div>
    <div class="form-group">
        <label for="future-desc" class="control-label">职称:</label>
        <div class="input">
            <input type="text" value="副研究员" class="form-control input-count" name="academic-title" id="academic-title" placeHolder="你的职称" min="0" max="10" chartype="2">
        </div>
    </div>
    <div class="form-group">
    	<label class="control-label"></label>
        <div class="input">
            <button id="submit-info" class="submit-btn">保存</button>
        </div>
    </div>
 </form>
 </div>
 <?php $this->load->view('footer') ?>
</body>
</html>
