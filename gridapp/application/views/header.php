<div id="page-header">
    <div class="wraper-header">
    <a href="<?=site_url('home')?>"><img src="<?=base_url()?>img/scgg.jpg"  border=0 style="float:left;width:160px;height:50px;" /></a>
	<ul class="header-navigation-bar">
	    <li><a href="<?=site_url('home')?>" class="li-link">��ҳ</a></li>
    	<li><a href="" class="li-link" id="aboutplatform">����ƽ̨</a>
    	    <ul class="newdropdown-menu">
        		<li><a href="<?=site_url('home/introduce_platform')?>">ƽ̨����</a></li>
        		<li><a href="<?=site_url('home/download_software')?>">PSWAT����</a></li>
        	</ul>
    	</li>
    	<li><a href="<?=site_url('home/submit_pswat')?>" class="li-link">��ҵ�ύ</a></li>
    	<li><a href="<?=site_url('home/inquriy_Historyjob')?>" class="li-link">��ʷ����</a></li>
    	<li style="float: right!important;margin-right:0px;"><a href="" class="li-link ty-link"><?php echo $this->session->userdata('username');?></a>
    	   <ul class="dropdown-menu">
        		<li><a href="<?=site_url('account/settings')?>">    &nbsp;&nbsp;�ʻ�����</a></li>
        		<li><a href="<?=site_url('login/logout')?>">    &nbsp;&nbsp;�˳���¼</a></li>
        	</ul>
    	</li>
    </ul>
    </div>
</div>
