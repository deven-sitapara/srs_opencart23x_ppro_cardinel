<?php
    //////////////////////////////////////////////////////////////////////////////////////////////
    //	Cardinal Commerce (http://www.cardinalcommerce.com)
    //	ccAuthBridge.php
    //	Version 6.0 
    //	04/01/2006
    //
    //  Usage - Sample page to execute a Auth Bridge transaction.
    //
    //////////////////////////////////////////////////////////////////////////////////////////////

    session_start();
       
    //////////////////////////////////////////////////////////////////////////////////////////////
    // Referece the Centinel Thin Client and configuration files. The Thin Client has helper methods
    // that will assist with the XML message handling.
    // Note that depending on your environment and deployment, these references may change.
    //////////////////////////////////////////////////////////////////////////////////////////////

    require("CentinelClient.php");
    include("CentinelConfig.php");


    if(isset($_POST['transaction_id'])){
        $_SESSION["TID"]= $_POST["transaction_id"];
    }else
        $_SESSION["TID"]="";

    if(isset($_POST['refund_amount'])){
        $_SESSION["refundAmount"]= $_POST["refund_amount"];
    }else
        $_SESSION["refundAmount"]="";

    if(isset($_POST['currency_code'])){
        $_SESSION["currencyCode"]= $_POST["currency_code"];
    }else
        $_SESSION["currencyCode"]="";

    if(isset($_POST['execute'])){
        $executeTransaction = $_POST['execute'];
    }else
        $executeTransaction ="";
            
            

    print"<html>";
    print"<head>";
    print"<title>Centinel - Auth Bridge Page</title>";
    print"</head>";
    print"<body>";

    include "ccMenu.php";

    print"<br/>";
    print"<b>Auth Bridge Lookup Request Form</b>";
    print"<form name=\"frm\" method=\"POST\" action=\"ccAuthBridge.php\">";
    print"<input type=\"hidden\" name=\"execute\" value=\"true\">";
    print"<table>";
    print"<tr bgcolor=\"ffff40\">";
        print"<td>TransactionId </td><td><input type=text size=\"60\" name=\"transaction_id\" value=\"".$_SESSION['TID']."\"></td>";
    print"</tr>";
    print"<tr bgcolor=\"ffff40\">";
        print"<td>Transaction Type</td><td>";
        print"<select name=txn_type>";
            print"<option value=\"C\">C - Credit Card";
        print"</select>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td>Card Number </td><td><input type=text name=\"pan\" value=\"\"></td>";
    print"</tr>";
    print"<tr>";
        print"<td>Amount </td><td><input type=text name=\"amount\" value=\"\"></td>";
    print"</tr>";
    print"<tr>";
        print"<td>Currency Code </td>";
        print"<td><select name=\"currency_code\">";
            print"<option value=\"840\">840 - USD</option>";
            print"<option value=\"978\">978 - EUR</option>";
            print"<option value=\"392\">392 - JPY</option>";
            print"<option value=\"124\">124 - CAD</option>";
            print"<option value=\"826\">826 - GBP</option>";
        print"</select>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td>From Date </td><td><input type=text size=\"10\" name=\"from_dt\" value=\"\"></td>";
    print"</tr>";
    print"<tr>";
        print"<td>To Date </td><td><input type=text size=\"10\" name=\"to_dt\" value=\"\"></td>";
    print"</tr>";
    print"<tr>";
        print"<td></td>";
        print"<td><input type=submit name=\"submit\" value=\"Process\" onClick=\"setExecute()\"></td>";
    print"</tr>";
    print"<tr>";
        print"<td colspan=\"2\"><br><b><i>Required fields highlighted</i></b></td>";
    print"</tr>";
    print"</table>";
    print"</form>";
    print"<br>";
    print"<hr>";
    print"<br><br>";

        
    if ( strcasecmp('true',$executeTransaction )== 0) {

        $centinelClient = new CentinelClient;

        //////////////////////////////////////////////////////////////////////////////////////////
        // Construct Message using Name / Value pairs
        //////////////////////////////////////////////////////////////////////////////////////////

        $centinelClient->add('MsgType','cmpi_ab_lookup');
        $centinelClient->add('Version', CENTINEL_MSG_VERSION);
        $centinelClient->add('ProcessorId', CENTINEL_PROCESSOR_ID);
        $centinelClient->add('MerchantId', CENTINEL_MERCHANT_ID);
        $centinelClient->add('TransactionPwd', CENTINEL_TRANSACTION_PWD);
        $centinelClient->add('TransactionType', $_POST['txn_type']);
        $centinelClient->add('TransactionId', $_POST['transaction_id']);
        $centinelClient->add('Amount', $_POST['refund_amount']);
        $centinelClient->add('CurrencyCode', $_POST['currency_code']);
        $centinelClient->add('CardNumber', $_POST['pan']);
        $centinelClient->add('FromDt', $_POST['from_dt']);
        $centinelClient->add('ToDt', $_POST['to_dt']);

        // Send Message to the MAPS Server
        $centinelClient->sendHttp(CENTINEL_MAPS_URL, CENTINEL_TIMEOUT_CONNECT, CENTINEL_TIMEOUT_READ);

        $strErrorNo = $centinelClient->getValue('ErrorNo');
        $strErrorDesc = $centinelClient->getValue('ErrorDesc');
        $strCAVV = $centinelClient->getValue('Cavv');
        $strXID = $centinelClient->getValue('Xid');
        $strECI = $centinelClient->getValue('EciFlag');
        $strEnrolled = $centinelClient->getValue('Enrolled');
        $strStatus = $centinelClient->getValue('PAResStatus');
        $strSignature = $centinelClient->getValue('SignatureVerification');

        print"<b> Auth-Bridge Transaction Request </b>";
        print"<table>";
        print"<tr>";
            print"<td>ProcessorId</td>";
            print"<td>".CENTINEL_PROCESSOR_ID."</td>";
        print"</tr>";
        print"<tr>";
            print"<td>MerchantId</td>";
            print"<td>".CENTINEL_MERCHANT_ID."</td>";
        print"</tr>";
        print"<tr>";
            print"<td>TransactionPwd</td><td>".CENTINEL_trANSACTION_PWD."</td>";
        print"</tr>";
        print"<tr>";
            print"<td>TransactionId</td><td>".$_POST["transaction_id"]."</td>";
        print"</tr>";
        print"<tr>";
            print"<td>Refund Type</td><td>".$_POST["refund_type"]."</td>";
        print"</tr>";
        print"<tr>";
            print"<td>Refund Amount</td><td>".$_POST["refund_amount"]."</td>";
        print"</tr>";
        print"<tr>";
            print"<td>Currency Code</td><td>".$_POST["currency_code"]."</td>";
        print"</tr>";
        print"<tr>";
            print"<td>Description</td><td>".$_POST["description"]."</td>";
        print"</tr>";
        print"</table>";
        print"<br/><br/>";
        print"<b> Auth-Bridge Transaction Results </b>";
        print"<table>";
        print"<tr>";
            print"<td>ErrorNo</td><td>$strErrorNo</td>";
        print"</tr>";
        print"<tr>";
            print"<td>Description</td><td>$strErrorDesc</td>";
        print"</tr>";
        print"<tr>";
            print"<td>Enrolled</td><td>$strEnrolled</td>";
        print"</tr>";
        print"<tr>";
            print"<td>Authentication Status</td><td>$strStatus</td>";
        print"</tr>";
        print"<tr>";
            print"<td>Signature Status</td><td>$strSignature</td>";
        print"</tr>";
        print"<tr>";
            print"<td>ECI</td><td>$strECI</td>";
        print"</tr>";
        print"<tr>";
            print"<td>CAVV</td><td>$strCAVV</td>";
        print"</tr>";
        print"<tr>";
            print"<td>XID</td><td>$strXID</td>";
        print"</tr>";
        print"</table>";

        /////////////////////////////////////////////////////////////////////////////////////////////
        // Remove the Session values once the Transaction is complete.
        // Unset all of the session variables and destroy the session.
        /////////////////////////////////////////////////////////////////////////////////////////////

        session_unset();
        session_destroy();
    }

    print"</body>";
    print"</html>";

?>
