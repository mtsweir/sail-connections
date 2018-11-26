<?php

// IP LOOKUP OF COUNTRY

if (@$_SERVER["HTTP_CF_IPCOUNTRY"]) { // Get Country code from cloudflare
  $country_code = $_SERVER["HTTP_CF_IPCOUNTRY"];
  }
else { // If no cloudflare, get country code from server default geo looup
  $country_code = trim(shell_exec('geoip-lookup '.$_SERVER['REMOTE_ADDR'])); 
  }
if (!isset($country_code)) {
    $country_code = ''; //no country id available
}

// ASSIGN COUNTRIES TO MARKETS

$market_au = array('AU','CX','CC','HM','NF');

$market_nz = array('CK','NZ','NU','TK');

$market_americas = array('AI','AG','AR','AW','BS','BB','BZ','BM','BQ','BV','BR','CA','KY','CL','CO','CR','CU','CW','DM','DO','EC','SV','FK','GF','GD','GP','GT','GY','HT','HN','JM','MQ','MX','MS','NI','PA','PY','PE','PR','BL','KN','LC','MF','PM','VC','SX','GS','SR','TT','TC','US','UM','UY','VE','VG','VI');

$market_asiapac = array('AF','AS','AO','AQ','AZ','BD','BT','BO','BW','BN','KH','CN','FJ','PF','GU','HK','IN','ID','JP','KZ','KI','KP','KR','KG','LA','MO','MY','MV','MH','FM','MN','MM','NR','NP','NC','MP','PK','PW','PG','PH','PN','WS','SG','SB','LK','TW','TJ','TH','TL','TO','TM','TV','UZ','VU','VN','WF');

$market_eu_mideast = array('AX','AL','DZ','AD','AM','AT','BH','BY','BE','BJ','BA','BG','BF','CM','CV','CF','TD','CI','HR','CY','CZ','DK','DJ','EG','GQ','ER','EE','ET','FO','FI','FR','GA','GM','GE','DE','GH','GI','GR','GL','GG','GN','GW','VA','HU','IS','IR','IQ','IE','IM','IL','IT','JE','JO','KW','LV','LB','LR','LY','LI','LT','LU','MK','ML','MT','MR','MD','MC','ME','MA','NL','NE','NG','NO','OM','PS','PL','PT','QA','RO','RU','SM','ST','SA','SN','RS','SL','SK','SI','SO','SS','ES','SD','SJ','SE','CH','SY','TG','TN','TR','UA','AE','GB','EH','YE');

$market_southernafrica = array('IO','BI','KM','CG','CD','TF','KE','LS','MG','MW','MU','YT','MZ','NA','RE','RW','SH','SC','ZA','SZ','TZ','UG','ZM','ZW');

// SET MARKET TO PASS TO FORMS FOR HUBSPOT

if (in_array($country_code, $market_au)) { 
  $market = "Australia";
  }
elseif (in_array($country_code, $market_nz)) { 
  $market = "New Zealand";
  }
elseif (in_array($country_code, $market_americas)) { 
  $market = "Americas";
  }
elseif (in_array($country_code, $market_asiapac)) { 
  $market = "Asia & Pacific";
  }
elseif (in_array($country_code, $market_eu_mideast)) { 
  $market = "Europe & M/East";
  }
elseif (in_array($country_code, $market_southernafrica)) { 
  $market = "Southern Africa";
  }
else { 
  $market = ""; // Market Not Set
  }
?>