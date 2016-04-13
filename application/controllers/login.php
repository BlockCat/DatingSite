<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model');
		$this->load->library('session');
		$this->load->library('form_validation');
	}
	
	public function index()
	{   		
		$this->form_validation->set_rules('email', 'Email', 'callback_authenticate_login');
		$this->form_validation->run();
		$this->load->view('header');	
        $this->load->view('login');		
	}
	
	//no input validation yet!!!
	public function authenticate_login($email){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$result = $this->Users_model->authenticate_login($email, $password)[0];
		if($result){	
			$newdata = array(
				'loggedIn' => true,
				'userID' =>	$result['userID'],
				'userEmail' => $result['userEmail'],
				'userNickname' => $result['userNickname'],
				'userFirstName' => $result['userFirstName'],
				'userLastName' => $result['userLastName'],
				'userSex' => $result['userSex'],
				'userBirthdate' => $result['userBirthdate'],
				'userMinAgePref' => $result['userMinAgePref'],
				'userMaxAgePref' => $result['userMaxAgePref'],
				'userSexPref' => $result['userSexPref'],
				'userAdmin' => $result['userAdmin'],
				'userPersonality' => $result['userPersonality'],
				'userPersonalityPref' => $result['userPersonalityPref'],
			);
			$this->session->set_userdata($newdata);
			$this->session->unset_userdata('triedlogin');
			header('Location: http://localhost/DatingSite/');
		}
		else
		{			
			$this->session->set_userdata('triedlogin', true);
			return false;
		}		
	}
}
