<?php
class Users_model extends CI_Model {
	
	public function __construct(){
		$this->load->database();
	}
	
	public function get_all_brands(){
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
	
	
	public function get_certain_profile($userID){	
		$this->db->where('userID', $userID);
		$query = $this->db->get('UserProfile');
		$result = $query->result_array();
		return $result;
	}
	
	public function get_random_profiles($userID){	
		$this->db->where('userID <>', $userID);
		$this->db->limit(6);
		$query = $this->db->get('UserProfile');
		$result = $query->result_array();
		shuffle ($result);		
		return array_slice($result, 0, 6);
	}
	
	public function get_personality($personalityID){
		$this->db->where('personalityID', $personalityID);
		$query = $this->db->get('Personality');
		return $query->result_array();
	}
	
	public function get_brands($userID){
		$this->db->where('user', $userID);
		$query = $this->db->get('BrandPref');
		$shuffledarray = $query->result_array();
		shuffle ($shuffledarray);
		return $shuffledarray;
	}
}