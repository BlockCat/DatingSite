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
        $this->load->model('Brand_Model');
		$this->load->library('session');
		$this->load->library('form_validation');

	}
	
	public function index()
	{
        if ($this->session->userdata('loggedIn') == true) {
			header('Location: http://localhost/DatingSite/');
            //header('/');
            //Redirect to other page here.
            //return;
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
        //$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|matches[passwordconfirmation]');
        $this->form_validation->set_rules('passwordconfirmation', 'Password confirmation', 'trim|required');
        $this->form_validation->set_rules('date', "birthdate", 'required|callback_date_valid|callback_date_older_than_18');
        $this->form_validation->set_rules('minAge', "minimum age", 'required|greater_than[17]');
        $this->form_validation->set_rules('maxAge', "maximum age", 'required|less_than[105]');
        $this->form_validation->set_rules('description', 'min_length[100]');
        $this->form_validation->set_rules('profilepicture', 'Profile picture');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('attraction[]', 'Attraction', 'required');
        $this->form_validation->set_rules('brandslist[]', 'Brands', 'required');
        if ($this->load->form_validation->run() == FALSE) {

            $brandView = $this->load->view('brands_register', array('brands' => $this->Brand_Model->get_all_brands()), true);
            $questionsView = $this->load->view('questions', '', true);
            $this->load->view('register', array('brands' => $brandView, 'questions' => $questionsView));

        } else {
            if ($this->registerUser()) {
                //Success
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
                    header('Location: http://localhost/DatingSite/profilepage/upload');
                } else {
                    header('Location: http://localhost/DatingSite/login/');
                }
            } else {
                $brandView = $this->load->view('brands_register', array('brands' => $this->Brand_Model->get_all_brands()), true);
                $questionsView = $this->load->view('questions', '', true);
                $this->load->view('register', array('brands' => $brandView, 'questions' => $questionsView));
            }

            //header('Location: http://localhost/DatingSite/');
        }
	}

    public function is_unique_email($email) {
        $this->load->model('Users_model');
        return true;
        return !$this->Users_model->email_exists($email);
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

    private function registerUser() {
        $username = $this->input->post('username');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $birthdate = $this->input->post('date');
        $description = $this->input->post('description');
        $gender = $this->input->post('gender');
        $attraction = $this->input->post('attraction');
        $minAge = $this->input->post('minAge');
        $maxAge = $this->input->post('maxAge');
        $brands = $this->input->post('brandslist');

        $personality_array = $this->verifyquestions();

        if (count($attraction) == 1) {
            $attraction = $attraction[0]; //Attracted to gender m or v.
        }  else {
            $attraction = 'b'; //Attracted to both: b.
        }

        $prefPresonality = array(
            'e' => $personality_array['i'],
            'i' => $personality_array['e'],
            'n' => $personality_array['s'],
            's' => $personality_array['n'],
            't' => $personality_array['f'],
            'f' => $personality_array['t'],
            'j' => $personality_array['p'],
            'p' => $personality_array['j']
        );

        //We have to store the user personality first...
        $data = array(
            'userID' => NULL,
            'userEmail' => $email,
            'userNickname' => $username,
            'userPassword' => $password,
            'userFirstName' => $firstname,
            'userLastName' => $lastname,
            'userSex' => $gender,
            'userBirthdate' => $birthdate,
            'userMinAgePref' => $minAge,
            'userMaxAgePref' => $maxAge,
            'userSexPref' => $attraction,
            'userAdmin' => false,
            'userDescription' => $description
        );
        $this->load->model('Users_model');
        return $this->Users_model->register_user($data, $personality_array, $prefPresonality, $brands);
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
            'personalityID' => NULL,
            'e' => $E,
            'i' => (1000 - $E),
            'n' => $N,
            's' => (1000 - $N),
            't' => $T,
            'f' => (1000 - $T),
            'j' => $J,
            'p' => (1000 - $J)
        );
        return $data;
    }
}
