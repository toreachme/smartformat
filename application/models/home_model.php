<?php
class Home_model extends CI_Model {

	public function getQuestionnairebyId($id){
		$query = $this->db->query('SELECT * FROM questionnaire WHERE Q_id ='.$id);
		// $query = $this->db->query('SELECT * FROM questionnaire JOIN header ON questionnaire.H_id = header.H_id WHERE questionnaire.Q_id ='.$id);

		if($query->num_rows() > 0){
			$result = $query->row();

			return $result;
		}
	}

	public function getAnswerById($id){
		$query = $this->db->query('SELECT * FROM answers WHERE Q_id ='.$id);

		if($query->num_rows() > 0){
			$result = $query->row();

			return $result;
		}
	}

	public function getAllbyAnswerDomain($domain){
		$query = $this->db->query("SELECT * FROM answers JOIN questionnaire ON answers.Q_id = questionnaire.Q_id JOIN header ON questionnaire.H_id = header.H_id WHERE answers.Domain ='$domain'");

		$result = $query->result();

		return $result;

	}


	/* All new data structure 
	 *
	 *
	 */

	public function getAllHeaders(){
		$query = $this->db->query("SELECT * FROM header");
		$result = $query->result();

		return $result;

	}

	public function getQandAbyDomain($domain){
		$query = $this->db->query("SELECT * FROM answers JOIN questionnaire ON answers.Q_id = questionnaire.Q_id WHERE answers.Domain ='$domain'");

		
		$result = $query->result();

		return $result;

	}

}

