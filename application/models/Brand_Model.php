<?php
class Brand_Model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_all_brands(){
        $query = $this->db->get('Brands');
        return $query->result_array();
    }

    public function get_brands($userID){
        $this->db->where('user', $userID);
        $query = $this->db->get('BrandPref');
        $shuffledarray = $query->result_array();
        shuffle ($shuffledarray);
        return $shuffledarray;
    }

    public function add_brand($brand) {
        if (preg_match("/^[a-zA-Z-_.,/\\0-9()'~`&$%#@!&*\[\]]+$/", $brand)) {
            $sql = "INSERT INTO Brands (brandName) VALUES (?)";
            $this->db->query($sql, array($brand));
        }
    }
}