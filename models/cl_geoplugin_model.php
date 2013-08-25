<?php
class Cl_geoplugin_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->library('logger');
	}

	public function create_table() {
		$this->load->dbforge();
		$this->dbforge->add_field($this->table_fields);
		$this->dbforge->add_key($this->table_keys);
		$this->dbforge->create_table($this->table, TRUE);
	}

	public function drop_table() {
		$this->load->dbforge();
		return $this->dbforge->drop_table($this->name);
	}
}