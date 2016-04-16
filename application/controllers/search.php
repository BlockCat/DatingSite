<?php
    class search extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('user');
            $this->load->model('Brand_Model');
            $this->load->library('session');
            $this->load->library('form_validation');
            $this->load->model('Users_model');

        }

        public function index() {
            if(!$this->session->userdata('loggedIn')) {
                $data['brands'] = $this->Brand_Model->get_all_brands();
                $data['gender'] = 'm';
                $data['sexpref'] = 'v';
                $data['minage'] = '20';
                $data['maxage'] = '40';
            } else {

                $userdata = $this->Users_model->get_certain_profile($this->session->userdata("userID"))[0];


                $data['brands'] = $this->Brand_Model->get_all_brands();
                $data['gender'] = $userdata['userSex'];
                $data['sexpref'] = $userdata['userSexPref'];
                $data['minage'] = $userdata['userMinAgePref'];
                $data['maxage'] = $userdata['userMaxAgePref'];
                $data['prefpersonality'] = $this->Users_model->get_personality($userdata['userPersonalityPref'])[0];

                //echo print_r($userdata);
                //echo print_r($data['prefpersonality']);
            }

            $this->load->view('header');


            $this->form_validation->set_rules('gender', 'Gender', 'required');
            if($this->form_validation->run() == false){
                $this->load->view('search', $data);
            } else {
                $this->load->view('search', $data);
                $this->search_profiles();
            }


            $this->load->view('footer');
        }

        private function search_profiles() {
            $gender = $this->input->post('gender');
            $preference = $this->input->post('preference');
            $ageMin =$this->input->post('minage');
            $ageMax = $this->input->post('maxage');
            $e = $this->input->post('e');
            $n = $this->input->post('n');
            $t = $this->input->post('t');
            $f = $this->input->post('f');
            $brands = $this->input->post('brands');
            $this->load->view('searchresults');
        }


}