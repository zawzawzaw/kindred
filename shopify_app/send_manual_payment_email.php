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

  $message = '<!DOCTYPE html>
<html lang="en">

<head>
  <title>Reset your password</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">  
  <link rel="stylesheet" type="text/css" href="https://kindred-teas.myshopify.com/assets/notifications/styles.css">
</head>

  <body style="margin: 0">
    <style type="text/css">
      body{margin:0}.body{height:100% !important;width:100% !important}.row{width:100%}.container{width:560px;text-align:left;margin:0 auto}
      @media (max-width: 600px){.container{width:94% !important}}table{border-spacing:0;border-collapse:collapse}td{font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif}h1,h2,h3,h4,h5,h6{font-weight:normal;margin:0}h1,h1 a,h1 a:hover,h1 a:active,h1 a:visited{font-size:30px;color:#333}h2{font-size:24px;margin-bottom:10px}h3{font-size:20px;margin-bottom:25px}h4{font-size:16px;font-weight:500;color:#555;margin-bottom:5px}p{margin:0;color:#777;line-height:150%}p+p{margin-top:15px}span,strong,del,a,p{font-size:16px}strong{color:#555}small{font-size:14px;color:#999}a,a:hover,a:active,a:visited{text-decoration:none}.actions{margin-top:20px}.main-action-cell{float:left;margin-right:15px}
      @media (max-width: 600px){.main-action-cell{float:none !important;margin-right:0 !important}}.secondary-action-cell{margin-top:19px}
      @media (max-width: 600px){.secondary-action-cell{text-align:center;width:100%}}.section{border-top:1px solid #e5e5e5}.section__cell{padding:40px 0}.content__cell{padding-bottom:40px}.text-icon-row td{padding-bottom:5px}.text-icon{padding-right:8px}.text-icon__image{width:18px;height:18px;display:inline-block;vertical-align:middle}.header{margin:40px 0 20px}
      @media (max-width: 600px){.header{margin-top:20px !important;margin-bottom:2px !important}}
      @media (max-width: 600px){.shop-name__cell{display:block}}.order-number__cell{text-transform:uppercase;font-size:14px;text-align:right;color:#999}
      @media (max-width: 600px){.order-number__cell{display:block;text-align:left !important;margin-top:20px}}
      @media (max-width: 600px){.button{width:100%}}.button__cell{text-align:center;border-radius:4px}.button__text{display:block;padding:20px 25px}.button__text,.button__text:hover,.button__text:active,.button__text:visited{color:#fff;text-decoration:none}.or{color:#999;display:inline-block;margin-right:10px}
      @media (max-width: 600px){.or{margin-right:0 !important}}.apple-wallet-button{display:block;margin-top:15px}
      @media (max-width: 600px){.apple-wallet-button{text-align:center}}.customer-info__item{padding-bottom:40px;width:50%}
      @media (max-width: 600px){.customer-info__item{display:block;width:100% !important}}.customer-info__item--last{padding-bottom:0}.customer-info__item-credit{height:24px;display:inline-block;margin-right:10px;margin-top:5px;margin-bottom:-6px}.footer{border-top:1px solid #e5e5e5}.footer__cell{padding:35px 0}.disclaimer__subtext{font-size:14px;color:#999}.disclaimer__subtext a{font-size:14px}.spacer{min-width:600px;height:0}
      @media (max-width: 600px){.spacer{display:none}}.order-list__item{width:100%}.order-list__item+.order-list__item{border-top:1px solid #e5e5e5}.order-list__item:not(:first-child) .order-list__item__cell{padding-top:15px}.order-list__item:not(:last-child) .order-list__item__cell{padding-bottom:15px}.order-list__product-image{margin-right:15px;border:1px solid #e5e5e5;border-radius:8px}.order-list__product-description-cell{width:100%}.order-list__item-title{font-weight:600;line-height:1.4;color:#555}.order-list__item-variant{color:#999;font-size:14px}.order-list__item-original-price{display:block;text-align:right;color:#999;font-size:14px}.order-list__item-price{font-weight:600;text-align:right;margin-left:15px;color:#555}.order-list__price-cell{white-space:nowrap}.subtotal-lines{margin-top:15px;border-top:1px solid #e5e5e5}.subtotal-table{margin-top:20px}.subtotal-line td{padding:5px 0}.subtotal-line__value{text-align:right}.subtotal-line__title p{line-height:1.2em}.subtotal-table--total{border-top:2px solid #e5e5e5}.subtotal-table--total td{padding:20px 0 0}.subtotal-table--total .subtotal-line__value strong{font-size:24px}.subtotal-table--payment-methods{border-top:1px solid #e5e5e5}.subtotal-table--payment-methods p,.subtotal-table--payment-methods strong{color:#999;font-size:14px}.subtotal-table__small-space{height:10px}.subtotal-table__line{border-bottom:1px solid #e5e5e5;height:1px;padding:0}.subtotal-spacer{width:40%}
      @media (max-width: 600px){.subtotal-spacer{display:none}}
      body {
        margin: 0;
      }
      h1 a:hover {
        font-size: 30px; color: #333;
      }
      h1 a:active {
        font-size: 30px; color: #333;
      }
      h1 a:visited {
        font-size: 30px; color: #333;
      }
      a:hover {
        text-decoration: none;
      }
      a:active {
        text-decoration: none;
      }
      a:visited {
        text-decoration: none;
      }
      .button__text:hover {
        color: #fff; text-decoration: none;
      }
      .button__text:active {
        color: #fff; text-decoration: none;
      }
      .button__text:visited {
        color: #fff; text-decoration: none;
      }
      a:hover {
        color: #cca79b;
      }
      a:active {
        color: #cca79b;
      }
      a:visited {
        color: #cca79b;
      }
      @media (max-width: 600px) {
        .container {
          width: 94% !important;
        }
        .main-action-cell {
          float: none !important; margin-right: 0 !important;
        }
        .secondary-action-cell {
          text-align: center; width: 100%;
        }
        .header {
          margin-top: 20px !important; margin-bottom: 2px !important;
        }
        .shop-name__cell {
          display: block;
        }
        .order-number__cell {
          display: block; text-align: left !important; margin-top: 20px;
        }
        .button {
          width: 100%;
        }
        .or {
          margin-right: 0 !important;
        }
        .apple-wallet-button {
          text-align: center;
        }
        .customer-info__item {
          display: block; width: 100% !important;
        }
        .spacer {
          display: none;
        }
        .subtotal-spacer {
          display: none;
        }
      }
    </style>



    <table class="body" style="border-collapse: collapse; border-spacing: 0; height: 100% !important; width: 100% !important">
      <tr>
        <td style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif">


          
<table class="header row" style="border-collapse: collapse; border-spacing: 0; margin: 40px 0 20px; width: 100%">
  <tr>
    <td class="header__cell" style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif">
      <center>

        <table class="container" style="border-collapse: collapse; border-spacing: 0; margin: 0 auto; text-align: left; width: 560px">
          <tr>
            <td style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif">

              <table class="row" style="border-collapse: collapse; border-spacing: 0; width: 100%">
                <tr>
                  <td class="shop-name__cell" style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif">
                    
                      <img src="https://cdn.shopify.com/s/files/1/1558/2721/email_settings/email-logo.png?15725933752412065483" alt="Kindred Teas" width="100">
                    
                  </td>

                </tr>
              </table>

            </td>
          </tr>
        </table>

      </center>
    </td>
  </tr>
</table>



<table class="row content" style="border-collapse: collapse; border-spacing: 0; width: 100%">
  <tr>
    <td class="content__cell" style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif; padding-bottom: 40px">
      <center>
        <table class="container" style="border-collapse: collapse; border-spacing: 0; margin: 0 auto; text-align: left; width: 560px">
          <tr>
            <td style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif">
              
            <h2 style="font-size: 24px; font-weight: normal; margin: 0 0 10px">Hello '. $customer_name .'!</h2>
            <p style="color: #777; font-size: 16px; line-height: 150%; margin: 0">Please click on the link below to complete your payment via internet banking or ATM transfers.</p>
            <table class="row actions" style="border-collapse: collapse; border-spacing: 0; margin-top: 20px; width: 100%">
              <tr>
                <td class="actions__cell" style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif">
                  <table class="button main-action-cell" style="border-collapse: collapse; border-spacing: 0; float: left; margin-right: 15px">
                    <tr>
                      <td class="button__cell" style="background: #cca79b; border-radius: 4px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif; text-align: center" align="center" bgcolor="#cca79b"><a href="https://kindredteas.com/pages/bank-deposit" class="button__text" style="color: #fff; display: block; font-size: 16px; padding: 20px 25px; text-decoration: none">Proceed with payment</a></td>
                    </tr>
                  </table>
                  
                <table class="link secondary-action-cell" style="border-collapse: collapse; border-spacing: 0; margin-top: 19px">
                  <tr>
                    <td class="link__cell" style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif"><a href="https://kindredteas.com/account" class="link__text" style="color: #cca79b; font-size: 16px; text-decoration: none"><span class="or" style="color: #999; display: inline-block; font-size: 16px; margin-right: 10px">or</span> Login to your account</a></td>
                  </tr>
                </table>


                </td>
              </tr>
            </table>

            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
</table>


<table class="row footer" style="border-collapse: collapse; border-spacing: 0; border-top-color: #e5e5e5; border-top-style: solid; border-top-width: 1px; width: 100%">
  <tr>
    <td class="footer__cell" style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif; padding: 35px 0">
      <center>
        <table class="container" style="border-collapse: collapse; border-spacing: 0; margin: 0 auto; text-align: left; width: 560px">
          <tr>
            <td style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif">
              <p class="disclaimer__subtext" style="color: #999; font-size: 14px; line-height: 150%; margin: 0">If you have any questions, reply to this email or contact us at <a href="mailto:hello@kindredteas.com" style="color: #cca79b; font-size: 14px; text-decoration: none">hello@kindredteas.com</a></p>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
</table>

<img src="https://cdn.shopify.com/s/assets/themes_support/notifications/spacer-33e666f8be758a80f13b842e18a51d065cf0c87d45a9b56c7a03d6a109b58669.png" class="spacer" height="1" style="height: 0; min-width: 600px">






        </td>
      </tr>
    </table>
  </body>
</html>';

 
 $message = quoted_printable_decode($message);

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

if ($inputs->payment_gateway_names && $inputs->payment_gateway_names[0] == "Bank Transfer") {

  $customer_name = $inputs->billing_address->first_name . ' ' . $inputs->billing_address->last_name;
  $customer_email = $inputs->email;
  
  // $subject = 'Kindred Teas Bank Transfer Payment Details';
  $subject = 'Bank Transfer Payment Details';
  $message = get_bank_deposit_email($inputs);


  // SEND EMAIL
  sendEmail($subject, $message, $customer_email, $customer_name);
  
}






header("HTTP/1.1 200 OK");
?>