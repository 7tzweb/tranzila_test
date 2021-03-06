<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Main_model');
	}

	public function index() {
		$data['title'] = "Todolist by Tsohar zigdon";
		$data['todos'] = $this->Main_model->get_todos();
		$this->load->view('index',$data);
	}

	public function insert() {
		if (!$this->input->is_ajax_request()) {
			exit('not allowed');
			return false;
		}
		$todoname = array('name'=>$this->input->post('todo'),'status'=>0);
		$insert_id = $this->Main_model->insert($todoname);
		$this->find_todo($insert_id);
	}

	public function done() {
		if (!$this->input->is_ajax_request()) {
			exit('not allowed');
			return false;
		}
		$id = $this->input->post('id');
		$data = array(
					'status'	=> 1,
					'done_at'	=> date("Y-m-d H:i:s"),
				);
		$this->Main_model->update($data,$id);
	}

	public function delete() {
		if (!$this->input->is_ajax_request()) {
			exit('not allowed');
			return false;
		}
		$id = $this->input->post('id');
		$todo = $this->Main_model->find_todo($id);
		// if ($todo->created_at ) {
		// 	# code...
		// }
		$days_more6 = date('Y-m-d', strtotime('+6 days', strtotime($todo->created_at)));
		$now = date('Y-m-d');
		$now=date('Y-m-d', strtotime($now));
		if($now > $days_more6){
			$this->Main_model->delete($id);
		}else{
			exit('need 6 dayes ago');
			return false;
		}
	}

	public function edit() {
		if (!$this->input->is_ajax_request()) {
			exit('not allowed');
			return false;
		}
		$id = $this->input->post('id');
		$todo = $this->Main_model->find_todo($id);
		echo json_encode($todo);
	}

	public function update() {
		if (!$this->input->is_ajax_request()) {
			exit('not allowed');
			return false;
		}
		$id = $this->input->post('id');
		$data = array(
					'name'	=> $this->input->post('todo'),
				);
		$this->Main_model->update($data,$id);
		$this->find_todo($id);
	}

	public function find_todo($id) {
		$todo = $this->Main_model->find_todo($id);
		echo json_encode($todo);
	}

	public function countTodos() {
		$todo = $this->Main_model->get_todos();
		echo json_encode($todo);
	}

}
