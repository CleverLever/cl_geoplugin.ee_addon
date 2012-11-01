<?php
require_once('includes/geoplugin.class.php');

class Eedfw_geoplugin
{
	private $settings;
	
	public function __construct() {
		$this->EE =& get_instance();
		$this->EE->load->model('Eedfw_geoplugin_settings_model');

		$this->settings = $this->EE->Eedfw_geoplugin_settings_model->get();
		$this->geoplugin = new geoPlugin();
		
		$this->ip_address = $this->EE->TMPL->fetch_param('ip_address', $this->EE->input->ip_address());
	}

	public function locate() {
		$this->geoplugin->locate($this->ip_address);
		$data[0] = (array) $this->geoplugin;
		return $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $data);
	}
}