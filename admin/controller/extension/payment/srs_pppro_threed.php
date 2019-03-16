<?php

class ControllerExtensionPaymentSrsPpproThreed extends Controller {
    
	private $error = array();

	private $data = array();

	public function index() {
				
		$this->load->language('extension/payment/srs_pppro_threed');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			$this->model_setting_setting->editSetting('srs_pppro_threed', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'type=payment&token=' . $this->session->data['token'], true));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_edit'] = $this->language->get('text_edit'); // Opencart 2x

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_sale'] = $this->language->get('text_sale');
		
		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_signature'] = $this->language->get('entry_signature');

                $this->data['entry_centinel_processor_id'] = $this->language->get('entry_centinel_processor_id');
                $this->data['entry_centinel_marchant_id'] = $this->language->get('entry_centinel_marchant_id');
                $this->data['entry_centinel_transaction_pwd'] = $this->language->get('entry_centinel_transaction_pwd');
                $this->data['entry_centinel_maps_url'] = $this->language->get('entry_centinel_maps_url');
                

		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_transaction'] = $this->language->get('entry_transaction');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_total'] = $this->language->get('entry_total');			
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		 if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['username'])) {
			$this->data['error_username'] = $this->error['username'];
		} else {
			$this->data['error_username'] = '';
		}
		
 		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
 		if (isset($this->error['signature'])) {
			$this->data['error_signature'] = $this->error['signature'];
		} else {

			$this->data['error_signature'] = '';
		}


                //Centinel Error 
                if (isset($this->error['error_centinel_processor_id'])) {
			$this->data['error_centinel_processor_id'] = $this->error['error_centinel_processor_id'];
		} else {
			$this->data['error_centinel_processor_id'] = '';
		}

 		if (isset($this->error['error_centinel_marchant_id'])) {
			$this->data['error_centinel_marchant_id'] = $this->error['error_centinel_marchant_id'];
		} else {
			$this->data['error_centinel_marchant_id'] = '';
		}

 		if (isset($this->error['error_centinel_transaction_pwd'])) {
			$this->data['error_centinel_transaction_pwd'] = $this->error['error_centinel_transaction_pwd'];
		} else {

			$this->data['error_centinel_transaction_pwd'] = '';
		}

 		if (isset($this->error['error_centinel_maps_url'])) {
			$this->data['error_centinel_maps_url'] = $this->error['error_centinel_maps_url'];
		} else {

			$this->data['error_centinel_maps_url'] = '';
		}

				$this->document->breadcrumbs = array();

   		 
		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/extension', 'type=payment&token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/payment/srs_pppro_threed', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('extension/payment/srs_pppro_threed', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/extension', 'type=payment&token=' . $this->session->data['token'], 'SSL');

		
		if (isset($this->request->post['srs_pppro_threed_username'])) {
			$this->data['srs_pppro_threed_username'] = $this->request->post['srs_pppro_threed_username'];
		} else {
			$this->data['srs_pppro_threed_username'] = $this->config->get('srs_pppro_threed_username');
		}
		
		if (isset($this->request->post['srs_pppro_threed_password'])) {
			$this->data['srs_pppro_threed_password'] = $this->request->post['srs_pppro_threed_password'];
		} else {
			$this->data['srs_pppro_threed_password'] = $this->config->get('srs_pppro_threed_password');
		}
		
		if (isset($this->request->post['srs_pppro_threed_signature'])) {
			$this->data['srs_pppro_threed_signature'] = $this->request->post['srs_pppro_threed_signature'];
		} else {
			$this->data['srs_pppro_threed_signature'] = $this->config->get('srs_pppro_threed_signature');
		}
		
                ////3d secure -- centinel API
                if (isset($this->request->post['srs_pppro_threed_centinel_processor_id'])) {
			$this->data['srs_pppro_threed_centinel_processor_id'] = $this->request->post['srs_pppro_threed_centinel_processor_id'];
		} else {
			$this->data['srs_pppro_threed_centinel_processor_id'] = $this->config->get('srs_pppro_threed_centinel_processor_id');
		}

                if (isset($this->request->post['srs_pppro_threed_centinel_marchant_id'])) {
			$this->data['srs_pppro_threed_centinel_marchant_id'] = $this->request->post['srs_pppro_threed_centinel_marchant_id'];
		} else {
			$this->data['srs_pppro_threed_centinel_marchant_id'] = $this->config->get('srs_pppro_threed_centinel_marchant_id');
		}

                if (isset($this->request->post['srs_pppro_threed_centinel_transaction_pwd'])) {
			$this->data['srs_pppro_threed_centinel_transaction_pwd'] = $this->request->post['srs_pppro_threed_centinel_transaction_pwd'];
		} else {
			$this->data['srs_pppro_threed_centinel_transaction_pwd'] = $this->config->get('srs_pppro_threed_centinel_transaction_pwd');
		}

                if (isset($this->request->post['srs_pppro_threed_centinel_maps_url'])) {
			$this->data['srs_pppro_threed_centinel_maps_url'] = $this->request->post['srs_pppro_threed_centinel_maps_url'];
		} else {
			$this->data['srs_pppro_threed_centinel_maps_url'] = $this->config->get('srs_pppro_threed_centinel_maps_url');
		}
                ///

		if (isset($this->request->post['srs_pppro_threed_test'])) {
			$this->data['srs_pppro_threed_test'] = $this->request->post['srs_pppro_threed_test'];
		} else {
			$this->data['srs_pppro_threed_test'] = $this->config->get('srs_pppro_threed_test');
		}
		
		if (isset($this->request->post['srs_pppro_threed_method'])) {
			$this->data['srs_pppro_threed_transaction'] = $this->request->post['srs_pppro_threed_transaction'];
		} else {
			$this->data['srs_pppro_threed_transaction'] = $this->config->get('srs_pppro_threed_transaction');
		}
		if (isset($this->request->post['srs_pppro_threed_total'])) {
			$this->data['srs_pppro_threed_total'] = $this->request->post['srs_pppro_threed_total'];
		} else {
			$this->data['srs_pppro_threed_total'] = $this->config->get('srs_pppro_threed_total'); 
		} 		
		if (isset($this->request->post['srs_pppro_threed_order_status_id'])) {
			$this->data['srs_pppro_threed_order_status_id'] = $this->request->post['srs_pppro_threed_order_status_id'];
		} else {
			$this->data['srs_pppro_threed_order_status_id'] = $this->config->get('srs_pppro_threed_order_status_id');
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['srs_pppro_threed_geo_zone_id'])) {
			$this->data['srs_pppro_threed_geo_zone_id'] = $this->request->post['srs_pppro_threed_geo_zone_id'];
		} else {
			$this->data['srs_pppro_threed_geo_zone_id'] = $this->config->get('srs_pppro_threed_geo_zone_id');
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['srs_pppro_threed_status'])) {
			$this->data['srs_pppro_threed_status'] = $this->request->post['srs_pppro_threed_status'];
		} else {
			$this->data['srs_pppro_threed_status'] = $this->config->get('srs_pppro_threed_status');
		}
		
		if (isset($this->request->post['srs_pppro_threed_sort_order'])) {
			$this->data['srs_pppro_threed_sort_order'] = $this->request->post['srs_pppro_threed_sort_order'];
		} else {
			$this->data['srs_pppro_threed_sort_order'] = $this->config->get('srs_pppro_threed_sort_order');
		}

		/*$this->template = 'extension/payment/srs_pppro_threed.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());*/
		
		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/srs_pppro_threed', $this->data));

	}
	
	


	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/srs_pppro_threed')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['srs_pppro_threed_username']) {
			$this->error['username'] = $this->language->get('error_username');
		}

		if (!$this->request->post['srs_pppro_threed_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->request->post['srs_pppro_threed_signature']) {
			$this->error['signature'] = $this->language->get('error_signature');
		}



              // Centinel validation
                if (!$this->request->post['srs_pppro_threed_centinel_processor_id']) {
			$this->error['error_centinel_processor_id'] = $this->language->get('error_centinel_processor_id');
		}

                if (!$this->request->post['srs_pppro_threed_centinel_marchant_id']) {
			$this->error['error_centinel_marchant_id'] = $this->language->get('error_centinel_marchant_id');
		}

                if (!$this->request->post['srs_pppro_threed_centinel_transaction_pwd']) {
			$this->error['error_centinel_transaction_pwd'] = $this->language->get('error_centinel_transaction_pwd');
		}

                if (!$this->request->post['srs_pppro_threed_centinel_maps_url']) {
			$this->error['error_centinel_maps_url'] = $this->language->get('error_centinel_maps_url');
		}

                
                if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>