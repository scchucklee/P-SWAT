<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh" dir="ltr">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
	<title>修改密码-SCGG</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/main.js"></script>   
</head>
<body class="homebg">
 <?php $this->load->view('header') ?>
 <div id="content">
     <ul class="title-box list-inline">
			<li class="unactive"><a href="<?=site_url('account/settings')?>" target="_self">个人档案</a></li><li class="active">修改密码</li>
		</ul>
		<form class="form-horizontal" role="form" id="password-form" method="post" action="<?=site_url('account/changepasswd')?>">
			<div class="change-password-success-tip hide"></div>
		    <div class="form-group">
		        <label for="current-password" class="control-label">当前密码:</label>
		        <div class="input">
		            <input type="password" typex="password" class="form-control input-count" name="current-password" id="current-password" min="1" max="999" chartype="1">
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="new-password" class="control-label">新密码:</label>
		        <div class="input">
		            <input type="password" typex="password" class="form-control input-count" name="new-password" id="new-password" min="6" max="20" chartype="1">
		        </div>
		        <div class="count hide">
		            <span class="current-count">0</span>/20，至少6个字符</span>
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="confirm-password" class="control-label">确认密码:</label>
		        <div class="input">
		            <input type="password" typex="password" class="form-control" name="confirm-password" id="confirm-password">
		        </div>
		    </div>
		    <div class="form-group">
		    	<label class="control-label"></label>
		        <div class="input">
		            <button type="submit" id="submit-password" class="submit-btn" disabled>保存</button>
		        </div>
		    </div>
		</form>
 </div>
 <?php $this->load->view('footer') ?>
</body>
</html>

