<?php
class Form_model extends CI_Model {

	public function create_name($data){
		$this->db->insert('forms', $data);
		$formid = $this->db->insert_id();
		return $formid;
	}
}