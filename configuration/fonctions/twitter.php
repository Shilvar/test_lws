<?php
	
	/** 
	 * Fonction qui va envoyer un tweet 
	 */
	function tweet($message) {
		
		$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
		$twitter->post('statuses/update', array(
			'status' => utf8_encode($message)));

		if ($twitter->response['code'] == 200){
			return $twitter->response['id'];
		}else{			
			return 'Le tweet n\'a pas été envoyé !';
		}
}
?>