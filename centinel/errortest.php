<?php

    session_start();

    require('CentinelClient.php');
    require('CentinelConfig.php');


    for($i=0;$i<100;$i++) {

            $centinelClient = new CentinelClient;


            $centinelClient->add('MsgType', 'cmpi_authenticate');
            $centinelClient->add('Version', CENTINEL_MSG_VERSION);
            $centinelClient->add('MerchantId', CENTINEL_MERCHANT_ID);
            $centinelClient->add('ProcessorId', CENTINEL_PROCESSOR_ID);
            $centinelClient->add('TransactionPwd', CENTINEL_TRANSACTION_PWD);
            $centinelClient->add('TransactionType', "C");
//            $centinelClient->add('OrderId', $_SESSION['Centinel_OrderId']);
            $centinelClient->add('TransactionId', '2o5ilsDzn2z5QRwlVLO5');
            $centinelClient->add('PAResPayload', "foo");


            $centinelClient->sendHttp(CENTINEL_MAPS_URL, CENTINEL_TIMEOUT_CONNECT, CENTINEL_TIMEOUT_READ);

    } // end
?>
