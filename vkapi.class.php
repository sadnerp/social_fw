<?php

require_once 'snapi.class.php';

class vkapi extends snapi {

	protected $_api_href = "https://api.vk.com/method/";

	/*
	https://oauth.vk.com/authorize?client_id=3382849&scope=offline&display=page&response_type=token
	*/
	public function usersGet(){
		return $this->apiRequest( array(
			'method' => 'users.get',
		));
	}
}
?>