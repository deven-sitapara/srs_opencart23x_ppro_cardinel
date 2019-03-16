<html>
    <head>
        <title>Launch Payer Authentication Page</title>
        <script language="javascript">
            function onLoadHandler(){
                 document.frmLaunchACS.submit();
            }
        </script>
    </head>

    <body onLoad="onLoadHandler();">
    <br/><br/><br/><br/>
    <center>
    <form name="frmLaunchACS" method="Post" action="<?php echo $AcsUrl; ?>">
        <input type=hidden name="PaReq" value="<?php echo $PaReq; ?>">
        <input type=hidden name="TermUrl" value="<?php echo $TermUrl; ?>">
        <input type=hidden name="MD" value="<?php echo $MD; ?>">
        <noscript>
        <center>
            <font color="red">
                <h2>Processing your Payer Authentication Transaction</h2>
                <h3>JavaScript is currently disabled or is not supported by your browser.<br></h3>
                <h4>Please click Submit to continue the processing of your transaction.</h4>
            </font>
        <input type="submit" value="Submit">
        </center>
        </noscript>
    </form>
    </center>
    </body>
</html>