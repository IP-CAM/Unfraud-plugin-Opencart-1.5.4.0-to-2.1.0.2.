<?php
/**
 * Class ModelModuleUnfraud
 *
 * @category    Unfraud
 * @package     Unfraud_Unfraud
 */
class ModelModuleUnfraud extends Model {

	const SAFE_API_RESPONSE = "safe";
	const FRAUD_API_RESPONSE = "fraud";
	const SUCCESS_API_RESPONSE = 1;

	const BEA_URL = "//www.unfraud.com/bea/bea.js";

	protected $_analyticsUrl = 'https://www.unfraud.com/unfraud_analytics/analytics.php?getSession=true';
	protected $_eventsUrl = 'http://api.unfraud.com/events';

	public function setSessionId(){
		$this->config->set("unfraud_session_id",session_id());
	}

	public function getSessionId(){
		if(!$this->config->get("unfraud_session_id")){
			$this->setSessionId();
		}
		return $this->config->get("unfraud_session_id");
	}

	/**
	 * @param array $fields
	 * @return json|null
	 */
	public function sendRequest(array $fields)
	{
		$url = $this->_eventsUrl;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);

		$server_output = curl_exec ($ch);
		curl_close ($ch);

		if ($server_output === FALSE) {
			$this->logError("Response from ".$this->_eventsUrl." :");
			$this->logError(printf("cUrl error (#%d): %s<br>\n", curl_errno($ch),
		           htmlspecialchars(curl_error($ch))));
		}
		else{
			$this->log("Response from ".$this->_eventsUrl." :");
			$this->log($server_output);
		}

		$resp = json_decode($server_output);
		return $resp;
	}


	function getCustomerFirstnames() {
		$query = "SELECT firstname FROM " . DB_PREFIX . "customer";
		$result = $this->db->query($query);
		return $result->rows;
	}
	
	function getCustomer($id)
	{
		$query = "SELECT  " . DB_PREFIX . "customer.*,  " . DB_PREFIX . "zone.name as `region`, " . DB_PREFIX . "country.iso_code_3 as `country`,  " . DB_PREFIX . "address.* FROM " . DB_PREFIX . "customer JOIN " . DB_PREFIX . "address ON " . DB_PREFIX . "customer.address_id = " . DB_PREFIX . "address.address_id JOIN " . DB_PREFIX . "zone ON  " . DB_PREFIX . "zone.zone_id =  " . DB_PREFIX . "address.zone_id JOIN  " . DB_PREFIX . "country ON  " . DB_PREFIX . "country.country_id = " . DB_PREFIX . "zone.country_id  WHERE " . DB_PREFIX . "customer.customer_id = '".$id."''";
		
		$result = $this->db->query($query);
		return $result->row;
	}
	
	function getAddress($id)
	{
		$query = "SELECT " . DB_PREFIX . "address.*, " . DB_PREFIX . "zone.name as region, " . DB_PREFIX . "country.iso_code_3 as country FROM " . DB_PREFIX . "address JOIN " . DB_PREFIX . "zone ON " . DB_PREFIX . "zone.zone_id = " . DB_PREFIX . "address.zone_id JOIN " . DB_PREFIX . "country ON " . DB_PREFIX . "country.country_id = " . DB_PREFIX . "address.country_id WHERE address_id = '".$id."'";
		$result = $this->db->query($query);
		return $result->row;
	}
	
	function getOrder($id)
	{
		$query = "SELECT * FROM " . DB_PREFIX . "order WHERE order_id = '".$id."'";
		$result = $this->db->query($query);
		return $result->row;		
	}

	function getProducts($order_id)
	{
		$query = "SELECT " . DB_PREFIX . "product.product_id as item_id, " . DB_PREFIX . "order_product.name as product_title, " . DB_PREFIX . "order_product.price as price, " . DB_PREFIX . "order_product.quantity as quantity, 
" . DB_PREFIX . "manufacturer.name as brand, " . DB_PREFIX . "category_description.name as `category`
FROM " . DB_PREFIX . "order_product 
JOIN " . DB_PREFIX . "product ON " . DB_PREFIX . "product.product_id = " . DB_PREFIX . "order_product.product_id 
JOIN " . DB_PREFIX . "manufacturer ON " . DB_PREFIX . "product.manufacturer_id = " . DB_PREFIX . "manufacturer.manufacturer_id
JOIN " . DB_PREFIX . "product_to_category ON " . DB_PREFIX . "product.product_id = " . DB_PREFIX . "product_to_category.product_id 
JOIN " . DB_PREFIX . "category_description ON " . DB_PREFIX . "product_to_category.category_id =  " . DB_PREFIX . "category_description.category_id
WHERE order_id = '$order_id' GROUP BY price";
		
		$result = $this->db->query($query);
		return $result->rows;		
	}

	/**
	 * @param $data
	 */
	public function log($data) {
		if ($this->config->get('unfraud_debug')) {
			$log = new Log('unfraud.log');
			$backtrace = debug_backtrace();
			$log->write($backtrace[1]['class'] . '::' . $backtrace[1]['function'] . ' Data:  ' . print_r($data, 1));
		}
	}

	/**
	 * @param $data
	 */
	public function logError($data) {
		if ($this->config->get('unfraud_debug')) {
			$log = new Log('unfraud_error.log');
			$backtrace = debug_backtrace();
			$log->write($backtrace[1]['class'] . '::' . $backtrace[1]['function'] . ' Data:  ' . print_r($data, 1));
		}
	}


}

?>