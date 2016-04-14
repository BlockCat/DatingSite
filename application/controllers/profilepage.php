<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class profilepage extends CI_Controller {

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
		$this->form_validation->set_rules('nickname', 'Nickname', 'callback_overwrite_user');
		$this->form_validation->run();
		$data['userdata'] = $this->Users_model->get_certain_profile($this->input->get('ID'))[0];
		$this->load->view('header');
		$this->load->view('profile', $data);
	}
	
	public function overwrite_user($nickname)
	{	
		$nickname = $this->input->post('nickname');
		$first = $this->input->post('firstname');
		$last = $this->input->post('lastname');
		$sex = $this->input->post('sex');
		$date = $this->input->post('date');
		$sexpref = $this->input->post('sexpref');
		$min = $this->input->post('min');
		$max = $this->input->post('max');
		$brands = $this->input->post('brands');
		$email = $this->input->post('email');
		$description = $this->input->post('description');
		$pass = $this->input->post('password');

		$tempbrand = explode(", ", $brands);
		
		$this->Users_model->edit_user($_SESSION['userID'], $email, $pass, $nickname,
		$first, $last, $sex, $date, $min, $max, $sexpref, $_SESSION['userAdmin'], $description, 
		$_SESSION['userPersonality'], $_SESSION['userPersonalityPref'], $tempbrand);
		
	}
	
}
