<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('rest');
        $this->load->helper('cookie');
    }
    
    public function index()
	{
		$this->load->view('settings');
	}
	
	public function settings()
	{
        $this->load->view('settings');
	}
	
	public function password()
	{
		$this->load->view('password');
	}
	
	public function changepasswd(){
		$username = $this->session->userdata('username');
		$current_passwd= $this->input->post('current-password');
		$new_passwd= $this->input->post('new-password');
		$confirm_passwd= $this->input->post('confirm-password');
		$cookiefile = $this->session->userdata['cookiefile'];
		if($new_passwd ==$confirm_passwd){
			$url_changePass='https://api.scgrid.cn/v1/users/'.$username.'/newpwd?newpwd='.$new_passwd.'&oldpwd='.$current_passwd;
			//$url_changePass='https://api.scgrid.cn:8443/sceapi-rest/restv0/users/'.$name.'/newpwd?newpwd='.$newpw.'&oldpwd='.$passowrd;
			$req_changepw= curl_init();
			curl_setopt($req_changepw, CURLOPT_URL, $url_changePass);
			curl_setopt($req_changepw, CURLOPT_HEADER, false);
			curl_setopt($req_changepw, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
			curl_setopt($req_changepw, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($req_changepw, CURLOPT_COOKIEJAR, $cookiefile); //保存cookie
			curl_setopt($req_changepw, CURLOPT_COOKIEFILE, $cookiefile); //发送cookie
			curl_setopt($req_changepw, CURLOPT_SSL_VERIFYPEER, false);
			
			$exec_changepw = curl_exec($req_changepw);
			$json_exec_changepw = json_decode($exec_changepw, true);
			//$md5secret=$json_exec_changepw['md5secret'];
			curl_close($req_changepw) ;
			$status_changepw=$json_exec_changepw['status_code'];
			if($status_changepw=='0'){
				echo '<script type="text/javascript" language="javascript">;alert("密码修改成功！");location.href="'.site_url('account/password').'";</script>';
			}else{
				echo '<script type="text/javascript" language="javascript">;alert("用户名密码错误，请重新输入！");location.href="'.site_url('account/password').'";</script>';
			}
	    }else{
	    		echo '<script type="text/javascript" language="javascript">alert("两次输入的新密码不一致，请重新输入！");location.href="'.site_url('account/password').'";</script>';
	    }
	}
	
	
}
