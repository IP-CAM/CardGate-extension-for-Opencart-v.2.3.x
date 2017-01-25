<?php 
class ControllerExtensionTotalCardgatefee extends Controller { 
	private $error = array(); 
	 
	public function index() { 
		$this->language->load('extension/total/cardgatefee');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('cardgatefee', $this->request->post);
		
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_tax'] = $this->language->get('entry_tax');
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['tab_fee'] = $this->language->get('tab_fee');
		$data['tab_general'] = $this->language->get('tab_general');
		$data['text_all'] = $this->language->get('text_all');
		$data['entry_order_total'] = $this->language->get('entry_order_total');
		
		
		$data['entry_payment'] = $this->language->get('entry_payment');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_order_max_total'] = $this->language->get('entry_order_max_total');
					
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

   		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
   		);

   		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/total/cardgatefee', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('extension/total/cardgatefee', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true);

		for($i=1;$i<=10;$i++)
		 {
				if (isset($this->request->post['cardgatefee_cost'.$i])) {
					$data['cardgatefee_cost'.$i] = $this->request->post['cardgatefee_cost'.$i];
				} else {
					$data['cardgatefee_cost'.$i] = $this->config->get('cardgatefee_cost'.$i);
				}
				
				if (isset($this->request->post['cardgatefee_name'.$i])) {
					$data['cardgatefee_name'.$i] = $this->request->post['cardgatefee_name'.$i];
				} else {
					$data['cardgatefee_name'.$i] = $this->config->get('cardgatefee_name'.$i);
				}
				
				if (isset($this->request->post['cardgatefee_free'.$i])) {
					$data['cardgatefee_free'.$i] = $this->request->post['cardgatefee_free'.$i];
				} else {
					$data['cardgatefee_free'.$i] = $this->config->get('cardgatefee_free'.$i);
				}
		
				if (isset($this->request->post['cardgatefee_tax_class_id'.$i])) {
					$data['cardgatefee_tax_class_id'.$i] = $this->request->post['cardgatefee_tax_class_id'.$i];
				} else {
					$data['cardgatefee_tax_class_id'.$i] = $this->config->get('cardgatefee_tax_class_id'.$i);
				}
		
				if (isset($this->request->post['cardgatefee_geo_zone_id'.$i])) {
					$data['cardgatefee_geo_zone_id'.$i] = $this->request->post['cardgatefee_geo_zone_id'.$i];
				} else {
					$data['cardgatefee_geo_zone_id'.$i] = $this->config->get('cardgatefee_geo_zone_id'.$i);
				}
				
				if (isset($this->request->post['cardgatefee_status'.$i])) {
					$data['cardgatefee_status'.$i] = $this->request->post['cardgatefee_status'.$i];
				} else {
					$data['cardgatefee_status'.$i] = $this->config->get('cardgatefee_status'.$i);
				}
				
				if (isset($this->request->post['cardgatefee_shipping'.$i])) {
					$data['cardgatefee_shipping'.$i] = $this->request->post['cardgatefee_shipping'.$i];
				} else {
					$data['cardgatefee_shipping'.$i] = $this->config->get('cardgatefee_shipping'.$i);
				}
				
				if (isset($this->request->post['cardgatefee_payment'.$i])) {
					$data['cardgatefee_payment'.$i] = $this->request->post['cardgatefee_payment'.$i];
				} else {
					$data['cardgatefee_payment'.$i] = $this->config->get('cardgatefee_payment'.$i);
				}
				
				if (isset($this->request->post['cardgatefee_total'.$i])) {
					$data['cardgatefee_total'.$i] = $this->request->post['cardgatefee_total'.$i];
				} else {
					$data['cardgatefee_total'.$i] = $this->config->get('cardgatefee_total'.$i);
				}
				
				if (isset($this->request->post['cardgatefee_total_max'.$i])) {
					$data['cardgatefee_total_max'.$i] = $this->request->post['cardgatefee_total_max'.$i];
				} else {
					$data['cardgatefee_total_max'.$i] = $this->config->get('cardgatefee_total_max'.$i);
				}
				
				
				
				if (isset($this->request->post['cardgatefee_sort_order'.$i])) {
					$data['cardgatefee_sort_order'.$i] = $this->request->post['cardgatefee_sort_order'.$i];
				} else {
					$data['cardgatefee_sort_order'.$i] = $this->config->get('cardgatefee_sort_order'.$i);
				}
		 }	
		 
		 if (isset($this->request->post['cardgatefee_status'])) {
					$data['cardgatefee_status'] = $this->request->post['cardgatefee_status'];
				} else {
					$data['cardgatefee_status'] = $this->config->get('cardgatefee_status');
				}
		if (isset($this->request->post['cardgatefee_sort_order'])) {
					$data['cardgatefee_sort_order'] = $this->request->post['cardgatefee_sort_order'];
				} else {
					$data['cardgatefee_sort_order'] = $this->config->get('cardgatefee_sort_order');
				}						

		$this->load->model('localisation/tax_class');
		
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$shipping_mods=array();
		$xshipping_installed=false;
		$result=$this->db->query("select * from " . DB_PREFIX . "extension where type='shipping'");
		if($result->rows){
		  foreach($result->rows as $row){
		     $shipping_mods[$row['code']]=$this->getModuleName($row['code'],$row['type']);  
			 if($row['code']=='xshippingpro')$xshipping_installed=true;
		  }
		}
		
		$data['shipping_mods'] = $shipping_mods;
		
		/*For X-Shipping Pro*/
		   if($xshipping_installed){
			   $language_id=$this->config->get('config_language_id');
			   $xshippingpro=$this->config->get('xshippingpro');
			   if($xshippingpro) {
			     $xshippingpro=unserialize(base64_decode($xshippingpro)); 
			   }
			
			   if(!isset($xshippingpro['name']))$xshippingpro['name']=array();
			   if(!is_array($xshippingpro['name']))$xshippingpro['name']=array();
			   
			   $xshippingpro_methods=array();
			   foreach($xshippingpro['name'] as $no_of_tab=>$names){
				  
				   if(isset($names[$language_id]) && $names[$language_id]){
					  $code = 'xshippingpro'.'.xshippingpro'.$no_of_tab;
					  $xshippingpro_methods[$code]=$names[$language_id];
					}
			   }
	         $data['xshippingpro_methods'] = $xshippingpro_methods;
		   }
		/*End of X-shipping Pro*/
		
		
		$payment_mods=array();
		$cardgate_installed=false;
		$result=$this->db->query("select * from " . DB_PREFIX . "extension where type='payment' && code LIKE 'cardgate%' && code <>'cardgate'");
		if($result->rows){
		  foreach($result->rows as $row){
		     $payment_mods[$row['code']]=$this->getModuleName($row['code'],$row['type']);
                     
		     if($row['code']=='cardgate') $cardgate_installed=true; 
		  }
		}
		
		$data['payment_mods'] = $payment_mods;
		
		/*For CardGate Payment*/
	    if($cardgate_installed){
		   $language_id=$this->config->get('config_language_id');
		   $cardgatepayment=$this->config->get('cardgatepayment');
		   if($cardgatepayment){
			  $cardgatepayment=unserialize(base64_decode($cardgatepayment));
		   }
		
		   if(!isset($cardgatepayment['name']))$cardgatepayment['name']=array();
		   if(!is_array($cardgatepayment['name']))$cardgatepayment['name']=array();
		   
		   $cardgatepayment_methods=array();
		   foreach($cardgatepayment['name'] as $no_of_tab=>$names){
			  
			   if(isset($names[$language_id]) && $names[$language_id]){
				  $code = 'cardgatepayment'.'.cardgatepayment'.$no_of_tab;
				  $cardgatepayment_methods[$code]=$names[$language_id];
				}
		    }
		     $data['cardgatepayments'] = $cardatepayment_methods;
		   }
		  
		 /*End of CardGate Payment*/
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		 $this->response->setOutput($this->load->view('extension/total/cardgatefee', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/total/cardgatefee')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	function getModuleName($code,$type)
	{
	   if(!$code) return '';
	   
	   $this->language->load('extension/'.$type.'/'.$code);
	   return $this->language->get('heading_title');
	}
}
?>