<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ownprofilepage extends CI_Controller {

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
        $this->load->model('Brand_Model');
		$this->load->library('session');
		$this->load->library('form_validation');
	}
	
	public function index()
	{
        if (!$this->session->userdata('loggedIn')) {
			header('Location: http://localhost/DatingSite/');           
        }

        $this->load->database();

		$this->load->view('header');

        $this->form_validation->set_message('min_length', 'The %s should be at least %d characters.');
        $this->form_validation->set_message('max_length', 'The %s should be at most %d characters.');
        $this->form_validation->set_message('required', '%s is required.');
        $this->form_validation->set_message('matches', '%s should match %s.');
        $this->form_validation->set_message('greater_than', 'The %s should be greater than %d');
        $this->form_validation->set_message('date_valid', 'The %s is invalid');
        $this->form_validation->set_message('date_older_than_18', 'You must be older than 18 to use this site');
        $this->form_validation->set_message('is_unique_email', '%s already exists');

        $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[4]|max_length[20]|alpha_numeric');
        $this->form_validation->set_rules('firstname', 'First name', 'trim|required|alpha_numeric|prep_for_form');
        $this->form_validation->set_rules('lastname', 'Last name', 'trim|required|alpha_numeric|prep_for_form');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_is_unique_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|matches[passwordconfirmation]');
        $this->form_validation->set_rules('passwordconfirmation', 'Password confirmation', 'trim|required');
        $this->form_validation->set_rules('date', "birthdate", 'required|callback_date_valid|callback_date_older_than_18');
        $this->form_validation->set_rules('minAge', "minimum age", 'required|greater_than[17]');
        $this->form_validation->set_rules('maxAge', "maximum age", 'required|less_than[105]');
        $this->form_validation->set_rules('description', 'min_length[100]');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('attraction[]', 'Attraction', 'required');
        $this->form_validation->set_rules('brandslist[]', 'Brands', 'required');
		
        if ($this->load->form_validation->run() == FALSE) {
            $brandView = $this->load->view('brands_profile', array('brands' => $this->Brand_Model->get_all_brands()), true);
            $userdata = $this->Users_model->get_sensitive_profile($this->session->userdata('userID'));
            $this->load->view('ownprofile', array('brands' => $brandView, 'userdata' => $userdata[0]));
        }
		else 
		{
            if ($this->editUser()) {
                header('Location: http://localhost/DatingSite/ownprofilepage');                
            } else {
                $brandView = $this->load->view('brands_register', array('brands' => $this->Brand_Model->get_all_brands()), true);
				$userdata = $this->Users_model->get_sensitive_profile($this->session->userdata('userID'));
				$this->load->view('ownprofile', array('brands' => $brandView, 'userdata' => $userdata[0]));
            }
        }
	}

    public function is_unique_email($email) {
        $userdata = $this->Users_model->get_sensitive_profile($this->session->userdata('userID'))[0];
		if($email = $userdata['userEmail']){
			return true;
		}
		else{
			$this->load->model('Users_model');
			return !$this->Users_model->email_exists($email);
		}
    }

    public  function date_valid($date) {
        $date = date_parse($date);
        return $date['error_count'] == 0;
    }

    public function date_older_than_18($date) {
        if (!$this->date_valid($date)) return true; //Because we don't want to show this error in that case, the date invalid is already shown then.

        $date = new DateTime($date);
        $today = new DateTime();
        $diff = $date->diff($today)->y;

        return $diff >= 18 && $today > $date;
    }

    private function editUser() {
        $username = $this->input->post('username', true);
        $firstname = $this->input->post('firstname', true);
        $lastname = $this->input->post('lastname', true);
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $birthdate = $this->input->post('date');
        $description = htmlentities($this->input->post('description'), ENT_QUOTES);
        $gender = $this->input->post('gender');
        $attraction = $this->input->post('attraction');
        $minAge = $this->input->post('minAge');
        $maxAge = $this->input->post('maxAge');
        $brands = $this->input->post('brandslist');


        if (count($attraction) == 1) {
            $attraction = $attraction[0]; //Attracted to gender m or v.
        }  else {
            $attraction = 'b'; //Attracted to both: b.
        }
		
		$olddata = $this->Users_model->get_sensitive_profile($this->session->userdata('userID'))[0];
		
        $this->load->model('Users_model');
        return $this->Users_model->edit_user($this->session->userdata('userID'), $email, $password,
            $username, $firstname, $lastname, $gender, $birthdate, $minAge, $maxAge, $attraction, $olddata['userAdmin'],
		    $description, $olddata['userPersonality'], $olddata['userPersonalityPref'], $brands);
    }
}
