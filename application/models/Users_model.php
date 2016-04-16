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

	public function register_user($userdata, $userpersonality, $prefPersonality, $brands) {

		$this->db->trans_begin(); //Begin transaction, so if something goes wrong we can roll back.
		$this->db->insert('UserProfile', $userdata);
		$userId = $this->db->insert_id();

		$this->db->insert('Personality', $userpersonality);
		$personalityId = $this->db->insert_id();

		$this->db->insert('Personality', $prefPersonality);
		$prefPersonality = $this->db->insert_id();

		$this->db->where('userID', $userId);
		$this->db->update('UserProfile', array(
			'userPersonality' => $personalityId,
			'userPersonalityPref' => $prefPersonality));


		foreach($brands as $id => $brand){
			$newbrand = array(
				'user' =>	$userId,
				'brand' => 	$brand
			);
			$this->db->insert('BrandPref', $newbrand);
		}

		if ($this->db->trans_status() === false) { //If the transaction went wrong, roll back return false.
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
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
	
	public function set_liked($user, $profile){
		$like = array(
			'likes' =>	$user,
			'liked' => 	$profile
		);
		
		$this->db->insert('UserLikes', $like);
		return $like;
		
	}

	public function email_exists($email) {
		$this->db->select('*');
		$this->db->from('UserProfile');
		$this->db->where('userEmail', $email);

		$query = $this->db->get();
		return $query->num_rows() >= 1;
	}
	
	public function get_relation($user, $profile){
		$this->db->select('*');
		$this->db->from('UserLikes');
		$this->db->where('likes', $user);
		$this->db->where('liked', $profile);		
		$given = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('UserLikes');
		$this->db->where('likes', $profile);
		$this->db->where('liked', $user);		
		$received = $this->db->get();
		
		if(count($given->result_array()) == 1){
			if(count($received->result_array()) == 1){
				return 'm';
			}
			else{
				return "g";
			}
		}
		else{
			if($received->num_rows() == 1){
				return "r";
			}
			else{
				return "n";
			}
		}
	}	
	
	
	public function get_certain_profile($userID){	
		userMaxAgePref, userSexPref, userAdmin, userDescription, userPersonality, userPersonalityPref');
		$this->db->where('userID', $userID);
		$query = $this->db->get('UserProfile');
		$result = $query->result_array();
		return $result;
	}
	
	public function get_sensitive_profile($userID){	
		$this->db->select('userID, userEmail, userNickname, userFirstName, userLastName, 
		userSex, userBirthdate, userMinAgePref, userMaxAgePref, userSexPref, userAdmin, userDescription, userPersonality, userPersonalityPref');
		$this->db->where('userID', $userID);
		$query = $this->db->get('UserProfile');
		$result = $query->result_array();
		return $result;
	}
	
	public function get_random_profiles($userID){	
		$this->db->where('userID <>', $userID);
		$this->db->select('userID, userNickname, userSex, userBirthdate, userMaxAgePref, 
		userMaxAgePref, userSexPref, userAdmin, userDescription, userPersonality, userPersonalityPref');
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