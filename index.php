<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<h1>welcome to my app</h1>";
require __DIR__.'/conf.php'; 
require __DIR__.'/vendor/autoload.php';
use phpish\shopify;
if(isset($_REQUEST['shop']))
{
  $webhook_url = $_REQUEST['shop']."/admin/webhooks.json";
  $webhook_data = array('webhook' =>
    array(
      'topic' => 'products/update',
      'address' => WP_SHOP_URL,
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
  print_r($curlResponse);
}
?>

