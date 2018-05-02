<?php
require __DIR__.'/conf.php'; 
require __DIR__.'/vendor/autoload.php';
use phpish\shopify;

function verify_webhook($data, $hmac_header) {
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SHARED_SECRET, true));
  if($hmac_header == $calculated_hmac) {
	  return true;
  }
}
$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);
error_log('Webhook verified: '.var_export($verified, true));
if($verified) {
  mail('samriti.3ginfo@gmail.com', 'Order Create' , 'message sent');
  mail('samriti.3ginfo@gmail.com', 'Order Data' , $data);
	$dataarray[] = json_decode($wdata, true);
} 
  
?>
