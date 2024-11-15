<?php

require_once(__DIR__ . '/../Models/usuario.php');

if (!empty($_REQUEST['action'])) {
    user_controller::main($_REQUEST['action']);
}else{
  header('location: ../Views/validation.php');
}

class user_controller
{

    static function main($action)
    {
        if ($action == "crear") {
            user_controller::crear();
        } else if ($action == "ingresar") {
            user_controller::ingresar();
        } else if ($action == "recuperar") {
            user_controller::recuperar();
        } else if ($action == "confirmar") {
            user_controller::confirmar();
        } else if ($action == "editar") {
            user_controller::editar();
        } else if ($action == "buscarID") {
          user_controller::buscarID();
        }
    }

    static public function crear()
    {

        try {
            $arrayUser = array();

            $arrayUser['Nombre'] = $_POST['Nombre'];
            $arrayUser['Email'] = $_POST['Email'];
            $arrayUser['Clave'] = md5($_POST['Clave']);
            $arrayUser['Clave2'] = md5($_POST['Clave2']);
            $arrayUser['PreguntaS'] = $_POST['PreguntaS'];
            $arrayUser['Respuesta'] = $_POST['Respuesta'];
            $user = new usuario();
            $objUser = usuario::buscar("SELECT * FROM Usuarios WHERE Email = ? ", array($arrayUser['Email']));

            if (count($objUser) > 0) {
                echo "<center><h1>Usuario Ya existe</h1></center>";
                echo "<center><h1><a href='../index.php'>Salir</a></h1></center>";
            } else {
                if ($_POST['Clave'] == $_POST['Clave2']) {

                    $users = new usuario ($arrayUser);
                    $objUsers = $users->insertar();
                    //var_dump($users);exit();
                    header('location: ../Views/validation.php');
                } else {
                    echo "<center><h1>Claves no coinciden</h1></center>";
                    echo "<center><h1><a href='../index.php'>Salir</a></h1></center>";
                }
            }


        } catch (Exception $e) {
            echo "error";
        }


    }

    static public function editar()
    {
        try {
            session_start();
            $Id = $_SESSION['id'];

            $arrayUser = array();
            $arrayUser['Nombre'] = $_POST['Nombre'];
            $arrayUser['Email'] = $_POST['Email'];
            $arrayUser['Clave'] = md5($_POST['Clave']);
            $arrayUser['PreguntaS'] = $_POST['PreguntaS'];
            $arrayUser['Respuesta'] = $_POST['Respuesta'];
            $arrayUser['IdUsuarios'] = $Id;


            $user = new usuario ($arrayUser);
            $user->editar();

            echo "<center><h1>Datos Modificados</h1></center>";
            echo "<center><h1><a href='../Vistas/inicio.php'>Salir</a></h1></center>";
            foreach (usuario::buscar("SELECT * FROM usuarios WHERE Email = ? ", array($arrayUser['Email'])) as $key => $value) {
                $User = $value->getNombre();
                $Id = $value->getIdUsuarios();

            }
            $_SESSION['usuario'] = $User;
            $_SESSION['id'] = $Id;
            $_SESSION['sesion_iniciada'] = true;


        } catch (Exception $e) {
            echo "error";
        }
    }

    static public function ingresar()
    {
        try {
            $arrayUser = array();
            $arrayUser['Email'] = $_POST['Email'];
            $arrayUser['Clave'] = md5($_POST ['Clave']);
            $users = new usuario ($arrayUser);

            $objUser = usuario::buscar("SELECT * FROM usuarios WHERE Email = ? AND Clave =?", array($arrayUser['Email'], $arrayUser['Clave']));

            if (count($objUser) > 0) {

                foreach (usuario::buscar("SELECT * FROM usuarios WHERE Email = ? ", array($arrayUser['Email'])) as $key => $value) {
                    $User = $value->getNombre();
                    $Id = $value->getIdUsuarios();

                }

                session_start();
                $_SESSION['usuario'] = $User;
                $_SESSION['id'] = $Id;
                $_SESSION['sesion_iniciada'] = true;
                header('Location: ../Views/pagPrincipal.php');


            } else {
                session_start(FALSE);
                echo "<center><h1>Datos Incorrectos</h1></center>";
                header('location: ../Views/login.php');
            }
        } catch (Exception $e) {
            echo "error";
        }


    }

    static public function recuperar()
    {
        try {
            $arrayUser = array();
            $arrayUser['Email'] = $_POST['Email'];
            $arrayUser['PreguntaS'] = $_POST['PreguntaS'];
            $arrayUser['Respuesta'] = $_POST['Respuesta'];


            $user = new usuario($arrayUser);
            $objUser = usuario::buscar("SELECT * FROM usuarios WHERE Email = ? AND PreguntaS=? AND Respuesta =?", array($arrayUser['Email'], $arrayUser['PreguntaS'], $arrayUser['Respuesta']));

            if (count($objUser) > 0) {
                header('Location: ../Views/cambiarC.php');
            } else {
                echo "<center><h1>Datos Incorrectos</h1></center>";
                echo "<center><h1><a href='../Views/recuperarClave.php'>Volver</a></h1></center>";

            }

        } catch (Exception $e) {
            echo "error";
        }
    }

    static public function confirmar()
    {

        try {
            $arrayUser = array();
            $arrayUser['Email'] = $_POST['Email'];
            $arrayUser['Clave1'] = md5($_POST['Clave1']);
            $arrayUser['Clave'] = md5($_POST['Clave']);

            if ($arrayUser['Clave1'] == $arrayUser['Clave']) {
                $user = new usuario ($arrayUser);
                $objUser = usuario::buscar("SELECT * FROM usuarios WHERE Email = ?", array($arrayUser['Email']));
                if (count($objUser) > 0) {
                    foreach ($user as $objUser => $value) {
                        $objUser = $arrayUser['Clave'];
                        $user->actualizar("UPDATE usuarios set Clave='" . $arrayUser['Clave'] . "' where Email=?", array($arrayUser['Email']));
                    }
                    echo "<center><h1>Has cambiado tu clave</h1></center>";
                    echo "<center><h1><a href='../Vistas/InicioSesion.php'>Inicia Sesion</a></h1></center>";
                } else {
                    echo "<center><h1>Usuario no existe</h1></center>";
                    echo "<center><h1><a href='../Vistas/recuperarClave.php'>Volver</a></h1></center>";
                }
            } else {
                echo "<center><h1>Claves no coinciden</h1></center>";
                echo "<center><h1><a href='../Vistas/recuperarClave.php'>Volver</a></h1></center>";
            }


        } catch (Exception $e) {
            echo "error";
        }

    }

    static public function buscarID($id)
    {
        try {
            return usuario::buscarForId($id);
        } catch (Exception $e) {
            header("Location: ../buscar.php?respuesta=error");
        }
    }

    public function buscarAll()
    {
        try {
            return usuarios::getAll();
        } catch (Exception $e) {
            header("Location: ../buscar.php?respuesta=error");
        }
    }

    public function buscar($campo, $parametro)
    {
        try {
            return usuarios::getAll();
        } catch (Exception $e) {
            header("Location: ../buscar.php?respuesta=error");
        }
    }


}

?>
