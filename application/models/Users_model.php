<?php
class Users_model extends CI_Model {
	
	public function __construct(){
		$this->load->database();
	}
	
	public function get_brands(){
		$query = $this->db->get('Brands');
		return $query->result_array();
	}
}