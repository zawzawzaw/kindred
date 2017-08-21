<?php 
require 'PHPMailer/PHPMailerAutoload.php';

$referrer_email = (isset($_POST['referrer_email'])) ? $_POST['referrer_email'] : "";
$friend_email = (isset($_POST['friend_email'])) ? $_POST['friend_email'] : "";

// update_admin_about_generated_code
function getCode() {
  $servername = "localhost:3306";
  $username = "kindred_dbadmin";
  $password = "e8oQy#54";
  $dbname = "kindred";

  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $code_generated = 0;
  $reward_sent = 1;

  if(!empty($referrer_email) && !empty($friend_email)) {
    $stmt = $conn->prepare("SELECT * FROM friend_referral WHERE friend_email = ? AND referrer_email = ? AND code_generated = ? AND reward_sent = ?");
    $stmt->bindParam(1, $friend_email);
    $stmt->bindParam(2, $referrer_email);
    $stmt->bindParam(3, $code_generated);
    $stmt->bindParam(4, $reward_sent);
  }else {
    $stmt = $conn->prepare("SELECT * FROM friend_referral WHERE code_generated = ? AND reward_sent = ?");
    $stmt->bindParam(1, $code_generated);
    $stmt->bindParam(2, $reward_sent);
    $stmt->execute();
  }

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  return $result;
}

function updateGeneratedCodeStatus($id) {
  $servername = "localhost:3306";
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

// print_r($result); exit();

if(count($result) > 0) {
  foreach ($result as $key => $value) {
    $codes .= $value['discount_code'] . '<br>';
    updateGeneratedCodeStatus($value['id']);
  }

  sendEmail($codes);
}
?>