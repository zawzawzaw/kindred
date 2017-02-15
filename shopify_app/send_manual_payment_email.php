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




function get_bank_deposit_email($inputs){   // input is passed to this function

  $customer_name = $inputs->billing_address->first_name . ' ' . $inputs->billing_address->last_name;

  $message = '<html>
<head>
    <meta http-equiv="Content-Security-Policy" content="script-src \'none\'; style-src * \'unsafe-inline\'; default-src *;">
</head>
<body>
    <title>Your gift card is now available! </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="https://kindred-teas.myshopify.com/assets/notifications/styles.css">
    <style>
    .button__cell {
        background: #cca79b;
    }
    
    a,
    a:hover,
    a:active,
    a:visited {
        color: #cca79b;
    }
    </style>
    <table class="body">
        <tbody>
            <tr>
                <td>
                    <table class="header row">
                        <tbody>
                            <tr>
                                <td class="header__cell">
                                    <center>
                                        <table class="container">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <table class="row">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="shop-name__cell">
                                                                        <img src="https://cdn.shopify.com/s/files/1/1558/2721/email_settings/email-logo.png?138749194973076144" alt="Kindred Teas" width="120">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="row content">
                        <tbody>
                            <tr>
                                <td class="content__cell">
                                    <center>
                                        <table class="container">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h2>Hello '. $customer_name .'!</h2>
                                                        <p>Please click on the link below to complete your payment via bank deposit, internet banking or ATM transfers.</p>
                                                        <table class="row actions">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="actions__cell">
                                                                        <table class="link secondary-action-cell">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="link__cell"><a href="https://kindredteas.com/pages/bank-deposit" class="link__text">Proceed for payment</a></td>
                                                                                    <td class="link__cell">or</td>
                                                                                    <td class="link__cell"><a href="https://kindredteas.com/account" class="link__text">Login to your account</a></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="row footer">
                        <tbody>
                            <tr>
                                <td class="footer__cell">
                                    <center>
                                        <table class="container">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="disclaimer__subtext">If you have any questions, reply to this email or contact us at <a href="mailto:hello@kindredteas.com">hello@kindredteas.com</a></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <img src="https://cdn.shopify.com/s/assets/themes_support/notifications/spacer-33e666f8be758a80f13b842e18a51d065cf0c87d45a9b56c7a03d6a109b58669.png" class="spacer" height="1">
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>';

  return $message;
}


// copied from    send_invite_rewards.php
function sendEmail($subject, $message, $email, $name) {
  $mail = new PHPMailer;

  $mail->setFrom('hello@kindredteas.com', 'Kindred Teas');
  $mail->addAddress($email, $name);     // Add a recipient
  $mail->addReplyTo('hello@kindredteas.com', 'Kindred Teas');

  $mail->isHTML(true);                                  // Set email format to HTML

  $mail->Subject = $subject;
  $mail->Body    = $message;
  $mail->AltBody = '';

  if(!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
      return false;
  } else {
      return true;
  }
}





// if bank deposit

if ($inputs->payment_gateway_names && $inputs->payment_gateway_names[0] == "Bank Deposit") {

  $customer_name = $inputs->billing_address->first_name . ' ' . $inputs->billing_address->last_name;
  $customer_email = $inputs->email;
  
  $subject = 'Kindred Teas Bank Deposit Payment Details';
  $message = get_bank_deposit_email($inputs);


  // SEND EMAIL
  sendEmail($subject, $message, $customer_email, $customer_name);
  
}






header("HTTP/1.1 200 OK");
?>