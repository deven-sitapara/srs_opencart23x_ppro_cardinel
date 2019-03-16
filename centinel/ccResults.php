<?php
    /************************************************************************************/
    /*                                                                                  */
    /*CardinalCommerce (http://www.cardinalcommerce.com)                                */
    /*ccResults.php                                                                     */
    /*                                                                                  */
    /*Usage                                                                             */
    /*    This page is used to simply display the results of the transaction processing.*/
    /*    This page simulates a order confirmation page.                                */
    /*                                                                                  */
    /************************************************************************************/


    session_start();

    require('CentinelConfig.php');
?>

<html>
<head>
<title>Centinel - Transaction Results Page</title>
</head>
<body>


<?php
    
    if (!isset($_SESSION['Centinel_TransactionId'])){

        $_SESSION['Message'] ='Order Already Processed, User Hit the Back Button';
        print "\n<meta http-equiv=\"refresh\" content=\"0;URL=./ccStart.php\">\n";	
        
    } else {

        include("ccMenu.php");

        echo"<br/>";
        echo"<b>Transaction Results Page</b>";
        echo"<br/>";
        echo"Intended to simulate an order confirmation page.";
        if (isset($_SESSION["Message"])){
            echo"<br>";
            echo"<font color=\"red\"><b>Sample Message :".$_SESSION["Message"]."</b></font>";
            echo"<br>";
        }
        echo"<br>";
        echo"<table id=\"results\">";
        echo"<tr>";
            echo"<td>Enrolled :</td>";
            if (isset($_SESSION["Centinel_Enrolled"])){
               echo"<td>". $_SESSION["Centinel_Enrolled"]."</td>";
            }
        echo"</tr>";
        echo"<tr>";
            echo"<td>Transaction Status :</td>";
            if (isset($_SESSION["Centinel_PAResStatus"])){
               echo"<td>". $_SESSION["Centinel_PAResStatus"]."</td>";
            }
        echo"</tr>";
        echo"<tr>";
            echo"<td>Signature Verification :</td>";
            if (isset($_SESSION["Centinel_SignatureVerification"])){
               echo"<td>". $_SESSION["Centinel_SignatureVerification"]."</td>";
            }
        echo"</tr>";
        echo"<tr>";
            echo"<td>ECI :</td>";
            if (isset($_SESSION["Centinel_ECI"])){
               echo"<td>". $_SESSION["Centinel_ECI"]."</td>";
            }
        echo"</tr>";
        echo"<tr>";
            echo"<td>Error No :</td>";
            if (isset($_SESSION["Centinel_ErrorNo"])){
               echo"<td>". $_SESSION["Centinel_ErrorNo"]."</td>";
            }
        echo"</tr>";
        echo"<tr>";
            echo"<td>Error Desc :</td>";
            if (isset($_SESSION["Centinel_ErrorDesc"])){
               echo"<td>". $_SESSION["Centinel_ErrorDesc"]."</td>";
            }
        echo"</tr>";


        echo"<tr>";
            echo"<td>Cavv:</td>";
            if (isset($_SESSION["Centinel_CAVV"])){
               echo"<td>". $_SESSION["Centinel_CAVV"]."</td>";
            }
        echo"</tr>";

        echo"<tr>";
            echo"<td>Xid:</td>";
            if (isset($_SESSION["Centinel_XID"])){
               echo"<td>". $_SESSION["Centinel_XID"]."</td>";
            }
        echo"</tr>";
        echo"<tr>";
            echo"<td>Transaction Id :</td>";
            if (isset($_SESSION["Centinel_TransactionId"])){
               echo"<td>". $_SESSION["Centinel_TransactionId"]."</td>";
            }
        echo"</tr>";
        echo"<tr>";
            echo"<td>OrderId :</td>";
            if (isset($_SESSION["Centinel_OrderId"])){
               echo"<td>". $_SESSION["Centinel_OrderId"]."</td>";
            }
        echo"</tr>";
        echo"<tr>";
            echo"<td>AuthenticationPath :</td>";
            if (isset($_SESSION["Centinel_AuthenticationPath"])){
               echo"<td>". $_SESSION["Centinel_AuthenticationPath"]."</td>";
            }
        echo"</tr>";
        echo"</table>";


        /////////////////////////////////////////////////////////////////////////////////////////////
        // Remove the Session values once the Transaction is complete.
        // Unset all of the session variables and destroy the session.
        /////////////////////////////////////////////////////////////////////////////////////////////

        session_unset();
        session_destroy();

    }  // end else
?>

</body>
</html>
<?php

?>
