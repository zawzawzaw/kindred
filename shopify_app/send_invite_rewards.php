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

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, $inputs);
fclose($myfile);

$inputs = json_decode($inputs);

function findEmail($email) {
  $servername = "localhost";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->prepare("SELECT * FROM friend_referral WHERE friend_email = ? AND reward_sent = 0");
  $stmt->bindParam(1, $email);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  return $result;
}

function sendEmail($subject, $message, $email, $name) {
  $mail = new PHPMailer;

  $mail->setFrom('hello@kindredteas.com', 'Kindred Tea');
  $mail->addAddress($email, $name);     // Add a recipient
  $mail->addReplyTo('hello@kindredteas.com', 'Kindred Tea');

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

function updateStatus($data) {
  $servername = "localhost";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $reward_sent = true;

  // prepare sql and bind parameters  
  $stmt = $conn->prepare("UPDATE friend_referral SET reward_sent=:reward_sent WHERE id = :id");
  $stmt->bindParam(':reward_sent', $reward_sent);
  $stmt->bindParam(':id', $data['id']);

  $stmt->execute();

  $conn = null;
}

$data = findEmail($inputs->email);
if(count($data) > 0) {
  
  $data = end($data);

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
                                                        <h2>Hello '.$data['referrer_name'].'!</h2>
                                                        <p>Your friend '.$data['friend_name'].' has joined us and bought an item after your invitation. Thanks for your invitation and here is the discount coupon as a reward.</p>
                                                        <p>10% Discount code: '.$data['discount_code'].'</p>
                                                        <table class="row actions">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="actions__cell">
                                                                        <table class="link secondary-action-cell">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="link__cell"><a href="https://kindredteas.com" class="link__text">Visit our store</a></td>
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
  $message_2 = '<html>
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
                                                        <h2>Hello '.$data['friend_name'].'!</h2>
                                                        <p>Thank you for your first purchase. As you were referred by your friend '.$data['referrer_name'].', we are also giving discount code for you as a reward.</p>
                                                        <p>10% Discount code: '.$data['discount_code'].'</p>
                                                        <table class="row actions">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="actions__cell">
                                                                        <table class="link secondary-action-cell">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="link__cell"><a href="https://kindredteas.com" class="link__text">Visit our store</a></td>
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
  $subject = 'Reward for successful friend referral at Kindred Tea';

  sendEmail($subject, $message, $data['referrer_email'], $data['referrer_name']);
  sendEmail($subject, $message_2, $data['friend_email'], $data['friend_name']);
  updateStatus($data);
}

header("HTTP/1.1 200 OK");
?>