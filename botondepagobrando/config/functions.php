<?php
include 'config.inc.php';

function getBaseUrl($environment) {
  switch ($environment) {
    case 'S':
      return BASE_URL_SANDBOX;
      break;
    case 'D':
      return BASE_URL_DEV;
      break;
    case 'T':
      return BASE_URL_TEST;
      break;
    case 'P':
      return BASE_URL_PROD;
      break;
    default:
      return BASE_URL_TEST;
      break;
  }
}

function getJsUrl($environment) {
  switch ($environment) {
    case 'S':
      return URL_JS_SANDBOX;
      break;
    case 'D':
      return URL_JS_DEV;
      break;
    case 'T':
      return URL_JS_TEST;
      break;
    case 'P':
      return URL_JS_PROD;
      break;
    default:
      return URL_JS_TEST;
      break;
  }
}

function generateToken($environment, $user, $password) {
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => getBaseUrl($environment).URL_SECURITY,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      'Authorization: ' . 'Basic ' . base64_encode($user . ":" . $password)
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return array(
    "url" => getBaseUrl($environment).URL_SECURITY,
    "request" => "",
    "response" => $response
  );
}

function generateSesion($environment, $amount, $token, $merchantId) {
  $correo = $_POST['cardHolderEmail'];
  $url = getBaseUrl($environment).URL_SESSION.$merchantId;

  $response = file_get_contents("http://ip.jsontest.com/");
  $data = json_decode($response, true);
  $clientIp = $data['ip'];
  $session = array(
    'amount' => $amount,
    'antifraud' => array(
      'clientIp' => $clientIp,
      'merchantDefineData' => array(
        'MDD4' => $correo,
        'MDD21' => "0",
        'MDD32' => '75834714',
        'MDD75' => 'Registrado',
        'MDD77' => '7'
      ),
    ),
    'channel' => 'web',
  );

  $json = json_encode($session);
  $response = json_decode(postRequest($url, $json, $token));

  return array(
    "url" => $url,
    "request" => $json,
    "response" => $response
  );
}

function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token, $environment, $merchantId, $countable, $currency) {
  $url = getBaseUrl($environment).URL_AUTHORIZATION.$merchantId;
  $data = array(
    'antifraud' => null,
    'captureType' => 'manual',
    'channel' => 'web',
    'countable' => $countable == 'A' ? true : false,
    'order' => array(
      'amount' => $amount,
      'currency' => $currency,
      'purchaseNumber' => $purchaseNumber,
      'tokenId' => $transactionToken
    ),
    'recurrence' => null,
    'sponsored' => null
  );
  $json = json_encode($data);
  $response = json_decode(postRequest($url, $json, $token));
  return array(
    "url" => $url,
    "request" => $json,
    "response" => $response
  );
}

function postRequest($url, $postData, $token)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      'Authorization: ' . $token,
      'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => $postData
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}

function generatePurchaseNumber()
{
  $archivo = "assets/purchaseNumber.txt";
  $purchaseNumber = 1;
  $fp = fopen($archivo, "r");
  $purchaseNumber = fgets($fp, 10);
  fclose($fp);
  ++$purchaseNumber;
  $fp = fopen($archivo, "w+");
  fwrite($fp, $purchaseNumber, 10);
  fclose($fp);
  return $purchaseNumber;
}
