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

// $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
// fwrite($myfile, $inputs);
// fclose($myfile);

$inputs = json_decode($inputs);

function findEmail($email, $sent) {
  $servername = "localhost:3306";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->prepare("SELECT * FROM friend_referral WHERE friend_email = ? AND reward_sent = ?");
  $stmt->bindParam(1, $email);
  $stmt->bindParam(2, $sent);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  return $result;
}

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

function updateStatus($data) {
  $servername = "localhost:3306";
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

function notifyAdmin($data) {
  //extract data from the post
  //set POST variables
  $url = 'https://www.manic.com.sg/kindred/shopify_app/cron.php';
  $fields = array(
    'referrer_email' => urlencode($data['referrer_email']),
    'friend_email' => urlencode($data['friend_email'])
  );

  //url-ify the data for the POST
  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  rtrim($fields_string, '&');

  //open connection
  $ch = curl_init();

  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, count($fields));
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

  //execute post
  $result = curl_exec($ch);

  //close connection
  curl_close($ch);
}

$data = findEmail($inputs->email, 1);
// print_r(count($data));

if(count($data) <= 0) {

  $data = findEmail($inputs->email, 0);
  
  $data = reset($data);
  // print_r($data); exit();

  $message = '<html>
<head>
    <meta http-equiv="Content-Security-Policy" content="script-src \'none\'; style-src * \'unsafe-inline\'; default-src *;">
</head>
<body>
    <title>Reward for successful friend referral at Kindred Teas</title>
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
                                                                        <img src="https://cdn.shopify.com/s/files/1/1558/2721/email_settings/email-logo.png?138749194973076144" alt="Kindred Teas" width="100">
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
                                                        <p>Your friend, '.$data['friend_name'].', has made his/her first purchase with us at Kindred Teas.</p>
                                                        <p>To thank you for your invitation, we have sent you a 10% discount code to be used for your next purchase. This code can only be used one.</p>
                                                        <p>10% discount code: '.$data['discount_code'].'</p>

                                                        <table class="row actions">
                                                          <tr>              
                                                            <td class="actions__cell" style="font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif">
                                                                <table class="button main-action-cell" style="border-collapse: collapse; border-spacing: 0; float: left; margin-right: 15px">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="button__cell" style="background: #cca79b; border-radius: 4px; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif; text-align: center" align="center" bgcolor="#cca79b"><a href="https://kindredteas.com/account/login" class="button__text" style="color: #fff; display: block; font-size: 16px; padding: 20px 25px; text-decoration: none">Create an account</a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                              
                                                                <table class="link secondary-action-cell" style="border-collapse: collapse; border-spacing: 0; margin-top: 19px">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="link__cell" style="font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif"><a href="https://kindredteas.com" class="link__text" style="color: #cca79b; font-size: 16px; text-decoration: none;"><span class="or" style="color: #999; display: inline-block; font-size: 16px; margin-right: 10px">or</span> <span style="color: #cca79b!important; font-size: 16px; text-decoration: none">Visit our store</span></a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                          </tr>
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
                                                        <p>Thank you for making your first purchase at Kindred Teas via '.$data['referrer_name'].'\'s referral.</p><p>To reward you for your patronage, here is a 10% discount code to be used for your next transaction with us.</p><p>We hope to see you soon!</p>
                                                        <p>10% discount code: '.$data['discount_code'].'</p>
                                                        <table class="row actions">
                                                          <tr>              
                                                            <td class="actions__cell" style="font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif">
                                                                <table class="button main-action-cell" style="border-collapse: collapse; border-spacing: 0; float: left; margin-right: 15px">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="button__cell" style="background: #cca79b; border-radius: 4px; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif; text-align: center" align="center" bgcolor="#cca79b"><a href="https://kindredteas.com/account/login" class="button__text" style="color: #fff; display: block; font-size: 16px; padding: 20px 25px; text-decoration: none">Create an account</a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                              
                                                                <table class="link secondary-action-cell" style="border-collapse: collapse; border-spacing: 0; margin-top: 19px">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="link__cell" style="font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif"><a href="https://kindredteas.com" class="link__text" style="color: #cca79b; font-size: 16px; text-decoration: none;"><span class="or" style="color: #999; display: inline-block; font-size: 16px; margin-right: 10px">or</span> <span style="color: #cca79b!important; font-size: 16px; text-decoration: none">Visit our store</span></a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                          </tr>
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

  // $subject = 'Reward for successful friend referral at Kindred Teas';
  $subject = 'Reward for successful Friend Referral';

  // sendEmail($subject, $message, $data['referrer_email'], $data['referrer_name']);
  // sendEmail($subject, $message_2, $data['friend_email'], $data['friend_name']);
  // updateStatus($data);
  // notifyAdmin($data);
}

header("HTTP/1.1 200 OK");
?>