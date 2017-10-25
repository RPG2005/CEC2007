<?php
    static $keyCheckEmail = 1547862157725;

     //$baseUrl = Doctrine_Core::getTable('Configs')->find('website')->value;
     //$imgUrl= Doctrine_Core::getTable('Configs')->find('websitemm')->value;

    //$GLOBALS[$keyCheckEmail] = 1547862157725;

/*function enviar_mail($de,$para,$asunto,$body){
    $mail_de=$de;
    $mail_para=$para;
    $asunto_mail = $asunto;
	$body_mail =$body;

	$cabeceras_mail  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras_mail .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$cabeceras_mail .= 'From: ' . $mail_de . "\r\n";
    return mail($mail_para, $asunto_mail, $body_mail, $cabeceras_mail);
} */

//formulario de login
if(isset($_POST['form_login'])){
	if(isset($_POST['email'])){
		$res= Doctrine_Query::create()->from('User')->where('email = ?', $_POST['email'])->andWhere('password = ?', md5($_POST['password']))->andWhere('isActive=1')->limit(1)->execute();
	}else if(isset($_POST['username'])){
		$res= Doctrine_Query::create()->from('User')->where('user = ?', $_POST['username'])->andWhere('password = ?', md5($_POST['password']))->andWhere('isActive=1')->limit(1)->execute();
	}
	
	if($res && $res->Count() != null)
	{
		$user=$res->toArray();
		$_SESSION['user']=$user[0];
		$imagen = Doctrine_Query::create()->from('Files')->where('token = ?', $user[0]['token'])->execute()->getFirst();
		if($imagen){
			$img=$imagen->toArray();
		}else{
			$img = array();
			$img['name']="imagen user";
			$img['filename']="avatar.png";
			$img['filepath']="../intranet/assets/img/default/";
			$img['thumb_filepath']="../intranet/assets/img/default/";
			$img['isActive']=1;
			
		}
		$_SESSION['user']['picture']=$img;
		header('Location:'.$_POST['http-refer']);
	}
	else
	{
		$_msg=new stdClass();
		$_msg->type='danger';
		$_msg->text='Usuario o contraseña incorrectos';
	}
}


//registro
if(isset($_POST['formulario_registro_usuario'])){
	$reg = new UserWeb();
	
    $reg->token = date('dmyHis');
    $reg->is_active = 1;
    $reg->username = $_POST['username'];
    $reg->password = md5($_POST['password']);
    $reg->name = $_POST['name'];
    $reg->email = $_POST['email'];
    $reg->lastname = $_POST['lastname'];
    $reg->permisocmc = 0;
    $reg->permisoec = 0;
    $reg->permisocmu = 0;
    $reg->permisoeu = 0;
    $reg->type = 1;
    $reg->phone = $_POST['phone'];
    $reg->pagado_hasta = gmdate("Y-m-d H:i:s",strtotime("now"));
    $reg->options = '0,0,1';
    $msg = $reg->trySave();

    if($msg){
        $mail = Doctrine_Query::create()->from('Emails')->where("title = 'Usuario registrado'")->execute()->getFirst();
        $de = "no-reply@goofix.es";
        $para = $reg->email;
        $asunto = $mail->asunto;
        $body = sustituir($mail->description,$reg);
        enviar_mail($de,$para,$asunto,$body);
    }



}

// Mis formularios

if(isset($_POST['formregister'])){

    $reg = new UserWeb();
    $reg->name = $_POST['name'];
    $reg->lastname = $_POST['lastname'];
    $reg->token = date('dmyHis');
    $reg->username = $_POST['username'];
    $reg->password = $_POST['password'];
    $reg->email = $_POST['email'];
    $reg->checkemail = (intval($reg->token) + $keyCheckEmail);
    error_log($reg->username . " este usuario con " .$reg->email . ", valor de checkmail " . $reg->checkemail . ", valor de token " .$reg->token);

    try {
        $reg->save();

        //error_log("Enviar correo");
        $to = "phperror666@gmail.com, PHPError";
        $subject = "Bienvenido a SurfWave activa " . $_POST['email'];
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <surfwaveinfo@surfwave.com>' . "\r\n";
        $headers .= 'Cc: elexterno@hotmail.com' . "\r\n";
$message = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="">
            <meta name="author" content="">
            <link rel="shortcut icon" href="http://p5.formacion.xerintel.net/style/images/favicon.png">
            <link rel="stylesheet" href="http://p5.formacion.xerintel.net/style/font-awesome/css/font-awesome.min.css">
            <title>"Acivar registro email"</title>
            <link href="http://p5.formacion.xerintel.net/style/css/bootstrap.css" rel="stylesheet">
            <link href="http://p5.formacion.xerintel.net/style/css/settings.css" rel="stylesheet">
            <link href="http://p5.formacion.xerintel.net/style/css/emailActivate.css" rel="stylesheet">
            <link href="http://p5.formacion.xerintel.net/style/css/color/aqua.css" rel="stylesheet">
        </head>';

$message .='	<body>
        <div class="body-wrapper">
			<div class="container">
                <div class="row">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                    </div>
                    <div class="col-sm-7 col-md-7 col-lg-7">
						<img class="card-logo-top" src="http://p5.formacion.xerintel.net/style/images/logo_wavesurf.png">
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2">
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                    </div>
                    <div class="col-sm-7 col-md-7 col-lg-7">
                        <div class="card card-inverse card-info">
                            <img class="card-img-top" src="http://p5.formacion.xerintel.net/style/images/art/surf-emailcheck.jpg">
                            <div class="card-block">
                                <figure class="profile">
                                    <img src="http://p5.formacion.xerintel.net/style/images/art/surf-emailcheck.jpg" class="profile-avatar" alt="">
                                </figure>
                                <h4 class="card-title mt-3">Bienvenido a SurfWave</h4>
                                <div class="meta card-text"><a>Friends</a></div>
                                <div class="card-text">Activa tu correo electronico.</div>
								<form name="checkemail" action="http://p5.formacion.xerintel.net/index.php?activar='. $reg->checkemail .'"  method="get">
									<input type="hidden" name="activar" value="'. $reg->checkemail .'">
                                    <input id="botonactivar" type="submit" class="btn btn-info bt-sm" value="Activar">
                                </form>
                            </div>
                            <div class="card-footer">
                                <small>Frase del dia aleatoria</small>
                            </div>
						</div>
                    </div>
                </div>';

$message .= '				<div class="row">
					<div class="col-sm-2 col-md-2 col-lg-2"></div>
					<div class="col-sm-7 col-md-7 col-lg-7">
						<div class="card-footer" style="text-align: center;">
							<ul class="social">
								<li><a href="#"><i class="icon-s-rss"></i></a></li>
								<li><a href="#"><i class="icon-s-twitter"></i></a></li>
								<li><a href="#"><i class="icon-s-facebook"></i></a></li>
								<li><a href="#"><i class="icon-s-dribbble"></i></a></li>
								<li><a href="#"><i class="icon-s-pinterest"></i></a></li>
								<li><a href="#"><i class="icon-s-instagram"></i></a></li>
								<li><a href="#"><i class="icon-s-vimeo"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
        </div>
		<script src="http://p5.formacion.xerintel.net/style/js/jquery.min.js"></script>
        <script src="http://p5.formacion.xerintel.net/style/js/bootstrap.min.js"></script>
		<script src="http://p5.formacion.xerintel.net/style/js/twitter-bootstrap-hover-dropdown.min.js"></script>
    </body>
</html>';
        //error_log($message);
        mail($to,$subject,$message,$headers);

    }catch (Exception $error){
        error_log($error);
        error_log("en el catch");
    }
}
//formulario de login comprobar datos
if(isset($_POST['formlogin'])){
    error_log($_POST['formlogin']);
    try {
        $reg = Doctrine_Query::create()->from('UserWeb')->where('password = ?', $_POST['password'])->andWhere('email = ?', $_POST['email'])->execute()->getFirst();
        if (isset($reg->email)){
            error_log("SI existe usuario" . $_SESSION['email'] . " " . $_POST['password']);
            $_SESSION['id'] = $reg->id;
            $_SESSION['name'] =  $reg->name;
            $_SESSION['lastname'] =  $reg->lastname;
            $_SESSION['username'] =  $reg->username;
            $_SESSION['password'] =  $reg->password;
            $_SESSION['email'] =  $reg->email;
            $_SESSION['navbariconlogin'] =  "fa fa-address-book-o";
            $_SESSION['navbarmodal'] = "myModalUser";
            error_log($_SESSION['$navbariconlogin' . " Inicio de sesion " . $_SESSION['email']]);
        }
    }catch (Exception $error){
        error_log($error);
    }
}
//formulario de logout comprobar datos y reiniciar variables
if(isset($_POST['formlogout'])){
    if ($_POST['formlogoutinfo'] == "formlogout") {
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        unset($_SESSION['lastname']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['email']);
    }
}

//formulario de usario comprobar datos
if(isset($_POST['formupdateuser'])){
    $update = 0;
    try {
        $reg = Doctrine_Query::create()->from('UserWeb')->where('id = ?', $_SESSION['id'])->execute()->getFirst();
        if (isset($reg->id)){
            error_log("------ Inicio de formupdateuser loadFroms.php --------");
            foreach($_POST as $x => $x_value) {
                if($_POST[$x]){
                    error_log ("Varibale Post $x su valor modificado: $x_value antiguo valor $reg->$x");
                    $reg->$x = $x_value;
                    $_SESSION[$x] =  $x_value;
                    $update = 1;
                }
            }
            if ($update!=0){
                $reg->save();
            }
        }
    }catch (Exception $error){
        error_log($error);
    }
}

?>