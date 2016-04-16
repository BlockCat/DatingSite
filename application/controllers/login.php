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
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('form_validation');
	}
	
	public function index()
	{


		//Set the first set of rules...
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		//Set the first set of error messages for the rules
		$this->form_validation->set_message('required', "%s is required");
		$this->form_validation->set_message('valid_email', '%s is not a valid');

		$this->load->view('header'); //Load the header view.
		if($this->form_validation->run() === false) { //The input failed the requirements.
			$this->load->view('login');
		} else { //The input is valid.

			//Set the second set of rules, namely to see if the login information
			$this->form_validation->set_rules('submit', '', 'callback_authenticate_login');
			$this->form_validation->set_message('authenticate_login', "We could not validate you, try to login again.");

			//We do it like this so we won't need to check the database if the input is wrong.
			if($this->form_validation->run() === false) {//If we can't login, display the login view and the error.
				$this->load->view('login');
			} else {
				redirect(base_url('/')); //Redirect to the base_url(controller/function);
			}
		}


	}
	
	//no input validation yet!!!
	public function authenticate_login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$result = $this->Users_model->authenticate_login($email, $password)[0];
		if($result){	
			$newdata = array(
				'loggedIn' => true,
				'userID' =>	$result['userID'],
				'userAdmin' => $result['userAdmin'],
				'userPersonality' => $result['userPersonality'],
				'userPersonalityPref' => $result['userPersonalityPref'],
			);
			$this->session->set_userdata($newdata);
			//$this->session->unset_userdata('triedlogin');
			//header('Location: http://localhost/DatingSite/');
			return true;
		}
		else
		{
			//$this->session->set_userdata('triedlogin', true);
			return false;
		}		
	}
}
