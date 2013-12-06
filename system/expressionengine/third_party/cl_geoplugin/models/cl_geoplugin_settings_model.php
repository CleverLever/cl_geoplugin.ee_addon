<?php
require_once(dirname(__FILE__).'/cl_geoplugin_model.php');

class Cl_geoplugin_settings_model extends Cl_geoplugin_model
{
	protected $table = "cl_geoplugin_settings";
	protected $table_fields = array(
		'site_id'	=> array(
			'type'			=> 'int',
			'constraint'	=> 10,
			'unsigned'		=> TRUE,
			),
		'key'	=> array(
			'type' 			=> 'varchar',
			'constraint'	=> '30',
			'null'			=> FALSE,
			'default'		=> ''
			),
		'value'  => array(
			'type' 			=> 'text',
			'null'			=> FALSE,
			'default'		=> ''
			),
		'serialized' => array(
			'type' 		=> 'int',
			'constraint' => 1,
			'null' => TRUE,
			'default' => '0'
			),									
	);
	protected $table_keys = array();

	private $settings = array("license" => "0000-0000-0000-0000");

	public function __construct() {
		parent::__construct();
	}
	
	public function get($key = false) {
		$query = $this->db->from($this->table)->where('site_id', $this->config->item('site_id'));

		if ($key) {
			$query->where('key', $key);
			return ($query->get()->num_rows() > 0) ? $query->row()->value : $this->settings[$key];
		} else {
			foreach ($query->get()->result_array() as $row) {
				$this->settings[$row['key']] = $row['value'];
			}
			return $this->settings;
		}
	}
	
	public function set($key, $value) {
		$data = array('site_id' => $this->config->item('site_id'),
			'key' => $key,
			'value' => (is_array($value)) ? serialized($value) : $value,
			'serialized' => (is_array($value)) ? 'y' : 'n',		
		);
		
		if ($this->db->from($this->table)->where('key', $key)->count_all_results() > 0)
			return $this->db->where('key', $key)->update($this->table, $data);
		else
			return $this->db->insert($this->table, $data); 
	}

}
