<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('rest');
        $this->load->helper('cookie');
    }
    
    public function index()
	{
		$this->load->view('login');
	}
	
    public function check()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		//cookie文件存储目录，windows版本，这里指定了文件名
        //$cookiefile='C:\Windows\Temp\cookies.txt';
        $cookiefile= $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/cookies.txt';
        //登录请求，url前缀为api.scgrid.cn:8443/sceapi-rest/是API服务器
        $url_login = 'https://rest.scgrid.cn:443/sceapi-rest/restv0/users/login?username='.$username.'&password='.$password.'&appid=geotest&remember=true';
        //登录请求，url前缀为59.226.49.157:8443/restapi2/是曹荣强自己的本机服务器，有时单步调试测试能用到 api.scgrid.cn/v1
        //$url_login = 'https://159.226.49.157:8443/restapi2/restv0/users/login?username='.$name.'&password='.$passowrd.'&appid=test&remember=true';

        $req_login = curl_init();//初始化会话
        curl_setopt($req_login, CURLOPT_URL, $url_login);
        curl_setopt($req_login, CURLOPT_HEADER, false);
        //这里是请求的头信息设置，要求返回内容json格式，user-agent后面这个变量，暂时除了纯数字外随便写
        curl_setopt($req_login, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
        curl_setopt($req_login, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req_login, CURLOPT_COOKIEJAR, $cookiefile); //保存cookie
        curl_setopt($req_login, CURLOPT_COOKIEFILE, $cookiefile); //发送cookie
        curl_setopt($req_login, CURLOPT_SSL_VERIFYPEER, false);
        
        //发送请求并执行
        $exec_login = curl_exec($req_login);       
        //echo $exec_login;
        //将API返回的请求进行json解析
        $json_exec_login = json_decode($exec_login, true);       
        //status_code为状态码，该参数为0说明登录验证通过
        $status=$json_exec_login['status_code'];       
        //以下是登录跳转（应用选择作业提交页面first_GaussianWizard.php）和错误提示
        if($status=='0'){
        	//获取其中的md5secret参数
            //这个登录的返回可以直接浏览器访问后看一下具体的返回内容
            //敲：https://api.scgrid.cn:8443/sceapi-rest/restv0/users/login?username=scgrid00&password=111111&appid=test&remember=true
            $md5secret=$json_exec_login['md5secret'];
 
            $this->session->set_userdata('md5secret',$md5secret);
            $this->session->set_userdata('cookiefile',$cookiefile);
            $this->session->set_userdata('username',$username);
            //echo "md5secret:".$md5secret;
            redirect(site_url('home'));           
        }else{ 
           echo '<script type="text/javascript" language="javascript">alert("用户名或密码错误，请重新输入！");location.href="index";</script>';
        }     
        curl_close($req_login) ;
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}
