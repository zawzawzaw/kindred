<?php
session_start();
$shop_name = 'kindred-teas';
$client_id = '23d744a08144e3e5c97b876eede866a9';
$client_secret = 'c519232ccfe83b192795e094ba0063d3';
$code = (isset($_GET['code'])) ? $_GET['code'] : "";
$shop = (isset($_GET['shop'])) ? $_GET['shop'] : "";
$hmac = (isset($_GET['hmac'])) ? $_GET['hmac'] : "";
$state = (isset($_GET['state'])) ? $_GET['state'] : "";
$email = (isset($_GET['email'])) ? $_GET['email'] : "";

// if coming back from redirection
if(!empty($code) && isset($_SESSION['email'])) $email = $_SESSION['email'];

$access_token = "";

// if($state!==$_SESSION['nonce']) {
//   echo "Failed.";
//   exit();
// }

function curlPostJson($url, $fields, $headr) {
  $fields_string = '';

  //url-ify the data for the POST
  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  rtrim($fields_string, '&');

  $ch = curl_init( );    

  curl_setopt( $ch, CURLOPT_URL, $url );
  // curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt( $ch, CURLOPT_POST, true );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_string );  
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $headr );
  
  $res = curl_exec($ch);
  curl_close($ch);

  return $res;
}

function curlPost($url, $fields) {  

  $fields_string = '';

  //url-ify the data for the POST
  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  rtrim($fields_string, '&');

  //open connection
  $ch = curl_init();

  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, count($fields));
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  
  if($url !== 'https://kindredteas.com/account/login') {
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  }  

  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 

  //execute post
  $res = curl_exec($ch);

  //close connection
  curl_close($ch);

  return $res;
}

function curlGet($url, $headr) {
  $crl = curl_init();  

  curl_setopt($crl, CURLOPT_URL, $url);
  curl_setopt($crl, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);

  $rest = curl_exec($crl);

  curl_close($crl);

  return $rest;  
}

function getAccessToken($url, $fields) {  
  $res = curlPost($url, $fields);
  $response_arr = json_decode($res, true);  

  $access_token = $response_arr['access_token'];  

  return $access_token;
}

if(empty($access_token)) {

  if(empty($code)) {
    $_SESSION['email'] = $email;
    header("Location: http://clients.manic.com.sg/kindred/shopify_app");
  }

  $url = 'https://'.$shop_name.'.myshopify.com/admin/oauth/access_token';
  $fields = array(
    'client_id' => urlencode($client_id),
    'client_secret' => urlencode($client_secret),
    'code' => urlencode($code)
  );
  
  $access_token = getAccessToken($url, $fields);
  
}

function searchCustomerByEmail($url, $headr) {
  $rest = curlGet($url, $headr);
  $rest_arr = json_decode($rest, true);  

  return $rest_arr;
}

// echo $access_token;


# START API CALL
$url = 'https://'.$shop_name.'.myshopify.com/admin/customers/search.json?query='.$email;
$headr = array();
$headr[] = 'X-Shopify-Access-Token: '.$access_token;

$rest_arr = searchCustomerByEmail($url, $headr);

// print_r($rest_arr); exit();

# if found then login
if(count($rest_arr['customers']) > 0) {

  $login_url = 'https://kindredteas.com/account/login';
  $login_email = $email;
  $login_password = 'FB_PASS!'; // fixed password for fb login users

  header('Location: '.$login_url.'?email='.$login_email.'&password='.$login_password);

} else { # if not sign up as new customer

  $url = 'https://'.$shop_name.'.myshopify.com/admin/customers.json';
  $headr = array();
  $headr[] = 'X-Shopify-Access-Token: '.$access_token;

  $first_name = 'Steve';
  $last_name = 'Lastnameson';
  $phone = '+15142546011';
  $address1_address = '123 Oak St';
  $address1_city = 'Ottawa';
  $address1_province = 'ON';
  $address1_phone = '555-1212';
  $address1_zip = '123 ABC';
  $address1_last_name = 'Lastnameson';
  $address1_first_name = 'Mother';
  $address1_country = 'CA';

  $address_1 = [
    'address1' => $address1_address,
    'city' => $address1_city,
    'province' => $address1_province,
    'phone' => $address1_phone,
    'zip' => $address1_zip,
    'last_name' => $address1_last_name,
    'first_name' => $address1_first_name,
    'country' => $address1_country
  ];

  $addresses = array();
  $addresses[] = $address_1;

  $data = [
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email,
    'phone' => $phone,
    'verified_email' => true,
    'addresses' => $addresses
  ];

  $payload = array( "customer"=> $data );

  $headr = array();
  $headr[] = 'X-Shopify-Access-Token: '.$access_token;

  // $res = curlPostJson($url, $payload, $headr);
  $res = curlPostJson($url, $payload, $headr);

  $response_arr = json_decode($res, true); 

  print_r($response_arr);
}
?>