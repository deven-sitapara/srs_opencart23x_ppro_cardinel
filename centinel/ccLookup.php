<?php
    /******************************************************************************************************/
    /*                                                                                                    */
    /*Cardinal Commerce (http://www.cardinalcommerce.com)                                                 */
    /*ccProcessor.php                                                                                     */
    /*Usage                                                                                               */
    /*    A sample or template integration of the Centinel Thin Client. The samples follows a basic inline*/
    /*    authentication approach and provides the sample that utilizes the Thin Client for communication */
    /*    with the MAPS servers.                                                                          */
    /*                                                                                                    */
    /*Transaction API                                                                                     */
    /*    Please reference the current transaction API documentation for a complete list of               */
    /*    all required and optional message elements.                                                     */
    /*                                                                                                    */
    /*Return Parameters Checked and Used for Processing                                                   */
    /*                                                                                                    */
    /*    Enrolled    - (Y/N/U) Indicates if the user is enrolled in the payer authentication program     */
    /*    ACSUrl      - The fully qualified Url of the location of the ACS Server (Card Issuer Server)    */
    /*    Payload     - The encrypted Message payload, to be interperted by the Card Issuer's Server      */
    /*    ErrorNo     - If an error was encountered while processing the Enrollment Request message       */
    /*              the error number will be available. Error Codes are distributed with the              */
    /*              Thin Client Documentation.                                                            */
    /*    ErrorDesc   - Indicates the ErrorDesc, if ErrorNo is not '0'                                    */
    /*                                                                                                    */
    /******************************************************************************************************/


    /*************************************************************************************************/
    /* Referece the Centinel Thin Client and configuration files. The Thin Client has helper methods */
    /* that will assist with the XML message handling.                                               */
    /* Note that depending on your environment and deployment, these references may change.          */
    /*************************************************************************************************/

    require('CentinelClient.php');
    require('CentinelConfig.php');
    require('CentinelUtility.php');

    session_start();
    clearCentinelSession();


    /*******************************************************************************/
    /*                                                                             */
    /*Using the local variables and constants, build the Centinel message using the*/
    /*Centinel Thin Client.                                                        */
    /*                                                                             */
    /*******************************************************************************/

    $centinelClient = new CentinelClient;


	$centinelClient->add("MsgType", "cmpi_lookup");
	$centinelClient->add("Version", CENTINEL_MSG_VERSION);
	$centinelClient->add("ProcessorId", CENTINEL_PROCESSOR_ID);
	$centinelClient->add("MerchantId", CENTINEL_MERCHANT_ID);
	$centinelClient->add("TransactionPwd", CENTINEL_TRANSACTION_PWD);
	$centinelClient->add("UserAgent", $_SERVER["HTTP_USER_AGENT"]);
	$centinelClient->add("BrowserHeader", $_SERVER["HTTP_ACCEPT"]);
	$centinelClient->add("TransactionType", "C");
//    $centinelClient->add('IPAddress', $_SERVER['REMOTE_ADDR']);

	$centinelClient->add("Amount", $_POST["amount"]);
	$centinelClient->add("ShippingAmount", $_POST["shipping_amount"]);
	$centinelClient->add("TaxAmount", $_POST["tax_amount"]);
	$centinelClient->add("CurrencyCode", $_POST["currency_code"]);
	$centinelClient->add("OrderNumber", $_POST["order_number"]);
	$centinelClient->add("OrderDescription", $_POST["order_description"]);

	$centinelClient->add("EMail", $_POST["email_address"]);
	$centinelClient->add("BillingFirstName", $_POST["b_first_name"]);
	$centinelClient->add("BillingMiddleName", $_POST["b_middle_name"]);
	$centinelClient->add("BillingLastName", $_POST["b_last_name"]);
	$centinelClient->add("BillingAddress1", $_POST["b_address1"]);
	$centinelClient->add("BillingAddress2", $_POST["b_address2"]);
	$centinelClient->add("BillingCity", $_POST["b_city"]);
	$centinelClient->add("BillingState", $_POST["b_state"]);
	$centinelClient->add("BillingPostalCode", $_POST["b_postal_code"]);
	$centinelClient->add("BillingCountryCode", $_POST["b_country_code"]);
	$centinelClient->add("BillingPhone", $_POST["b_phone"]);

	$centinelClient->add("ShippingFirstName", $_POST["s_first_name"]);
	$centinelClient->add("ShippingMiddleName", $_POST["s_middle_name"]);
	$centinelClient->add("ShippingLastName", $_POST["s_last_name"]);
	$centinelClient->add("ShippingAddress1", $_POST["s_address1"]);
	$centinelClient->add("ShippingAddress2", $_POST["s_address2"]);
	$centinelClient->add("ShippingCity", $_POST["s_city"]);
	$centinelClient->add("ShippingState", $_POST["s_state"]);
	$centinelClient->add("ShippingPostalCode", $_POST["s_postal_code"]);
	$centinelClient->add("ShippingCountryCode", $_POST["s_country_code"]);
	$centinelClient->add("ShippingPhone", $_POST["s_phone"]);

	$centinelClient->add("Item_Name_1", $_POST['Item_Name_1']);
	$centinelClient->add("Item_Desc_1", $_POST['Item_Desc_1']);
	$centinelClient->add("Item_Price_1", $_POST['Item_Price_1']);
	$centinelClient->add("Item_Quantity_1", $_POST['Item_Quantity_1']);
	$centinelClient->add("Item_SKU_1", $_POST['Item_SKU_1']);
	$centinelClient->add("Item_Name_2", $_POST['Item_Name_2']);
	$centinelClient->add("Item_Desc_2", $_POST['Item_Desc_2']);
	$centinelClient->add("Item_Price_2", $_POST['Item_Price_2']);
	$centinelClient->add("Item_Quantity_2", $_POST['Item_Quantity_2']);
	$centinelClient->add("Item_SKU_2", $_POST['Item_SKU_2']);

    // Payment type specific fields
    $centinelClient->add('CardNumber', $_POST['card_number']);
    $centinelClient->add('CardExpMonth', $_POST['expr_mm']);
    $centinelClient->add('CardExpYear', $_POST['expr_yyyy']);


//    $centinelClient->add('Recurring', "Y");
//    $centinelClient->add('RecurringFrequency', "7");
//    $centinelClient->add('RecurringEnd', "20090625");
//


    /**********************************************************************************/
    /*                                                                                */
    /*Send the XML Msg to the MAPS Server, the Response is the CentinelResponse Object*/
    /*                                                                                */
    /**********************************************************************************/


    $centinelClient->sendHttp(CENTINEL_MAPS_URL, CENTINEL_TIMEOUT_CONNECT, CENTINEL_TIMEOUT_READ);


//    // TODO: DEBUG (remove this before commit)
//    $_debug_title =  "";
//    echo "<b>$_debug_title</b><pre class='debug'>";
//    print_r($centinelClient);
//    echo "</pre>"; 
//    exit;
//

    // Save response in session
    $_SESSION['Centinel_Enrolled']      = $centinelClient->getValue('Enrolled');
    $_SESSION['Centinel_ErrorNo']       = $centinelClient->getValue('ErrorNo');
    $_SESSION['Centinel_ErrorDesc']     = $centinelClient->getValue('ErrorDesc');
    $_SESSION['Centinel_ECI']           = $centinelClient->getValue('EciFlag');
    $_SESSION['Centinel_ACSUrl']        = $centinelClient->getValue('ACSUrl');
    $_SESSION['Centinel_Payload']       = $centinelClient->getValue('Payload');
    $_SESSION['Centinel_OrderId']       = $centinelClient->getValue('OrderId');
    $_SESSION['Centinel_TransactionId'] = $centinelClient->getValue('TransactionId');
    $_SESSION['Centinel_AuthenticationPath'] = $centinelClient->getValue('AuthenticationPath');

    $_SESSION['Centinel_TermUrl']           = CENTINEL_TERM_URL;
    $_SESSION['Centinel_TransactionType']   = $_POST['txn_type'];
    $_SESSION['Centinel_OrderNumber']       = $_POST['order_number'];

    /******************************************************************************/
    /*                                                                            */
    /*                            Authentication Logic                            */
    /*                                                                            */
    /******************************************************************************/

    if(strcasecmp('0', $_SESSION['Centinel_ErrorNo'])== 0 && strcasecmp('Y', $_SESSION['Centinel_Enrolled']) == 0){

        /*****************************************************/
        /* Cardholder is enrolled, proceed to redirect page. */
        /*****************************************************/

        redirectBrowser('frames/ccFrame.php');

    
    } else {

        /******************************************************************/
        /* If the Payer Authentication enrollment response was not "Y" or */
        /* resulted in an error then do not redirect to ACS. Proceed to   */
        /* authorization.                                                 */
        /******************************************************************/

        redirectBrowser('ccResults.php');
    }
        
?>
