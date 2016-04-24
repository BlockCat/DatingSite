<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class liker extends CI_Controller {

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
		$this->load->helper('datevar');
	}
	
	public function index()
	{  
		//set like in databse
		$liker = $this->input->get('userID');
		$liked = $this->input->get('profileID');
		$result = $this->Users_model->set_liked($liker, $liked);
		
		//adjust personality preference of user
		$datevars = get_dating_variables();
		$alpha = floatval($datevars["alpha"]);
		$beta = floatval($datevars["beta"]);
		
		//only if we have a correct relation between alpha and beta
		$oldLiker = $this->Users_model->get_user_pref_personality($liker);
		$likedpers = $this->Users_model->get_user_personality($liked);
		
		//here the learning takes place
		$e = intval($alpha * $oldLiker["e"] + $beta * $likedpers["e"]);
		$n = intval($alpha * $oldLiker["n"] + $beta * $likedpers["n"]);
		$f = intval($alpha * $oldLiker["f"] + $beta * $likedpers["f"]);
		$j = intval($alpha * $oldLiker["j"] + $beta * $likedpers["j"]);	
		$i = 1000-$e;
		$s = 1000-$n;
		$t = 1000-$f;
		$p = 1000-$j;
		
		//put the in a array and store it in the database
		$newLiker = array(
						'e' => $e,
						'n' => $n,
						'f' => $f,
						'j' => $j,
						'i' => $i,
						's' => $s,
						't' => $t,
						'p' => $p,
		);
		$this->Users_model->edit_user_pref_personality($liker, $newLiker);
	}
}


