<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->library('form_validation');
		$this->load->helper('datevar');
	}
	
	public function index()
	{
        if (!$this->session->userdata('loggedIn') || $this->session->userdata('userAdmin') == 0) {
			redirect(site_url('/'));           
        }

		$this->load->view('header');
		
        $this->form_validation->set_message('greater_than', 'The %s should be greater than %d');
        $this->form_validation->set_message('less_than', 'The %s should be less than %d');
        $this->form_validation->set_message('required', '%s is required.');

		
		$this->form_validation->set_rules('alpha', "alphavar", 'required|greater_than[0]|less_than[1]');
		$this->form_validation->set_rules('xfactor', "xvar", 'required|greater_than[0]|less_than[1]');
		$this->form_validation->set_rules('distance', "dvar", 'required');




        if ($this->load->form_validation->run() == FALSE) {
			$datevars = get_dating_variables();
            $this->load->view('adminpage', array('datevars' => $datevars));
        }
		else 
		{
			$alpha = $this->input->post('alpha');
			$x = $this->input->post('xfactor');
			$d = $this->input->post('distance');
			if($this->session->userdata('userAdmin') == 1){
				set_dating_variables($alpha, $x, $d);
			}
			redirect(site_url('/'));
		}
	}

   
}
