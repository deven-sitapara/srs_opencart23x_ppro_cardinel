<?php

///////////////////////////////////////////////////////////////////////////////////////////////////
//  Cardinal Commerce (http://www.cardinalcommerce.com)
//  ccProcessor.php
//  Version 8.0.0 07/21/2007
//	Usage
//		A sample or template integration of the Centinel Thin Client. The samples follows a basic inline 
//		authentication approach and provides the sample that utilizes the Thin Client for communication
//		with the MAPS servers. 
//
//	Note 
//		This is ONLY A SAMPLE INTEGRATION. It has been tested under
//		Internet Explorer(6.0), Mozilla (1.3, 1.7), Netscape (4.08,7.0), a production integration
//		may require additional browser support and should be tested with respect to those guidelines.
//
//	Transaction API
//		Please reference the current transaction API documentation for a complete list of
//		all required and optional message elements.
//
//	Return Parameters Checked and Used for Processing
//
//		Enrolled	- (Y/N/U) Indicates if the user is enrolled in the payer authentication program
//		ACSUrl		- The fully qualified Url of the location of the ACS Server (Card Issuer Server)
//		Payload		- The encrypted Message payload, to be interperted by the Card Issuer's Server
//		ErrorNo		- If an error was encountered while processing the Enrollment Request message
//				  the error number will be available. Error Codes are distributed with the 
//				  Thin Client Documentation.
//		ErrorDesc	- Indicates the ErrorDesc, if ErrorNo is not '0'
///////////////////////////////////////////////////////////////////////////////////////////////////

	session_start();

	///////////////////////////////////////////////////////////////////////////////////////////////
	// Referece the Centinel Thin Client and configuration files. The Thin Client has helper methods
	// that will assist with the XML message handling.
	// Note that depending on your environment and deployment, these references may change.
	///////////////////////////////////////////////////////////////////////////////////////////////

	require('CentinelClient.php');
	include('CentinelConfig.php');
	include('CentinelUtility.php');

	///////////////////////////////////////////////////////////////////////////////////////////////
	// Complete Mapping of Merchant Form Field Names to the Centinel Identifiers
	///////////////////////////////////////////////////////////////////////////////////////////////

	$_SESSION['Centinel_TermURL'] = CENTINEL_TERM_URL;

	$transactionType = $_POST['txn_type'];                  // Transaction Type
	$_SESSION['Centinel_TransactionType'] = $transactionType;

	$card_number = $_POST['card_number'];                   // 13-19 digits

	if(isset($_POST['expr_mm'])){
		$expr_mm = $_POST['expr_mm'];						// MM
	}else{
		$expr_mm = '';
	}
	if(isset($_POST['expr_yyyy'])){
		$expr_yyyy = $_POST['expr_yyyy'];						// YYYY
	}else{
		$expr_yyyy = '';
	}

	$order_number = $_POST['order_number'];                 // Transaction Order Number
	$order_description = $_POST['order_description'];       // Transaction Order Description
	$amount = $_POST['amount'];                             // Raw Amount of Transaction (ex 23481)
	$currency_code = $_POST['currency_code'];               // ISO Currency Code (USD - 840)

	if(isset($_POST['recurring_frequency'])){
		$recur_frequency = $_POST['recurring_frequency'];		// Payment recurrence in days
	}else{
		$recur_frequency = '';
	}

	if(isset($_POST['recurring_end'])){
		$recur_expiry = $_POST['recurring_end'];                // Expiration date of payment recurrence
	}else{
		$recur_expiry = '';
	}

	if(isset($_POST['installment'])){
		$installment = $_POST['installment'];					// Number of installment payments
	}else{
		$installment = '';
	}


	///////////////////////////////////////////////////////////////////////////////////////////////
	// Using the local variables and constants, build the Centinel message using the
	// Centinel Thin Client.
	///////////////////////////////////////////////////////////////////////////////////////////////

	$centinelClient = new CentinelClient;

	$centinelClient->add('Version', CENTINEL_MSG_VERSION);
	$centinelClient->add('MsgType', 'cmpi_lookup');
	$centinelClient->add('ProcessorId', CENTINEL_PROCESSOR_ID);
	$centinelClient->add('MerchantId', CENTINEL_MERCHANT_ID);
	$centinelClient->add('TransactionPwd', CENTINEL_TRANSACTION_PWD);
	$centinelClient->add('TransactionType', $_POST['txn_type']);
	$centinelClient->add('Amount', $_POST['amount']);
	$centinelClient->add('CurrencyCode', $_POST['currency_code']);
	$centinelClient->add('CardNumber', $_POST['card_number']);
	$centinelClient->add('CardExpMonth', $_POST['expr_mm']);
	$centinelClient->add('CardExpYear', $_POST['expr_yyyy']);
	$centinelClient->add('OrderNumber', $_POST['order_number']);
	$centinelClient->add('OrderDescription', $_POST['order_description']);
	$centinelClient->add('UserAgent', $_SERVER['HTTP_USER_AGENT']);
	$centinelClient->add('BrowserHeader', $_SERVER['HTTP_ACCEPT']);
	$centinelClient->add('IPAddress', $_SERVER['REMOTE_ADDR']);
	$centinelClient->add('EMail', $_POST['email_address']);


	//////////////////////////////////////////////////////////////////////////////////////////
	// Send the XML Msg to the MAPS Server, the Response is the CentinelResponse Object
	//////////////////////////////////////////////////////////////////////////////////////////

	$centinelClient->sendHttp(CENTINEL_MAPS_URL, CENTINEL_TIMEOUT_CONNECT, CENTINEL_TIMEOUT_READ);

	$enrolled = '';
	$errorNo = '';
	$errorDesc = '';
	$transactionId = '';
	$eci = '';

	$errorNo = $centinelClient->getValue('ErrorNo');
	$errorDesc = $centinelClient->getValue('ErrorDesc');
	if(strcasecmp('0', $errorNo)== 0 ){
		$enrolled = $centinelClient->getValue('Enrolled');          // possible values of Y, N or U
		$transactionId = $centinelClient->getValue('TransactionId');
		$eci = $centinelClient->getValue('EciFlag');
		$_SESSION['Centinel_ACSURL']= $centinelClient->getValue('ACSUrl');
		$_SESSION['Centinel_PAYLOAD']= $centinelClient->getValue('Payload');

	}
	$_SESSION['Centinel_Enrolled']= $enrolled;
	$_SESSION['Centinel_TransactionId']= $transactionId;
	$_SESSION['Centinel_ErrorNo'] = $errorNo;
	$_SESSION['Centinel_ErrorDesc'] = $errorDesc;
	$_SESSION['Centinel_ECI'] = $eci;

    $_SESSION['Centinel_PIType'] = determineCardType($card_number);

	///////////////////////////////////////////////////////////////////////////////////////
	// Handle ALL Payer Authentication Logic
	//////////////////////////////////////////////////////////////////////////////////////


    if(strcasecmp('0', $errorNo)== 0 && strcasecmp('Y', $enrolled) == 0){

        //////////////////////////////////////////////////////////////////////////////////
        // Proceed to Payer Authentication
        //////////////////////////////////////////////////////////////////////////////////

        redirectBrowser('frames/ccFrame.php');

    }
    else if(strcasecmp('0', $errorNo)== 0 && strcasecmp('U', $enrolled) == 0){

        //////////////////////////////////////////////////////////////////////////////////
        // Proceed to Authorization, Payer Authentication Not Available
        // Set the proper ECI value based on the Card Type
        //////////////////////////////////////////////////////////////////////////////////
    
        redirectBrowser('ccResults.php');
        
    }
    else if(strcasecmp('0', $errorNo)== 0 && strcasecmp('N', $enrolled) == 0){

        //////////////////////////////////////////////////////////////////////////////
        // Proceed to Authorization, Payer Authentication Not Available
        // Set the proper ECI value based on the Card Type
        //////////////////////////////////////////////////////////////////////////////

        redirectBrowser('ccResults.php');
    }
    else{

        //////////////////////////////////////////////////////////////////////////////
        // An error was encountered
        // Log Error Message, this is an unexpected state
        // Proceed to authorization to complete the transaction.
        //////////////////////////////////////////////////////////////////////////////

        redirectBrowser('ccResults.php');
    }
		
?>
	
