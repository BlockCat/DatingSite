<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class deleteAccount extends CI_Controller {

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
		$this->load->library('session');
		$this->load->model('Users_model');
	}
	
	public function index()
	{   	
		$this->Users_model->delete_user($this->session->userdata('userID'), $this->session->userdata('userPersonality'), $this->session->userdata('userPersonalityPref'));	
		$this->session->sess_destroy();
		header('Location: http://localhost/DatingSite/');
	}
}
