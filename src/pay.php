<?php
/**
 * Add this script to the page used to request for payments
**/ 

if(!$_SERVER['REQUEST_METHOD'] == 'POST'){  
    die("No data found.");
}

$data = [
    'api' => 'pay', //Calls the make payment API
    'customer_email'  => 'user@domain.com', //Customer email name@domain.etc from your POST DATA
    'amount'  => '5000', //Amount your customer is to pay in Naira
    'callback'  => 'https://i.demfati.com/pay/api/verify?t=',
    'description'  => '',
    'for'  => '',
    'vat'  => 'true', //true or false; default is set to true, if set to true Value Added Tax (vat) will be charged from your customers
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
    if($result["redirect"] === true){
        header("Location: https://i.demfati.com/pay/".$result["link"]);
    }else{
        echo print_r($result);
    }
}




