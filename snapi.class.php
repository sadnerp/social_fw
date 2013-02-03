<?php

class snapi {
	protected $_api_href;

	private $_access_token;
	private $_proxy = false;
	
	public function setProxy( $ip, $port ) {
		$this->_proxy = $ip . ":" . $port;
	}
	public function getProxy() {
		return $this->_proxy;
	}
	public function setAccessToken( $access_token ) {
		$this->_access_token = $access_token;
	}
	private function getAccessToken() {
		return $this->_access_token;
	}
	protected function apiRequest( $request ) {
		$method = $request['method'];
		unset($request['method']);
		
		$method_params = "";
		foreach( $request as $k=>$v ) {
			$method_params .= $k . "=" . urlencode( $v ) . "&";
		}
		
		$result = $this->curlRequest( $this->_api_href . $method . '?' . $method_params . 'access_token=' . $this->getAccessToken() );
		
		return json_decode( $result, true );
	}
	private function curlRequest( $url ) {
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );	// не выводить результат в браузер
		curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );			// максимальное время выполнение curl-запроса
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );	// следовать по всем редиректам
		
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );

		$proxy = $this->getProxy();
		if( $proxy ) {
					curl_setopt( $ch, CURLOPT_HTTPPROXYTUNNEL, 1 );
					curl_setopt( $ch, CURLOPT_PROXY, $proxy ); 				
		}
		
		$response = curl_exec( $ch );
		curl_close( $ch );

		return $response;
	}
}

?>