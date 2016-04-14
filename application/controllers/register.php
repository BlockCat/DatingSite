<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

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
		$this->load->view('header');

        $this->form_validation->set_message('min_length', 'The %s should be at least %d characters.');
        $this->form_validation->set_message('max_length', 'The %s should be at most %d characters.');
        $this->form_validation->set_message('required', '%s is required.');
        $this->form_validation->set_message('matches', '%s should match %s.');

        $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[4]|max_length[20]|alpha_numeric');
        $this->form_validation->set_rules('firstname', 'First name', 'trim|required|alpha_numeric|prep_for_form');
        $this->form_validation->set_rules('lastname', 'Last name', 'trim|required|alpha_numeric|prep_for_form');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[UserProfile.userEmail]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|matches[passwordconfirmation]');
        $this->form_validation->set_rules('passwordconfirmation', 'Password confirmation', 'trim|required');
        $this->form_validation->set_rules('profilepicture', 'Profile picture');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('attraction', 'Attraction', 'required');
        if ($this->load->form_validation->run() == FALSE) {
            $this->load->view('register');
        } else {
            $data = array('post_data' => $this->input->post());
            $this->questions();
        }

	}

    public function registerUser() {
        $errors = array();
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $personality_array = $this->verifyquestions();
    }
    
    private function questions()
    {
        $this->load->view('questions');
    }
    
    public function verifyquestions() 
    {
        //EI
        $E = 500;        
        for ($i = 1; $i <= 5; $i++) {
            $char = $_POST['q'.$i];
            switch($char) {
                case 'a':
                    $E += 100;
                    break;
                case 'b':
                    $E -= 100;                    
            }
        }
        //NS
        $N = 500;        
        for ($i = 6; $i <= 9; $i++) {
            $char = $_POST['q'.$i];
            switch($char) {
                case 'a':
                    $N += 125;                 
                    break;
                case 'b':
                    $N -= 125;                 
            }
        }
        //TF
        $T = 500;        
        for ($i = 10; $i <= 13; $i++) {
            $char = $_POST['q'.$i];
            switch($char) {
                case 'a':
                    $T += 125;                    
                    break;
                case 'b':
                    $T -= 125;                    
            }
        }
        //JP
        $J = 500;        
        for ($i = 14; $i <= 19; $i++) {
            $char = $_POST['q'.$i];
            switch($char) {
                case 'a':
                    $J += 83;                    
                    break;
                case 'b':
                    $J -= 83;                                
            }
        }
        $data = array(
            'E' => $E,
            'N' => $N,
            'T' => $T,
            'J' => $J
        );

        $array = array(
            'E' => $E,
            'N' => $N,
            'T' => $T,
            'J' => $J);
        return $array;
    }
}
