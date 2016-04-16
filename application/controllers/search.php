<?php
    class search extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('user');
            $this->load->model('Brand_Model');
            $this->load->model('Users_model');
            $this->load->library('session');
            $this->load->library('form_validation');
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
                $data['selectedBrands'] = $this->Brand_Model->get_brands($this->session->userdata("userID"));

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
            $data['gender'] = $this->input->post('gender');
            $data['preference'] = $this->input->post('preference');
            $data['ageMin'] =$this->input->post('minage');
            $data['ageMax'] = $this->input->post('maxage');
            $data['e'] = $this->input->post('e');
            $data['n'] = $this->input->post('n');
            $data['t'] = $this->input->post('t');
            $data['f'] = $this->input->post('f');
            $data['brands'] = $this->input->post('brands');

            $this->load->view('searchresults', $data);
        }

        public function get_profiles() {
            $gender = $this->input->get('gender');
            $pref = $this->input->get('preference');

            if (!$pref || count($pref) > 1)
                $pref = 'b';
            else
                $pref = $pref[0];


            $amin = $this->input->get('minage', true);
            if (!$amin) $amin = 0;

            $amax = $this->input->get('maxage', true);
            if (!$amax) $amax = 99;

            $e = $this->input->get('e');
            $n = $this->input->get('n');
            $t = $this->input->get('t');
            $f = $this->input->get('f');
            $brands = $this->input->get('brands');
            $result = $this->Users_model->search_users($gender, $pref, $amin, $amax);

//            echo print_r($result);

            foreach($result as $key => $value) {
                //echo print_r($value);
                $result[$key]['image'] = get_profile_image_src($value['userID'], false, true);
                $result[$key]['personality'] = get_pretty_personality($value['userID']);
            }

            //$this->cmp($result[0], $result[1]);
            //usort($result, "cmp");

            header('Content-Type: application/json');
            echo json_encode($result);
        }

        private function cmp($user1, $user2) {

            //echo print_r($user1['userID']);

        }


}