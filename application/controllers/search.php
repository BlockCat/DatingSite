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
            $data = array();
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

            if (!$pref || count($pref) > 1) //If there is no preference or there are 2 preferences....
                $pref = 'b'; //The user prefers both
            else
                $pref = $pref[0];

            $amin = $this->input->get('minage', true);//Get preferred minimum age
            $amax = $this->input->get('maxage', true);//Get preferred maximum age

            $e = $this->input->get('e');
            $e = ($e ? $e : 500);
            $n = $this->input->get('n');
            $n = ($n ? $n : 500);
            $t = $this->input->get('t');
            $t = ($t ? $t : 500);
            $j = $this->input->get('j');
            $j = ($j ? $j : 500);

            $searchPersonality = array(
                'e' => $e,
                'n' => $n,
                't' => $t,
                'j' => $j,
                'i' => 1000 - $e,
                's' => 1000 - $n,
                'f' => 1000 - $t,
                'p' => 1000 - $j);
            $brands = $this->input->get('brands');
            $page = $this->input->get('page');

            if (!$amin) $amin = 0;
            if (!$amax) $amax = 99;
            if (!$page) $page = 0;

            $result = $this->Users_model->search_users($page, $gender, $pref, $amin, $amax);
            $memo_array = array();

            foreach($result as $key => $value) {
                $kpers = $this->Users_model->get_personality($value['userID'])[0];
                $result[$key]['image'] = get_profile_image_src($value['userID'], false, true);
                $result[$key]['personality'] = get_pretty_personality($value['userID']);
                $result[$key]['distance'] = array_sum(personality_difference($searchPersonality, $kpers)) / 8000;
                $memo_array[$value['userID']] = $result[$key]['distance'];
            }

            if (count($result) < ($page * 12)) {
                header('Content-Type: application/json');
                echo '[]';
                return;
            }

            $array = $this->quickSortRange($result, $memo_array, 0, count($result) - 1, $page * 12, ($page + 1) * 12);
            $result = $array['array'];

            usort($result, $this->cmp($searchPersonality, $memo_array));

            $result = array_slice($result, ($page * 12) - $array['low'], 12);

            header('Content-Type: application/json');
            echo json_encode($result, JSON_PRETTY_PRINT);
        }

        private function cmp($searchPersonality, $memo) {
            return function ($u1, $u2) use ($searchPersonality, $memo) {
                if ($memo[$u1['userID']] == $memo[$u2['userID']]) return 0;
                if ($memo[$u1['userID']] < $memo[$u2['userID']]) return 1;
                if ($memo[$u1['userID']] > $memo[$u2['userID']]) return -1;

                return 0;
            };
        }

        private function quickSortRange($result, $memo, $low, $high, $findLow, $findHigh) {
            if ($high - $low <= 1) return;

            while($high != $low) {
                $var = $this->partition($result, $memo, $low, $high, $findLow, $findHigh);
                $p = $var['pivot'];
                $result = $var['result'];

                if ($p >= $findHigh) { //We discard the right side
                    $high = $p;

                } else if ($p < $findLow) { //We discard the left side
                    $low = $p;
                } else { //Uh oh, the pivot is in the range of the ones we want...
                    if ($high - $low <= 24) {
                        return array('array' => array_slice($result, $low, $high - $low, true), 'low' => $low);
                    }
                }
            }
        }

        private function partition($result, $memo, $low, $high) {
            $pivot = rand($low, $high);
            $pivotdistance = $memo[$result[$pivot]['userID']];
            $i = $low;
            for ($j = $low; $j < $high; $j++) {
                $dist = $memo[$result[$j]['userID']];
                if ($dist >= $pivotdistance) {
                    $temp = $result[$j];
                    $result[$j] = $result[$i];
                    $result[$i] = $temp;
                    $i++;
                }
            }
            $temp = $result[$pivot];
            $result[$j] = $result[$pivot];
            $result[$pivot] = $temp;
            return array('pivot' => $i, 'result' => $result);
        }
}