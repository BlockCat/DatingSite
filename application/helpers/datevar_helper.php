<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('get_dating_variables')) {
    function get_dating_variables() {

        $file_source = FCPATH . "vars/datevars.txt";

		$content = file_get_contents($file_source);
		$content_array = explode(" ", $content);
		$result = array(
						'alpha' => $content_array[0],
						'beta' => $content_array[1],
						'x' => $content_array[2],
						'd' => $content_array[3]);

        return $result;
    }
}

if(!function_exists('set_dating_variables')) {
    function set_dating_variables($alpha, $x, $d) {
		$beta = 1 - $alpha;
        $file_source = FCPATH . "vars/datevars.txt";

        $new_content= "$alpha $beta $x $d";
		
		file_put_contents($file_source, $new_content);
    }
}