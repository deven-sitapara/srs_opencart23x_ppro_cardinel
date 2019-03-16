<?php
    function determineCardType($Card_Number){
                
        // VISA, MASTERCARD, JCB, AMEX, UNKNOWN

        $cardType = "UNKNOWN";

        if ((strlen($Card_Number) == 16) && (substr($Card_Number, 0, 1) == "4"))
        $cardType = "VISA";
        else if (strlen($Card_Number) == 13 && substr($Card_Number, 0, 1) == "5")
        $cardType = "MASTERCARD";
        else if (strlen($Card_Number) == 16 && substr($Card_Number, 0, 1) == "5")
        $cardType = "MASTERCARD";
        else if (strlen($Card_Number) == 15  && substr($Card_Number, 0, 4)== "2131")
        $cardType = "JCB";
        else if (strlen($Card_Number) == 15 && substr($Card_Number, 0, 4) == "1800")
        $cardType = "JCB";
        else if (strlen($Card_Number) == 16 && substr($Card_Number, 0, 1) == "3")
        $cardType = "JCB";
        else if (strlen($Card_Number) == 15 && substr($Card_Number, 0, 2) == "34")
        $cardType = "AMEX";
        else if (strlen($Card_Number) == 15 && substr($Card_Number, 0, 2) == "37")
        $cardType = "AMEX";

        return $cardType ;
    }

    function redirectBrowser($url) {

        $protocol = 'http://';

        if (getenv('HTTPS') == 'on'){
            $protocol = 'https://';
        }

        $url = $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/'.$url;

        header('Location: ' . $url);
        exit();
    }

    /**
     * Clears session of any variables that begin with "Centinel_"
     */
    function clearCentinelSession() {
        unset($_SESSION['Message']);
        foreach($_SESSION as $key => $value) {
            if(preg_match("/^Centinel_.*/", $key) > 0) {
                unset($_SESSION[$key]);
            }

        }

    } 
?>
