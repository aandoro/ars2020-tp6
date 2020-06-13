<?php
include('login.php');

$login = new Login();
$usuario_ing = $_POST['username'];
$clave_ing = $_POST['password'];
$msj = "";

if (isset($_POST['ing'])) {
    $msj = $login->login($usuario_ing, $clave_ing);
    header('home.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP6 ars2020</title>
</head>

<body>
    <h3>Inicio de sesion: </h3>
    <form action="index.php" method="post">
        <p>Ingrese usuario: </p>
        <input type="text" name="username" required>
        <p>Ingrese contraseña: </p>
        <input type="password" name="password" required>
        <br><br>
        <button type="submit" name="ing">Ingresar</button>
    </form>
    <br>
</body>

</html>