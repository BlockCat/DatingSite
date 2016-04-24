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
            $data['brands'] = $this->Brand_Model->get_all_brands();
            if(!$this->session->userdata('loggedIn')) {
                $data['brands'] = $this->Brand_Model->get_all_brands();
                $data['gender'] = 'm';
                $data['sexpref'] = 'v';
                $data['minage'] = '20';
                $data['maxage'] = '40';
                $data['prefpersonality'] = array(
                    'e' => 500,
                    'i' => 500,
                    'n' => 500,
                    's' => 500,
                    't' => 500,
                    'f' => 500,
                    'j' => 500,
                    'p' => 500,
                    );
                $data['selectedBrands'] = array();
            } else {

                $userdata = $this->Users_model->get_certain_profile($this->session->userdata("userID"))[0];



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

            if (!preg_match('/^[vm]$/', $gender)) {
                header('Content-Type: application/json');
                echo '[]';
                return;
            }
            if (!preg_match('/^[vmb]$/', $pref))

            if (!$pref || count($pref) > 1) //If there is no preference or there are 2 preferences....
                $pref = 'b'; //The user prefers both
            else
                $pref = $pref[0];

            if (!preg_match('/^[vmb]$/', $pref)){
                header('Content-Type: application/json');
                echo '[]';
                return;
            }

            $amin = $this->input->get('minage', true);//Get preferred minimum age
            $amax = $this->input->get('maxage', true);//Get preferred maximum age

            if (!preg_match('/^18|19|(2[0-9]+)$/', $amin)){
                header('Content-Type: application/json');
                echo '[]';
                return;
            }

            if (!$this->session->userdata('loggedIn')) {
                $e = $this->input->get('e') * 10;
                $e = ($e ? $e : 500);
                $n = $this->input->get('n') * 10;
                $n = ($n ? $n : 500);
                $t = $this->input->get('t') * 10;
                $t = ($t ? $t : 500);
                $j = $this->input->get('j') * 10;
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
                $myPersonality = array(
                    'e' => 1000-$e,
                    'n' => 1000-$n,
                    't' => 1000-$t,
                    'j' => 1000-$j,
                    'i' => $e,
                    's' => $n,
                    'f' => $t,
                    'p' => $j);
                    $page = 0;
            } else {
                $searchPersonality = $this->Users_model->get_user_pref_personality($this->session->userdata('userID'));
                $myPersonality = $this->Users_model->get_user_personality($this->session->userdata('userID'));
                $page = $this->input->get('page');
                if (!$page) $page = 0;
            }

            $brands = $this->input->get('brands');
            if (!$amin) $amin = 0;
            if (!$amax) $amax = 99;
            if (!$page) $page = 0;

            $result = $this->Users_model->search_users($page, $gender, $pref, $amin, $amax);
            $memo_array = array();

            foreach($result as $key => $value) {

                $kpers = $this->Users_model->get_personality($value['userPersonality'])[0]; //His personality
                $targetPref = $this->Users_model->get_personality($value['userPersonalityPref'])[0]; //His preference
                $brandresults = $this->Brand_Model->get_brands($value['userID']);

                $targetbrands = array();
                foreach($brandresults as $k => $v) {

                    $targetbrands[$k] = $v['brand'];
                }


                $dist1 = array_sum(personality_difference($searchPersonality, $kpers)) / 8000;
                $dist2 = array_sum(personality_difference($myPersonality, $targetPref)) / 8000;

                $result[$key]['image'] = get_profile_image_src($value['userID'], $this->session->userdata('loggedIn') == false, true);
                $result[$key]['personality'] = get_pretty_personality($value['userID']);
                $result[$key]['distance'] = max($dist1, $dist2);
                $result[$key]['brands'] = $targetbrands;
                $memo_array[$value['userID']] = $result[$key]['distance'];

                $datenow = new DateTime();
                $birthday = DateTime::createFromFormat('Y-m-d', $result[$key]['userBirthdate']);
                $age = $datenow->diff($birthday)->y;

                $result[$key]['userBirthdate'] = $age;
                $result[$key]['userID'] = $value['userID'];

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