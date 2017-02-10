<?php 
require 'PHPMailer/PHPMailerAutoload.php';

// update_admin_about_generated_code
function getCode() {
  $servername = "localhost";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $code_generated = 0;

  $stmt = $conn->prepare("SELECT * FROM friend_referral WHERE code_generated = ?");
  $stmt->bindParam(1, $code_generated);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  return $result;
}

function updateGeneratedCodeStatus($id) {
  $servername = "localhost";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $code_generated = true;

  // prepare sql and bind parameters  
  $stmt = $conn->prepare("UPDATE friend_referral SET code_generated=:code_generated WHERE id = :id");
  $stmt->bindParam(':code_generated', $code_generated);
  $stmt->bindParam(':id', $id);

  $stmt->execute();

  $conn = null;
}

function sendEmail($codes) {
  $mail = new PHPMailer;

  $mail->setFrom('info@kindredtea.com', 'Kindred Tea');
  $mail->addAddress('zaw@manic.com.sg', 'Kindred Tea Admin');     // Add a recipient
  $mail->addReplyTo('info@kindredtea.com', 'Kindred Tea');

  $mail->isHTML(true);                                  // Set email format to HTML

  $mail->Subject = "To Generate discount code at Kindred Tea Admin Panel";
  $mail->Body    = "Hi, <br><br>Please generate the following discount codes: <br><br> ".$codes;
  $mail->AltBody = '';

  if(!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
      return false;
  } else {
      return true;
  }
}

$result = getCode();
$codes = '';

if(count($result) > 0) {
  foreach ($result as $key => $value) {
    $codes .= $value['discount_code'] . '<br>';
    updateGeneratedCodeStatus($value['id']);
  }

  sendEmail($codes);
}
?>