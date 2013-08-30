<?php

class snapi {

	/**
	 * proxy option
	 * if u need it, put address:port
	 */
	public $proxy;

	/**
	 * api address
	 * required. example: https://api.vk.com/method/
	 * can be overload in subclass
	 */
	public $api_href;

	/**
	 * user access_token.
	 * most api methods required this param
	 */
	public $access_token;

	protected function apiRequest($method, $request) {

		/**
		 * prepare array for implode
		 */
		foreach ($request as $k => &$v)
			$v = $k . '=' . urlencode($v);

		$method_params = implode('&', $request);

		/**
		 * fix '?&' when method have not param  example '/blabla/blabla?&'
		 */
		if ($method_params)
			$method_params .= '&';

		/**
		 * final URL
		 */
		$result = $this->curlRequest($this->api_href . $method . '?' . $method_params . 'access_token=' . $this->access_token);


		return json_decode($result, true);
	}

	private function curlRequest($url) {

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
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