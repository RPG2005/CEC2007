<?php
    //Activacion de correo electronico
    $checkemailuser = intval($_REQUEST['activar']);
    error_log("------ Inicio de emailstatus.php --------");
    error_log("--emailstatus.php valor pasado email " . $checkemailuser);
    $checkemailuser = $checkemailuser - $keyCheckEmail;
    error_log("--emailstatus.php valor link email restando KeyCheckEmaiil " . $checkemailuser);
    $checkemailuser = strval($checkemailuser);
    try {
        $regcheckmail = Doctrine_Query::create()->from('UserWeb')->where('token = ?', $checkemailuser)->execute()->getFirst();
        if ($regcheckmail->checkemail && $regcheckmail->checkemail != $keyCheckEmail) {
            error_log("--emailstatus.php dentro del if email activado variables activadas");
            $regcheckmail->checkemail = $keyCheckEmail;
            $regcheckmail->save();
            error_log("--emailstatus.php Depues de salvar reg valor de checkemail:" .$regcheckmail->checkemail);
            error_log("--emailstatus.php SI Activado el usuario " . $regcheckmail->email . " " . $regcheckmail->password);
            $_SESSION['email'] =  $regcheckmail->email;
            $_SESSION['navbariconlogin'] =  "fa fa-sign-out";
            $_SESSION['navbarmodal'] = "myModalLogout";
            error_log("--emailstatus.php OK email activado variables activadas");
            $buttontext = "Siguiente";
            $buttoncolor = "5cb85c";
            $buttonclass = "btn-success";
        } else {
            error_log("--emailstatus.php Este email esta activado");
            $buttontext = "Cancelar";
            $buttoncolor = "d9534f";
            $buttonclass = "btn-danger";
        }
    }catch (Exception $error){
        error_log($error);
    }
?>

<!-- line modal -->
<div class="modal fade" id="myModalemailstatus" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header"><h4>Estado de link <i class="fa fa-lock"></i></h4></div>
                <div class="modal-body"><i class="fa fa-question-circle"></i>
                    <?php
                        echo (isset($_SESSION['email']))? "Cuenta activada" : "Esta cuenta ya esta activada. Inicie sesion con su usuario";

                    ?>
                </div>
                <div class="modal-footer">
                    <form id="idmyModalemailstatus" role="form" class="form-horizontal" name="myModalemailstatus" >
                        <button id="idbuttonmyModalemailstatus" name="myModalemailstatus" type="button" class="btn <?php echo $buttonclass ?> btn-sm" style="background-color: #<?php echo $buttoncolor ?> !important;" onclick="window.location.href='http://p5.formacion.xerintel.net/index.php'">
                            <?php echo $buttontext; ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.onreadystatechange = function(){
        if (document.readyState === "complete") {
            $("#myModalemailstatus").modal("show");
        }
    }
</script>