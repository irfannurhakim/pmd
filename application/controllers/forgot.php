<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('forgot/index');
	}

	public function init(){
		$username = $this->input->post('username');

		//cek email ke database
		$user = $this->builtbyprime->get('TBL_USER', array('username' => $username), TRUE);
		//$user = $this->builtbyprime->explicit("SELECT * FROM TBL_USER where username = '$username'");

		if(!$user){
			echo "Username tidak dikenal.";
			exit();
		}

    $factory = new RandomLib\Factory;
    $generator = $factory->getMediumStrengthGenerator();
    //Generate Token
    $token = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

    $this->builtbyprime->insert('TBL_FORGOT_PASSWORD', array('token' => $token, 'email' => $user['EMAIL']));
    //$this->builtbyprime->explicit("INSERT INTO TBL_FORGOT_PASSWORD (TOKEN, EMAIL) VALUES ('".$token."', '".$user['EMAIL']."')");



		// if(!$user['email']){
		// 	echo "Data email anda tidak ditemukan, Hubungi Administrator.";
		// 	exit();
		// } 

		//TODO kirim email
		// $this->load->library('email');

		// $this->email->from('myfunareaa@gmail.com', 'Admin PM Dashboard');
		// $this->email->to('irfannurhaim@s.itb.ac.id'); 
		// // $this->email->cc('another@another-example.com'); 
		// // $this->email->bcc('them@their-example.com'); 

		// $this->email->subject('Email Test');
		// $this->email->message('Testing the email class.');	

		// $this->email->send();

  //   //debug
  //   echo $this->email->print_debugger();
		//set response
		echo "Cek email anda untuk proses pemulihan password anda.";
	}

	public function process(){
		$email = $this->input->get('email', TRUE);
		$resetCode = $this->input->get('token', TRUE);

		//TODO reset password kemudian kirim ke email


		$this->load->view('authentication');
	} 
}
