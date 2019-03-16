<?php echo $header; ?>
<div id="content">
    <div class="top">
        <h1>Paypal Transaction error</h1>
    </div>
</div>
<div class="middle">


    <form name="frmResultPage" method="POST" action="index.php?route=checkout/cart" target="_parent">

        <?php  $resArray=$_SESSION['reshash']; ?>
        <table CELLSPACING=0 CELLPADDING=0 WIDTH=100% border="0" class="simpletext">
            <tr>
                <td VALIGN="TOP" align="center" style="padding-left:20px">

                    <table class="simpletext" width="80%">

                        <tr>
                            <td colspan="2">
                                <div class="simplepageheader"><i>Payment</i></div>
                            </td>
                        </tr>

                        <tr style="display:none">
                            <td colspan="2" class="header">The PayPal API has returned an error!</td>
                        </tr>

                        <?php  //it will print if any URL errors
			if(isset($_SESSION['curl_error_no'])) {
					$errorCode= $_SESSION['curl_error_no'] ;
					$errorMessage=$_SESSION['curl_error_msg'] ;
					foreach($_SESSION as $key => $val)
                        {
                        if($key <> 'uid')
                        {
                        unset($_SESSION[$key]);
                        }

                        }

                        //session_unset();
                        ?>


                        <tr>
                            <td>Error Number:</td>
                            <td><?php echo  $errorCode ?></td>
                        </tr>
                        <tr>
                            <td>Error Message:</td>
                            <td><?php echo  $errorMessage ?></td>
                        </tr>


                        <?php } else {

/* If there is no URL Errors, Construct the HTML page with
   Response Error parameters.
   */
?>
                        <tr>
                            <td>Ack:</td>
                            <td><?php echo  $resArray['ACK'] ?></td>
                        </tr>
                        <tr style="display:none">
                            <td>Correlation ID:</td>
                            <td><?php echo  $resArray['CORRELATIONID'] ?></td>
                        </tr>
                        <tr style="display:none">
                            <td>Version:</td>
                            <td><?php echo  $resArray['VERSION']?></td>
                        </tr>
                        <?php
                    $count=0;
                    while (isset($resArray["L_SHORTMESSAGE".$count])) {
                          $errorCode    = $resArray["L_ERRORCODE".$count];
                          $shortMessage = $resArray["L_SHORTMESSAGE".$count];
                          $longMessage  = $resArray["L_LONGMESSAGE".$count];
                          $count=$count+1;
?>
                        <tr>
                            <td>Error Number:</td>
                            <td><?php echo  $errorCode ?></td>
                        </tr>
                        <tr>
                            <td>Short Message:</td>
                            <td><?php echo  $shortMessage ?></td>
                        </tr>
                        <tr>
                            <td>Long Message:</td>
                            <td><?php echo  $longMessage ?></td>
                        </tr>

                        <?php }//end while
                }// end else

 ?>

                    </table>

                </td>
            </tr>
        </table>


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
        <center><input type="submit" value="Try again"></center>
    </form>


</div>

</div>
<?php echo $footer; ?>