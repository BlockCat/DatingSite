<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class randomprofile extends CI_Controller {

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
		$this->load->helper('url');
		$this->load->helper('user');

	}
	
	public function index()
	{  
		if(isset($_SESSION['loggedIn'])){
			$hide = false;
			$profiles = $this->Users_model->get_random_profiles($_SESSION['userID']);
		}
		else{
			$hide = true;
			$profiles = $this->Users_model->get_random_profiles(null);
		}
		foreach($profiles as $key => $value) {
			$profiles[$key]['image'] = get_profile_image_src($value['userID'], $hide, true);
		}
		echo json_encode($profiles);
	}
}
