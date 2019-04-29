<?php
/****************************************************
constants.php

This is the configuration file for the samples.This file
defines the parameters needed to make an API call.

PayPal includes the following API Signature for making API
calls to the PayPal sandbox:

API Username 	sdk-three_api1.sdk.com
API Password 	QFZCWN5HZM8VBG7Q
API Signature 	A-IzJhZZjhg29XQ2qnhapuwxIDzyAZQ92FRP5dqBzVesOkzbdUONzmOU

Called by CallerService.php.
****************************************************/

/**
# API user: The user that is identified as making the call. you can
# also use your own API username that you created on PayPal�s sandbox
# or the PayPal live site
*/


 $is_test =  $this->config->get('srs_pppro_threed_test') ;

 
	if( $is_test )
	{

		$srs_pppro_threed_username =  $this->config->get('srs_pppro_threed_username') ;
		$srs_pppro_threed_password =  $this->config->get('srs_pppro_threed_password') ;
		$srs_pppro_threed_signature =  $this->config->get('srs_pppro_threed_signature') ;
		$srs_pppro_end_point =  'https://api-3t.sandbox.paypal.com/nvp';
		$srs_pppro_pp_url =  'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';

		if(strlen($srs_pppro_threed_username) < 5 ){

			$srs_pppro_threed_username =  'devens_1212648101_biz_api1.yahoo.com' ;
			$srs_pppro_threed_password =  '1212648105';
			$srs_pppro_threed_signature =  'AzCGiEDcAxYe4Za62nctouWWB65EAjbZJbCNxrhqKpiHcihKsHrXZvpb';

		}

	}else{

                $srs_pppro_threed_username =  $this->config->get('srs_pppro_threed_username') ;
                $srs_pppro_threed_password =  $this->config->get('srs_pppro_threed_password') ;
                $srs_pppro_threed_signature =  $this->config->get('srs_pppro_threed_signature') ;
                $srs_pppro_end_point =  'https://api-3t.paypal.com/nvp';
                $srs_pppro_pp_url =  'https://www.paypal.com/webscr&cmd=_express-checkout&token=';
	}


define('API_USERNAME', 'devens_1212648101_biz_api1.yahoo.com');
define('API_PASSWORD', '1212648105');
define('API_SIGNATURE', 'AzCGiEDcAxYe4Za62nctouWWB65EAjbZJbCNxrhqKpiHcihKsHrXZvpb');

define('API_ENDPOINT', $srs_pppro_end_point);
define('PAYPAL_URL', $srs_pppro_pp_url);


/**
USE_PROXY: Set this variable to TRUE to route all the API requests through proxy.
like define('USE_PROXY',TRUE);
*/
define('USE_PROXY',FALSE);
/**
PROXY_HOST: Set the host name or the IP address of proxy server.
PROXY_PORT: Set proxy port.

PROXY_HOST and PROXY_PORT will be read only if USE_PROXY is set to TRUE
*/
define('PROXY_HOST', '127.0.0.1');
define('PROXY_PORT', '808');

/* Define the PayPal URL. This is the URL that the buyer is
   first sent to to authorize payment with their paypal account
   change the URL depending if you are testing on the sandbox
   or going to the live PayPal site
   For the sandbox, the URL is
   https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
   For the live site, the URL is
   https://www.paypal.com/webscr&cmd=_express-checkout&token=
   */

/**
# Version: this is the API version in the request.
# It is a mandatory parameter for each API request.
# The only supported value at this time is 2.3
*/

//define('VERSION', '53.0');
define('API_VERSION', '62.0');// Edited by Deven 25-3-10
?>