<?php
/////////////////////////////////////////////////////////////////////////////////////////////
//	CardinalCommerce (http://www.cardinalcommerce.com)
//	ccHeader.php
//	Version 6.0
//	04/01/2006
//
//	Page creates the header for framed layout for the payer authentication processing. 
//
/////////////////////////////////////////////////////////////////////////////////////////////
	session_start();

	include ".." . DIRECTORY_SEPARATOR . "CentinelConfig.php";

	$headerText = "";
	$imageSrc = "";

	if(strcasecmp("C", $_SESSION["Centinel_TransactionType"])== 0){
		$headerText = CENTINEL_AUTHENTICATION_MESSAGING;
		
		if(strcasecmp("VISA", $_SESSION["Centinel_PIType"])== 0){
			$imageSrc = VBV_LOGO;
		}else if(strcasecmp("MASTERCARD", $_SESSION["Centinel_PIType"])== 0){
			$imageSrc = MCSC_LOGO;
		}else if(strcasecmp("JCB", $_SESSION["Centinel_PIType"])== 0){
			$imageSrc = JCB_LOGO;
		}
	}else if(strcasecmp("E", $_SESSION["Centinel_TransactionType"])== 0){
		$headerText = CENTINEL_SECUREEBILL_MESSAGING;
		$imageSrc = SEB_LOGO;
	}else if(strcasecmp("B", $_SESSION["Centinel_TransactionType"])== 0){
		$headerText = CENTINEL_BILLMEMATER_MESSAGING;
		$imageSrc = BML_LOGO;
	}

print "<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">";
print "  <tr valign=\"top\">";
print "    <td width=\"20%\" align=\"right\"><img src=\"".CENTINEL_MERCHANT_LOGO."\"/></td>";
print "	<td width=\"*\"></td>";
print "	<td align=\"205\"></td>";
print "  </tr>";
print "  <tr><td colspan=\"3\"><hr/></td></tr>";
print "  <tr valign=\"top\">";
print "    <td width=\"20%\" align=\"right\"></td>";
print "	   <td width=\"60%\" align=\"center\">";
print "      <font size=\"2\" color=\"#000000\" face=\"Arial, Helvetica, sans-serif\">";
print "      $headerText";
print "	  </font>";
print "	  </td><td width=\"20%\"><img src=\"$imageSrc\"/></td>";
print "	  </tr></table>";
print "    </td>";
print "  </tr>";
print "</table>";

?>
