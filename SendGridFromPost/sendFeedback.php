<?php
require_once './sendgrid/sendgrid-php.php';

$comments = $_POST['comments'];
$contact = $_POST['contact'];
date_default_timezone_set("America/Denver");
$dateSent = date("Y-m-d");
$timeSent = date("h:i:s a");

$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

$email = new \SendGrid\Mail\Mail();
$email->setFrom("yourEmail@gmail.com", "Site Contact");
$email->setSubject("New Feedback");
$email->addTo("ToEmail@gmail.com", "To Contact");
$email->addContent("text/plain", "New feedback was left on {$dateSent} at {$timeSent} with contact {$contact}: {$comments}");
$email->addContent(
    "text/html", "<p>New feedback was left on {$dateSent} at {$timeSent} with contact {$contact}:</p><p>{$comments}</p>"
);

$sendgrid = new \SendGrid('Your Sendgrid key');

try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";

    header("Location: {$root}feedback.html");
exit();
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}

// todo: Clean up and extend try/catch
// todo: Handle errors better (ie, at all)
?>

