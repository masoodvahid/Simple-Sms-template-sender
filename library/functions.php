<?php 
require('config.php');

function sending_message ($ss, $m){
	$result['status'] = 'failed';
	if ($ss['sending_method'] == 'WSDL'){
		ini_set("soap.wsdl_cache_enabled", "0");		
		libxml_disable_entity_loader(false);
		try {
			$client = new SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
			$op  = "send";
			//If you want to send in the future  ==> $time = '2016-07-30' //$time = '2016-07-30 12:50:50'			
			$time = '';
			$result['value'] = $client->SendSMS($ss['panel_line_number'],$m['phone'],$m['content'],$ss['panel_username'],$ss['panel_password'],$time,$op);
			if ($result['value'] > 10000){
				$result['status'] = 'success';
				mysql_query("INSERT INTO `messages` (`phone`, `content`, `receipte`, `created_at` ) values ( '$m[phone]', '$m[content]', '$result[value]' , now()) ") or die (mysql_error());				
			}			
		} catch (SoapFault $ex) {
			$result['value'] = $ex->faultstring;
			//mysql_query("INSERT INTO records (code,phone, content) values ( $m['code'], $m['phone'], $m['content'] ) ") or die (mysql_error());
		}		
		return json_encode($result);
	}else if ($ss['sending_method'] == 'SERVICE'){
		$url = "37.130.202.188/services.jspd";		
		$rcpt_nm = $m['phone'];
		$param = array
					(
						'uname'=> $ss['panel_username'],
						'pass'=> $ss['panel_password'],
						'from'=> $ss['panel_line_number'],
						'message'=> $m['content'],
						'to'=> $m['phone'],
						'op'=>'send'
					);					
		$handler = curl_init($url);             
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$response2 = curl_exec($handler);		
		$response2 = json_decode($response2);
		$res_code = $response2[0];
		$res_data = $response2[1];				
		return $res_data;
	}else if ($ss['sending_method'] == 'URL'){
		$url = "https://sms.farazsms.com/class/sms/webservice/send_url.php?from=".$ss['panel_line_number']."&to=".$m['phone']."&msg=".$m['content']."&uname=".$ss['panel_username']."&pass=".$ss['panel_password']."";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/6.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.7) Gecko/20050414 Firefox/1.0.3");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
		$result = curl_exec ($ch); 
		curl_close ($ch);		
	}else{
		return false;
	}
}

function panel_credites($ss){
	ini_set("soap.wsdl_cache_enabled", "0");
	libxml_disable_entity_loader(false);
	$client = new SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
	
	$user = $ss['panel_username'];
	$pass = $ss['panel_password'];
	$result['status'] = 'failed';
	$result['value'] =  $client->GetCredit($user,$pass);
	if ($result['value'] > 0){
		$result['status'] = 'success';
	}	
	return json_encode($result);
}

?>