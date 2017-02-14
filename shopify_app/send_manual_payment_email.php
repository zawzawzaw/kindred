<?php
$http_origin = $_SERVER['HTTP_ORIGIN'];

$allowed_domains = array(
  'https://kindredteas.com',
  'http://kindredteas.com',
);

if (in_array($http_origin, $allowed_domains))
{  
    header("Access-Control-Allow-Origin: $http_origin");
}

require 'PHPMailer/PHPMailerAutoload.php';

$inputs = file_get_contents('php://input');

/*
// DEBUG CONTENTS
$debug_file = fopen("manual_payment.txt", "w") or die("Unable to open file!");
fwrite($debug_file, $inputs);
fclose($debug_file);
*/

$inputs = json_decode($inputs);


// if bank deposit

if ($inputs->payment_gateway_names && $inputs->payment_gateway_names[0] == "Bank Deposit") {

  $customer_name = $inputs->billing_address->first_name . ' ' . $inputs->billing_address->last_name;
  $customer_email = $inputs->email;
  
  // SEND EMAIL

  $mail = new PHPMailer;

  $mail->setFrom('no-reply@kindredtea.com', 'Kindred Tea');
  $mail->addAddress($customer_email, $customer_name);     // Add a recipient
  $mail->addReplyTo('no-reply@kindredtea.com', 'Kindred Tea');

  $mail->isHTML(true);                                  // Set email format to HTML
  
  $mail->Subject = 'Kindred Tea Bank Details';
  $mail->Body    = 'This is the bank deposit details for your kindred order: ';
  $mail->AltBody = '';

  if(!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
      return false;
  } else {
      return true;
  }
  
}






header("HTTP/1.1 200 OK");
?>