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
                $data = $this->get_anon_viewdata($data);
            } else {
                $data = $this->get_user_viewdata($data);

                if (!isset($_POST['gender'])) $_POST['gender'] = $data['gender'];
                if (!isset($_POST['preference'])) $_POST['preference'] = $data['sexpref'];
                if (!isset($_POST['minage'])) $_POST['minage'] = $data['minage'];
                if (!isset($_POST['maxage'])) $_POST['maxage'] = $data['maxage'];
            }

            $this->load->view('header');


            $this->form_validation->set_rules('gender', 'Gender', 'required|regex_match[/^[mv]$/]');
            $this->form_validation->set_rules('preference[]', 'Preference', 'required');
            $this->form_validation->set_rules('minage', 'Minimum age', 'required|greater_than[17]');
            $this->form_validation->set_rules('maxage', 'Minimum age', 'required|greater_than[17]');
            if ($this->form_validation->run() == false) {
                $this->load->view('search', $data);
            } else {
                $this->load->view('search', $data);
                $this->search_profiles();
            }
            $this->load->view('footer');
        }

        public function match() {
            if(!$this->session->userdata('loggedIn')) {
                redirect(base_url('search'));
            } else {
                $data = array();
                $data['brands'] = $this->Brand_Model->get_all_brands();
                $data = $this->get_user_viewdata($data);

                if (!isset($_POST['gender'])) $_POST['gender'] = $data['gender'];
                if (!isset($_POST['preference'])) $_POST['preference'] = $data['sexpref'];
                if (!isset($_POST['minage'])) $_POST['minage'] = $data['minage'];
                if (!isset($_POST['maxage'])) $_POST['maxage'] = $data['maxage'];
            }

            $this->load->view('header');
            $this->load->view('matching', $data);
            $this->search_profiles();
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
            if (!$this->session->userdata('loggedIn')) {
                $this->form_validation->set_rules('gender', 'Gender', 'required|regex_match[/^[mv]$/]');
                $this->form_validation->set_rules('preference[]', 'Preference', 'required');
                $this->form_validation->set_rules('minage', 'Minimum age', 'required|greater_than[17]');
                $this->form_validation->set_rules('maxage', 'Minimum age', 'required|greater_than[17]');
                if ($this->form_validation->run() == false) {
                    echo validation_errors();
                } else {
                    header('Content-Type: application/json');
                    echo $this->find_profiles();
                }
            } else {
                header('Content-Type: application/json');
                echo $this->find_profiles();
            }
        }

        private function find_profiles() {

            $gender = $this->input->post('gender');
            $pref = $this->input->post('preference');
            $amin = $this->input->post('minage', true);//Get preferred minimum age
            $amax = $this->input->post('maxage', true);//Get preferred maximum age


            if (!$pref || count($pref) > 1) //If there is no preference or there are 2 preferences....
                $pref = 'b'; //The user prefers both
            else
                $pref = $pref[0];

            //Get data if user is not logged in.
            if (!$this->session->userdata('loggedIn')) {
                $e = $this->input->post('e') * 10;
                $e = ($e ? $e : 500);
                $n = $this->input->post('n') * 10;
                $n = ($n ? $n : 500);
                $t = $this->input->post('t') * 10;
                $t = ($t ? $t : 500);
                $j = $this->input->post('j') * 10;
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

            } else if($this->input->post('search')){
                $e = $this->input->post('e') * 10;
                $e = ($e ? $e : 500);
                $n = $this->input->post('n') * 10;
                $n = ($n ? $n : 500);
                $t = $this->input->post('t') * 10;
                $t = ($t ? $t : 500);
                $j = $this->input->post('j') * 10;
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
                $myPersonality = $this->Users_model->get_user_personality($this->session->userdata('userID'));
                $user = $this->Users_model->get_certain_profile($this->session->userdata('userID'))[0];
                $page = $this->input->post('page');
                if (!$page) $page = 0;
            }else{
                //Get data if user is logged in, and it's not a search
                $searchPersonality = $this->Users_model->get_user_pref_personality($this->session->userdata('userID'));
                $myPersonality = $this->Users_model->get_user_personality($this->session->userdata('userID'));
                $user = $this->Users_model->get_certain_profile($this->session->userdata('userID'))[0];
                $gender = $user['userSex'];
                $pref = $user['userSexPref'];
                $amin = $user['userMinAgePref'];
                $amax = $user['userMaxAgePref'];

                $page = $this->input->post('page');
                if (!$page) $page = 0;
            }

            $brands = $this->input->post('brands');

            if (!$amin) $amin = 0;
            if (!$amax) $amax = 99;
            if (!$page) $page = 0;

            $result = $this->Users_model->search_users($page, $gender, $pref, $amin, $amax, $this->session->userdata('userID'), $this->input->post('wholikedme'), $this->input->post('whoiliked'));
            $memo_array = array();

            foreach($result as $key => $value) {
                $kpers = $this->Users_model->get_personality($value['userPersonality'])[0]; //His personality
                $targetPref = $this->Users_model->get_personality($value['userPersonalityPref'])[0]; //His preference
                $brandresults = $this->Brand_Model->get_brands($value['userID']); //The brands of this user

                //Create a pretty array of the brands.
                $targetbrands = array();
                foreach($brandresults as $k => $v) {
                    $targetbrands[$k] = $v['brand'];
                }
                //-----------------------------------

                //How much do I prefer him.
                $dist1 = array_sum(personality_difference($searchPersonality, $kpers)) / 8000;
                //How much does he prefer me.
                $dist2 = array_sum(personality_difference($myPersonality, $targetPref)) / 8000;

                //Load in data for view
                $result[$key]['image'] = get_profile_image_src($value['userID'], $this->session->userdata('loggedIn') == false, true);
                $result[$key]['personality'] = get_pretty_personality($value['userID']);
                $result[$key]['distance'] = max($dist1, $dist2); //Set the distance to be the max distance between the two.
                $result[$key]['brands'] = $targetbrands;
                $result[$key]['userID'] = $value['userID'];

                //Calculate age.
                $datenow = new DateTime();
                $birthday = DateTime::createFromFormat('Y-m-d', $result[$key]['userBirthdate']);
                $age = $datenow->diff($birthday)->y;

                $result[$key]['userBirthdate'] = $age;
                //------------

                //Load the array with distances.
                $memo_array[$value['userID']] = $result[$key]['distance'];
            }

            $displayOnPage = 6;
            if (count($result) < ($page * $displayOnPage)) {
                return '[]';
            }

            //Get the range we want

            if (count($result) <= $displayOnPage && $page == 0) {
                usort($result, $this->cmp($searchPersonality, $memo_array));
                $result = array_slice($result, 0, $displayOnPage);
                return json_encode($result);
            } else if (count($result) < $displayOnPage) {
                return '';
            } else {
                $array = $this->quickSortRange($result, $memo_array, 0, count($result) - 1, $page * $displayOnPage, ($page + 1) * $displayOnPage);
                $result = $array['array'];

                //Now we can sort it
                usort($result, $this->cmp($searchPersonality, $memo_array));

                //Get the actuall people we want.
                $result = array_slice($result, ($page * $displayOnPage) - $array['low'], $displayOnPage);
                return json_encode($result);
            }
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
                    if ($high - $low <= 16) {
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

        /**
         * @param $data
         * @return mixed
         */
        public function get_anon_viewdata($data)
        {
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
            return $data;
        }

        /**
         * @param $data
         * @param $b
         * @return mixed
         */
        private function get_user_viewdata($data)
        {
            $userdata = $this->Users_model->get_certain_profile($this->session->userdata("userID"))[0];

            $data['selectedBrands'] = $this->Brand_Model->get_brands($this->session->userdata("userID"));

            $data['gender'] = $userdata['userSex'];
            $data['sexpref'] = $userdata['userSexPref'];
            $data['minage'] = $userdata['userMinAgePref'];
            $data['maxage'] = $userdata['userMaxAgePref'];
            $data['prefpersonality'] = $this->Users_model->get_personality($userdata['userPersonalityPref'])[0];

            foreach ($data['selectedBrands'] as $k => $v) {
                $b[$k] = $v['brand'];
            }
            if (!isset($_POST['brands'])) $_POST['brands'] = $b;

            $modus = $this->input->get('mode');

            if ($modus == 1) {
                $data['wholikedme'] = false;
                $data['whoiliked'] = true;
                return $data;
            } elseif ($modus == 2) {
                $data['wholikedme'] = true;
                $data['whoiliked'] = false;
                return $data;
            } elseif ($modus == 3) {
                $data['wholikedme'] = true;
                $data['whoiliked'] = true;
                return $data;
            } else {
                $data['wholikedme'] = false;
                $data['whoiliked'] = false;
                return $data;
            }
        }
    }