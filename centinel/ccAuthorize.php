<?php
    session_start(); 
?>
<html>
    <head>
        <title>Centinel - Authorize Page</title>
        <script type="text/javascript" src="util.js"></script>
        <script type="text/javascript">
            window.onload = function() {
                document.frm.onsubmit = singleSubmit("frm");
            } // end onLoad
        </script>
    </head>
<body>

    <?php include('ccMenu.php'); ?>

    <br />
    <b>Authorization Request Form - 3ds</b>
    <form name="frm" method="POST" action="?execute=true">
    <TABLE>
    <TR>
        <td bgcolor="ffff40">Transaction Type</TD><TD>
        <select name=txn_type>
							<option value="C">C - Credit
        </select></TD>
    </TR>
    <TR>
        <TD bgcolor="ffff40">OrderId</TD><TD><input type=text name="order_id" value="123"></TD>
    </TR>
    <TR>
        <TD bgcolor="ffff40">TransactionId</TD><TD><input type=text name="order_id" value="112"></TD>
    </TR>
    <TR>
        <TD bgcolor="ffff40">Amount </TD><TD><input type=text name="amount" value="20"></TD>
    </TR>
    <TR>
        <TD bgcolor="ffff40">Currency </TD><TD><input type=text name="currency_code" value="840"></TD>
    </TR>
    <TR>
        <TD>Description </TD><TD><input type=text name="order_description" value="Sample Order..."></TD>
    </TR>

    

        <tr width="150">
            <td  bgcolor="ffff40">Card Number</td>
            <td>
                <input id="card_number" value="4000000000000002" type="text" name="card_number" />
            </td>
            <td colspan="5">
                <select id="card_number_selector" name="card_number_selector">
                    <option value="">Select PAN
                    <option value="4000000000000002">4000000000000002 - Y,Y,Y
                    <option value="5200000000000007">5200000000000007 - Y,Y,Y
                    <option value="3000000000000004">3000000000000004 - Y,Y,Y
                    <option value="1000000000000001">1000000000000001 - Error
                    <option value="4000000000000010">4000000000000010 - Y,Y,N
                    <option value="5200000000000015">5200000000000015 - Y,Y,N
                    <option value="3000000000000012">3000000000000012 - Y,Y,N
                    <option value="4000000000000028">4000000000000028 - Y,N,Y
                    <option value="3000000000000020">3000000000000020 - Y,N,Y
                    <option value="5200000000000023">5200000000000023 - Y,N,Y
                    <option value="4000000000000101">4000000000000101 - Y,A,Y
                    <option value="5200000000000106">5200000000000106 - Y,A,Y
                    <option value="180000000000028">  180000000000028 - Y,A,Y
                    <option value="4000000000000036">4000000000000036 - Y,U
                    <option value="5200000000000031">5200000000000031 - Y,U
                    <option value="3000000000000038">3000000000000038 - Y,U
                    <option value="4000000000000044">4000000000000044 - Timeout Test - Lookup
                    <option value="4000000000000259">4000000000000259 - Timeout Test - Authenticate
                    <option value="5200000000000049">5200000000000049 - Timeout Test - Lookup
                    <option value="5200000000000452">5200000000000452 - Timeout Test - Authenticate
                    <option value="213100000000001">  213100000000001 - Timeout Test - Lookup
                    <option value="3000000000000376">3000000000000376 - Timeout Test - Authenticate
                    <option value="4000000000000051">4000000000000051 - N
                    <option value="5200000000000056">5200000000000056 - N
                    <option value="213100000000019">  213100000000019 - N
                    <option value="4000000000000069">4000000000000069 - U
                    <option value="5200000000000064">5200000000000064 - U
                    <option value="213100000000027">  213100000000027 - U
                    <option value="4000000000000077">4000000000000077 - Error
                    <option value="5200000000000072">5200000000000072 - Error
                    <option value="213100000000035">  213100000000035 - Error
                    <option value="4000000000000085">4000000000000085 - Error
                    <option value="5200000000000080">5200000000000080 - Error
                    <option value="180000000000002">  180000000000002 - Error
                    <option value="4000000000000093">4000000000000093 - Y, Error
                    <option value="5200000000000098">5200000000000098 - Y, Error
                    <option value="180000000000010">  180000000000010 - Y, Error
                    <option value="4000000400000093">4000000400000093 - Not Test Card
                    <option value="5200000400000098">5200000400000098 - Not Test Card
                    <option value="180000040000010">  180000040000010 - Not Test Card
                    <option value="4000000000000432">4000000000000432 - Y,A,N
                    <option value="4000000000000606">4000000000000606 - Y,U,N
                    <option value="4000000000000838">4000000000000838 - Y,N,N
                    <option value="5200000000000221">5200000000000221 - Y,A,N
                    <option value="5200000000000270">5200000000000270 - Y,U,N
                    <option value="5200000000000148">5200000000000148 - Y,N,N
                    <option value="3000000000000657">3000000000000657 - Y,A,N
                    <option value="3000000000000962">3000000000000962 - Y,U,N
                    <option value="3000000000000210">3000000000000210 - Y,N,N
                </select>
            </td>
        </tr>


        <tr>
            <td bgcolor="ffff40">Expiration </td>
            <td>
            <select name="expr_mm">
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>

            <select name="expr_yyyy">
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011" selected>2011</option>

                </select>
            </td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td bgcolor="ffff40" width="150">Order Number</td><td><input type="text" name="order_number" value="221"></td>
            <td>Order Description </td><td><input type="text" name="order_description" value="Sample Order..."></td>
        </tr>
        <tr>
            <td bgcolor="ffff40">Amount </td><td><input type="text" name="amount" value="20"></td>
            <td bgcolor="ffff40" >Currency Code </td><td><input type="text" name="currency_code" value="840"></td>
        </tr>
        <tr>
            <td>Shipping Amount</td><td><input type=text name="shipping_amount" value=""></td>
            <td>Tax Amount</td><td><input type=text name="tax_amount" value=""></td>
        </tr>
        <tr>
            <td>&nbsp;</td><td></td>
            <td>&nbsp;</td><td></td>
        </tr>
        <tr>
            <td >Billing First Name</td><td><input type="text" name="b_first_name" value="Test1"></td>
            <td >Shipping First Name</td><td><input type="text" name="s_first_name" value="Test1"></td>
        </tr>
        <tr>
            <td>Billing Middle Name</td><td><input type=text name="b_middle_name" value=""></td>
            <td>Shipping Middle Name</td><td><input type=text name="s_middle_name" value=""></td>
        </tr>
        <tr>
            <td >Billing Last Name</td><td><input type="text" name="b_last_name" value="User"></td>
            <td >Shipping Last Name</td><td><input type="text" name="s_last_name" value="User"></td>
        </tr>
        <tr>
            <td >Billing Address1</td><td><input type="text" name="b_address1" value="1234 Main Street"></td>
            <td >Shipping Address1</td><td><input type="text" name="s_address1" value="1234 Main Street"></td>
        </tr>
        <tr>
            <td>Billing Address2</td><td><input type="text" name="b_address2" value=""></td>
            <td>Shipping Address2</td><td><input type="text" name="s_address2" value=""></td>
        </tr>
        <tr>
            <td >Billing City</td><td><input type="text" name="b_city" value="Mentor"></td>
            <td >Shipping City</td><td><input type="text" name="s_city" value="Mentor"></td>
        </tr>
        <tr>
            <td >Billing State</td><td><input type="text" name="b_state" value="OH"></td>
            <td >Shipping State</td><td><input type="text" name="s_state" value="OH"></td>
        </tr>
        <tr>
            <td >Billing Postal Code</td><td><input type="text" name="b_postal_code" value="44060"></td>
            <td >Shipping Postal Code</td><td><input type="text" name="s_postal_code" value="44060"></td>
        </tr>
        <tr>
            <td >Billing Country Code</td><td><input type="text" name="b_country_code" value="US"></td>
            <td >Shipping Country Code</td><td><input type="text" name="s_country_code" value="US"></td>
        </tr>
        <tr>
            <td >Billing Phone</td><td><input type="text" name="b_phone"></td>
            <td >Shipping Phone</td><td><input type="text" name="s_phone" ></td>
        </tr>
        <tr>
            <td >Buyer Email</td><td><input type="text" name="email_address" value="testuser@cardinalcommerce.com"></td>
            <td>&nbsp;</td><td></td>
        </tr>

        <tr>
            <td>&nbsp;</td><td></td>
            <td>&nbsp;</td><td></td>
        </tr>
        <tr>
            <td>Item 1 Name</td><td><input type="text" name="Item_Name_1" value="2GB MP3 Player"/></td>
            <td>Item 2 Name</td><td><input type="text" name="Item_Name_2" value=""/></td>
        </tr>
        <tr>
            <td>Item 1 SKU</td><td><input type="text" name="Item_SKU_1" value="123456"/></td>
            <td>Item 2 SKU</td><td><input type="text" name="Item_SKU_2" value=""/></td>
        </tr>
        <tr>
            <td>Item 1 Price</td><td><input type="text" name="Item_Price_1" value="1250"/></td>
            <td>Item 2 Price</td><td><input type="text" name="Item_Price_2" value=""/></td>
        </tr>
        <tr>
            <td>Item 1 Quantity</td><td><input type="text" name="Item_Quantity_1" value="1"/></td>
            <td>Item 2 Quantity</td><td><input type="text" name="Item_Quantity_2" value=""/></td>
        </tr>
        <tr>
            <td>&nbsp;</td><td></td>
            <td>&nbsp;</td><td></td>
        </tr>










    <TR>
      <TD></TD>
      <TD><input type=submit name="submit" value="Process Authorize"></TD>
    </TR>
    <TR>
      <TD colspan="2"><br><b><i>Required fields highlighted</i></b></TD>
    </TR>
    </table>
    </form>
    <br>
    <hr>
    <br><br>

<?php
		 
    require('CentinelClient.php');
    require('CentinelUtility.php');
    require('CentinelConfig.php');


    /******************************************************************************/
    /*                                                                            */
    /*                        Handle transaciton execution                        */
    /*                                                                            */
    /******************************************************************************/

    if ( strcasecmp('true',$_REQUEST['execute'] )== 0) {
        
        $centinelClient = new CentinelClient;

        $centinelClient->add('MsgType', 'cmpi_authorize');
        $centinelClient->add('Version', CENTINEL_MSG_VERSION);
        $centinelClient->add('ProcessorId', CENTINEL_PROCESSOR_ID);
        $centinelClient->add('MerchantId', CENTINEL_MERCHANT_ID);
        $centinelClient->add('TransactionPwd', CENTINEL_TRANSACTION_PWD);
        $centinelClient->add('TransactionId', $_POST['transaction_id']);
        $centinelClient->add('OrderId', $_POST['order_id']);
        $centinelClient->add('TransactionType', $_POST['txn_type']);
        $centinelClient->add('Amount', $_POST['amount']);
        $centinelClient->add('CurrencyCode', $_POST['currency_code']);
        $centinelClient->add('OrderDescription', $_POST['order_description']);


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





        $centinelClient->sendHttp(CENTINEL_MAPS_URL, CENTINEL_TIMEOUT_CONNECT, CENTINEL_TIMEOUT_READ);

?>
    <b> Authorize Transaction Request</b>
    <table>
    <tr>
        <td>ProcessorId</td>
        <td><?php echo CENTINEL_PROCESSOR_ID; ?></td>
    </tr>
    <tr>
        <td>MerchantId</td>
        <td><?php echo CENTINEL_MERCHANT_ID; ?></td>
    </tr>
    <tr>
        <td>OrderId</td><td><?php echo $_REQUEST['order_id']; ?></td>
    </tr>
    <tr>
        <td>TransactionType</td><td><?php echo $_POST['txn_type']; ?><td>
    </tr>
    <tr>
        <td>Amount</td><td><?php echo $_POST['amount']; ?><td>
    </tr>
    <tr>
        <td>CurrencyCode</td><td><?php echo $_POST['currency_code']; ?><td>
    </tr>
    <tr>
        <td>Description</td><td><?php echo $_POST['order_description']; ?><td>
    </tr>
    </table>
    <br/><br/>
    <b> Authorize Transaction Response</b>
    <table>
    <tr>
        <td>ErrorNo</td><td><?php echo $centinelClient->getValue('ErrorNo'); ?><td>
    </tr>
    <tr>
        <td>Description</td><td><?php echo $centinelClient->getValue('ErrorDesc') ?><td>
    </tr>
    <tr>
        <td>StatusCode</td><td><?php echo $centinelClient->getValue('StatusCode'); ?><td>
    </tr>
    <tr>
        <td>TransactionId</td><td><?php echo $centinelClient->getValue('TransactionId'); ?><td>
    </tr>
    <tr>
        <td>OrderId</td><td><?php echo $centinelClient->getValue('OrderId'); ?><td>
    </tr>
    <tr>
        <td>ReasonCode</td><td><?php echo $centinelClient->getValue('ReasonCode'); ?><td>
    </tr>
    <tr>
        <td>ReasonDesc</td><td><?php echo $centinelClient->getValue('ReasonDesc'); ?><td>
    </tr>
    </table>

<?php

    } // end if

    ///////////////////////////////////////////////////////////////////////////////////////////////
    // Remove the Session values once the Transaction is complete.
    // Unset all of the session variables and destroy the session.
    ///////////////////////////////////////////////////////////////////////////////////////////////

    clearCentinelSession();

?>
</body>
</html>
