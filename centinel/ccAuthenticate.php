<?php

    session_start();

    require('CentinelClient.php');
    require('CentinelConfig.php');

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

    if (strcasecmp('', $pares )!= 0 && $pares != null && isset($_SESSION['Centinel_TransactionId']) ) {

            $centinelClient = new CentinelClient;


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

    $redirectPage = "ccResults.php";

    if( ( strcasecmp("0", $errorNo) == 0 || strcasecmp("1140", $errorNo) == 0 ) && 
          strcasecmp("Y", $signatureVerificaiton) == 0 && 
        ( strcasecmp("Y", $paresStatus) == 0 || strcasecmp("A", $paresStatus ) == 0 )   ) {
   
        /******************************************************************************/
        /*                                                                            */
        /*     If no errors were returned, the signature verification passed, and     */
        /*     the transaction status was either "Y" (authenticated) or "A"           */
        /*     (attempted), Payer Authentication was successful.                      */
        /*                                                                            */
        /******************************************************************************/

        $_SESSION["Message"] = "Your transaction completed successfully.";
    
    } else if( strcasecmp("N", $paresStatus) == 0 ) {

        /******************************************************************************/
        /*                                                                            */
        /*       Customer was presented with the authentication screen however        */
        /*       either clicked the "exit" option or was unable to provide the        */
        /*       correct password.                                                    */
        /*                                                                            */
        /******************************************************************************/

        $_SESSION["Message"] = "Your transaction was unable to authenticate. Please provide another form of payment. (PAResStatus = N)";
//        $redirectPage = "ccStart.php";

    } else {

        /******************************************************************************/
        /*                                                                            */
        /*Continue to authorization, either an error occurred or an unexpected status */
        /*was returned ("U" for example).                                             */
        /*                                                                            */
        /******************************************************************************/

        $_SESSION["Message"] = "Your transaction completed however is pending review. Your order will be shipped once payment is verified.";

    } // end if

?>
<html>
<head>
<title>Centinel - Verifier Page</title>
</head>
<body onload="document.frmResultPage.submit();"></body>
<form name="frmResultPage" method="POST" action="<?php echo $redirectPage; ?>" target="_parent">
<noscript>
    <br><br>
    <center>
    <font color="red">
    <h1>Processing Your Transaction</h1>
    <h2>JavaScript is currently disabled or is not supported by your browser.<br></h2>
    <h3>Please click Submit to continue the processing of your transaction.</h3>
    </font>
    <input type="submit" value="Submit">
    </center>
</noscript>
</form>
</html>
