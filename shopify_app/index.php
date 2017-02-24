<?php 
$api_key = '23d744a08144e3e5c97b876eede866a9';
$scope = 'write_customers,read_customers';
$redirect_uri = 'http://www.manic.com.sg/kindred/shopify_app/callback.php';
$nonce = uniqid();

session_start();
$_SESSION["nonce"] = $nonce;

$option = 'per-user';

header('Location: https://kindred-teas.myshopify.com/admin/oauth/authorize?client_id='.$api_key.'&scope='.$scope.'&redirect_uri='.$redirect_uri.'&state='.$nonce);
?>