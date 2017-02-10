<?php
require 'PHPMailer/PHPMailerAutoload.php';

$inputs = file_get_contents('php://input');

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, $inputs);
fclose($myfile);

$inputs = json_decode($inputs);

function findEmail($email) {
  $servername = "localhost:3306";
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

  $mail->setFrom('info@kindredtea.com', 'Kindred Tea');
  $mail->addAddress($email, $name);     // Add a recipient
  $mail->addReplyTo('info@kindredtea.com', 'Kindred Tea');

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

$data = findEmail($inputs->email);
if(count($data) > 0) {
  
  $data = end($data);

  $message = 'Hi,<br><br>Your friend joined us and bought an item after your invitation. Here is the discount coupon as a reward.<br><br>10% Discount code: '.$data['discount_code'];
  $message_2 = 'Hi,<br><br>Your friend joined us and bought an item after your invitation. Here is the discount coupon as a reward.<br><br>10% Discount code: '.$data['discount_code'];
  $subject = 'Reward from Kindred Friend Referral';

  sendEmail($subject, $message, $data['referrer_email'], $data['referrer_name']);
  sendEmail($subject, $message_2, $data['friend_email'], $data['friend_name']);
  updateStatus($data);
}

header("HTTP/1.1 200 OK");
?>