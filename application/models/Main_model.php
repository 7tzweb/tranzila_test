<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {

	public function get_todos() {
		$q = $this->db->get_where('todos',array());
		return $q->result();
	}
	public function insert($data) {
		$this->db->insert('todos',$data);
		return $this->db->insert_id();
	}
	public function update($data,$id) {
		$this->db->where('id',$id);
		$this->db->update('todos',$data);
	}
	public function delete($id) {
		$this->db->delete('todos',array('id'=>$id));
	}
	public function find_todo($id) {
		$q = $this->db->get_where('todos',array('id'=>$id));
		return $q->row(0);
	}

}