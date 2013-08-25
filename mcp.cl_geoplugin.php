<?php
class Cl_Geoplugin_mcp 
{
	private $settings;
	
	public function __construct() {
		$this->EE =& get_instance();
		$this->EE->load->add_package_path(PATH_THIRD.'/cl_geoplugin');
		$this->EE->load->helper('form');
		
		$this->EE->load->model('Cl_geoplugin_settings_model');
		$this->settings = $this->EE->Cl_geoplugin_settings_model->get();
	}
	public function index() {
		$this->EE->functions->redirect(BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=cl_geoplugin'.AMP.'method=settings');
	}
	
	public function settings() {
		$this->EE->cp->set_variable('cp_page_title', lang('Cl_geoplugin_module_name'));

		if (!empty($_POST)) {
			foreach ($_POST['settings'] as $key => $value) {
				$this->EE->Geoplugin_settings_model->set($key, $value);
			}
			$this->EE->functions->redirect(BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=cl_geoplugin'.AMP.'method=settings');
		}
		return $this->EE->load->view(__FUNCTION__, array('settings' => $this->settings), TRUE);
	}
}
