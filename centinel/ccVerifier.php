<?php
    //////////////////////////////////////////////////////////////////////////////////////
    // CardinalCommerce (http://www.cardinalcommerce.com)
    // ccVerifier.aspx
    // Version 8.0.0 07/21/2007
    // Purpose
    //		This page represents the TermUrl passed on the ccLaunch.aspx page. The
    //		external system will post the results of the transaction to this page.  
    //
    // Note
    //      This is ONLY A SAMPLE INTEGRATION. It has been tested under
    //		Internet Explorer(6.0), Mozilla (1.3, 1.7), Netscape (4.08,7.0), a production integration
    //		may require additional browser support and should be tested with respect to those guidelines.
    //////////////////////////////////////////////////////////////////////////////////////


    session_start();

    require('CentinelClient.php');
    include('CentinelConfig.php');

    /////////////////////////////////////////////////////////////////////////////////////////
    // Retrieve the PaRes and MD values from the Card Issuer's Form POST to this Term URL page.
    // If you like, the MD data passed to the Card Issuer could contain the TransactionId
    // that would enable you to reestablish the transaction session. This would be the
    // alternative to using the Client Session Cookies
    /////////////////////////////////////////////////////////////////////////////////////////


    $pares = $_POST['PaRes'];
    $merchant_data = $_REQUEST['MD'];

    /////////////////////////////////////////////////////////////////////////////////////////
    // If the PaRes is Not Empty then process the cmpi_authenticate message
    /////////////////////////////////////////////////////////////////////////////////////////

    if (strcasecmp('', $pares )!= 0 && $pares != null) {


        //////////////////////////////////////////////////////////////////////////////////////
        // Send the XML Msg to the MAPS Server
        // SendHTTP will send the cmpi_authenticate message to the MAPS Server (requires fully qualified Url)
        // The Response is the CentinelResponse Object
        //////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////////////////////////
        // Send the XML Msg to the MAPS Server
        // SendHTTP will send the cmpi_lookup message to the MAPS Server (requires fully qualified URL)
        // The Response is the CentinelResponse Object
        //////////////////////////////////////////////////////////////////////////////////////

        $centinelClient = new CentinelClient;

        //////////////////////////////////////////////////////////////////////////////////////////////////
        // Construct Message using Name / Value pairs
        //////////////////////////////////////////////////////////////////////////////////////////////////

        $centinelClient->add('MsgType', 'cmpi_authenticate');
        $centinelClient->add('Version', CENTINEL_MSG_VERSION);
        $centinelClient->add('MerchantId', CENTINEL_MERCHANT_ID);
        $centinelClient->add('ProcessorId', CENTINEL_PROCESSOR_ID);
        $centinelClient->add('TransactionPwd', CENTINEL_TRANSACTION_PWD);
        $centinelClient->add('TransactionType', $_SESSION['Centinel_TransactionType']);
        $centinelClient->add('TransactionId', $_SESSION['Centinel_TransactionId']);
        $centinelClient->add('PAResPayload', $pares);


        /////////////////////////////////////////////////////////////////////////////////////////
        // Send the XML Msg to the MAPS Server
        // Send will send the cmpi_authenticate message to the MAPS Server (requires fully qualified Url)
        // The Response is the CentinelResponse Object
        /////////////////////////////////////////////////////////////////////////////////////////

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


    } else {

        $_SESSION["Centinel_ErrorDesc"]= "NO PARES RETURNED";
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    // Determine if the result was Successful or Error
    //
    // If the Authentication results (PAResStatus) is a Y or A, and the SignatureVerification is Y, then
    // the Payer Authentication was successful. The Authorization Message should be processed,
    // and the User taken to a Order Confirmation location.
    //
    // If the Authentication results were not successful, the Authentication results were N, U or
    // the ErrorNo was NOT '0' then the Consumer should be redirected, and prompted for another
    // form of payment.
    //
    // Note that it is also important that you account for cases when your flow logic can account
    // for error cases, and the flow can be broken after 'N' number of attempts
    /////////////////////////////////////////////////////////////////////////////////////////

    $redirectPage = "ccResults.php";


    if(strcasecmp("0", $_SESSION["Centinel_ErrorNo"])== 0 &&
        strcasecmp("N", $_SESSION["Centinel_SignatureVerification"]) == 0){

        $_SESSION["Message"] = "Your transaction completed however is pending review. Your order will be shipped once payment is verified.";
        $redirectPage = "ccResults.php";

    }else if(strcasecmp("0", $_SESSION["Centinel_ErrorNo"])== 0 &&
        strcasecmp("Y", $_SESSION["Centinel_SignatureVerification"]) == 0 &&
        strcasecmp("Y",$_SESSION["Centinel_PAResStatus"])==0){

        $_SESSION["Message"] = "Your transaction completed successfully. Your order will be shipped immediately.";
        $redirectPage = "ccResults.php";

    }else if(strcasecmp("0", $_SESSION["Centinel_ErrorNo"])== 0 &&
        strcasecmp("Y", $_SESSION["Centinel_SignatureVerification"]) == 0 &&
        strcasecmp("P",$_SESSION["Centinel_PAResStatus"])==0){

        $_SESSION["Message"] = "Your transaction completed however payment is currently pending. Your order will be shipped once payment is verified.";
        $redirectPage = "ccResults.php";

    }else if(strcasecmp("0", $_SESSION["Centinel_ErrorNo"])== 0 &&
        strcasecmp("Y", $_SESSION["Centinel_SignatureVerification"]) == 0 &&
        strcasecmp("X",$_SESSION["Centinel_PAResStatus"])==0){

        $_SESSION["Message"] = "Your transaction was canceled prior to completion. Please provide another form of payment.";
        $redirectPage = "ccResults.php";

    }else{
        /////////////////////////////////////////////////////////////////////////////////////////
        // Unexpected State
        // Log Message Information
        // Verify payment was receive prior to shipping goods to consumer.
        /////////////////////////////////////////////////////////////////////////////////////////

        $_SESSION["Message"] = "Your transaction completed however is pending review. Your order will be shipped once payment is verified.";
        $redirectPage = "ccResults.php";
    }



    print"<HTML>";
    print"<HEAD>";
    print"<Title>Centinel - Verifier Page</Title>";
    print"</Head>";
    print"<body onload=\"document.frmResultPage.submit();\"></body>";
    print"<FORM name=\"frmResultPage\" method=\"Post\" action=\"$redirectPage\" target=\"_parent\">";
    print"<noscript>";
        print"<br><br>";
        print"<center>";
        print"<font color=\"red\">";
        print"<h1>Processing Your Transaction</h1>";
        print"<h2>JavaScript is currently disabled or is not supported by your browser.<br></h2>";
        print"<h3>Please click Submit to continue the processing of your transaction.</h3>";
        print"</font>";
        print"<input type=\"submit\" value=\"Submit\">";
        print"</center>";
    print"</noscript>";
    print"</FORM>";
    print"</HTML>";
?>
