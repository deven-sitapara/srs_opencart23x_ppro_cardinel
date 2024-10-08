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

$livetmode = 0;

 	if($livetmode == 0)
	{
		define('API_USERNAME', 'devens_1257858297_biz_api1.yahoo.com');
		define('API_PASSWORD', '1257858410');
		define('API_SIGNATURE', 'ALWlC4wQqaBSFvlPsbqQfxVfmfTDAFkvxRaxyqyBOwn2F0FzYJwTTsYv');
		
		/*define('API_USERNAME', 'devens_1212648101_biz_api1.yahoo.com');
		define('API_PASSWORD', '1212648105');
		define('API_SIGNATURE', 'AzCGiEDcAxYe4Za62nctouWWB65EAjbZJbCNxrhqKpiHcihKsHrXZvpb'); */
		
		define('API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp');
		define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');
		
		
}else
{

		define('API_USERNAME', 'michael.braga_api1.beamdigital.com');
		define('API_PASSWORD', 'J8AS8Z2JBGGXAZW8');
		define('API_SIGNATURE', 'AhsoEamz.3EGaz6D1wsvNFp1R7FKAiBHdIw1xq3vtV9Zsl8ZbBsPktUx');
		
		/*define('API_USERNAME', 'devens_1212648101_biz_api1.yahoo.com');
		define('API_PASSWORD', '1212648105');
		define('API_SIGNATURE', 'AzCGiEDcAxYe4Za62nctouWWB65EAjbZJbCNxrhqKpiHcihKsHrXZvpb'); */
		
		define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
		define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');


}




				
				/*define('API_USERNAME', 'sdk-three_api1.sdk.com');
				
				 
				
				define('API_PASSWORD', 'QFZCWN5HZM8VBG7Q');
				 
				
				define('API_SIGNATURE', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI');
				 
				define('API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp');
				
				define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');*/

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

define('VERSION', '53.0');

?>