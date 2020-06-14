<?php

include('call_api.php');

class Usuario
{
    var $id;
    var $nombre;
    var $apellido;

    function get_all()
    {
        $get_data = callAPI('GET', 'http://localhost:3000/usuarios', false);
        $response = json_decode($get_data, true);
        return $response;
    }

    function get_user($id)
    {
        $get_data = callAPI('GET', 'http://localhost:3000/usuarios/' . $id, false);
        $response = json_decode($get_data, true);
        return $response;
    }

    function save($nombre, $apellido)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $make_call = callAPI('POST', 'http://localhost:3000/usuarios', json_encode($this));
        $response = json_decode($make_call, true);
        return $response;
    }

    function update($id, $nombre, $apellido)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $update_plan = callAPI('PUT', 'http://localhost:3000/usuarios/' . $id, json_encode($this));
        $response = json_decode($update_plan, true);
        return $response;
    }

    function delete($id)
    {
        $delete_plan = callAPI('DELETE', 'http://localhost:3000/usuarios/' . $id, false);
        $response = json_decode($delete_plan, true);
        return $response;
    }
}
