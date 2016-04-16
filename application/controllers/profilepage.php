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
		$this->load->helper('url');
	}
	
	public function index()
	{
		if($this->session->userdata('loggedIn') && !$this->input->get('ID'))//If logged in but no user Id is given..
		{
			$url = base_url('/profilepage?ID='.$this->session->userdata('userID'));
			redirect($url); //Just set the user id to the logged in user.
		} else if (!$this->input->get('ID')) //If the user is not logged in and no input is given... 404?
		{
			redirect(base_url('404'));
		}

		//Check if user exists.


		$this->form_validation->set_rules('nickname', 'Nickname', 'callback_overwrite_user');
		$this->form_validation->run();

		$resultarray = $this->Users_model->get_certain_profile($this->input->get('ID'));

		if($resultarray) { //If there is a user with the ID...			
			//if logged in
			if(isset($_SESSION['loggedIn'])){
					$resultarray = $this->Users_model->get_sensitive_profile($this->input->get('ID'));//send sensitive info
				}
			}
			
			$this->load->view('header');
			$data['userdata'] = $resultarray[0];
			$this->load->view('profile', $data);

			
		} else { //If there is no user with this id.
			redirect(base_url('404'));
		}
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

	public function upload() {

		if($this->session->userdata('loggedIn')) {
			$this->load->helper('user');

			$userId = $this->session->userdata('userID');
			$image_source = base_url("images/profilepic/" . $userId . ".jpg");
			$image_source = get_profile_image_src($userId);
			
			$data = array(
				'imgsrc' => $image_source
			);

			$this->load->view('header');

			//Form validation.
			$this->form_validation->set_message('do_upload', 'Your image is not the correct size or its type is not allowed');
			$this->form_validation->set_rules('userfile', 'Image to upload', 'callback_do_upload');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('upload', $data);
			} else {
				//Successfull upload...
				redirect(base_url('profilepage?ID='.$userId));
			}
		} else {
			redirect(base_url());
		}
	}

	public function do_upload()
	{
		if ($this->session->userdata('loggedIn')) {
			$userId = $this->session->userdata('userID');
			//Upload configuration
			$config['file_name'] = $userId . '.jpg';
			$config['upload_path'] = './images/profilepic/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = 500;
			$config['max_width'] = 513;
			$config['max_height'] = 513;
			$config['overwrite'] = true;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload()) {
				//Failure
				$errors = $this->upload->display_errors();
				return false;
				//redirect(base_url('profilepage/upload'));
			} else {
				//Success?

				$image['source_image'] = $this->upload->upload_path . $this->upload->file_name;
				$image['create_thumb'] = true;
				$image['new_image'] = './images/profilepic/';
				$image['quality'] = 50;
				$image['width'] = 200;
				$image['height'] = 200;

				$this->load->library('image_lib', $image);
				$this->image_lib->resize();
				return true;
			}
		}
		return false;
	}
}
