<?php

class snapi {

	public $proxy;
	public $api_href;
	public $access_token;


	protected function apiRequest($request) {

		$method = $request['method'];
		unset($request['method']);

		$method_params = "";
		foreach( $request as $k=>$v ) {
			$method_params .= $k . "=" . urlencode( $v ) . "&";
		}

		$result = $this->curlRequest($this->api_href . $method . '?' . $method_params . 'access_token=' . $this->access_token );

		return json_decode($result, true);
	}

	private function curlRequest($url) {

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	// не выводить результат в браузер
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);			// максимальное время выполнение curl-запроса
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);	// следовать по всем редиректам
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		if ($this->proxy) {
			curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
			curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		}

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}
}