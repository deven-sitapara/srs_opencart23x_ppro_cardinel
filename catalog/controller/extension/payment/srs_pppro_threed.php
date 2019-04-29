<?php
class ControllerExtensionPaymentSrsPpproThreed extends Controller {
 
 	protected $data;

    public function index() {

        $this->language->load('extension/payment/srs_pppro_threed');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

 		$this->data['text_credit_card'] = $this->language->get('text_credit_card');
		$this->data['text_start_date'] = $this->language->get('text_start_date');
		$this->data['text_issue'] = $this->language->get('text_issue');
		$this->data['text_wait'] = $this->language->get('text_wait');

		$this->data['entry_cc_type'] = $this->language->get('entry_cc_type');
		$this->data['entry_cc_number'] = $this->language->get('entry_cc_number');
		$this->data['entry_cc_start_date'] = $this->language->get('entry_cc_start_date');
		$this->data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
		$this->data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');
		$this->data['entry_cc_issue'] = $this->language->get('entry_cc_issue');

		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['help_start_date'] = $this->language->get('help_start_date');
		$this->data['help_issue'] = $this->language->get('help_issue');
		$this->data['text_loading'] = $this->language->get('text_loading');

		$this->data['cards'] = array();

		$this->data['cards'][] = array(
			'text'  => 'Visa',
			'value' => 'VISA'
		);

		$this->data['cards'][] = array(
			'text'  => 'MasterCard',
			'value' => 'MASTERCARD'
		);

		$this->data['cards'][] = array(
			'text'  => 'Discover Card',
			'value' => 'DISCOVER'
		);

		$this->data['cards'][] = array(
			'text'  => 'American Express',
			'value' => 'AMEX'
		);

		$this->data['cards'][] = array(
			'text'  => 'Maestro',
			'value' => 'SWITCH'
		);

		$this->data['cards'][] = array(
			'text'  => 'Solo',
			'value' => 'SOLO'
		);

		$this->data['months'] = array();

		for ($i = 1; $i <= 12; $i++) {
			$this->data['months'][] = array(
				'text'  => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
				'value' => sprintf('%02d', $i)
			);
		}

		$today = getdate();

		$this->data['year_valid'] = array();

		for ($i = $today['year'] - 10; $i < $today['year'] + 1; $i++) {
			$this->data['year_valid'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
			);
		}

		$this->data['year_expire'] = array();

		for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
			$this->data['year_expire'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
			);
		}

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/checkout';
		} else {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}

		$this->log("Payment Index" , $this->data);



		return $this->load->view('extension/payment/srs_pppro_threed', $this->data);




    } // index over

	public function step1() {

        
        $this->language->load('extension/payment/srs_pppro_threed');

		require_once('centinel/CentinelClient.php');
		require_once('centinel/CentinelConfig.php');
		require_once('centinel/CentinelUtility.php');

        clearCentinelSession();

		$payment_type = 'Sale';
		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
 
		if($order_info['currency_code'] == 'USD')
			$currency_ISO = '840';
		elseif($order_info['currency_code'] == 'GBP')
			$currency_ISO = '826';
		elseif($order_info['currency_code'] == 'EUR')
			$currency_ISO = '978';	
		elseif($order_info['currency_code'] == 'AUD')
			$currency_ISO = '036';	

		$_SESSION['currency_code'] =	$order_info['currency_code'];
	
 		$payment_data = array(
			'METHOD'         => 'DoDirectPayment',
			'VERSION'        => '51.0',
			'USER'           => $this->config->get('srs_pppro_threed_username'), //srs_pppro_threed_username
			'PWD'            => $this->config->get('srs_pppro_threed_password'),
			'SIGNATURE'      => $this->config->get('srs_pppro_threed_signature'),
			'CUSTREF'        => $order_info['order_id'],
			'PAYMENTACTION'  => $payment_type,
			'AMT'            => str_replace('.','',   $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE)),
            'AMT1'           => $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE),
			'CREDITCARDTYPE' => $this->request->post['cc_type'],
			'ACCT'           => str_replace(' ', '', $this->request->post['cc_number']),
			'CARDSTART'      => $this->request->post['cc_start_date_month'] . $this->request->post['cc_start_date_year'],
			'EXPDATE'        => $this->request->post['cc_expire_date_month'] . $this->request->post['cc_expire_date_year'],
			'CVV2'           => $this->request->post['cc_cvv2'],
			'CARDISSUE'      => $this->request->post['cc_issue'],
			'FIRSTNAME'      => $order_info['payment_firstname'],
			'LASTNAME'       => $order_info['payment_lastname'],
			'EMAIL'          => $order_info['email'],
			'PHONENUM'       => $order_info['telephone'],
			'IPADDRESS'      => $this->request->server['REMOTE_ADDR'],
			'STREET'         => $order_info['payment_address_1'],
			'CITY'           => $order_info['payment_city'],
			'STATE'          => ($order_info['payment_iso_code_2'] != 'US') ? $order_info['payment_zone'] : $order_info['payment_zone_code'],
			'ZIP'            => $order_info['payment_postcode'],
			'COUNTRYCODE'    => $order_info['payment_iso_code_2'],
			'CURRENCYCODE'   => $order_info['currency_code']
		);

		$this->log("Step1 - Order Info order_info " , $order_info);

		$this->log("Step1 - Payment Data payment_data " , $payment_data);


		if(   empty($order_info['shipping_address_1'])  || empty($order_info['shipping_postcode']) ||
			  empty($order_info['shipping_city']) || empty($order_info['shipping_zone'])) {
		
			$order_info['shipping_address_1']  = $order_info['payment_address_1']  ;
			$order_info['shipping_address_2']  = $order_info['payment_address_2']  ;
			$order_info['shipping_postcode']  = $order_info['payment_postcode']  ;
			$order_info['shipping_city'] = $order_info['payment_city']  ;
			$order_info['shipping_zone'] = $order_info['payment_zone']  ;
			
		}
                    
		/*******************************************************************************/
	    /*                                                                             */
	    /*Using the local variables and constants, build the Centinel message using the*/
	    /*Centinel Thin Client.                                                        */
	    /*                                                                             */
	    /*******************************************************************************/

	    $centinelClient = new CentinelClient;

		$ordernum = time();

		$centinelClient->add("MsgType", "cmpi_lookup");
		$centinelClient->add("Version", CENTINEL_MSG_VERSION);
		$centinelClient->add("ProcessorId", CENTINEL_PROCESSOR_ID);
		$centinelClient->add("MerchantId", CENTINEL_MERCHANT_ID);
		$centinelClient->add("TransactionPwd", CENTINEL_TRANSACTION_PWD);
		$centinelClient->add("UserAgent", $_SERVER["HTTP_USER_AGENT"]);
		$centinelClient->add("BrowserHeader", $_SERVER["HTTP_ACCEPT"]);
		$centinelClient->add("TransactionType", "C");
		//    $centinelClient->add('IPAddress', $_SERVER['REMOTE_ADDR']);
		$amount = $payment_data['AMT']; // $_POST['amount'].'00';
		$centinelClient->add("Amount", $amount);
		$centinelClient->add("ShippingAmount", '');
		$centinelClient->add("TaxAmount", '');
		$centinelClient->add("CurrencyCode", $currency_ISO);

		$centinelClient->add("OrderNumber", $ordernum);
		$centinelClient->add("OrderDescription", $order_info['store_name'] . ' Purchase ');

		$creditCardNumber = urlencode( $payment_data['ACCT']);

		$expDateMonth =urlencode( $this->request->post['cc_expire_date_month']  );
		$endpadDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		$expDateYear = urlencode( $this->request->post['cc_expire_date_year'] );


		$centinelClient->add("EMail", $order_info['email']);
		$centinelClient->add("BillingFirstName", $order_info['payment_firstname'] );
		$centinelClient->add("BillingMiddleName", '');
		$centinelClient->add("BillingLastName", $order_info['payment_lastname']);
		$centinelClient->add("BillingAddress1", $order_info['shipping_address_1']);
		$centinelClient->add("BillingAddress2", $order_info['shipping_address_2']);
		$centinelClient->add("BillingCity",$order_info['shipping_city']);
		$centinelClient->add("BillingState", $order_info['shipping_zone']);
		$centinelClient->add("BillingPostalCode", $order_info['shipping_postcode']);
		$centinelClient->add("BillingCountryCode", $order_info['payment_iso_code_2'] );
		$centinelClient->add("BillingPhone", $order_info['telephone']);

		// changed on 25-2-2012 as per new paypal rules...
		$_SESSION['cname']      = $order_info['payment_firstname'] ;
		$_SESSION['lastname']   = $order_info['payment_lastname'] ;
		$_SESSION['address']    = $order_info['payment_address_1']  ;
		$_SESSION['address2']   = $order_info['payment_address_2'] ;
		$_SESSION['b_city']     = $order_info['payment_city'] ;
		$_SESSION['state']      = $order_info['payment_zone']  ;
		$_SESSION['postcode']   = $order_info['payment_postcode'] ;
		$_SESSION['country']    = $order_info['payment_iso_code_2'] ;

		$_SESSION['amount']     = $payment_data['AMT1'] ;

		// shipping for paypal new update...
		$_SESSION['shipping'] = array(
			'SHIPTONAME' => $order_info['shipping_firstname']. ' '. $order_info['shipping_lastname'],
			'SHIPTOSTREET' => $order_info['shipping_address_1'],
			'SHIPTOSTREET2' => $order_info['shipping_address_2'], // optional
			'SHIPTOCITY' =>$order_info['shipping_city'],
			'SHIPTOSTATE' => $order_info['shipping_zone'],
			'SHIPTOZIP' => $order_info['shipping_postcode'],
			'SHIPTOCOUNTRY' => $order_info['shipping_iso_code_2']   //(2 letters ISO code)
		);
	
		$centinelClient->add("ShippingFirstName", $order_info['shipping_firstname']);
		$centinelClient->add("ShippingMiddleName", '');
		$centinelClient->add("ShippingLastName", $order_info['shipping_lastname']);
		$centinelClient->add("ShippingAddress1", $order_info['shipping_address_1']);
		$centinelClient->add("ShippingAddress2", $order_info['shipping_address_2']);
		$centinelClient->add("ShippingCity", $order_info['shipping_city']);
		$centinelClient->add("ShippingState", $order_info['shipping_zone']);
		$centinelClient->add("ShippingPostalCode", $order_info['shipping_postcode']);
		$centinelClient->add("ShippingCountryCode", $order_info['shipping_iso_code_2']);


		$centinelClient->add("ShippingPhone", '');

		$centinelClient->add("Item_Name_1", $order_info['order_id']);
		$centinelClient->add("Item_Desc_1", '');
		$centinelClient->add("Item_Price_1", '');
		$centinelClient->add("Item_Quantity_1", '');
		$centinelClient->add("Item_SKU_1", '');
		$centinelClient->add("Item_Name_2", '');
		$centinelClient->add("Item_Desc_2", '');
		$centinelClient->add("Item_Price_2", '');
		$centinelClient->add("Item_Quantity_2", '');
		$centinelClient->add("Item_SKU_2", '');

	    // Payment type specific fields
	    $centinelClient->add('CardNumber', $creditCardNumber);
	    $centinelClient->add('CardExpMonth', $endpadDateMonth );
	    $centinelClient->add('CardExpYear', $expDateYear );

		//$centinelClient->add('Recurring', "Y");
		//$centinelClient->add('RecurringFrequency', "7");
		//$centinelClient->add('RecurringEnd', "20090625");

	    /**********************************************************************************/
	    /*                                                                                */
	    /*Send the XML Msg to the MAPS Server, the Response is the CentinelResponse Object*/
	    /*                                                                                */
	    /**********************************************************************************/

  		$centinelClient->sendHttp(CENTINEL_MAPS_URL, CENTINEL_TIMEOUT_CONNECT, CENTINEL_TIMEOUT_READ);

		$this->log("Step1 centinelClient" , $centinelClient);
		
		/**
			Prepare Session to use in doDirectPayment
		*/
		
	    $_SESSION['Centinel_TermUrl']           = CENTINEL_TERM_URL;
	    $_SESSION['Centinel_TransactionType']   = 'C';
	    $_SESSION['Centinel_OrderNumber']       = $ordernum;
		

		$_SESSION['request'] = $_REQUEST;
		$_SESSION['request']['paymentType'] = 'Sale';
		$_SESSION['request']['product_id'] = $order_info['order_id'] ;
		$_SESSION['request']['item_name']  =   $order_info['store_name'] . ' Purchase ';  //$package['Package']['name'];  // Edited by Deven - 24-3-10

		$_SESSION['request']['issuenumber'] =  $payment_data['CARDISSUE'] ;

 
 		$startDateMonth = ( $this->request->post['cc_start_date_month'] );
		$endpadDateMonth = str_pad($startDateMonth, 2, '0', STR_PAD_LEFT);
		$startDateYear =  ( $this->request->post['cc_start_date_year'] );

	 	$_SESSION['request']['startDateMonth'] = $startDateMonth;
		$_SESSION['request']['startDateYear'] = $startDateYear;


	    // Save response in session
	    $_SESSION['Centinel_Enrolled']      = $centinelClient->getValue('Enrolled');
	    $_SESSION['Centinel_ErrorNo']       = $centinelClient->getValue('ErrorNo');
	    $_SESSION['Centinel_ErrorDesc']     = $centinelClient->getValue('ErrorDesc');
	    $_SESSION['Centinel_ECI']           = $centinelClient->getValue('EciFlag');
	    $_SESSION['Centinel_ACSUrl']        = $centinelClient->getValue('ACSUrl');
	    $_SESSION['Centinel_Payload']       = $centinelClient->getValue('Payload');
	    $_SESSION['Centinel_TransactionId'] = $centinelClient->getValue('TransactionId');

	    // $_SESSION['Centinel_AuthenticationPath'] = $centinelClient->getValue('AuthenticationPath');
		//$_SESSION['request']['issuenumber'] = $_POST['issuenumber'];

	    $enrolled = $errorNo =  $errorDesc = $transactionId =  $eci = "";

	    $errorNo = $centinelClient->getValue("ErrorNo");
	    $errorDesc = $centinelClient->getValue("ErrorDesc");

	    if(strcasecmp("0", $errorNo)== 0 ){

			$enrolled = $centinelClient->getValue("Enrolled");          # possible values of Y, N or U
            $transactionId = $centinelClient->getValue("TransactionId");
			$eci = $centinelClient->getValue("EciFlag");
			
			$_SESSION["Centinel_ACSURL"]= $centinelClient->getValue("ACSUrl");
			$_SESSION["Centinel_PAYLOAD"]= $centinelClient->getValue("Payload");

	    }

	    $_SESSION["Centinel_Enrolled"]= $enrolled;
	    $_SESSION["Centinel_TransactionId"]= $transactionId;
	    $_SESSION["Centinel_ErrorNo"] = $errorNo;
	    $_SESSION["Centinel_ErrorDesc"] = $errorDesc;
	    $_SESSION["Centinel_ECI"] = $eci;
	    $_SESSION["Centinel_PIType"] = $payment_data['CREDITCARDTYPE']; // $_POST['card_type'];

	    $this->log("Payment Step1 Session " , $_SESSION );
       
	    /******************************************************************************/
	    /*                                                                            */
	    /*                            Authentication Logic                            */
	    /*                                                                            */
	    /******************************************************************************/

		if(strcasecmp('0', $_SESSION['Centinel_ErrorNo'])== 0 && strcasecmp('Y', $_SESSION['Centinel_Enrolled']) == 0){

			/*****************************************************/
			/* Cardholder is enrolled, proceed to redirect page. */
			/*****************************************************/
		    // redirectBrowser('../../packages/frame');

			$_SESSION['Centinel_OrderId']       =    $centinelClient->getValue('OrderId');

			$this->response->redirect($this->url->link('extension/payment/srs_pppro_threed/srs_3d_frame', '', true)); // js redirect removed

		} else {

		 	   $_SESSION['Centinel_OrderId']       =   $centinelClient->getValue('OrderNumber');

				/******************************************************************/
				/* If the Payer Authentication enrollment response was not "Y" or */
				/* resulted in an error then do not redirect to ACS. Proceed to   */
				/* authorization.                                                 */
				/******************************************************************/

				$this->response->redirect($this->url->link('extension/payment/srs_pppro_threed/doDirect', '', true)); // js redirect removed
		}
            	  
    }// setp1 over


    public function srs_3d_frame() {
		
		require_once('centinel/CentinelClient.php');
		require_once('centinel/CentinelConfig.php');
		require_once('centinel/CentinelUtility.php');

        $this->language->load('extension/payment/srs_pppro_threed');
        $this->id = 'payment';
		$this->load->model('extension/payment/srs_pppro_threed');
 
		if( !isset($_SESSION["Centinel_OrderId"]) ) {

			clearCentinelSession();
			$this->response->redirect($this->url->link('extension/payment/srs_pppro_threed/authenticate_error', '', true));
 		}

		$this->log("Payment frame Session " , $_SESSION);

		if (!isset($_SESSION["Centinel_TransactionId"])){

			$this->log("Payment frame Session " , array("Order Already Processsed.") );
            echo "Order Already Processsed.";
            exit;
		}

		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/srs_3d_frame', $this->data));


    }// frame over

	
	public function srs_innerframe(){

	 	require_once('centinel/CentinelClient.php');
	    require_once('centinel/CentinelConfig.php');
	    require_once('centinel/CentinelUtility.php');

        $this->language->load('extension/payment/srs_pppro_threed');
        $this->id = 'payment';
		$this->load->model('extension/payment/srs_pppro_threed');

		if (!isset($_SESSION["Centinel_TransactionId"])) {

			$this->log("Payment Inner frame Session " , array("Order Already Processsed.") );
            echo "Order already processed";
            exit;
		}

        $this->data['AcsUrl']=    $_SESSION["Centinel_ACSUrl"];
        $this->data['PaReq']= $_SESSION["Centinel_Payload"];
        $this->data['TermUrl']=    $_SESSION["Centinel_TermUrl"];
        $this->data['MD']=  $_SESSION["Centinel_OrderId"];

        $this->log( "Payment Inner frame Session " , $_SESSION );


 		$this->response->setOutput($this->load->view('extension/payment/srs_innerframe', $this->data));


	}
     
    public function doDirect() {


       	require_once('centinel/CentinelClient.php');
		require_once('centinel/CentinelConfig.php');
		require_once('centinel/CallerService.php');
                
        $this->language->load('extension/payment/srs_pppro_threed');
        $this->id = 'payment';
		$this->load->model('extension/payment/srs_pppro_threed');

		/**
		* Get required parameters from the web form for the request
		*/

		//Owner
		$cardowner = urlencode( $_SESSION['cname']   . ' ' . $_SESSION['lastname']  );
		$firstname=urlencode($_SESSION['cname'] );
		$lastname=urlencode($_SESSION['lastname'] );

		//Credit Card
		$creditCardType =   urlencode( $_SESSION['Centinel_PIType']) ; // urlencode( $_SESSION['request']['card_type']);
		//$creditCardNumber = urlencode($_SESSION['request']['cc_number']);
		$creditCardNumber = urlencode(str_replace(' ', '', $_SESSION['request']['cc_number']) ); 		
		
		//Date
		$startDateMonth =urlencode( $_SESSION['request']['startDateMonth']);
		$expDateMonth =urlencode( $_SESSION['request']['cc_expire_date_month']);
		// Month must be padded with leading zero
	 	$startpadDateMonth = $startDateMonth;//;str_pad($startDateMonth, 2, '0', STR_PAD_LEFT);
		$endpadDateMonth = $expDateMonth;//str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
	 	$startpadDateMonth = str_pad($startpadDateMonth, 2, '0', STR_PAD_LEFT);
		$endpadDateMonth = str_pad($endpadDateMonth, 2, '0', STR_PAD_LEFT);
		$startDateYear =urlencode( $_SESSION['request']['startDateYear']);
		$expDateYear =urlencode( $_SESSION['request']['cc_expire_date_year']);
		
		$cvv2Number = urlencode($_SESSION['request']['cc_cvv2']);

		//Shipping Address
		$firstNameship = urlencode($_SESSION['cname']);
		$lastNameship = urlencode($_SESSION['lastname']);
		$address1 = urlencode($_SESSION['address']);
		$address2 = urlencode($_SESSION['address2']);
		$city = urlencode($_SESSION['b_city']);
		$state = urlencode( $_SESSION['state']);
		$zip = urlencode($_SESSION['postcode']);

		//Amount
		$amount = urlencode($_SESSION['amount']);
		//$currencyCode=urlencode($_POST['currency']);
		$currencyCode= $_SESSION['currency_code'];//"GBP";
		$paymentType=urlencode($_SESSION['request']['paymentType']);
		$issuenumber='';
		$issue_ext ='';

		if(isset($_SESSION['request']['issuenumber']) && $_SESSION['request']['issuenumber'] <> '' ) {
			$issuenumber=urlencode($_SESSION['request']['issuenumber']);
			$issue_ext = "&ISSUENUMBER=".$issuenumber;
		}

		//Country Code
		$paypal_country_code=$_SESSION['country'];

		/* Construct the request string that will be sent to PayPal.
		The variable $nvpstr contains all the variables and is a
		name value pair string with & as a delimiter */

		$nvpstr ="&CARDOWNER=".$cardowner."&PAYMENTACTION=".$paymentType."&AMT=".$amount."&CREDITCARDTYPE=".$creditCardType."&ACCT=".$creditCardNumber."&STARTDATE=".$startpadDateMonth.$startDateYear."&EXPDATE=". $endpadDateMonth.$expDateYear."&CVV2=$cvv2Number" . $issue_ext ."&FIRSTNAME=".$firstname."&LASTNAME=".$lastname."&NAME=".$firstNameship." ".$lastNameship."&STREET=".$address1." ".$address2."&CITY=".$city;
		
		$nvpstr .="&SHIPTONAME=".urlencode($_SESSION['shipping']['SHIPTONAME']). 
				 "&SHIPTOSTREET=".urlencode($_SESSION['shipping']['SHIPTOSTREET']).
				 "&SHIPTOSTREET2=".urlencode($_SESSION['shipping']['SHIPTOSTREET2']).
				 "&SHIPTOCITY=".urlencode($_SESSION['shipping']['SHIPTOCITY']).
				 "&SHIPTOSTATE=".urlencode($_SESSION['shipping']['SHIPTOSTATE']).
				 "&SHIPTOZIP=".urlencode($_SESSION['shipping']['SHIPTOZIP']).
				 "&SHIPTOCOUNTRY=".urlencode($_SESSION['shipping']['SHIPTOCOUNTRY']);
		
		$nvpstr.="&STATE=$state&ZIP=$zip&COUNTRYCODE=$paypal_country_code&CURRENCYCODE=$currencyCode&VERSION=62.0";


		/* By passing enrolled conditions here ... */
		if($creditCardType == 'Maestro') {
			//do nothing
		} else if(strcasecmp('Y', $_SESSION['Centinel_Enrolled']) == 0)	{
			$nvpstr.="&ECI=".$_SESSION['ECI3DS_secure']."&AuthStatus3ds=".$_SESSION['AUTHSTATUS3D_secure']."&MpiVendor3ds=".$_SESSION['MPIVENDOR3DS_secure']."&Cavv=".$_SESSION['CAVV_secure']."&Eci3ds=".$_SESSION['ECI3DS_secure']."&XID=".$_SESSION['XID_secure']."";
		} else {
			$nvpstr.="&ECI3DS=".$_SESSION['Centinel_ECI']."&AuthStatus3ds=&MpiVendor3ds=".$_SESSION['Centinel_Enrolled']."&Cavv=&Eci3ds=".$_SESSION['Centinel_ECI']."&XID=";
		}

		/**
			Log complete doDirectPayment request 
		*/
		global $API_Endpoint,$version,$API_UserName,$API_Password,$API_Signature,$nvp_Header;

		$nvpreq_log="METHOD=".urlencode("doDirectPayment")."&PWD=".urlencode(API_PASSWORD)."&USER=".urlencode(API_USERNAME)."&SIGNATURE=".urlencode(API_SIGNATURE).$nvpstr;
        $this->log( "Payment doDirect Request  " , explode("&" , $nvpreq_log ) );


		/* Make the API call to PayPal, using API signature.
		The API response is stored in an associative array called $resArray */

		$resArray=hash_call("doDirectPayment",$nvpstr);

		$this->log( "Payment doDirect Response  " , $resArray );

		$this->log( "Payment doDirect Session  " , $_SESSION );

		/* Display the API response back to the browser.
		If the response from PayPal was a success, display the response parameters'
		If the response was an error, display the errors received using APIError.php.
		*/

		$ack = strtoupper($resArray["ACK"]);
 
		if($ack!="SUCCESS" && $ack!="SUCCESSWITHWARNING")  {
			$_SESSION['reshash']=$resArray;
			$this->response->redirect($this->url->link('extension/payment/srs_pppro_threed/dodirect_error', '', true));

		}

		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING") {

            $this->load->model('checkout/order');

            //$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('config_order_status_id'));

			/*TIMESTAMP = 2010-01-07T14:48:10Z##
			CORRELATIONID = 9de3693a92cd1##
			ACK = Success##
			VERSION = 53.0##
			BUILD = 1152253##
			AMT = 5.00##
			CURRENCYCODE = GBP##
			AVSCODE = F##
			CVV2MATCH = M##
			TRANSACTIONID = 69457580G0189651V
			*/
			
			$message = '';
            
            if (isset($resArray['ACK'])) {
				$message .= 'ACK: ' . $resArray['ACK'] . "\n";
			}
			if (isset($resArray['TIMESTAMP'])) {
				$message .= 'TIMESTAMP: ' . $resArray['TIMESTAMP'] . "\n";
			}

			if (isset($resArray['CORRELATIONID'])) {
				$message .= 'CORRELATIONID: ' . $resArray['CORRELATIONID'] . "\n";
			}

			if (isset($resArray['AVSCODE'])) {
				$message .= 'AVSCODE: ' . $resArray['AVSCODE'] . "\n";
			}

			if (isset($resArray['TRANSACTIONID'])) {
				$message .= 'TRANSACTIONID: ' . $resArray['TRANSACTIONID'] . "\n";
			}

			if (isset($resArray['CVV2MATCH'])) {
				$message .= 'CVV2MATCH: ' . $resArray['CVV2MATCH'] . "\n";
			}

			if (isset($resArray['AMT'])) {
				$message .= 'AMT: ' . $resArray['AMT'] . "\n";
			}

			if (isset($resArray['CURRENCYCODE'])) {
				$message .= 'CURRENCYCODE: ' . $resArray['CURRENCYCODE'] . "\n";
			}
            
            if (isset($resArray['VERSION'])) {
				$message .= 'VERSION: ' . $resArray['VERSION'] . "\n";
			}

			//$this->model_checkout_order->update($this->session->data['order_id'], $this->config->get('srs_pppro_threed_order_status_id'), $message, FALSE);
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('srs_pppro_threed_order_status_id'), $message, false);


			//$this->url->link('checkout/success');
                ?><script type="text/javascript">window.parent.location='index.php?route=checkout/success'</script><?php
                  exit;
            } 

			?><script type="text/javascript">window.parent.location='index.php?route=checkout/checkout'</script><?php
            	exit;

    } // frame over


    public function dodirect_error() {

        $this->language->load('extension/payment/srs_pppro_threed');
        $this->id = 'payment';
		$this->load->model('extension/payment/srs_pppro_threed');

		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/dodirect_error', $this->data));


    }// dodirect_error

	public function srs_authenticate(){

		require_once('centinel/CentinelClient.php');
		require_once('centinel/CentinelConfig.php');
		require_once('centinel/CentinelUtility.php');

				
		$success = false;

		$this->language->load('extension/payment/srs_pppro_threed');
		$this->id = 'payment';
		$this->load->model('extension/payment/srs_pppro_threed');
		
	    /********************************************************************************************/
	    /* Retrieve the PaRes and MD values from the Card Issuer's Form POST to this Term URL page. */
	    /* If you like, the MD data passed to the Card Issuer could contain the TransactionId       */
	    /* that would enable you to reestablish the transaction session. This would be the          */
	    /* alternative to using the Client Session Cookies                                          */
	    /********************************************************************************************/

 	    $pares         = $_POST['PaRes'];
	    $merchant_data = $_REQUEST['MD'];

	    /******************************************************************************/
	    /*                                                                            */
	    /*    If the PaRes is Not Empty then process the cmpi_authenticate message    */
	    /*                                                                            */
	    /******************************************************************************/
	    
	    $centinelClient = new CentinelClient;

	    //if (strcasecmp('', $pares )!= 0 && $pares != null && isset($_SESSION['Centinel_TransactionId']) ) {
		if (isset($_SESSION['Centinel_TransactionId']) ) { 

            $centinelClient->add('MsgType', 'cmpi_authenticate');
            $centinelClient->add('Version', CENTINEL_MSG_VERSION);
            $centinelClient->add('MerchantId', CENTINEL_MERCHANT_ID);
            $centinelClient->add('ProcessorId', CENTINEL_PROCESSOR_ID);
            $centinelClient->add('TransactionPwd', CENTINEL_TRANSACTION_PWD);
            $centinelClient->add('TransactionType', $_SESSION['Centinel_TransactionType']);
            $centinelClient->add('OrderId', $_SESSION['Centinel_OrderId']);
//            $centinelClient->add('TransactionId', $_SESSION['Centinel_TransactionId']);
            $centinelClient->add('PAResPayload', $pares);


            $centinelClient->sendHttp(CENTINEL_MAPS_URL, CENTINEL_TIMEOUT_CONNECT, CENTINEL_TIMEOUT_READ);


            /////////////////////////////////////////////////////////////////////////////////////////
            // ************************************************************************************
            //                              ** Important Note **
            // ************************************************************************************
            //
            // Here you should persist the authentication results to your commerce system. A production
            // integration should, at a minimum, write the PAResStatus, Cavv, EciFlag, Xid to a database
            // for use when sending the authorization message to your gateway provider.
            //
            // Be sure not to simply 'pass' the authentication results around from page to page, since
            // the values could be easily spoofed if that technique is used.
            //
            /////////////////////////////////////////////////////////////////////////////////////////


            // Using the centinelResponse object, we need to retrieve the results as follows
            $_SESSION["Centinel_ErrorDesc"] = $centinelClient->getValue("ErrorDesc");
            $_SESSION["Centinel_ErrorNo"] = $centinelClient->getValue("ErrorNo");

            $_SESSION["Centinel_PAResStatus"] = $centinelClient->getValue("PAResStatus");
            $_SESSION["Centinel_SignatureVerification"] = $centinelClient->getValue("SignatureVerification");


            $_SESSION["Centinel_CAVV"] = $centinelClient->getValue("Cavv");
            $_SESSION["Centinel_ECI"] = $centinelClient->getValue("EciFlag");
            $_SESSION["Centinel_XID"] = $centinelClient->getValue("Xid");

			$success = true;

	    } else {

	        $_SESSION["Centinel_ErrorDesc"]= "NO PARES RETURNED";
	    }

	    /***************************************************************************************************/
	    /*                                                                                                 */
	    /*Determine if the result was Successful or Error                                                  */
	    /*                                                                                                 */
	    /*If the Authentication results (PAResStatus) is a Y or A, and the SignatureVerification is Y, then*/
	    /*the Payer Authentication was successful. The Authorization Message should be processed,          */
	    /*and the User taken to a Order Confirmation location.                                             */
	    /*                                                                                                 */
	    /*Note that it is also important that you account for cases when your flow logic can account       */
	    /*for error cases, and the flow can be broken after 'N' number of attempts                         */
	    /*                                                                                                 */
	    /***************************************************************************************************/

		$paresStatus            = $_SESSION['Centinel_PAResStatus'];
	
		$signatureVerificaiton  = $_SESSION['Centinel_SignatureVerification'];
	
		$errorNo                = $_SESSION['Centinel_ErrorNo'];


		if( strcasecmp("0", $_SESSION["Centinel_ErrorNo"])== 0 && strcasecmp("Y", $_SESSION["Centinel_SignatureVerification"]) == 0 && 			( strcasecmp("U",$_SESSION["Centinel_PAResStatus"])==0 || 		strcasecmp("N",$_SESSION["Centinel_PAResStatus"])==0 )) {

			$this->log( "Payment srs_authenticate  " , $_SESSION );
			$success = false;
			clearCentinelSession();
			$this->response->redirect($this->url->link('extension/payment/srs_pppro_threed/authenticate_error', '', true));
		}
				 
  
		if($success === true) {
		
			if($_SESSION['Centinel_Enrolled'] == 'Y') {

				$_SESSION['AUTHSTATUS3D_secure'] = $_SESSION['Centinel_PAResStatus'];
				$_SESSION['CAVV_secure'] = $_SESSION['Centinel_CAVV'];
				$_SESSION['ECI3DS_secure'] = $_SESSION['Centinel_ECI']; // Centinel_ECI_
				$_SESSION['XID_secure'] = $_SESSION['Centinel_XID'];
			
			} else {

				$_SESSION['AUTHSTATUS3D_secure'] = '';
				$_SESSION['CAVV_secure'] = '';
				$_SESSION['ECI3DS_secure'] = $_SESSION['Centinel_ECI'];
				$_SESSION['XID_secure'] = '';
			}

			$_SESSION['MPIVENDOR3DS_secure'] = $_SESSION['Centinel_Enrolled'];

		} else {

			$_SESSION["Centinel_ErrorDesc"]= "NO PARES RETURNED";
			$success = false;
					
		}

		$this->log( "Payment srs_authenticate  " , $_SESSION );

                
		if($success == true) {
		
			$this->response->redirect($this->url->link('extension/payment/srs_pppro_threed/doDirect', '', true));
 		
		} else {

			clearCentinelSession();	
            $this->response->redirect($this->url->link('extension/payment/srs_pppro_threed/authenticate_error', '', true));

		}


	}//authenticate over
        
    public function authenticate_error() {

		$this->id = 'payment';
	?>
		<br><br><center>Credit Card  Authentication Error</center>
		
        <script language="javascript">
			function redirect1(){
               window.top.location = 'index.php?route=checkout/cart'; 
    	    }
		setTimeout("redirect1()",2000);
		</script>

	<?php
    }

    public function log($title, $data  = array() ) {

       	if(false) {

			$fp = $fp = fopen(dirname( dirname(dirname(dirname(dirname(__FILE__))))).'/logfile1.txt','a+');

			$temp = chr(13)."\n======================================= ". $title ." ========================================================\n";
            
            $temp .= '\n REQUEST_URI '.$_SERVER['REQUEST_URI'].'\n';
            
            $temp .= '\n Data '. print_r($data,true) .'\n';
            
            fwrite($fp,$temp);

			fclose($fp);
        }
    }
 }