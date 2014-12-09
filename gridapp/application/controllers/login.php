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
		//cookie�ļ��洢Ŀ¼��windows�汾������ָ�����ļ���
        //$cookiefile='C:\Windows\Temp\cookies.txt';
        $cookiefile= $_SERVER['DOCUMENT_ROOT'].'/gridapp/tmp/cookies.txt';
        //��¼����urlǰ׺Ϊapi.scgrid.cn:8443/sceapi-rest/��API������
        $url_login = 'https://rest.scgrid.cn:443/sceapi-rest/restv0/users/login?username='.$username.'&password='.$password.'&appid=geotest&remember=true';
        //��¼����urlǰ׺Ϊ59.226.49.157:8443/restapi2/�ǲ���ǿ�Լ��ı�������������ʱ�������Բ������õ� api.scgrid.cn/v1
        //$url_login = 'https://159.226.49.157:8443/restapi2/restv0/users/login?username='.$name.'&password='.$passowrd.'&appid=test&remember=true';

        $req_login = curl_init();//��ʼ���Ự
        curl_setopt($req_login, CURLOPT_URL, $url_login);
        curl_setopt($req_login, CURLOPT_HEADER, false);
        //�����������ͷ��Ϣ���ã�Ҫ�󷵻�����json��ʽ��user-agent���������������ʱ���˴����������д
        curl_setopt($req_login, CURLOPT_HTTPHEADER, Array("accept:application/json","user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"));
        curl_setopt($req_login, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req_login, CURLOPT_COOKIEJAR, $cookiefile); //����cookie
        curl_setopt($req_login, CURLOPT_COOKIEFILE, $cookiefile); //����cookie
        curl_setopt($req_login, CURLOPT_SSL_VERIFYPEER, false);
        
        //��������ִ��
        $exec_login = curl_exec($req_login);       
        //echo $exec_login;
        //��API���ص��������json����
        $json_exec_login = json_decode($exec_login, true);       
        //status_codeΪ״̬�룬�ò���Ϊ0˵����¼��֤ͨ��
        $status=$json_exec_login['status_code'];       
        //�����ǵ�¼��ת��Ӧ��ѡ����ҵ�ύҳ��first_GaussianWizard.php���ʹ�����ʾ
        if($status=='0'){
        	//��ȡ���е�md5secret����
            //�����¼�ķ��ؿ���ֱ����������ʺ�һ�¾���ķ�������
            //�ã�https://api.scgrid.cn:8443/sceapi-rest/restv0/users/login?username=scgrid00&password=111111&appid=test&remember=true
            $md5secret=$json_exec_login['md5secret'];
 
            $this->session->set_userdata('md5secret',$md5secret);
            $this->session->set_userdata('cookiefile',$cookiefile);
            $this->session->set_userdata('username',$username);
            //echo "md5secret:".$md5secret;
            redirect(site_url('home'));           
        }else{ 
           echo '<script type="text/javascript" language="javascript">alert("�û���������������������룡");location.href="index";</script>';
        }     
        curl_close($req_login) ;
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}
