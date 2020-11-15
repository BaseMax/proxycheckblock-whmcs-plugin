<?php
/*
 * @Name: proxycheckblock-whmcs-plugin
 * @Author: Max Base
 * @Repository: https://github.com/BaseMax/proxycheckblock-whmcs-plugin/
 * @Date: 2020-11-13
 */

$proxycheck_name = "LcenseMan"; // CHANGE THIS
$proxycheck_emai = "admin@licenseman.net"; // CHANGE THIS

/*
* A PHP Function which checks if the IP Address specified is a Proxy Server utilising the API provided by https://proxycheck.io
* This function is covered under an MIT License.
*/
function proxycheck_function($Visitor_IP) {

  // ------------------------------
  // SETTINGS
  // ------------------------------

  $API_Key = "********"; // Supply your API key between the quotes if you have one
  $VPN = "1"; // Change this to 1 if you wish to perform VPN Checks on your visitors
  $TLS = "1"; // Change this to 1 to enable transport security, TLS is much slower though!
  $TAG = "1"; // Change this to 1 to enable tagging of your queries (will show within your dashboard)
  
  // If you would like to tag this traffic with a specific description place it between the quotes.
  // Without a custom tag entered below the domain and page url will be automatically used instead.
  $Custom_Tag = ""; // Example: $Custom_Tag = "My Forum Signup Page";

  // ------------------------------
  // END OF SETTINGS
  // ------------------------------

  // Setup the correct querying string for the transport security selected.
  if ( $TLS == 1 ) {
    $Transport_Type_String = "https://";
  } else {
    $Transport_Type_String = "http://";
  }
  
  // By default the tag used is your querying domain and the webpage being accessed
  // However you can supply your own descriptive tag or disable tagging altogether above.
  if ( $TAG == 1 && $Custom_Tag == "" ) {
    $Post_Field = "tag=" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  } else if ( $TAG == 1 && $Custom_Tag != "" ) {
    $Post_Field = "tag=" . $Custom_Tag;
  } else {
    $Post_Field = "";
  }
  
  // Performing the API query to proxycheck.io/v2/ using cURL
  $ch = curl_init($Transport_Type_String . 'proxycheck.io/v2/' . $Visitor_IP . '?key=' . $API_Key . '&vpn=' . $VPN);
  
  $curl_options = array(
    CURLOPT_CONNECTTIMEOUT => 30,
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $Post_Field,
    CURLOPT_RETURNTRANSFER => true
  );
    
  curl_setopt_array($ch, $curl_options);
  $API_JSON_Result = curl_exec($ch);
  curl_close($ch);
  
  // Decode the JSON from our API
  $Decoded_JSON = json_decode($API_JSON_Result);

  // Check if the IP we're testing is a proxy server
  if ( isset($Decoded_JSON->$Visitor_IP->proxy) && $Decoded_JSON->$Visitor_IP->proxy == "yes" ) {

    // A proxy has been detected.
    return true;
    
  } else {
    
    // No proxy has been detected.
    return false;
    
  }
}

if(proxycheck_function($_SERVER["REMOTE_ADDR"])) {
  // echo "<h3>It appears you're a Proxy / VPN / bad IP, please contact [admin[@]YOUR_WEBSITE_SUPPORT] for more information. <br />"; 
  echo '<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width">
  <meta name="robots" content="noindex,follow">
  <title>Error: Proxy or VPN detected</title>
  <style type="text/css">
    html {
      background: #f1f1f1;
    }
    body {
      background: #fff;
      color: #444;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
      margin: 2em auto;
      padding: 1em 2em;
      max-width: 700px;
      -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
    }
    h1 {
      border-bottom: 1px solid #dadada;
      clear: both;
      color: #666;
      font-size: 24px;
      margin: 30px 0 0 0;
      padding: 0;
      padding-bottom: 7px;
    }
    #error-page {
      margin-top: 50px;
    }
    #error-page p,
    #error-page .wp-die-message {
      font-size: 14px;
      line-height: 1.5;
      margin: 25px 0 20px;
    }
    #error-page code {
      font-family: Consolas, Monaco, monospace;
    }
    ul li {
      margin-bottom: 10px;
      font-size: 14px ;
    }
    a {
      color: #0073aa;
    }
    a:hover,
    a:active {
      color: #006799;
    }
    a:focus {
      color: #124964;
      -webkit-box-shadow:
        0 0 0 1px #5b9dd9,
        0 0 2px 1px rgba(30, 140, 190, 0.8);
      box-shadow:
        0 0 0 1px #5b9dd9,
        0 0 2px 1px rgba(30, 140, 190, 0.8);
      outline: none;
    }
    .button {
      background: #f7f7f7;
      border: 1px solid #ccc;
      color: #555;
      display: inline-block;
      text-decoration: none;
      font-size: 13px;
      line-height: 2;
      height: 28px;
      margin: 0;
      padding: 0 10px 1px;
      cursor: pointer;
      -webkit-border-radius: 3px;
      -webkit-appearance: none;
      border-radius: 3px;
      white-space: nowrap;
      -webkit-box-sizing: border-box;
      -moz-box-sizing:    border-box;
      box-sizing:         border-box;

      -webkit-box-shadow: 0 1px 0 #ccc;
      box-shadow: 0 1px 0 #ccc;
      vertical-align: top;
    }

    .button.button-large {
      height: 30px;
      line-height: 2.15384615;
      padding: 0 12px 2px;
    }

    .button:hover,
    .button:focus {
      background: #fafafa;
      border-color: #999;
      color: #23282d;
    }

    .button:focus {
      border-color: #5b9dd9;
      -webkit-box-shadow: 0 0 3px rgba(0, 115, 170, 0.8);
      box-shadow: 0 0 3px rgba(0, 115, 170, 0.8);
      outline: none;
    }

    .button:active {
      background: #eee;
      border-color: #999;
      -webkit-box-shadow: inset 0 2px 5px -3px rgba(0, 0, 0, 0.5);
      box-shadow: inset 0 2px 5px -3px rgba(0, 0, 0, 0.5);
    }

      </style>
</head>
<body id="error-page">
  <div class="wp-die-message"><p><b>Proxy or VPN detected </b><br> Please disable your VPN to '.$proxycheck_name.' website and use valid IP :)<br><br>If you believe that you are seeing this message in error please <a href="mailto:'.$proxycheck_emai.'" target="_blank">contact to admin</a></p></div>
<p><a href="javascript:history.back()">&laquo; Back</a></p></body>
</html>';
  exit();
}
