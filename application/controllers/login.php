<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
	public function index()
	{        
        $this->load->view('login');
	}
    
    public function loginUser() {
        //If username is correct and such
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            $_SESSION['logged_in'] = 1;
            if (isset($_POST['username'])) $_SESSION['username'] = $_POST['username'];
            $array = array('state' => 'success');
        } else {
            $array = array('state' => 'error');
        }       
        
        $array = array('state' => 'success');
        header('Content-Type: application/json');        
		echo json_encode($array);
    }
    
    public function logout() {
        $_SESSION['logged_in'] = 0;
        session_start();
        session_destroy();
            
        echo 'Hi';
    }
}
