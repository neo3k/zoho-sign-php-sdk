<?php

	/*
		:: Zoho Sign API examples using PHP SDK ::
		
		Use Case : Get particular document details
	*/
	require_once __DIR__ . '/vendor/autoload.php';

	use Vera\ZohoSign\OAuth;
	use Vera\ZohoSign\ZohoSign;
	use Vera\ZohoSign\SignException;
	use Vera\ZohoSign\api\Fields;
	use Vera\ZohoSign\api\Actions;
	use Vera\ZohoSign\api\RequestObject;
	use Vera\ZohoSign\api\fields\ImageField;

	try{

		/*********
			STEP 1 : Set user credentials
		**********/

		$user = new OAuth( array(
			OAuth::CLIENT_ID 	=> "",
			OAuth::CLIENT_SECRET=> "",
			OAuth::DC 			=> "COM",
			OAuth::REFRESH_TOKEN=> "",
			// OAuth::ACCESS_TOKEN => "" // optional. If not set, will auto refresh for access token
		) );

		ZohoSign::setCurrentUser( $user );

		$user->generateAccessTokenUsingRefreshToken();  // manully generate access token. Else, will auto refresh.

		$access_token = $user->getAccessToken(); // get and store access token so to avoid unnecessary regeneration.

		/*********
		STEP 2 : Get particular document details
		**********/

		$req_obj = ZohoSign::getRequest( 1234567890 ); // enter valid "request_id"

		$request_id 	= $req_obj->getRequestName();
		$request_status = $req_obj->getRequestStatus();
		// and other required info from the request

		echo $request_id." : ".$request_status;
		
	}catch( SignException $signEx ){
		// log it
		echo "SIGN EXCEPTION : ".$signEx;
	}catch( Exception $ex ){
		// handle it
	}

?>