<?php
require_once('includes/geoplugin.class.php');

class Eedfw_geoplugin
{
	private $settings;
	private $ip_address;
	private $geoplugin;
	private $data = array();

	public function __construct()
	{
		$this->EE =& get_instance();
		$this->EE->load->model('Eedfw_geoplugin_settings_model');

		$this->settings = $this->EE->Eedfw_geoplugin_settings_model->get();
		$this->geoplugin = new geoPlugin();
		
		$this->ip_address = $this->EE->TMPL->fetch_param('ip_address', $this->EE->input->ip_address());

		$this->geoplugin->locate($this->ip_address);
	}

	public function locate()
	{
		$this->data[0]['ip']                 = $this->geoplugin->ip;
		$this->data[0]['city']               = $this->geoplugin->city;
		$this->data[0]['region']             = $this->geoplugin->region;
		$this->data[0]['area_code']          = $this->geoplugin->areaCode;
		$this->data[0]['dma_code']           = $this->geoplugin->dmaCode;
		$this->data[0]['country_code']       = $this->geoplugin->countryCode;
		$this->data[0]['country_name']       = $this->geoplugin->countryName;
		$this->data[0]['continent_code']     = $this->geoplugin->continentCode;
		$this->data[0]['latitude']           = $this->geoplugin->latitude;
		$this->data[0]['longitude']          = $this->geoplugin->longitude;
		$this->data[0]['currency_code']      = $this->geoplugin->currencyCode;
		$this->data[0]['currency_symbol']    = $this->geoplugin->currencySymbol;
		$this->data[0]['currency_converter'] = $this->geoplugin->currencyConverter;
		
		$this->data[0]['nearby'] 			 = $this->_nearby($radius, $limit);

		return $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $this->data);
	}
	
	public function nearby($radius = 10, $limit = 10)
	{
		$radius			= $this->EE->TMPL->fetch_param('radius', $radius);
		$limit			= $this->EE->TMPL->fetch_param('limit', $limit);

		$nearby = $this->_nearby($radius, $limit);

		return $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $nearby);
	}
	
	public function is_nearby($radius = 10, $limit = 100)
	{
		$city			= $this->EE->TMPL->fetch_param('city');
		$region			= $this->EE->TMPL->fetch_param('region');
		$country_code	= $this->EE->TMPL->fetch_param('country_code');
		$radius			= $this->EE->TMPL->fetch_param('radius', $radius);
		$limit			= $this->EE->TMPL->fetch_param('limit', $limit);
		
		$nearbys = $this->_nearby($radius, $limit);
		
		$data = FALSE;
		foreach ($nearbys as $nearby) {
			if ($nearby['city'] == $city && $nearby['region'] == $region && $nearby['country_code'] == $country_code) {
				$data = TRUE;
				break;
			}
		}

		return $data;
	}
	
	public function city() 					{ return $this->geoplugin->city; }
	public function region() 				{ return $this->geoplugin->region; }	
	public function area_code() 			{ return $this->geoplugin->area_code; }
	public function dma_code() 				{ return $this->geoplugin->dma_code; }
	public function country_code() 			{ return $this->geoplugin->country_code; }
	public function continent_code() 		{ return $this->geoplugin->continent_code; }
	public function latitude() 				{ return $this->geoplugin->latitude; }
	public function longitude() 			{ return $this->geoplugin->longitude; }
	public function currency_code() 		{ return $this->geoplugin->currency_code; }
	public function currency_symbol() 		{ return $this->geoplugin->currency_symbol; }
	public function currency_converter() 	{ return $this->geoplugin->currency_converter; }
	
	private function _nearby($radius = 10, $limit = 10)
	{
		$nearbys = $this->geoplugin->nearby($radius, $limit);

		$row = 0;
		foreach ($nearbys as $nearby) {
			$this->data[$row]['city'] 			= $nearby['geoplugin_place'];
			$this->data[$row]['region'] 			= $nearby['geoplugin_region'];
			$this->data[$row]['country_code'] 	= $nearby['geoplugin_countryCode'];
			$this->data[$row]['latitude']			= $nearby['geoplugin_latitude'];
			$this->data[$row]['longitude']		= $nearby['geoplugin_longitude'];
			$row++;
		}
	 	return $this->data;
	}
}