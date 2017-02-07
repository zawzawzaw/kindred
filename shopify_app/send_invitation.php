<?php
require 'PHPMailerAutoload.php';

$data = array();
$data['salutation'] = $_POST['salutation'];
$data['from_name'] = $_POST['from_name'];
$data['from_email'] = $_POST['from_email'];
$data['to_name'] = $_POST['to_name'];
$data['to_email'] = $_POST['to_email'];
$data['message'] = $_POST['message'];

$data['discount_code'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);

function saveReferrals($data) {
  $servername = "localhost:3306";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // prepare sql and bind parameters  
  $stmt = $conn->prepare("INSERT INTO friend_referral ('referrer_name', 'referrer_email', 'friend_name', 'friend_email', 'discount_code') VALUES (:referrer_name, :referrer_email, :friend_name, :friend_email, :discount_code)");
  $stmt->bindParam(':referrer_name', $data['from_name']);
  $stmt->bindParam(':referrer_email', $data['from_email']);
  $stmt->bindParam(':friend_name', $data['friend_name']);
  $stmt->bindParam(':friend_email', $data['friend_email']);
  $stmt->bindParam(':discount_code', $data['discount_code']);

  $stmt->execute();

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
  $mail->addReplyTo('info@kindredtea.com', 'Kindred Tea');

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

saveReferrals($data);
return sendEmail($data);
?>