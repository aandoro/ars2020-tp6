<?php
include('usuario.php');


$m_user = new Usuario();

$msj_user = $m_user->get_all();

if (isset($_GET['get_users'])) {
    $msj_user = $m_user->get_all();
}

if (isset($_POST['get_user'])) {
    if (have_id($_POST['id'])) {
        $msj_user = $m_user->get_user($_POST['id']);
    } else {
        $msj_user = array('mensaje' => 'El id es obligatorio');
    }
}

if (isset($_POST['create_user'])) {
    $msj_user = $m_user->save($_POST['nombre'], $_POST['apellido']);
}

if (isset($_POST['update_user'])) {
    if (have_id($_POST['id'])) {
        $msj_user = $m_user->update($_POST['id'], $_POST['nombre'], $_POST['apellido']);
    } else {
        $msj_user = array('mensaje' => 'El id es obligatorio');
    }
}

if (isset($_POST['delete_user'])) {
    if (have_id($_POST['id'])) {
        $msj_user = $m_user->delete($_POST['id']);
    } else {
        $msj_user = array('mensaje' => 'El id es obligatorio');
    }
}

if (isset($_POST['log_out'])) {
    session_destroy();
    header("Location: ./index.php");
}

function have_id($id)
{
    if ($id == '') {
        return FALSE;
    }
    return TRUE;
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
    <form action="home.php" method="get">
        <button type="submit" name="get_users"> obtener usuarios</button>
    </form>
    <form action="home.php" method="post">
        <p>id: <input type="text" name="id"></p>
        <p>Nombre: <input type="text" name="nombre"></p>
        <p>Apellido: <input type="text" name="apellido"></p>
        <button type="submit" name="create_user"> crear</button>
        <button type="submit" name="update_user"> actualizar</button>
        <button type="submit" name="delete_user"> borrar</button>
        <button type="submit" name="get_user"> obtener un usuario</button><br><br>
        <button type="submit" name="log_out"> cerrar Sesion</button>
    </form>

    <strong>
        <p> Mensaje: <?php echo $msj_user['mensaje']; ?></p>
    </strong>

    <?php
    echo "<table>";
    echo  "<tr>";
    echo   "<th>id</th>";
    echo "<th>Nombre</th>";
    echo "<th>Apellido</th>";
    echo "</tr>";
    if (sizeof($msj_user['respuesta'][0]) == null) {
        echo "<tr>";
        echo "<th>" . $msj_user['respuesta']['id'] . "</th>";
        echo "<th>" . $msj_user['respuesta']['nombre'] . "</th>";
        echo "<th>" . $msj_user['respuesta']['apellido'] . "</th>";
        echo "</tr>";
    } else {

        for ($i = 0; $i < sizeof($msj_user['respuesta']); $i++) {
            echo "<tr>";
            echo "<th>" . $msj_user['respuesta'][$i]['id'] . "</th>";
            echo "<th>" . $msj_user['respuesta'][$i]['nombre'] . "</th>";
            echo "<th>" . $msj_user['respuesta'][$i]['apellido'] . "</th>";
            echo "</tr>";
        }
    }

    echo "</table>";

    ?>

</body>

</html>