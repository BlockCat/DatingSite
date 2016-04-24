<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->load->model('Brand_Model');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('user');
	}
	
	public function index()
	{
		if (!$this->input->get('ID')) //If the user is not logged in and no input is given... 404?
		{
			redirect(site_url('404'));
		}
		if ($this->input->get('ID') == $this->session->userdata('userID')) {
			redirect(site_url('ownprofilepage'));
		}

		//Check if user exists.

		$resultarray = $this->Users_model->get_certain_profile($this->input->get('ID'));

		if($resultarray) { //If there is a user with the ID...	
			$resultarray[0]['userEmail'] = "";
			$resultarray[0]['userFirstName'] = "";
			$resultarray[0]['userLastName'] = "";
			
			
			//if logged in
			if(isset($_SESSION['loggedIn'])){
				//if there is a mutual like
				if($this->Users_model->get_relation($this->session->userdata('userID'), $this->input->get('ID'))  == "m"){ 
					$resultarray = $this->Users_model->get_sensitive_profile($this->input->get('ID'));//send sensitive info
				}
			}
			$resultarray[0]['image'] = get_profile_image_src($this->input->get('ID'),!$this->session->userdata('loggedIn'), false);

			$this->load->view('header');
			$data['userdata'] = $resultarray[0];
			$this->load->view('profile', $data);
			
		} else { //If there is no user with this id.
			redirect(site_url('404'));
		}
	}

	public function upload() {

		if($this->session->userdata('loggedIn')) {
			$this->load->helper('user');
			$this->load->library('form_validation');
			$userId = $this->session->userdata('userID');
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
				redirect(site_url());
			}
		} else {
			redirect(site_url());
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
				//redirect(site_url('profilepage/upload'));
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
