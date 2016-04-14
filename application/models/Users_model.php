<?php
class Users_model extends CI_Model {
	
	public function __construct()
	{
		$this->load->database();
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
	
	public function edit_user($ID, $email, $pass, $nickname, $firstname, $lastname, $sex, 
	$birth, $min, $max, $sexpref, $admin, $desc, $pers, $perspref, $brands){
		$data = array(
				'userID' =>	$ID,
				'userEmail' => $email,
				'userPassword' => $pass,
				'userNickname' => $nickname,
				'userFirstName' => $firstname,
				'userLastName' => $lastname,
				'userSex' => $sex,
				'userBirthdate' => $birth,
				'userMinAgePref' => $min,
				'userMaxAgePref' => $max,
				'userSexPref' => $sexpref,
				'userAdmin' => $admin,
				'userDescription' => $desc,
				'userPersonality' => $pers,
				'userPersonalityPref' => $perspref
		);
		
		$this->db->replace('UserProfile', $data);
		
		$this->db->delete('BrandPref', array('user' => $ID));
		
		foreach($brands as $brand){
			$newbrand = array(
				'user' =>	$ID,
				'brand' => 	$brand
			);
			$this->db->insert('BrandPref', $newbrand);
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
}