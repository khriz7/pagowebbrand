<?php

$user = $_POST['user'];
$password = $_POST['password'];
$merchant = $_POST['merchant'];
$purchase = $_POST['purchaseNumber'];




// Función para generar el token utilizando los valores del usuario y contraseña
function generateToken($user, $password) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://apitestenv.vnforapps.com/api.security/v1/security',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            'Authorization: ' . 'Basic ' . base64_encode($user . ":" . $password)
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    
    return $response;
}

// Llamar a la función para generar el token
$tokenResponse = generateToken($user, $password);
// Imprimir la respuesta del token
//echo "Respuesta del token:<br>";
//echo $tokenResponse;

$curl = curl_init(); // Inicializa una nueva instancia de cURL aquí

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apitestenv.vnforapps.com/api.authorization/v3/retrieve/purchase/$merchant/$purchase",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        "Authorization: $tokenResponse"
    ),
));

$response = curl_exec($curl);

curl_close($curl);

// Decodificar la respuesta JSON y formatearla
$formattedResponse = json_encode(json_decode($response), JSON_PRETTY_PRINT);

echo "Respuesta Consulta:<br>";
echo "<pre>$formattedResponse</pre>";


?>

