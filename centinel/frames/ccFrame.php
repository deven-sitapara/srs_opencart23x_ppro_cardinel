<?php
 /******************************************************************************************/
 /*                                                                                        */
 /*CardinalCommerce (http://www.cardinalcommerce.com)                                      */
 /*                                                                                        */
 /*Usage                                                                                   */
 /*   Page creates the framed layout for the payer authentication processing.              */
 /*                                                                                        */
 /*   Note that is is simply a sample layout. Your production implementation should take   */
 /*   on your website's branding and layout. The only requirement is that there is adequate*/
 /*   space (420 X 400) to display the authentication window to the consumer.              */
 /*                                                                                        */
 /******************************************************************************************/


	require(".." . DIRECTORY_SEPARATOR . "CentinelConfig.php");

    session_start(); // start session

    $AcsUrl  = $_SESSION["Centinel_ACSUrl"];
    $PaReq   = $_SESSION["Centinel_Payload"];
    $TermUrl = $_SESSION["Centinel_TermUrl"];
?>
<html>
    <head>
        <title>Processing Your Transaction</title>

        <?php
            /////////////////////////////////////////////////////////////////////////////////////////////
            // Check the transaction Id value to verify that this transaction has not already
            // been processed. This attempts to block the user from using the back button.
            /////////////////////////////////////////////////////////////////////////////////////////////

            if (!isset($_SESSION["Centinel_TransactionId"])){
            
                $_SESSION["Message"] = "Order Already Processed, User Hit the Back Button";
                echo "\n<meta http-equiv=\"refresh\" content=\"0;URL=..\ccStart.php\">\n";
            }
        ?>
    </head>

    <body>
        <img src="<?php echo CENTINEL_MERCHANT_LOGO; ?>"/>
        <hr /><br />
        <center>
            <b><?php echo CENTINEL_AUTHENTICATION_MESSAGING; ?></b><br /><br />
            <iframe width='390px' height='400px' scrolling='auto' src='ccLaunch.php'></iframe>
        </center>
    </body>
</html>
