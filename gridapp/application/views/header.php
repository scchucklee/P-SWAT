<div id="page-header">
    <div class="wraper-header">
    <a href="<?=site_url('home')?>"><img src="<?=base_url()?>img/scgg.jpg"  border=0 style="float:left;width:160px;height:50px;" /></a>
	<ul class="header-navigation-bar">
	    <li><a href="<?=site_url('home')?>" class="li-link">首页</a></li>
    	<li><a href="" class="li-link" id="aboutplatform">关于平台</a>
    	    <ul class="newdropdown-menu">
        		<li><a href="<?=site_url('home/introduce_platform')?>">平台介绍</a></li>
        		<li><a href="<?=site_url('home/download_software')?>">PSWAT下载</a></li>
        	</ul>
    	</li>
    	<li><a href="<?=site_url('home/submit_pswat')?>" class="li-link">作业提交</a></li>
    	<li><a href="<?=site_url('home/inquriy_Historyjob')?>" class="li-link">历史任务</a></li>
    	<li style="float: right!important;margin-right:0px;"><a href="" class="li-link ty-link"><?php echo $this->session->userdata('username');?></a>
    	   <ul class="dropdown-menu">
        		<li><a href="<?=site_url('account/settings')?>">    &nbsp;&nbsp;帐户设置</a></li>
        		<li><a href="<?=site_url('login/logout')?>">    &nbsp;&nbsp;退出登录</a></li>
        	</ul>
    	</li>
    </ul>
    </div>
</div>
