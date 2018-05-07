<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<h1>welcome to Webhook Auto Creation app</h1>";
require __DIR__.'/conf.php'; 
require __DIR__.'/vendor/autoload.php';
use phpish\shopify;

if(isset($_REQUEST['shop']) && isset($_REQUEST['code']))
{
  $access_token = shopify\access_token($_REQUEST['shop'], SHOPIFY_APP_API_KEY, SHOPIFY_APP_SHARED_SECRET, $_REQUEST['code']);
  $webhook_url = 'https://'.SHOPIFY_APP_API_KEY.':'.$access_token.'@'.$_REQUEST['shop'].'/admin/webhooks.json'; 
  $address = WEBHOOK_APP_URL.'/webhook.php?shop='.$_REQUEST['shop'];
  $webhook_data = array('webhook' =>
    array(
      'topic' => 'orders/create',
      'address' => $address,
      'format' => 'json'
    )
  );
  $webhookdata = json_encode($webhook_data);
  $ch = curl_init($webhook_url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $webhookdata);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Content-Length: ' . strlen($webhookdata)));
  $curlResponse = curl_exec($ch);
  curl_close($ch);
  echo 'Webhook Created/Updated Successfully!';
}
?>

