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
		$this->load->view('register');
	}

    public function register() {
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $secondname = $_POST['firstname'];
    }
    
    public function questions() 
    {
        //Check if from the register
        $this->load->view('header');
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
            'J' => $J,
            'html' => $this->load->view('questionsresult', $data, true));

        header('Content-Type: application/json');
        echo json_encode($array);
    }
}
