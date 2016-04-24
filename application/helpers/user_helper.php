<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('user_personality_distance')) {
    function user_personality_distance($user1, $user2) {

        $controller = get_instance();
        $controller->load->model('Users_model');
        $userdata1 = $controller->Users_model->get_certain_profile($user1);
        $userdata2 = $controller->Users_model->get_certain_profile($user2);

        if (!$userdata1 || !$userdata2) return 1;

        $userdata1 = $userdata1[0];
        $userdata2 = $userdata2[0];

        $personality_user1 = $controller->Users_model->get_personality($userdata1['userPersonality']);
        $personality_user1_pref = $controller->Users_model->get_personality($userdata1['userPersonalityPref']);
        $personality_user2 = $controller->Users_model->get_personality($userdata2['userPersonality']);
        $personality_user2_pref = $controller->Users_model->get_personality($userdata2['userPersonalityPref']);

        $personality_1_difference_array = personality_difference($personality_user1_pref[0], $personality_user2[0]);
        $personality_2_difference_array = personality_difference($personality_user2_pref[0], $personality_user1[0]);

        $personality_1_difference = 0;
        $personality_2_difference = 0;

        foreach($personality_1_difference_array as $char => $value) {
            $personality_1_difference += $value;

        }
        foreach($personality_2_difference_array as $value) {
            $personality_2_difference += $value;
        }

        $personality_1_difference /= 8000;
        $personality_2_difference /= 8000;

        return max($personality_1_difference, $personality_2_difference);
    }
}

if(! function_exists('personality_difference')) {
    function personality_difference($personality1, $personality2) {
        $difference = array();
        foreach($personality1 as $char => $value) {
            if ($char=='personalityID') continue;
            $p1 = $personality1[$char];
            $p2 = $personality2[$char];
            $difference[$char] = abs($p1 - $p2);
        }
        return $difference;
    }
}

if(!function_exists('brand_difference')) {
    function brand_difference($user1, $user2) {
        $controller = get_instance();
        /*$controller->load->model('Users_model');
        $userdata1 = $controller->Users_model->get_certain_profile($user1);
        $userdata2 = $controller->Users_model->get_certain_profile($user2);

        if (!$userdata1 || !$userdata2) return 1;
        */
        $controller->load->model('Brand_Model');

        $result1 = $controller->Brand_Model->get_brands($user1);
        $result2 = $controller->Brand_Model->get_brands($user2);

        foreach($result1 as $k=>$v) {
            $brands1[$k] = $v['brand'];
        }
        foreach($result2 as $k=>$v) {
            $brands2[$k] = $v['brand'];
        }


        $intersection = array_intersect($brands1, $brands2);
        $xy =  count($intersection);
        $x = count($result1);
        $y = count($result2);

        //echo ($xy / ($x + $y))."<br>";
        return ($xy / ($x + $y - $xy));
    }
}

if (!function_exists('brand_array_difference')) {
    function brand_array_difference($brands1, $brands2, $mode) {
        $intersection = array_intersect($brands1, $brands2);
        $xy =  count($intersection);
        $x = count($brands1);
        $y = count($brands2);

        switch($mode) {
            case 'o':
                return $xy / min($x, $y);
            case 'j':
                return $xy / ($x + $y - $xy);
            case 'c':
                return $xy/(sqrt($x) * sqrt($y));
            default:
                return (2 * $xy) / ($x + $y);

        }
        //echo ($xy / ($x + $y))."<br>";
        return ($xy / ($x + $y - $xy));
    }
}

if(!function_exists('get_profile_image')) {
    function get_profile_image_src($userId, $hide = false, $thumb = false) {


        $image_source = base_url("images/profilepic/" . $userId . ($thumb ? "_thumb" : "").".jpg");

        if (@getimagesize($image_source) && !$hide) {
            $image_source = $image_source;
        } else {
            $controller = get_instance();
            $controller->load->model('Users_model');

            $userdata = $controller->Users_model->get_certain_profile($userId);

            if ($userdata) {
                $image_source = base_url("/images/profilepic/{$userdata[0]['userSex']}silhoutte".($thumb ? "_thumb" : "").".jpg");
            } else {
                $image_source = base_url("/images/profilepic/msilhoutte.".($thumb ? "_thumb" : "")."jpg");
            }
        }

        return $image_source;
    }
}

if(!function_exists('delete_profile_image')) {
    function delete_profile_image($userId) {
		
		if(unlink("images/profilepic/" . $userId   . ".jpg") &&  unlink("images/profilepic/" . $userId . "_thumb.jpg")){
			return "file deleted";
		}
		return "file failed to delete";
    }
}

if (!function_exists('get_pretty_personality')) {
    function get_pretty_personality($userId) {
        $controller = get_instance();
        $controller->load->model('Users_model');

        $personality = $controller->Users_model->get_personality($userId)[0];

        $e = (($personality['e'] >= 50) ? 'e: '.$personality['e']/10 : 'i: '.$personality['i']/10).'%';
        $n = (($personality['n'] >= 50) ? 'n: '.$personality['n']/10 : 's: '.$personality['s']/10).'%';
        $t = (($personality['t'] >= 50) ? 't: '.$personality['t']/10 : 'f: '.$personality['f']/10).'%';
        $j = (($personality['j'] >= 50) ? 'j: '.$personality['j']/10 : 'p: '.$personality['p']/10).'%';
        return $e.", ".$n.", ".$t.", ". $j;
    }
}
