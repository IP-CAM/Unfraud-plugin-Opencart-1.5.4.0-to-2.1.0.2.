<?php
/**
 * Class ControllerModuleUnfraud
 *
 * @category    Unfraud
 * @package     Unfraud_Unfraud
 */
class ControllerModuleUnfraud extends Controller {
	
	private $error = array();
	const DASHBOARD_URL = "https://unfraud.com/dashboard";
	const LOGIN_API_URL = "https://unfraud.com/api/v1.1/index.php/user/?login=true";
	const LOGIN_URL = "https://unfraud.com/api/helpers/login.php";

	public function install() {
		
		$this->load->model('setting/setting');
			
		$nlayouts = 11;
			
		$settings = array();

		
		if(version_compare(VERSION, '1.5.0.9', '>')) {
			for ($i=0;$i<$nlayouts;$i++)
			{
				$settings['unfraud_module'][$i] = Array (
					"limit"=>99,
					"image_width"=>80,
					"image_height"=>80,
					"layout_id"=>$i+1,
					"position"=>"content_top",
					"status"=>1,
					"sort_order"=>0
				);
			}
			
			$this->model_setting_setting->editSetting('unfraud', $settings);		

		} else {
			for ($i=0;$i<$nlayouts;$i++) {
			    $settings["unfraud_{$i}_layout_id"] = $i+1;
			    $settings["unfraud_{$i}_image_width"] = 80;
			    $settings["unfraud_{$i}_image_height"] = 80;
			    $settings["unfraud_{$i}_position"] = 'content_top';
			    $settings["unfraud_{$i}_status"] = 1;
			    $settings["unfraud_{$i}_sort_order"] = '';
			    $settings["unfraud_"] .= "$i,";
			}
			
			$settings["unfraud_module"] = substr($settings["unfraud_module"],0,-1);
			$this->model_setting_setting->editSetting('unfraud', $settings);

		}

    }

    public function index() {

		$this->load->language('module/unfraud');
        $this->load->model('setting/setting');
        $this->load->model('design/layout');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('unfraud', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('module/unfraud', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$text_strings = array(
				'heading_title',
				'text_enabled',
				'text_disabled',
				'text_content_top',
				'text_content_bottom',
				'text_column_left',
				'text_column_right',
				'entry_layout',
				'entry_limit',
				'entry_image',
				'entry_position',
				'entry_status',
				'entry_sort_order',
				'button_save',
				'button_cancel',
				'button_add_module',
				'button_remove',
				'entry_apikey',
				'entry_email',
				'entry_password',
                'entry_debug',
				'entry_threshold',
                'entry_configuration_error',
                'entry_credentials_error'
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}

		$config_data = array(
				'unfraud_apikey', 
				'unfraud_email',
				'unfraud_password',
				'unfraud_threshold',
		);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$data[$conf] = $this->request->post[$conf];
			} else {
				$data[$conf] = $this->config->get($conf);
			}
		}
	
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/unfraud', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$data['action'] = $this->url->link('module/unfraud', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');


		$data['modules'] = array();
		
		if (isset($this->request->post['unfraud_module'])) {
			$data['modules'] = $this->request->post['unfraud_module'];
		} elseif ($this->config->get('unfraud_module')) {
			$data['modules'] = $this->config->get('unfraud_module');
		}	

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['unfraud_email'] = $this->config->get('unfraud_email');
		$data['unfraud_password'] = $this->config->get('unfraud_password');
		$data['unfraud_apikey'] = $this->config->get('unfraud_apikey');
		$data['unfraud_threshold'] = $this->config->get('unfraud_threshold');
		$data['unfraud_login_api_url'] = self::LOGIN_API_URL;
		$data['unfraud_login_url'] = self::LOGIN_URL;

		if(version_compare(VERSION, '2.0.0.0', '<')) {
			$data['version']="1.5";
			$this->data = $data;
			$this->template = 'module/unfraud.tpl';
			$this->children = array(
				'common/header',
				'common/footer',
			);
			$this->response->setOutput($this->render());
		}
		else{
			$data['version']="2";
			$data['header'] = $this->load->controller('common/header');
        	$data['column_left'] = $this->load->controller('common/column_left');
        	$data['footer'] = $this->load->controller('common/footer');
			$this->response->setOutput($this->load->view('module/unfraud.tpl', $data));
		}





	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/unfraud')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}


}
?>