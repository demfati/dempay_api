<?php
/**
 * Add this script to the page used to request for payments
**/ 

if(!$_SERVER['REQUEST_METHOD'] == 'POST'){  
    die("No data found.");
}

$data = [
    'api' => 'verify', //Calls the verify transaction API
    'reference'  => '', //Customer transaction reference; Either with $_POST[''], $_GET[''] or $variable
];

$url = 'https://i.demfati.com/pay/api/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$headers = array(
    "Accept: application/json",
    "Authorization: Bearer API_KEY", //Your registered Demfati Pay API KEY
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$request = curl_exec($ch);
curl_close($ch);
$result = array();

if ($request) {
    $result = json_decode($request, true);
    if(array_key_exists('data', $result) && array_key_exists('status', $result['data'])){
        echo $result["data"]["status"]; // The status of your transaction, Make use of this in your application
    }else{
        print_r($result); // Make use of the array available
    }
}




