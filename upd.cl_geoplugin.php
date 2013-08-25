<?php
class Cl_geoplugin_upd {

	public $name = "Cl_geoplugin";
	public $version = "1.0.0";
	public $description = "";
	public $settings_exist = "y";
	public $docs_url = "http://cl.us/products/geoplugin";

	var $settings			= array();

	private $mod_actions 	= array();

	public function __construct() {
		$this->EE =& get_instance();
		$this->EE->load->add_package_path(PATH_THIRD.'/cl_geoplugin');
		$this->EE->load->library('logger');

		$this->EE->load->model('Cl_geoplugin_settings_model');
	}

	function install() {
		// install module
		$data = array(
			'module_name' => $this->name,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);
		$this->EE->db->insert('modules', $data);

		// install actions
		$this->EE->db->select('method')
			->from('actions')
			->like('class', $this->name, 'after');
		$existing_methods = array();
		foreach ($this->EE->db->get()->result() as $row) $existing_methods[] = $row->method;
		foreach ($this->mod_actions as $method)	{
			if ( ! in_array($method, $existing_methods)) {
				$this->EE->db->insert('actions', array('class' => $this->name, 'method' => $method));
			}
		}
		
		// install settings
		$this->EE->Cl_geoplugin_settings_model->create_table();

		return TRUE;

	}

	function uninstall() {
		$this->EE->db->delete('modules', array('module_name' => $this->name));
		$this->EE->db->like('class', $this->name, 'after')->delete('actions');
		
		$this->EE->Cl_geoplugin_settings_model->drop_table();

		return TRUE;
	}
}
