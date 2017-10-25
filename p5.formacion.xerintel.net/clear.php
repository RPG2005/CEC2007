<?php
/**
 * Created by PhpStorm.
 * User: practicas
 * Date: 10/10/17
 * Time: 16:45
 */
    echo "limpiar variables";
    session_destroy();
    header('Location: index.php');
?>