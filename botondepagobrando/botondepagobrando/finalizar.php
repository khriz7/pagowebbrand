<?php
include 'config/functions.php';
$cardHolderName = $_GET["cardHolderName"];
$cardHolderLastName = $_GET["cardHolderLastName"];
$transactionToken = $_POST["transactionToken"];
$email = $_POST["customerEmail"];
$channel = $_POST["channel"];
$amount = $_GET["amount"];
$purchaseNumber = $_GET["purchaseNumber"];
$url = '';

$token = $_COOKIE['token'];
$environment = $_COOKIE['environment'];
$merchantId = $_COOKIE['merchantId'];
$countable = $_COOKIE['countable'];
$currency = $_COOKIE['currency'];

if ($channel == 'web') {
  $authorizationResponse = generateAuthorization($amount, $purchaseNumber, $transactionToken, $token, $environment, $merchantId, $countable, $currency);
  $data = $authorizationResponse['response'];
} else if ($channel == 'pagoefectivo') {
  $url = $_POST["url"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Respuesta de pago</title>
  <script defer src="https://app.embed.im/snow.js"></script>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<style>
       body {
            background-color: #1A4795;
            font-family: Arial, sans-serif;
            width: 100%;
            box-sizing: border-box;
            margin: 0;
        }

        .container-fluid {
            padding: 20px;
        }

        .card {
            background-color: #242526;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #888888;
            padding: 20px;
            margin: 20px;
            font-family: Arial, sans-serif;
            color: #FFFFFF;
            font-size: 16px;
        }

        .transparent-input,
        .transparent-textarea {
            background-color: transparent !important;
            border: none;
            color: #FFFFFF !important;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .label-white {
            color: white !important;
        }

        @media (max-width: 768px) {
            .card {
                margin: 10px;
                padding: 10px;
            }

            .elemento {
                left: 0;
            }

            #toggle-theme {
                bottom: 70px;
            }

            .dark-mode {
                background-color: #F4ED2A !important;
            }
        }
</style>

<body>

  <br>

  <div class="container">
    <div class="row mt-3">
      <div class="col-md-4">
        <div class="form-group">
          <label for="transactionToken" class="label-white">
            <?php
            if ($url == '') {
              echo 'Transaction token';
            } else echo 'CIP';
            ?>
          </label>
          <input type="text" name="transactionToken" id="transactionToken" class="form-control transparent-input" value="<?php echo $transactionToken; ?>" disabled>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="channel" class="label-white">Channel</label>
          <input type="text" name="channel" id="channel" class="form-control transparent-input" value="<?php echo $channel; ?>" disabled>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="customerEmail" class="label-white">Customer Email</label>
          <input type="text" name="customerEmail" id="customerEmail" class="form-control transparent-input" value="<?php echo $email; ?>" disabled>
        </div>
      </div>
      <?php
      if ($url != '') {
        echo '
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="urlPagoEfectivo">URL PagoEfectivo</label>
                        <input type="text" name="urlPagoEfectivo" id="urlPagoEfectivo" class="form-control" value="' . $url . '" disabled>
                    </div>
                </div>
            ';
      }
      ?>
    </div>

    <?php
    if ($url == '') {
    ?>
      <div class="row mt-3 mb-3">
        <div class="col-md-12">
          <div class="form-group">
            <label for=""><b>API Autorización</b></label>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-white">Request</label>
                  <textarea name="" id="" cols="30" rows="15" class="form-control transparent-textarea" disabled><?php echo json_encode(json_decode($authorizationResponse['request']), JSON_PRETTY_PRINT); ?></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-white">Response</label>
                  <textarea name="" id="" cols="30" rows="15" class="form-control transparent-textarea" disabled><?php echo json_encode($authorizationResponse['response'], JSON_PRETTY_PRINT); ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr>
      <style>
        .custom-alert {
          background-color: #008000;
        }
      </style>
      <?php
      if (isset($data->dataMap)) {
        if ($data->dataMap->ACTION_CODE == "000") {
          $c = preg_split('//', $data->dataMap->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
      ?>
         

          <div class="row">
            <div class="col-md-12">
              <?php

              $mensaje = 'Estado: ' . $data->dataMap->ACTION_DESCRIPTION;
              $mensaje .= '\nNúmero de pedido: ' . $purchaseNumber;
              $mensaje .= '\nNombre y Apellido: ' . $cardHolderName . ' ' . $cardHolderLastName;
              $mensaje .= '\nFecha y hora del pedido: ' . $c[4] . $c[5] . "/" . $c[2] . $c[3] . "/" . $c[0] . $c[1] . " " . $c[6] . $c[7] . ":" . $c[8] . $c[9] . ":" . $c[10] . $c[11];;
              $mensaje .= '\nTarjeta: ' . $data->dataMap->CARD . " (" . $data->dataMap->BRAND . ")";
              $mensaje .= '\nImporte de la transacción: ' . number_format($data->order->amount, 2) . " " . $data->order->currency;
              $mensaje .= '\nDescripción de el /los productos: ' . "Producto de prueba de Niubiz";

              echo '<script>alert("' . $mensaje . '");</script>';
             
              ?>
            </div>
          </div>
        <?php
        }
      } else {
        $c = preg_split('//', $data->data->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
        ?>
        <!-- <div class="alert alert-danger" role="alert">
           echo $data->data->ACTION_DESCRIPTION; ?>
        </div> -->
        <?php

$mensaje = 'Estado: ' . $data->data->ACTION_DESCRIPTION;
$mensaje .= '\nNúmero de pedido: ' . $purchaseNumber;
$mensaje .= '\nFecha y hora del pedido: ' . $c[4] . $c[5] . "/" . $c[2] . $c[3] . "/" . $c[0] . $c[1] . " " . $c[6] . $c[7] . ":" . $c[8] . $c[9] . ":" . $c[10] . $c[11];;
$mensaje .= '\nDescripción de el /los productos: ' . "Producto de prueba de Niubiz";

echo '<script>alert("' . $mensaje . '");</script>';

?>
</div>
        <!-- <div class="row">
          <div class="col-md-12">
            <b>Número de pedido: </b> <?php echo $purchaseNumber; ?>
          </div>
          <div class="col-md-12">
            <b>Fecha y hora del pedido: </b> <?php echo $c[4] . $c[5] . "/" . $c[2] . $c[3] . "/" . $c[0] . $c[1] . " " . $c[6] . $c[7] . ":" . $c[8] . $c[9] . ":" . $c[10] . $c[11]; ?>
          </div>
          <div class="col-md-12">
            <b>Descripción de el /los productos: </b> <?php echo "Producto de prueba" ?>
          </div>
        </div> -->
      <?php
      }
      ?>
  </div>
<?php
    }
?>

<br>

<div class="container">
  <div class="row">
    <div class="col-sm-6 col-md-4 mb-2">
      <a href="<?php echo BASE_PROJECT_URL; ?>" class="btn btn-success btn-block">Inicio</a>
    </div>
    <div class="col-sm-6 col-md-4 mb-2">
      <a target="_blank" href="http://bdp.evirtuales.shop?purchase=<?php echo $purchaseNumber; ?>" class="btn btn-primary btn-block">API's Complementarias</a>
    </div>
  </div>
</div>

<br>
<br>

</body>

</html>