<?php
class Users_model extends CI_Model {
	
	public function __construct(){
		$this->load->database();
	}
	
	public function get_brands(){
		$query = $this->db->get('Brands');
		return $query->result_array();
	}
	
	public function authenticate_login($email, $password){
		$this->db->select('*');
		$this->db->from('UserProfile');
		$this->db->where('userEmail', $email);
		$this->db->where('userPassword', $password);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1){
			return $query->result_array();
		}
		else{
			return false;
		}
	}
}