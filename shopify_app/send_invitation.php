<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

function saveReferrals($data) {
  $servername = "localhost:3306";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $discount_code = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  try {
    // prepare sql and bind parameters  
    $stmt = $conn->prepare("INSERT INTO `friend_referral` (`salutation`, `referrer_name`, `referrer_email`, `friend_name`, `friend_email`, `discount_code`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $data['salutation']);
    $stmt->bindParam(2, $data['from_name']);
    $stmt->bindParam(3, $data['from_email']);
    $stmt->bindParam(4, $data['to_name']);
    $stmt->bindParam(5, $data['to_email']);
    $stmt->bindParam(6, $discount_code);
    $stmt->bindParam(7, $data['message']);

    $stmt->execute();
  } catch( PDOException $e ) { 
      /*
       * save the error to the error log defined as @ERROR_LOG
       */ 
      print_r($e->getMessage());
      die( "FATAL ERROR...Please check the error log." );
  }

  $conn = null;
}

function sendEmail($data) {
  $mail = new PHPMailer;

  //$mail->SMTPDebug = 3;                               // Enable verbose debug output

  // $mail->isSMTP();                                      // Set mailer to use SMTP
  // $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
  // $mail->SMTPAuth = true;                               // Enable SMTP authentication
  // $mail->Username = 'user@example.com';                 // SMTP username
  // $mail->Password = 'secret';                           // SMTP password
  // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
  // $mail->Port = 587;                                    // TCP port to connect to

  $mail->setFrom('hello@kindredteas.com', 'Kindred Teas');
  $mail->addAddress($data['to_email'], $data['to_name']);     // Add a recipient
  $mail->addReplyTo('hello@kindredteas.com', 'Kindred Teas');

  $mail->isHTML(true);                                  // Set email format to HTML

  // $mail->Subject = 'Your friend '.$data['from_name'].' invites you to try Kindred Teas!';
  $mail->Subject = 'Your friend, '.$data['from_name'].', has invited you to join us';

  $mail->Body    = '<html>
<head>
    <meta http-equiv="Content-Security-Policy" content="script-src \'none\'; style-src * \'unsafe-inline\'; default-src *;">
</head>
<body>
    <title>Your friend, '.$data['from_name'].', has invited you to join us</title>
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
                                <td class="header__cell" style="font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif">
                                    <center>
                                        <table class="container" style="border-collapse: collapse; border-spacing: 0; margin: 0 auto; text-align: left; width: 560px">
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
                                <td class="content__cell" style="font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif">
                                  <center>
                                    <table class="container" style="border-collapse: collapse; border-spacing: 0; margin: 0 auto; text-align: left; width: 560px">
                                        <tbody>
                                            <tr>
                                                <td style="padding-bottom: 10px;">
                                                    <h2 style="font-weight:normal;font-size:24px;margin:0 0 10px;">Sharing is caring!</h2>
                                                    <p style="color:#777;line-height:150%;font-size:16px;margin:0;">Your friend, '.$data['from_name'].', thinks you\'d love Kindred Teas as much as he / she does! We have created a selection of specially crafted teas that we hope you will enjoy just as much as we have enjoyed searching for them. </p>
                                                    <p style="color:#777;line-height:150%;font-size:16px;margin:0;">We look forward to seeing you!</p>
                                                </td>
                                            </tr>
                                            <tr>                                                                                                    
                                                <td>
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
                                <td class="footer__cell" style="font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif">
                                    <center>
                                        <table class="container" style="border-collapse: collapse; border-spacing: 0; margin: 0 auto; text-align: left; width: 560px">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="disclaimer__subtext">If you have any questions, reply to this email or contact us at <a href="mailto:hello@kindredteas.com" style="color: #cca79b!important; font-size: 16px; text-decoration: none">hello@kindredteas.com</a></p>
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
  $mail->AltBody = '';

  if(!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
      return false;
  } else {
      return true;
  }
}

function checkIfAlreadyInvited($referrer_email, $friend_email) {
  $servername = "localhost:3306";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $stmt = $conn->prepare("SELECT * FROM friend_referral WHERE friend_email = ? AND referrer_email = ?");
  $stmt->bindParam(1, $friend_email);
  $stmt->bindParam(2, $referrer_email);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  return $result;
}


$data = array();
$to_count = $_POST['to_count'];
$data['salutation'] = $_POST['salutation'];
$data['from_name'] = $_POST['from_name'];
$data['from_email'] = strtolower($_POST['from_email']);
$data['to_name'] = $_POST['to_name'];
$data['to_email'] = strtolower($_POST['to_email']);
$data['message'] = 'some message';

// to check if to_email already has an account

$result = checkIfAlreadyInvited($data['from_email'], $data['to_email']);

// print_r($result);

$invited_email = array();

if(count($result) == 0) {
  saveReferrals($data);
  sendEmail($data);
} else {
  $invited_email[] = $data['to_email'];
}

for($i=2; $i <= $to_count; $i++) {
  
  if(!empty($_POST['to_name_'.$i]) && !empty($_POST['to_email_'.$i]) && $_POST['to_name_'.$i] != "Name" && $_POST['to_email_'.$i] != "email address") {
    $data['to_name'] = $_POST['to_name_'.$i];
    $data['to_email'] = strtolower($_POST['to_email_'.$i]);

    $result = checkIfAlreadyInvited($data['from_email'], $data['to_email']);

    if(count($result) == 0) {      
      saveReferrals($data);
      sendEmail($data);
    }else {
      $invited_email[] = $data['to_email'];
    }

  }
}

if(count($invited_email) > 0) {
  $invited_emails = implode(", ", $invited_email);

  // echo "The following emails were already invited: ".$invited_emails.".";
  // header("Location: https://kindredteas.com/account?success=true&emails=".$invited_emails."#page-account-friend-referral-section");
  header("Location: https://kindredteas.com/account?success=true&emails=".$invited_emails."#friend-referral");
}else {
  // echo "Successfully invited.";
  // header("Location: https://kindredteas.com/account?success=true#page-account-friend-referral-section");
  header("Location: https://kindredteas.com/account?success=true#friend-referral");
}
?>