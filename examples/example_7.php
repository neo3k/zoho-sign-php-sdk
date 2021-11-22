<?php
	/*
		:: Zoho Sign API examples using PHP SDK ::
		
		Use Case : use Zoho Sign template, set prefill-fields recipient info and quickly send out for signature
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
		STEP 2 : Get template object by ID
		**********/

		$template = ZohoSign::getTemplate( 2000002552015 );
		
		/*********
		STEP 3 : Set values to the same object & send for signature
		**********/

		$template->setRequestName("Partnership Agreement [test]");
		$template->setNotes("Call us back if you need clarificaions regarding agreement");
		
		$template->setPrefillTextField		( "Full name",	"Hagrid R" );
		$template->setPrefillBooleanField	( "Agree ?", 	true );
		$template->setPrefillDateField		( "Date - 1",	"08 July 2020" );
	
		$template->getActionByRole("Partner")->setRecipientName("Hagrid R");
		$template->getActionByRole("Partner")->setRecipientEmail("hagrid@hogwcorp.com");
	
		$resp_obj = ZohoSign::sendTemplate( $template, false );

		echo ":: ".$resp_obj->getRequestId()." : ".$resp_obj->getRequestStatus();


	}catch( SignException $signEx ){
		// log it
		echo "SIGN EXCEPTION : ".$signEx;
	}catch( Exception $ex ){
		// handle it
	}

?>s