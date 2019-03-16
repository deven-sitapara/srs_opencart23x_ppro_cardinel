<?php echo $header; ?>
<div class="container">


    <div class="row">
                <div id="content">
                  <div class="top">
                    <div class="center">
                      <h1>Processing 3d secure transaction...</h1>
                    </div>
                  </div>
                  <div class="middle">

                      <p>Please wait a few seconds for the window below to load. This is an additional check to ensure the security of your transaction. Thank you for your patience.</p>
                <center>
                            <b><?php echo CENTINEL_AUTHENTICATION_MESSAGING; ?></b><br /><br />

                            <iframe width='390px' style="border:1px solid #ccc" height='400px' scrolling='auto' src='index.php?route=extension/payment/srs_pppro_threed/srs_innerframe'></iframe>
                </center>

                  </div>
                </div>
    </div>
</div>
<?php echo $footer; ?>
