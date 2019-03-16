<?php
    session_start();
?>

<html>
<head>
    <title>Centinel - Start Page</title>
    

    <script type="text/javascript" src="util.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            document.frm.order_number.value = randomOrderNumber();
            document.frm.amount.value = randomAmount();
            document.frm.Item_Price_1.value = document.frm.amount.value;
            document.frm.card_number_selector.onchange = 
                function() {
                    document.getElementById("card_number").value = document.getElementById("card_number_selector").value;
                }
            build3DSDateOptions();
            
            document.frm.onsubmit = singleSubmit("frm");

        } // end onLoad
    </script>


</head>
<body>

<?php
    include ("ccMenu.php");

    echo"<br/>";
    echo"<b>Lookup Transaction Form</b>";
    echo"<br/>";
    echo"This form is intended to simulate your payment page within your ecommerce website.";
    echo"<br/>All payment information is collected, and clicking the submit button at the bottom of the page simulates the consumer clicking the final buy button.";
    echo"<br/>";
    if (isset($_SESSION["Message"])){
        echo"<br>";
        echo"<font color=\"red\"><b>Sample Message :".$_SESSION["Message"]."</b></font>";
        echo"<br>";
    }
    echo"<br>";
?>

    <form name="frm"method=post action="ccLookup.php">
        <table>
        <tr>
            <td bgcolor="ffff40">Transaction Type</td><td>
            <select name="txn_type">
                <option value="C">C - Credit Card / Debit Card
            </select></td>
            <td>&nbsp;</td><td></td>
        </tr>

        <tr style="">
            <td colspan="6">&nbsp;</td>
        </tr>


        <tr width="150">
            <td  bgcolor="ffff40">Card Number</td>
            <td>
                <input id="card_number" value="5434829001517660" type="text" name="card_number" />
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
                <option value="11"  selected>11</option>
                <option value="12">12</option>
            </select>

            <select name="expr_yyyy">
            <option value="2008">2008</option>
                    <option value="2009" >2009</option>
                    <option value="2010">2010</option>
                    <option value="2011" selected>2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
             </select>
            </td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td bgcolor="ffff40" width="150">Order Number</td><td><input type="text" name="order_number" value="123"></td>
            <td>Order Description </td><td><input type="text" name="order_description" value="Test cc."></td>
        </tr>
        <tr>
            <td bgcolor="ffff40">Amount </td><td><input type="text" name="amount" value="5"></td>
            <td bgcolor="ffff40" >Currency Code </td><td><input type="text" name="currency_code" value="826"></td>
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
            <td >Billing First Name</td><td><input type="text" name="b_first_name" value="John"></td>
            <td >Shipping First Name</td><td><input type="text" name="s_first_name" value="John"></td>
        </tr>
        <tr>
            <td>Billing Middle Name</td><td><input type=text name="b_middle_name" value=""></td>
            <td>Shipping Middle Name</td><td><input type=text name="s_middle_name" value=""></td>
        </tr>
        <tr>
            <td >Billing Last Name</td><td><input type="text" name="b_last_name" value="Wesson"></td>
            <td >Shipping Last Name</td><td><input type="text" name="s_last_name" value="Wesson"></td>
        </tr>
        <tr>
            <td >Billing Address1</td><td><input type="text" name="b_address1" value="46 Randall Drive"></td>
            <td >Shipping Address1</td><td><input type="text" name="s_address1" value="46 Randall Drive"></td>
        </tr>
        <tr>
            <td>Billing Address2</td><td><input type="text" name="b_address2" value=""></td>
            <td>Shipping Address2</td><td><input type="text" name="s_address2" value=""></td>
        </tr>
        <tr>
            <td >Billing City</td><td><input type="text" name="b_city" value="Milton Keynes"></td>
            <td >Shipping City</td><td><input type="text" name="s_city" value="Milton Keynes"></td>
        </tr>
        <tr>
            <td >Billing State</td><td><input type="text" name="b_state" value="Buckinghamshire"></td>
            <td >Shipping State</td><td><input type="text" name="s_state" value="Buckinghamshire"></td>
        </tr>
        <tr>
            <td >Billing Postal Code</td><td><input type="text" name="b_postal_code" value="MK18 2FQ"></td>
            <td >Shipping Postal Code</td><td><input type="text" name="s_postal_code" value="MK18 2FQ"></td>
        </tr>
        <tr>
            <td >Billing Country Code</td><td><input type="text" name="b_country_code" value="UK"></td>
            <td >Shipping Country Code</td><td><input type="text" name="s_country_code" value="UK"></td>
        </tr>
        <tr>
            <td >Billing Phone</td><td><input type="text" name="b_phone"></td>
            <td >Shipping Phone</td><td><input type="text" name="s_phone" ></td>
        </tr>
        <tr>
            <td >Buyer Email</td><td><input type="text" name="email_address" value="gkolbe@gmail.com"></td>
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

            <tr>
                <td></td>
                <td colspan="10">
                    <table width="500">
                        <tr>
                            <td>
                                <a target="_vbvLearnMore" href="vbv_learn_more.html" border="0"><img border="0" src="../images/vbv_learn_more.gif" /></a>
                                <a target="_mcscLearnMore" href="mcs_learn_more.html" border="0"><img border="0" src="../images/mcsc_learn_more.gif" /></a>
                            </td>
                            <td style="font-size: 10pt;">
                                Your card may be eligible or enrolled in Verified by Visa or MasterCard SecureCode payer authentication programs. After clicking the 'Submit Order' button, your Card Issuer may prompt you for your payer authentication password to complete your purchase. This will go on your checkout page / where you enter your credit card number.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        <tr>
            <td>&nbsp;</td><td></td>
            <td>&nbsp;</td><td></td>
        </tr>
        <tr>
          <td></td>
          <TD colspan="" align="center"><input type='submit' name="submit" value="Submit Order"></td>
        </tr>
        <tr>
          <TD colspan="2"><br><b><i>Required fields highlighted</i></b></td>
        </tr>
        </table>
    </form>

</body>
</html>
