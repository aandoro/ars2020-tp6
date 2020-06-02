<?php
include('usuario.php');


$m_user = new Usuario();
$msj_get_user = $m_user->get_all();

$new_user = $_POST['create_user'];
$update_user = $_POST['update_user'];
$msj_new_user = '';
$b_n_user = new Usuario();


if (isset($new_user)) {
    $b_n_user->$nombre = $_POST['nombre'];
    $b_n_user->$apellido = $_POST['apellido'];
    $msj_new_user = $m_user->save($b_n_user);
    $msj_get_user = '';
    $msj_update_user = '';
}

if (isset($update_user)) {
    $b_n_user->$nombre = $_POST['nombre'];
    $b_n_user->$apellido = $_POST['apellido'];
    $msj_update_user = $m_user->update($b_n_user);
    $msj_get_user = '';
    $msj_new_user = '';
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
    <form action="index.php" method="post">
        <input type="text" name="nombre" id=""><br><br>
        <input type="text" name="apellido" id=""><br>
        <button type="submit" name="create_user"> crear</button>
        <button type="submit" name="update_user"> actualizar</button>
        <button type="submit" name="delete_user"> borrar</button>
    </form>

    <strong>
        <p><?php echo $msj_get_user ?></p>
    </strong>

    <strong>
        <p><?php echo $msj_new_user ?></p>
    </strong>

    <strong>
        <p><?php echo $msj_update_user ?></p>
    </strong>

</body>

</html>