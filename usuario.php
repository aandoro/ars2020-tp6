<?php

include 'call_api.php';

class Usuario
{
    var $nombre;
    var $apellido;

    function get_all()
    {
        $get_data = callAPI('GET', 'http://localhost:3000/usuario', false);
        $response = json_decode($get_data, true);
        if ($response['error'] == true) {
            return $response['mensaje'];
        }
        $data = $response['response']['data'][0];

        return $data;
    }

    function save($usuario_nuevo)
    {
        $make_call = callAPI('POST', 'http://localhost:3000/usuario', json_encode($usuario_nuevo));
        $response = json_decode($make_call, true);
        if ($response['error'] == true) {
            return $response['mensaje'];
        }
        $data     = $response['response']['data'][0];
        return $data;
    }

    function update($usuario_actualizar)
    {
        $update_plan = callAPI('PUT', 'http://localhost:3000/usuario', json_encode($usuario_actualizar));
        $response = json_decode($update_plan, true);
        if ($response['error'] == true) {
            return $response['mensaje'];
        }
        $data = $response['response']['data'][0];
    }

    function delete($usuario_borrar)
    {
        $delete_plan = callAPI('DELETE', 'http://localhost:3000/usuario', json_encode($usuario_borrar));
        $response = json_decode($delete_plan, true);
        if ($response['error'] == true) {
            return $response['mensaje'];
        }
    }
}
