<?php

class SmartyStreet extends \Eloquent {
	protected $table="smartystreet";
	protected $guarded=array('id');
	protected $softdelete=true;
	public function addresses(){
		return $this->belongsTo("addresses");
	}
	public function street_secret($array){
		// Put your own auth ID/token values here (obtained from your account)
		$post=array_filter($array);
		//print_r($post);
		
		//Encode JSON for Address verification. 
		$json_input="[";
		foreach ( $post as $value ) {
			$json_input .= "{street: '$value'},";
		}
		$json_input = rtrim($json_input, ",");
		$json_input .= "]";
		
		// Your authentication ID/token (obtained in your SmartyStreets account)
		$authId = urlencode(Config::get('development/smarty.secret_ID'));
		$authToken = Config::get('development/smarty.secret_token');
		
		// Initialize cURL
		$ch = curl_init();
		
		// Configure the cURL command
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//Change this when not localhost
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-standardize-only: true')); // Enable this line if you want to only standardize addresses that are "good enough"
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		// Use the next line if you prefer to use your Javascript API token rather than your REST API token.
		//curl_setopt($ch, CURLOPT_REFERER, "http://YOUR-AUTHORIZED-DOMAIN-HERE");
		curl_setopt($ch, CURLOPT_URL, "https://api.smartystreets.com/street-address/?auth-id={$authId}&auth-token={$authToken}");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_input);
		
		// Output comes back as a JSON string.
		$json_output = curl_exec($ch);
		// Show results
		$result=(json_decode($json_output));
		return $result;
		}
	public function flatten($result){
		$data=array();
			foreach($result as $each){
			$iterator = new RecursiveIteratorIterator(
		    new RecursiveArrayIterator($each),
		    RecursiveIteratorIterator::SELF_FIRST);
			$keys = array();
			iterator_apply($iterator, function(Iterator $iterator) use (&$keys) {
			$keys[] = $iterator->key();
			return TRUE;
			}, array($iterator));
			
			//Remove the Metadata Key
			if (($key = array_search('metadata', $keys)) !== false) {
	    		unset($keys[$key]);
			}
			//Remove the components key
			if (($key = array_search('components', $keys)) !== false) {
	    		unset($keys[$key]);
			}
			//Remove the analysis key
			if (($key = array_search('analysis', $keys)) !== false) {
	    		unset($keys[$key]);
			}
			//Recursive for flattening arrays
			$j=0;	
			$values=array(); //Reset values array	
			foreach ($each as $innerArray) {
		    //  Check type
		    if (is_object($innerArray)){
		        //  Scan through inner loop
		        foreach ($innerArray as $value) {
		            $values[$j]=$value;
					$j++;
		        }
		    }else{
		        // one, two, three
		       $values[$j]=$innerArray;
			   $j++;
		    	}
			}	
			$combined=array_combine($keys, $values);
			array_push($data,$combined);
				
		}
		$flattened=$data;
		return $flattened;
	}
	public function generateIbm(){
		$tracker_id='';
    	for($i = 0; $i < 6; $i++) {
	        $tracker_id .= mt_rand(0, 9);
	    }
		$mailer_id=Config::get('development/smarty.mailer_id');
		$barcode_id=Config::get('development/smarty.barcode_id');
		$service_id=Config::get('development/smarty.service_id');
		$zip=$this->zipcode;
		$plus4=$this->plus4_code;
		$dpoint=$this->delivery_point;
		$code=$barcode_id.$service_id.$tracker_id.$service_id.$zip.$plus4.$dpoint;
		return DNS1D::getBarcodeHTML($code, "IMB");
	}
}