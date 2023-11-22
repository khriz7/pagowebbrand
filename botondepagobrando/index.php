<?php
include 'config/functions.php';
$purchaseNumber = generatePurchaseNumber();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png"
        href="https://static.mercadonegro.pe/wp-content/uploads/2020/02/22214750/visanet-en-linea-usuario.jpeg">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- <script 
defer 
src="https://app.embed.im/snow.js"
></script> -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
    /* Your existing CSS styles for larger screens */
    * {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

   
    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

    </style>
    
</style>

</head>

<body>
    <form action="<?php echo BASE_PROJECT_URL; ?>boton.php" method="POST">
        <div class="content">
            <div class="container mt-3">

                <div class="card">
                    <div class="card-header">
                        <marquee behavior="scroll" direction="left">
                            Configuración general de Pago web - Botón de Pago 👨🏻‍💻
                        </marquee>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="environment" class="bold-label">Entorno (*)</label>
                                    <select name="environment" id="environment" class="form-control transparent-select"
                                        required class="bold-label">
                                        <option value="S">Sandbox</option>
                                        <option value="D">Dev</option>
                                        <option value="T" selected>Test</option>
                                        <option value="P">Producción</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="merchantId" class="bold-label">Código comercio (*)</label>
                                    <input type="text" name="merchantId" id="merchantId"
                                        class="form-control transparent-input" required value="522591303">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="user" class="bold-label">Usuario (*)</label>
                                    <input type="text" name="user" id="user" class="form-control transparent-input"
                                        required value="integraciones.visanet@necomplus.com">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="password" class="bold-label">Contraseña (*)</label>
                                    <input type="text" name="password" id="password"
                                        class="form-control transparent-input" required value="d5e7nk$M">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="currency" class="bold-label">Moneda (*)</label>
                                    <select name="currency" id="currency" class="form-control transparent-select"
                                        class="bold-label" required>
                                        <option value="PEN" selected>Soles</option>
                                        <option value="USD">Dólares</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="countable" class="bold-label">Liquidación (*)</label>
                                    <select name="countable" id="countable" class="form-control transparent-select"
                                        required>
                                        <option value="A" selected>Automática</option>
                                        <option value="M">Manual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="amount" class="bold-label">Importe (*)</label>
                                    <input type="number" name="amount" id="amount"
                                        class="form-control transparent-input" step=".01" required value="7.00">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="purchaseNumber" class="bold-label transparent-input">Número de pedido
                                        (*)</label>
                                    <input type="number" name="purchaseNumber" id="purchaseNumber"
                                        class="form-control transparent-input" required
                                        value="<?php echo $purchaseNumber; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cardHolderName" class="bold-label">Nombre</label>
                                    <input type="text" name="cardHolderName" id="cardHolderName"
                                        class="form-control transparent-input" value="Integraciones" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cardHolderLastName" class="bold-label">Apellido</label>
                                    <input type="text" name="cardHolderLastName" id="cardHolderLastName"
                                        class="form-control transparent-input" value="Brando" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cardHolderEmail" class="bold-label">Correo electrónico</label>
                                    <input type="text" name="cardHolderEmail" id="cardHolderEmail"
                                        class="form-control transparent-input" value="intebrand@necomplus.com">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="form-control transparent-button">Enviar 🫡</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <a href="consulta1.php" class="form-control transparent-button" target="blanck">Consulta 😁</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
    </form>
</body>

</html>