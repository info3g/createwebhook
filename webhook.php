<?php
require __DIR__.'/conf.php'; 
require __DIR__.'/vendor/autoload.php';
use phpish\shopify;
if(isset($_REQUEST['shop'])) {
	$shop = $_REQUEST['shop'];
} else {
	$shop = '';
}
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
//if($verified) {
  $dataarray[] = json_decode($wdata, true);
  $logPath = WEBHOOK_APP_URL."/".$shop."webhookLog.txt";
  $mode = (!file_exists($logPath)) ? 'w':'a';
  $logfile = fopen($logPath, $mode);
  fwrite($logfile, "\r\n". $data);
  fclose($logfile);
//} 
  
?>
