<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot extends CI_Controller {

	public function __construct(){
		parent::__construct();
    if($this->session->userdata('isLoggedIn')){
      redirect('/', 'refresh');
    } 
	}

	public function index()
	{
		$this->load->view('forgot/index');
	}

	public function init(){
		$username = $this->input->post('username');

		//cek email 
		$user = $this->builtbyprime->get('TBL_USER',array('USERNAME'=>$username), TRUE);
		if(!$user){
			echo "Username tidak dikenal / belum terdaftar.";
			exit();
		}

	    $factory   = new RandomLib\Factory;
	    $generator = $factory->getMediumStrengthGenerator();
	    
	    //Generate Token
	    $token      = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		
		$this->builtbyprime->update('TBL_FORGOT_PASSWORD',array('EMAIL'=>$user['EMAIL']),array('IS_VALID'=>0));

		//insert token
	    $insert = $this->builtbyprime->insert('TBL_FORGOT_PASSWORD',array('token'=>$token,'EMAIL'=>$user['EMAIL']));
	  
		// kirim email
		$config = Array(
		        'protocol'  => 'smtp',
		        'smtp_host' => 'ssl://smtp.googlemail.com',
		        'smtp_port' => '465',
		        'smtp_user' => 'dev@aegis.co.id',
      			'smtp_pass' => 'aegis10201',
		        'mailtype'  => 'html',
		        'starttls'  => true,
		        'newline'   => "\r\n"
	      );

	    $this->load->library('email', $config);
	    $this->email->from('noreply@Aegis.co.id', 'Forgot Password Confirmation');
	    $this->email->to($user['EMAIL']);
	    $this->email->subject('Forgot Password Confirmation');

	    $name = $user["NAME"];
	    $url  = ''.base_url().'forgot/confirm/?email='.$user['EMAIL'].'&token='.$token.'';
	    $mailContent = <<< EOT
		   Hi, $name <br />
		   Anda mengirimkan permintaan untuk me-reset passsword anda.<br /><br />
		   Silahkan klik link berikut ini untuk me-reset password :<br /> $url
EOT;
 
   		$this->email->message($mailContent);

	    if($this->email->send())
	    {
			echo "Cek email anda untuk proses pemulihan password.";
	    }
	    else
	    {
  			echo $this->email->print_debugger();
	    }
	}

	public function confirm(){
		$email = $this->input->get('email');
		$token = $this->input->get('token');
   		
   		$data = $this->builtbyprime->get('TBL_FORGOT_PASSWORD',array('TOKEN'=>$token,'EMAIL'=> $email,'IS_VALID'=>1),TRUE);

	    if(!$data){
	       show_404();
	    }

	    $password = rand(111111,999999);
	    $this->builtbyprime->update('TBL_USER',array('EMAIL'=>$data['EMAIL']),array('PASSWORD'=>md5($password)));

		// kirim email
		$config = Array(
		        'protocol'  => 'smtp',
		        'smtp_host' => 'ssl://smtp.googlemail.com',
		        'smtp_port' => '465',
		        'smtp_user' => 'dev@aegis.co.id',
      			'smtp_pass' => 'aegis10201',
		        'mailtype'  => 'html',
		        'starttls'  => true,
		        'newline'   => "\r\n"
	      );

	    $this->load->library('email', $config);
	    $this->email->from('noreply@Aegis.co.id', 'New Password');
	    $this->email->to($data['EMAIL']);
	    $this->email->subject('New Password');

	    $url  = ''.base_url().'forgot/change_pass/?email='.$data['EMAIL'].'';
	    $mailContent = <<< EOT
   			<br /><br />
   			Password Baru Anda : $password <br /><br />
   			Anda dapat langsung merubah password anda diatas, silahkan klik link berikut : $url
EOT;
 
   		$this->email->message($mailContent);

   		if($this->email->send())
	    {
			$this->load->view('forgot/confirm');
	    }
	    else
	    {
  			echo $this->email->print_debugger();
	    }
	}

	public function change_pass(){
		$data['email'] = '';
		if($this->input->get('email') != '')
		{
			$data['email'] = $this->input->get('email');
		}

	    if(!$data){ show_404();}
		$this->load->view('forgot/change_password',$data);
	} 

	public function change_pass_init(){
		$email    	  = $this->input->post('email');
		$password 	  = md5($this->input->post('password'));
		$new_password = md5($this->input->post('new_password'));

		//cek email 
		$user = $this->builtbyprime->get('TBL_USER',array('EMAIL'=> $email),TRUE);
	    if(!$user){ echo "Email yang anda masukkan tidak terdaftar !";exit(); }
	    if($user['PASSWORD'] != $password){ echo "Password yang anda masukkan salah !";exit(); }

	    $update = $this->builtbyprime->update('TBL_USER',array('EMAIL'=>$user['EMAIL']),array('PASSWORD'=>$new_password));

	    if($update)
	    {
	    	echo "Password anda berhasil di ubah.";exit();
	    }
	    else
	    {
	    	echo "Proses perubahan password gagal.";exit();
	    }
	} 
}
