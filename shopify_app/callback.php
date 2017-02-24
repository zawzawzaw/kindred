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
$first_name = (isset($_GET['first_name'])) ? $_GET['first_name'] : "";
$last_name = (isset($_GET['last_name'])) ? $_GET['last_name'] : "";
$gender = (isset($_GET['gender'])) ? $_GET['gender'] : "";
$birthday = (isset($_GET['birthday'])) ? $_GET['birthday'] : "";

// if coming back from redirection
if(!empty($code) && isset($_SESSION['email'])) $email = $_SESSION['email'];
if(!empty($code) && isset($_SESSION['first_name'])) $first_name = $_SESSION['first_name'];
if(!empty($code) && isset($_SESSION['last_name'])) $last_name = $_SESSION['last_name'];
if(!empty($code) && isset($_SESSION['gender'])) $gender = $_SESSION['gender'];
if(!empty($code) && isset($_SESSION['birthday'])) $birthday = $_SESSION['birthday'];

$access_token = "";

function retrieveStoredAccessToken() {
  $servername = "localhost";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT token FROM access_token WHERE DATE(expiry_date) > DATE(NOW())"); 
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $last_token = end($result);

  if($last_token) $access_token = $last_token['token'];
  else $access_token = "";

  return $access_token;
}

$access_token = retrieveStoredAccessToken();

function curlPostJson($url, $payload, $headr) {

  $ch = curl_init( $url );  
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
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

function saveAccessToken($access_token, $expiry_date) {
  $servername = "localhost";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";


  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // prepare sql and bind parameters  
  $stmt = $conn->prepare("UPDATE access_token SET token=:token, expiry_date=DATE_ADD( NOW(), INTERVAL 24 HOUR ) WHERE id = 1");
  $stmt->bindParam(':token', $token);

  $token = $access_token;
  $stmt->execute();

  $conn = null;

}

function getAccessToken($url, $fields) {  
  $res = curlPost($url, $fields);
  $response_arr = json_decode($res, true);

  return $response_arr;
}

if(empty($access_token)) {

  if(empty($code)) {
    $_SESSION['email'] = $email;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['gender'] = $gender;
    $_SESSION['birthday'] = $birthday;
    header("Location: http://www.manic.com.sg/kindred/shopify_app");
  }

  $url = 'https://'.$shop_name.'.myshopify.com/admin/oauth/access_token';
  $fields = array(
    'client_id' => urlencode($client_id),
    'client_secret' => urlencode($client_secret),
    'code' => urlencode($code)
  );
  
  $response_arr = getAccessToken($url, $fields);

  $access_token = $response_arr['access_token'];
  // $expiry_date = $response_arr['expires_in'];
  $expiry_date = "";

  saveAccessToken($access_token, $expiry_date);
  
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

  if($gender=='male') $salutation = "Mr";
  else $salutation = "Ms";

  $metafields = array();  

  $metafield = array(
    'key' => 'salutation',
    'value' => $salutation,
    'value_type' => 'string',
    'namespace' => 'global'
  );

  $metafield_2 = array(
    'key' => 'birthday',
    'value' => $birthday,
    'value_type' => 'string',
    'namespace' => 'global'
  );

  $metafields[] = $metafield;
  $metafields[] = $metafield_2;

  $data = array(
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email,
    'verified_email' => true,
    "password" => "FB_PASS!",
    "password_confirmation" => "FB_PASS!",
    "send_email_welcome" => true,
    "metafields" => $metafields
  );

  $payload = array( "customer"=> $data );

  $payload = json_encode($payload);

  // print_r($payload); exit();

  $headr = array();
  $headr[] = 'X-Shopify-Access-Token: '.$access_token;
  $headr[] = 'Accept: application/json';
  $headr[] = 'Accept-Encoding: gzip, deflate';
  $headr[] = 'Content-Type: application/json';
  $headr[] = 'Accept-Language: en-us';

  // $res = curlPostJson($url, $payload, $headr);
  $res = curlPostJson($url, $payload, $headr);

  $response_arr = json_decode($res, true);

  // print_r($response_arr);

  $login_url = 'https://kindredteas.com/account/login';

  if(isset($response_arr['customer']) && count($response_arr['customer']) > 0) {    
    header('Location: '.$login_url.'?email='.$email.'&password=FB_PASS!');
  }else {
    echo "Failed to login please try again. You will be redirect back to login page in 5 secs";
    header('Refresh: 5;url='.$login_url);
  }
}
?>