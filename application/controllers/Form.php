<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('form_model');
	}

	public function index(){
		$this->load->view('create_form');
	}

	public function create(){
		$this->form_validation->set_rules('fname', 'Form name', 'required');


		if ($this->form_validation->run() == FALSE){
			$this->load->view('create_form');
		}
		else{
			$data['name'] = $this->input->post('fname');
			$this->form_model->create_name($data);
			echo "Success";
		}

	}

}