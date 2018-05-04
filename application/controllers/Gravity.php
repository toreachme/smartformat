<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gravity extends CI_Controller {

	private $apiKey = '2952d7f60c';
	private $privateKey = '91e4bdf05cd2faf';
	private $baseUrl = 'https://feinternational.com/forms/gravityformsapi/';
	public $httpMethod = 'GET';
	public $expiration;


	public function __construct(){
		$this->expiration = strtotime('+30 mins');
	}



	public function index(){
		echo "Opps! Gravity Index Controller";
	}



	public function mergedData($formId){
		$forms = $this->forms($formId);
		$formEntries = $this->formEntries($formId);

		$formsFieldsArray = $forms['response']['fields'];
		$formEntriesArray = $formEntries['response']['entries'];


		foreach ($formsFieldsArray as $formsfields) {
			//Check for only Section Headers
			if ($formsfields['type'] == 'section') {
				echo "<h3>".$formsfields['label']."</h3><br/>";
			}
			// Add form field ID to a variable for ease of use
			$fieldId = $formsfields['id'];

			//Loop through Form Entries
			foreach ($formEntriesArray as $entries) {
				foreach ($entries as $key => $value) {
					//Make sure only Questions show up not (Sections and HTML types) 
					if ($key == $fieldId && ($formsfields['type'] != 'section' && $formsfields['type'] != 'html')) {
						//Output Questions
						echo "<b>".$formsfields['label']."</b><br/>";
						//Output Answers
						echo $value."<br/><br/>";
					}
				}
			}
		}


	}	



	public function formEntries($formId){
		//FormEntries Route
		$route = "forms/".$formId."/entries";

		//Create SIgnature
		$signature = $this->signString($route);

		$url = $this->baseUrl . $route . '?api_key=' . $this->apiKey . '&signature=' . $signature . '&expires=' . $this->expiration;

		$contents = $this->getUrlContents($url);
		$decodedContent = json_decode($contents, true);
		return $decodedContent;

	}



	public function forms($formId){
		//Forms Route
		$route = "forms/".$formId;

		//Create SIgnature
		$signature = $this->signString($route);

		$url = $this->baseUrl . $route . '?api_key=' . $this->apiKey . '&signature=' . $signature . '&expires=' . $this->expiration;

		$contents = $this->getUrlContents($url);
		$decodedContent = json_decode($contents, true);
		return $decodedContent;
	}




	/*
	 * Helper methods
	 *
	 */

	private function signString($route){
		//$expiration = strtotime('+30 mins');
		$string_to_sign = sprintf("%s:%s:%s:%s", $this->apiKey, $this->httpMethod, $route, $this->expiration);
		$signed = $this->calculate_signature($string_to_sign, $this->privateKey);
		return $signed;
	}

	private function calculate_signature($string, $private_key) {
		$hash = hash_hmac("sha1", $string, $private_key, true);
		$sig = rawurlencode(base64_encode($hash));
		return $sig;
	}

	private function http_get_contents ($url) {
		if (!function_exists('curl_init')){ 
			die('CURL is not installed!');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	private function getUrlContents($url){
		$fileOutput = file_get_contents($url);
		return $fileOutput;
	}

}