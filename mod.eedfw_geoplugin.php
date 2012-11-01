<?php
require_once('includes/geoplugin.class.php');

class Eedfw_geoplugin
{
	private $settings;

	public function __construct()
	{
		$this->EE =& get_instance();
		$this->EE->load->model('Eedfw_geoplugin_settings_model');

		$this->settings = $this->EE->Eedfw_geoplugin_settings_model->get();
		$this->geoplugin = new geoPlugin();
	}

	public function locate()
	{
		$this->ip_address = $this->EE->TMPL->fetch_param('ip_address', $this->EE->input->ip_address());

		$this->geoplugin->locate($this->ip_address);
		$data[0]['ip']                 = $this->geoplugin->ip;
		$data[0]['city']               = $this->geoplugin->city;
		$data[0]['region']             = $this->geoplugin->region;
		$data[0]['area_code']          = $this->geoplugin->areaCode;
		$data[0]['dma_code']           = $this->geoplugin->dmaCode;
		$data[0]['country_code']       = $this->geoplugin->countryCode;
		$data[0]['country_name']       = $this->geoplugin->countryName;
		$data[0]['continent_code']     = $this->geoplugin->continentCode;
		$data[0]['latitude']           = $this->geoplugin->latitute;
		$data[0]['longitude']          = $this->geoplugin->longitude;
		$data[0]['currency_code']      = $this->geoplugin->currencyCode;
		$data[0]['currency_symbol']    = $this->geoplugin->currencySymbol;
		$data[0]['currency_converter'] = $this->geoplugin->currencyConverter;

		return $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $data);
	}
}