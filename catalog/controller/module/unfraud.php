<?php
/**
 * Class ControllerModuleUnfraud
 *
 * @category    Unfraud
 * @package     Unfraud_Unfraud
 */
class ControllerModuleUnfraud extends Controller {

   public function index()
   {
       $this->load->model('module/unfraud');
       $this->load->model('setting/setting');
       $this->load->language('module/unfraud');
       $this->config->set('unfraud_session_id', $this->model_module_unfraud->setSessionId());
       $data['api_key'] = $this->config->get("unfraud_apikey");
       $modelClass = get_class($this->model_module_unfraud);

       if ($data['api_key']){
           if (isset($_GET["route"]) && $_GET["route"] == "checkout/success") {
               //$threshold = $this->config->get('unfraud_threshold');

               $last_order_id = @$this->session->data["order_id"];

               if($last_order_id) {
                   $order = $this->model_module_unfraud->getOrder($last_order_id);
                   $items = $this->model_module_unfraud->getProducts($last_order_id);

                   $billing_address = array(
                       "name" => $order["payment_firstname"] . " " . $order["payment_lastname"],
                       "address_1" => $order["payment_address_1"],
                       "address_2" => $order["payment_address_2"],
                       "city" => $order["payment_city"],
                       "region" => $order["payment_zone"],
                       "country" => $order["payment_country"],
                       "zipcode" => $order["payment_postcode"],
                       "phone" => $order["telephone"]
                   );

                   $shipping_address = array(
                       "name" => $order["shipping_firstname"] . " " . $order["shipping_lastname"],
                       "address_1" => $order["shipping_address_1"],
                       "address_2" => $order["shipping_address_2"],
                       "city" => $order["shipping_city"],
                       "region" => $order["shipping_zone"],
                       "country" => $order["shipping_country"],
                       "zipcode" => $order["shipping_postcode"],
                       "phone" => $order["telephone"]
                   );

                   $unfraud_data = array(
                       "type" => "new_order",
                       "api_id" => $this->config->get('unfraud_apikey'),
                       "user_id" => $order["email"],
                       "order_id" => $last_order_id,
                       "amount" => $order["total"],
                       "currency_code" => $this->session->data["currency"],
                       "session_id" => $this->model_module_unfraud->getSessionId(),
                       "ip_address" => $_SERVER['REMOTE_ADDR'],
                       "timestamp" => time(),
                       "items" => $items,
                       "billing_address" => $billing_address,
                       "shipping_address" => $shipping_address,
                       "unfraud_plugin" => "unfraud-opencart_1.0.0"
                   );


                   try{
                       $result = $this->model_module_unfraud->sendRequest($unfraud_data);

                       if ($result->success == $modelClass::SUCCESS_API_RESPONSE) {
                           $fraud = false;
                           if ($result->unfraud_label != $modelClass::SAFE_API_RESPONSE) {
                               $this->model_module_unfraud->log("Unfraud Response flagged as '{$result->unfraud_label}'");
                               $fraud = true;
                           }
                           // we cannot add exception as well as in Magento module managed because Opencart hasn't transactions
                           // on Checkout actions and we cannot rollback to prevoius situation. Thus we left commented the follow code lines.
                           //else if ($result->unfraud_label == $modelClass::SAFE_API_RESPONSE && $result->unfraud_label >= (int)$threshold) {
                           //    $this->model_module_unfraud->log("Unfraud Response score ({$result->unfraud_label}) higher than default setted in configuration settings ($threshold)");
                           //    $fraud = true;
                           //}
                           /*if ($fraud == true) {
                               $this->session->data['error'] = $this->language->get("checkout_error_text");
                               $this->response->redirect($this->url->link('checkout/checkout', '', 'SSL'));
                           }*/
                       } else {
                           $this->model_module_unfraud->logError("Unfraud API Error");
                       }
                   }
                   catch(Exception $e){
                       $this->model_module_unfraud->logError($e->getMessage());
                   }
               }
           } else {
               $data['session_id'] = $this->model_module_unfraud->getSessionId();
               $data['bea_url'] = $modelClass::BEA_URL;
               $this->template = 'default/template/module/unfraud.tpl';
               if(version_compare(VERSION, '2.0.0.0', '<')) {
                   $this->data = $data;
                   $this->render();
               }
               else{
                   return $this->load->view($this->template, $data);
               }

           }
        }

	}

}
?>