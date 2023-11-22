<?php
// print_r($_POST);
include 'config/functions.php';
$environment = $_POST["environment"];
$merchantId = $_POST["merchantId"];
$user = $_POST["user"];
$password = $_POST["password"];
$amount = $_POST["amount"];
$currency = $_POST["currency"];
$countable = $_POST["countable"];
$purchaseNumber = $_POST["purchaseNumber"];
$cardHolderName = $_POST["cardHolderName"];
$cardHolderLastName = $_POST["cardHolderLastName"];
$cardHolderEmail = $_POST["cardHolderEmail"];

$tokenResponse = generateToken($environment, $user, $password);
$sesionResponse = generateSesion($environment, $amount, $tokenResponse['response'], $merchantId);

setcookie("environment", $environment);
setcookie("merchantId", $merchantId);
setcookie("token", $tokenResponse['response']);
setcookie("currency", $currency);
setcookie("countable", $countable);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Botón de Pago Web</title>
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
</style>



<body>

  <br>

  <div class="container-fluid">
    <div class="row">

      <div class="col-md-12">
        <div class="form-group">
          <div class="row align-items-center">
            <div class="col-2 col-md-1">
              <label  class="text-white"><b>API SEGURIDAD:</b></label>
            </div>
            <div class="col-9 col-md-11">
              <input type="text"  name="" id="" class="form-control transparent-input" value="<?php echo $tokenResponse['url'] ?>" disabled>
            </div>
          </div>
        </div>
        <div class="form-group mt-2">
          <b> <label  class="label-white">RESPONSE</label></b>
          <textarea name="" id="" cols="30" rows="4" class="form-control transparent-textarea" disabled><?php echo $tokenResponse['response']; ?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12">


    <div class="form-group">
      <div class="row align-items-center">
        <div class="col-2 col-md-1">
          <label  class="label-white"><b>API SESIÓN:</b></label>
        </div>
        <div class="col-9 col-md-11">
          <input type="text" name="" id="" class="form-control transparent-input" value="<?php echo $sesionResponse['url'] ?>" disabled>
        </div>

        <div class="col-md-6">
          <div class="form-group mt-2">
            <b> <label class="label-white">REQUEST</label></b>
            <textarea name="" id="" cols="30" rows="5" class="form-control transparent-textarea" disabled><?php echo json_encode(json_decode($sesionResponse['request']), JSON_PRETTY_PRINT); ?></textarea>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group mt-2">
            <b> <label class="label-white">RESPONSE</label></b>
            <textarea name="" id="" cols="30" rows="5" class="form-control transparent-textarea" disabled><?php echo json_encode($sesionResponse['response'], JSON_PRETTY_PRINT); ?></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <img src="../botondepagobrando/imagen/logodeniubiz.png" height="50">        
  </div>
  <div class="col-md-6">
  
    <input type="checkbox" name="ckbTerms" id="ckbTerms" onclick="visaNetEc3()">
    <label for="ckbTerms" class="label-white">Acepto los <b><a href="#" target="_blank">Términos y condiciones</a></b></label>   /
    <form method="post" id="frmVisaNet" action="<?php echo BASE_PROJECT_URL; ?>finalizar.php?amount=<?php echo urlencode($amount); ?>&purchaseNumber=<?php echo urlencode($purchaseNumber); ?>&cardHolderName=<?php echo urlencode($cardHolderName); ?>&cardHolderLastName=<?php echo urlencode($cardHolderLastName); ?>" style="display:none;">
    <!-- echo urlencode($amount) ; ?>    -->
    
    <script src="<?php echo getJsUrl($environment) ?>" 
      data-sessiontoken="<?php echo $sesionResponse['response']->sessionKey; ?>" 
      data-channel="web" 
      data-merchantid="<?php echo $merchantId ?>" 
      data-merchantlogo="<?php echo BASE_PROJECT_URL; ?>assets/img/logo27.png"
      data-purchasenumber="<?php echo $purchaseNumber; ?>" 
      data-amount="<?php echo $amount; ?>" 
      data-expirationminutes="5" 
      data-formbuttoncolor="#F4ED2A"
      data-timeouturl="<?php echo BASE_PROJECT_URL; ?>" 
      data-cardholdername="<?php echo $cardHolderName; ?>" 
      data-cardholderlastname="<?php echo $cardHolderLastName; ?>" 
      data-cardholderemail="<?php echo $cardHolderEmail; ?>" 
      data-usertoken="<?php echo $cardHolderEmail; ?>"
      >

      </script>
      <!--data-hidexbutton="true"-->



<!-- data-buttonsize="echo $_POST['buttonSize']; ?>" 
      data-buttoncolor=" echo $_POST['buttoncolor']; ?>" 
      data-formbuttoncolor=" echo $_POST['formButtonColor']; ?>" 
      data-showamount=" echo $_POST['showAmount']; ?>" 
      data-hidexbutton="FALSE" 
      data-usertoken=" echo $_POST['userToken']; ?>"> -->
    </form>
  </div>
  
  <script>
    function visaNetEc3() {
      const checkbox = document.getElementById("ckbTerms");
      const form = document.getElementById("frmVisaNet");
      if (checkbox.checked) {
        form.style.display = "block";
      } else {
        form.style.display = "none";
      }
    }
  </script>

  </div>
  <br>
</body>
<!-- <script src="assets/js/script.js"></script> -->

</html>