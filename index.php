<?php
include('usuario.php');

$m_user = new Usuario();
$msj_user = $m_user->get_all();

if (isset($_GET['get_user'])) {
    $msj_user = $m_user->get_all();
}

if (isset($_POST['create_user'])) {
    $msj_user = $m_user->save($_POST['nombre'], $_POST['apellido']);
}

if (isset($_POST['update_user'])) {
    $msj_user = $m_user->update($_POST['nombre'], $_POST['apellido']);
}

if (isset($_POST['delete_user'])) {
    $msj_user = $m_user->delete();
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
    <form action="." method="get">
        <button type="submit" name="get_user"> obtener usuario</button>
    </form>
    <br>
    <form action="." method="post">
        <input type="text" name="nombre" id=""><br><br>
        <input type="text" name="apellido" id=""><br><br>
        <button type="submit" name="create_user"> crear</button>
        <button type="submit" name="update_user"> actualizar</button>
        <button type="submit" name="delete_user"> borrar</button>
    </form>

    <strong>
        <p> Mensaje:
            <?php if ($msj_user['error']) {
                echo $msj_user['mensaje'];
            } else {
                if ($msj_user['respuesta']['nombre'] != null)
                    echo $msj_user['respuesta']['nombre'] . ' ' . $msj_user['respuesta']['apellido'];
                else
                    echo $msj_user['mensaje'];
            } ?>
        </p>
    </strong>



</body>

</html>