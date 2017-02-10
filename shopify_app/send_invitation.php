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
  $servername = "localhost";
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

  $mail->setFrom($data['from_email'], $data['from_name']);
  $mail->addAddress($data['to_email'], $data['to_name']);     // Add a recipient
  $mail->addReplyTo('no-reply@kindredtea.com', 'Kindred Tea');

  $mail->isHTML(true);                                  // Set email format to HTML

  $mail->Subject = 'Your friend '.$data['from_name']. 'invites you to try Kindred Tea!';
  $mail->Body    = 'Hi,<br><br>You are invited to Kindred Tea by your friend. You and your friend will receive 10% discount code after you make first purchase at Kindred Tea.';
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
  $servername = "localhost";
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
$data['from_email'] = $_POST['from_email'];
$data['to_name'] = $_POST['to_name'];
$data['to_email'] = $_POST['to_email'];
$data['message'] = $_POST['message'];

// to check if to_email already has an account

$result = checkIfAlreadyInvited($data['from_email'], $data['to_email']);

$invited_email = array();

if(count($result) == 0) {
  saveReferrals($data);
  sendEmail($data);
} else {
  $invited_email[] = $data['to_email'];
}

for($i=2; $i <= $to_count; $i++) {
  
  if(!empty($_POST['to_name_'.$i]) && !empty($_POST['to_email_'.$i])) {
    $data['to_name'] = $_POST['to_name_'.$i];
    $data['to_email'] = $_POST['to_email_'.$i];

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

  echo "The following emails were already invited: ".$invited_emails.".";
}else {
  echo "Successfully invited.";
}
?>