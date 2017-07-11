<?php

$includes = array(
				"OAuthException", 
				"OAuthConsumer", 
				"OAuthToken", 
				"OAuthSignatureMethod", 
				"OAuthSignatureMethod_HMAC_SHA1", 
				"OAuthSignatureMethod_PLAINTEXT", 
				"OAuthSignatureMethod_RSA_SHA1", 
				"OAuthRequest", 
				"OAuthServer", 
				"OAuthDataStore", 
				"OAuthUtil");

foreach ($includes as $file) {
	require_once ("OAuth/" . $file . ".php");
}
