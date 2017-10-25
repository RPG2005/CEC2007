<?php
include('../lib/php/loadAll.php');
//error_log(print_r($_POST,true));
//error_log(print_r($_FILES,true));
if(isset($_GET['form_ajax'])){
	foreach($_GET as $key=>$value){
		$_POST[$key]=$value;
	}
}
function subirFichero($archivo,$reg){
	$tmp_filename = date('dmYHis'.substr((string)microtime(), 2, 6)) . '.' . substr(strrchr(basename($archivo['name']), '.'), 1);
	$nombre=pathinfo($archivo['name'], PATHINFO_FILENAME);
    $ruta=$_POST['form_ajax'].'/';
    list($w, $h) = getimagesize($archivo['tmp_name']);
    
	$reg_file = new Files();
    $reg_file->token = $reg->token;
    $reg_file->mime = $archivo['type'];
	$reg_file->filename = $tmp_filename;
	$reg_file->name = $nombre;
	$reg_file->filepath = $ruta;
	$reg_file->size = $archivo['size'];
    $reg_file->width = $w;
    $reg_file->height = $h;
    $reg_file->thumb_width = 0;
    $reg_file->thumb_height = 0;
    $reg_file->thumb_filepath = $ruta."thumbnail/";
    $reg_file->created_at = new Doctrine_Expression('NOW()');
    $reg_file->isActive = 1;
    $reg_file->type = $archivo['ficheroType'];
    $reg_file->save();
    
    if(!is_dir('../uploads')){
	    mkdir('../uploads');
    }
    
    if(!is_dir('../uploads/'.$ruta)){
	    mkdir('../uploads/'.$ruta);
    }
    move_uploaded_file($archivo["tmp_name"], '../uploads/'.$ruta."thumbnail/".$tmp_filename);
    move_uploaded_file($archivo["tmp_name"], '../uploads/'.$ruta.$tmp_filename);
    return $reg_file;
}
function subirFicheros($reg){
	$result = array();
	$res = array();
	if(is_array($_FILES['file']['name'])){
	    foreach($_FILES["file"] as $key1 => $value1){ 
	        foreach($value1 as $key2 => $value2){
	            $result[$key2][$key1] = $value2;
	            $result[$key2]['ficheroType']='multiple';
	        }
	    }
	}else{
        if($_FILES['file']['size']){ //si solo es un fichero, los antiguos hay que borrarlos
	        $imgs=Doctrine_Query::create()->from('Files')->where('token = ?', $reg->token)->andWhere('type=?','unico')->execute();
			foreach($imgs as $img){
				unlink("../uploads/".$img->filepath.$img->filename);
				unlink("../uploads/".$img->thumb_filepath.$img->filename);
				$img->delete();
			}
	    }
	    $_FILES['file']['ficheroType']='unico';
		$result[0]=$_FILES['file'];
	}
    foreach($result as $archivo){
	    $res[] = subirFichero($archivo,$reg);
    }
    return $res;
}

/********* UNIFICAR DELETES *********/
if(strrpos($_POST['form_ajax'], "delete")===0){
	$borrar=ucwords(strtolower(substr($_POST['form_ajax'],6)));
	$_POST['form_ajax']='delete';
}
/********* FIN UNIFICAR DELETES *********/

if(isset($_POST['form_ajax'])){
	switch($_POST['form_ajax']){
		case 'delete':
			$reg = Doctrine_Query::create()->from($borrar)->where('token = ?',$_POST['deleteToken'])->execute()->getFirst();
			$reg->deleted=1;
			$reg->Save();
			echo 'deleted';
		break;
		case 'users':
			if(isset($_POST['editToken'])){
				$reg= Doctrine_Query::create()->from('User')->where('token = ?',$_POST['editToken'])->execute()->getFirst();
				$token=$_POST['editToken'];
			}else{
				$reg=new User();
				$token=date('dmYHis');
				$reg->createdAt=date('Y-m-d H:i:s');
			}
			$reg->token=$token;
			$reg->isActive=(isset($_POST['isActive']))?1:0;
			$reg->user=$_POST['user'];
			$reg->password=($_POST['password']!='')?md5($_POST['password']):$reg->password;
			$reg->name=$_POST['name'];
			$reg->lastname=$_POST['lastname'];
			$reg->email=$_POST['email'];
			$reg->phone=$_POST['phone'];
			$reg->facebook=$_POST['facebook'];
			$reg->twitter=$_POST['twitter'];
			$reg->linkedin=$_POST['linkdin'];
			$reg->googleplus=$_POST['google_plus'];
			$reg->deleted=0;
			$reg->asignedContent=(isset($_POST['asociado']) && is_numeric($_POST['asociado']))?intval($_POST['asociado']):null;
			$reg->type=$_POST['type'];
			$reg->permisos='0000';
			$reg->Save();
			subirFicheros($reg);
		break;
		case 'module':
			if(isset($_POST['editToken'])){
				$reg= Doctrine_Query::create()->from('Modules')->where('token = ?',$_POST['editToken'])->execute()->getFirst();
				$token=$_POST['editToken'];
			}else{
				$reg=new Modules();
				$token=date('dmYHis');
			}
			$reg->token=$token;
			$reg->icon=$_POST['icon'];
			$reg->title=$_POST['title'];
			$reg->link=$_POST['addlink'];
			$reg->description=$_POST['description'];
			//$reg->isActive=$_POST['isActive'];
			$reg->tableName=$_POST['tablename'];
			$reg->Save();
			echo 'refresh';
		break;
		case 'subidaMultiple':
			$reg = new stdClass;
			$reg->token = '123456789';
			$ficheros = subirFicheros($reg);
			$fichero = $ficheros[0];
			$response = array();
			$response['name'] = $fichero->filename;
			$response['size'] = $fichero->size;
			$response['path'] = $fichero->filepath;
			$response['mime'] = $fichero->mime;
			echo json_encode($response);
		break;
		case 'headers':
			if(isset($_POST['editToken'])){
				$reg= Doctrine_Query::create()->from('Headers')->where('token = ?',$_POST['editToken'])->execute()->getFirst();
				$token=$_POST['editToken'];
			}else{
				$reg=new Headers();
				$token=date('dmYHis');
				$reg->createdAt=date('Y-m-d H:i:s');
			}
			$reg->token=$token;
			$reg->title=$_POST['title'];
			$reg->description=$_POST['description'];
			$reg->link=(isset($_POST['link']))?$_POST['link']:'';
			$reg->target=(isset($_POST['target']))?$_POST['target']:'';
			$reg->position=intval($_POST['position']);
			$reg->isActive=(isset($_POST['isActive']))?1:0;
			$reg->startAt=((bool)strtotime($_POST['startAt']))?$_POST['startAt']:null;
			$reg->endAt=((bool)strtotime($_POST['endAt']))?$_POST['endAt']:null;
			$reg->Save();
			subirFicheros($reg);
		break;
		case 'list_sliders':
			$url_base=Doctrine_Core::getTable('Configs')->find('websitemm')->value;
			$listado=Doctrine_Query::create()->from('Headers')->orderBy('id DESC')->execute();
			
            $lista=array();
			foreach($listado as $l){
				$img = Doctrine_Query::create()->from('Files')->where('token = ?', $l->token)->limit(1)->execute()->getFirst();
				$url=$url_base.$img->thumb_filepath . $img->filename."?".rand();
				
				$row=array();
				$row['id']=$l->id;
				$row['token']=$l->token;
				$row['title']=$l->title;
				$row['description']=$l->description;
				$row['link']=$l->link;
				$row['target']=$l->target;
				$row['isActive']=$l->isActive;
				$row['startAt']=$l->startAt;
				$row['endAt']=$l->endAt;
				$row['img']=$url;
				$lista[]=$row;                
            }
            echo json_encode($lista);
		break;
		case 'procesaImagen':
			$resultado=array();
			$resultado['type']='error';
			$resultado['data']=array();
			$resultado['data']['msg']='no se pudo procesar la imagen';
			
			$base64Imagen=$_POST['imagen'];
		    //$base64Imagen:    data:image/png;base64,asdfasdfasdf
		    $splited = explode(',', substr($base64Imagen, 5 ), 2);
		    $mime=$splited[0];
		    $data=$splited[1];
		    $decodedData = base64_decode($data);
		    
			$size=((strlen($data))*3)/4; //bytes
			
		    $mimeSinBase64=explode(';', $mime,2);
		    $mimeSplit=explode('/', $mimeSinBase64[0],2);
		    $mimeType=explode(':', $mimeSinBase64[0],2);
		    $mimeType=$mimeType[0];
		    if(count($mimeSplit)==2)
		    {
		        $extension=$mimeSplit[1];
		        if($extension=='jpeg')$extension='jpg';
		        
		        $tmp_filename = date('dmYHis'.substr((string)microtime(), 2, 6));
				$nombre=$tmp_filename;
				$tmp_filename.= '.' . $extension;
			    $ruta=$_POST['modulo'].'/';
			    list($w, $h) = getimagesizefromstring($decodedData);
				$reg_file = new Files();
			    $reg_file->token = $_POST['token'];
			    $reg_file->mime = $mimeType;
				$reg_file->filename = $tmp_filename;
				$reg_file->name = $nombre;
				$reg_file->filepath = $ruta;
				$reg_file->size = $size;
			    $reg_file->width = $w;
			    $reg_file->height = $h;
			    $reg_file->thumb_width = 0;
			    $reg_file->thumb_height = 0;
			    $reg_file->thumb_filepath = $ruta."thumbnail/";
			    $reg_file->created_at = new Doctrine_Expression('NOW()');
			    $reg_file->isActive = 1;
			    $reg_file->type = 'content';
				try{
				   $reg_file->save();
				}catch(Exception $e){
				    error_log($e);
				}
			    
			    if(!is_dir('../uploads')){
				    mkdir('../uploads');
			    }
			    
			    if(!is_dir('../uploads/'.$ruta)){
				    mkdir('../uploads/'.$ruta);
			    }
				file_put_contents('../uploads/'.$ruta.$tmp_filename, $decodedData);
				
				$datosArchivo=array();
				$datosArchivo['srcImagen']=$_config->websitemm.$ruta.$tmp_filename;
				$datosArchivo['idActual']=$_POST['idActual'];
				$datosArchivo['idImagen']=$_POST['idImagen'];
				$datosArchivo['msg']='1';
				
				$resultado['type']='ok';
				$resultado['data']=$datosArchivo;
		    }else{
			    $resultado['data']['msg']='no se pudo guardar la imagen';
		    }
			echo json_encode($resultado);
		break;
        case 'blog':
            echo "Estoy en case BLOG -------------------------------------------";
            error_log("Estoy en el case blog error log");
            if(isset($_POST['editToken'])){
                $reg= Doctrine_Query::create()->from('Blog')->where('token = ?',$_POST['editToken'])->execute()->getFirst();
                $token=$_POST['editToken'];
            }else{
                $reg=new Blog();
                $token=date('dmYHis');
                $reg->createdAt=date('Y-m-d H:i:s');
            }
            error_log("Valores de reg ANTES de ASIGNAR  y POST -------------------------------------------");
            foreach($reg as $x => $x_value) {
                if ($x != "text"){
                    error_log("Valor de REG ". $x . " " .$x_value . " </br> Valor de POST " . $_POST[$x]);
                }
            }

            $reg->position=intval($_POST['position']);
            $reg->token=$token;
            $reg->title=$_POST['title'];
            $reg->isActive=(isset($_POST['isActive']))?1:0;
            $reg->author=$_POST['author'];
            $reg->createdAt=((bool)strtotime($_POST['createdAt']))?$_POST['createdAt']:null;
            $reg->sortText=$_POST['sortText'];
            $reg->countLike=intval($_POST['countLike']);
            $reg->text=$_POST['text'];
            $reg->movieUrl =(isset($_POST['movieUrl']))?1:0;



            $reg->image = (isset($_FILES['file']['name']))?1:0;

            error_log("Valores de reg DESPUES de ASIGNAR y POST -------------------------------------------");
            foreach($reg as $x => $x_value) {
                if ($x != "text"){
                    error_log("Valor de REG ". $x . " " .$x_value . " </br> Valor de POST " . $_POST[$x]);
                }
            }
            error_log ( json_encode($_FILES));
            error_log ("Valores de Files file -------------------------------------------");
            foreach($_FILES['file'] as $x => $x_value) {
                error_log( $x . " " .$x_value . "</br>");
            }

            try {
                $reg->Save();
            }
            catch(Exception $e)
            {
                error_log($e);
            }

            (isset($_FILES['file']['name']) && ($_FILES['file']['name']!=""))?subirFicheros($reg): error_log ("NO subir");


        break;

	}
}
else{
	header("Location:".Doctrine_Core::getTable('Configs')->find('website')->value);
}
?>