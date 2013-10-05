<?php
require_once('includes/geoplugin.class.php');

class Cl_geoplugin
{
	private $settings;
	private $ip_address;
	private $geoplugin;


	public function __construct()
	{
		$this->EE =& get_instance();
		$this->EE->load->add_package_path(PATH_THIRD.'/cl_geoplugin');
		$this->EE->load->model('Cl_geoplugin_settings_model');

		$this->settings = $this->EE->Cl_geoplugin_settings_model->get();
		$this->geoplugin = new geoPlugin();
		
		$this->ip_address = $this->EE->TMPL->fetch_param('ip_address', $this->EE->input->ip_address());

		$this->geoplugin->locate($this->ip_address);
	}

	public function locate()
	{
		$data = array();

		$data[0]['ip']                 = $this->geoplugin->ip;
		$data[0]['city']               = $this->geoplugin->city;
		$data[0]['region']             = $this->geoplugin->region;
		$data[0]['area_code']          = $this->geoplugin->areaCode;
		$data[0]['dma_code']           = $this->geoplugin->dmaCode;
		$data[0]['country_code']       = $this->geoplugin->countryCode;
		$data[0]['country_name']       = $this->geoplugin->countryName;
		$data[0]['continent_code']     = $this->geoplugin->continentCode;
		$data[0]['latitude']           = $this->geoplugin->latitude;
		$data[0]['longitude']          = $this->geoplugin->longitude;
		$data[0]['currency_code']      = $this->geoplugin->currencyCode;
		$data[0]['currency_symbol']    = $this->geoplugin->currencySymbol;
		$data[0]['currency_converter'] = $this->geoplugin->currencyConverter;
		
		$data[0]['nearby'] 			 = $this->_nearby();

		return $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $data);
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
			if ($nearby['nearby_city'] == $city && $nearby['nearby_region'] == $region && $nearby['nearby_country_code'] == $country_code) {
				$data = TRUE;
				break;
			}
		}

		return $data;
	}
	
	public function city() 					{ return $this->geoplugin->city; }
	public function region() 				{ return $this->geoplugin->region; }	
	public function area_code() 			{ return $this->geoplugin->areaCode; }
	public function dma_code() 				{ return $this->geoplugin->dmaCode; }
	public function country_code() 			{ return $this->geoplugin->countryCode; }
	public function continent_code() 		{ return $this->geoplugin->continentCode; }
	public function latitude() 				{ return $this->geoplugin->latitude; }
	public function longitude() 			{ return $this->geoplugin->longitude; }
	public function currency_code() 		{ return $this->geoplugin->currencyCode; }
	public function currency_symbol() 		{ return $this->geoplugin->currencySymbol; }
	public function currency_converter() 	{ return $this->geoplugin->currencyConverter; }
	
	private function _nearby($radius = 10, $limit = 10)
	{
		$data = array();
		$nearbys = $this->geoplugin->nearby($radius, $limit);

		$row = 0;
		foreach ($nearbys as $nearby) {
			$data[$row]['nearby_city'] 			= $nearby['geoplugin_place'];
			$data[$row]['nearby_region'] 		= $nearby['geoplugin_region'];
			$data[$row]['nearby_country_code'] 	= $nearby['geoplugin_countryCode'];
			$data[$row]['nearby_latitude']		= $nearby['geoplugin_latitude'];
			$data[$row]['nearby_longitude']		= $nearby['geoplugin_longitude'];
			$row++;
		}
	 	return $data;
	}
}
