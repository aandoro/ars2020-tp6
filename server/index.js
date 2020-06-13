const express = require("express");
const bodyParser = require('body-parser');
const app = express();

app.use(bodyParser.urlencoded({
    extended: false
}));
app.use(bodyParser.json());

const admins = [{
    username: 'aandoro',
    password: 'aandoro'
}, {
    username: 'oascagorta',
    password: 'oascagorta'
}, {
    username: 'wfusiman',
    password: 'wfusiman'
}, {
    username: 'fpap',
    password: 'fpap'
}]

let token = '';

let usuarios = [];
let contador_usuarios = 1;

let respuesta = {
    error: false,
    codigo: 200,
    mensaje: ''
};

app.get('/', function (req, res) {
    respuesta = {
        error: true,
        codigo: 200,
        mensaje: 'Punto de inicio'
    };
    res.send(respuesta);
});

app.post('/login', function (req, res) {
    if (!login(req.body, admins)) {
        respuesta = {
            error: true,
            codigo: 501,
            mensaje: 'usuario y/o contraseña incorrecta'
        };
    } else {
        respuesta = {
            error: false,
            codigo: 200,
            mensaje: 'te logueaste!',
            respuesta: req.body
        };
    }

    res.send(respuesta);
})

function login(obj, list) {
    for (let i = 0; i < list.length; i++) {
        if (list[i].username === obj.username && list[i].password === obj.password) {
            return true;
        }
    }
    return false;
}

function isAdmin(auth, list) {

    const base64Credentials = auth.split(' ')[1];
    const credentials = Buffer.from(base64Credentials, 'base64').toString('ascii');
    const user_current = credentials.split(':');

    for (let i = 0; i < list.length; i++) {
        if (list[i].username === user_current[0] && list[i].password === user_current[1]) {
            return true;
        }
    }
    return false;
}

app.route('/usuarios')
    .get(function (req, res) {
        if (!isAdmin(req.headers.authorization, admins)) {
            respuesta = {
                error: true,
                codigo: 403,
                mensaje: 'usuario no autorizado'
            };
        } else {
            respuesta = {
                error: false,
                codigo: 200,
                mensaje: ''
            };
            if (usuarios.length === 0) {
                respuesta = {
                    error: true,
                    codigo: 501,
                    mensaje: 'No Hay usuarios creados'
                };
            } else {
                respuesta = {
                    error: false,
                    codigo: 200,
                    mensaje: 'respuesta del usuario',
                    respuesta: usuarios
                };
            }
        }
        res.send(respuesta);
    })
    .post(function (req, res) {
        if (!isAdmin(req.headers.authorization, admins)) {
            respuesta = {
                error: true,
                codigo: 403,
                mensaje: 'usuario no autorizado'
            };
        } else {
            if (!req.body.nombre || !req.body.apellido) {
                respuesta = {
                    error: true,
                    codigo: 502,
                    mensaje: 'El campo nombre y apellido son requeridos'
                };
            } else {
                if (containsObject(req.body, usuarios)) {
                    respuesta = {
                        error: true,
                        codigo: 503,
                        mensaje: 'El usuario ya fue creado previamente'
                    };
                } else {
                    post_user(req.body, usuarios)
                    respuesta = {
                        error: false,
                        codigo: 200,
                        mensaje: 'Usuario creado',
                        respuesta: usuarios
                    };
                    contador_usuarios++
                }
            }
        }

        res.send(respuesta);
    });
app.route('/usuarios/:id')
    .get(function (req, res) {
        if (!isAdmin(req.headers.authorization, admins)) {
            respuesta = {
                error: true,
                codigo: 403,
                mensaje: 'usuario no autorizado'
            };
        } else {
            if (!exist_id(req.params.id, usuarios)) {
                respuesta = {
                    error: true,
                    codigo: 501,
                    mensaje: 'El usuario no ha sido creado'
                };
            } else {
                usuario = get_user(req.params.id, usuarios)
                respuesta = {
                    error: false,
                    codigo: 200,
                    mensaje: 'respuesta del usuario',
                    respuesta: usuario
                };
            }
        }
        res.send(respuesta);
    })
    .put(function (req, res) {
        if (!isAdmin(req.headers.authorization, admins)) {
            respuesta = {
                error: true,
                codigo: 403,
                mensaje: 'usuario no autorizado'
            };
        } else {
            if (!req.body.nombre || !req.body.apellido) {
                respuesta = {
                    error: true,
                    codigo: 502,
                    mensaje: 'El campo nombre y apellido son requeridos'
                };
            } else {
                if (!exist_id(req.params.id, usuarios)) {
                    respuesta = {
                        error: true,
                        codigo: 501,
                        mensaje: 'El usuario no ha sido creado'
                    };
                } else {
                    update_user(req.params.id, req.body, usuarios)
                    respuesta = {
                        error: false,
                        codigo: 200,
                        mensaje: 'Usuario actualizado',
                        respuesta: usuarios
                    };
                }
            }
        }
        res.send(respuesta);
    })
    .delete(function (req, res) {
        if (!isAdmin(req.headers.authorization, admins)) {
            respuesta = {
                error: true,
                codigo: 403,
                mensaje: 'usuario no autorizado'
            };
        } else {
            if (!exist_id(req.params.id, usuarios)) {
                respuesta = {
                    error: true,
                    codigo: 501,
                    mensaje: 'El usuario no ha sido creado'
                };
            } else {
                usuarios = delete_user(req.params.id, usuarios)
                respuesta = {
                    error: false,
                    codigo: 200,
                    mensaje: 'Usuario eliminado'
                };
            }
        }
        res.send(respuesta);
    });

function containsObject(obj, list) {
    for (let i = 0; i < list.length; i++) {
        if (list[i].apellido === obj.apellido && list[i].nombre === obj.nombre) {
            return true;
        }
    }

    return false;
}

function get_user(id, list) {
    for (let i = 0; i < list.length; i++) {
        if (list[i].id === parseInt(id)) {
            return list[i]
        }

    }
}

function post_user(obj, list) {

    list.push({
        id: contador_usuarios,
        nombre: obj.nombre,
        apellido: obj.apellido
    });
}

function exist_id(id, list) {
    for (let i = 0; i < list.length; i++) {
        if (list[i].id === parseInt(id)) {
            return true
        }

    }
    return false

}

function update_user(id, obj, list) {
    for (let i = 0; i < list.length; i++) {

        if (list[i].id === parseInt(id)) {
            list[i].apellido = obj.apellido;
            list[i].nombre = obj.nombre;
        }
    }
}

function delete_user(id, list) {

    return list.filter((value) => {
        return value.id != id
    })

}

app.use(function (req, res, next) {
    respuesta = {
        error: true,
        codigo: 404,
        mensaje: 'URL no encontrada'
    };
    res.status(404).send(respuesta);
});

app.listen(3000, () => {
    console.log("El servidor está inicializado en el puerto 3000");
});