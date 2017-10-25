<?php
	$_intranet=true;
    require_once("../../../lib/php/loadAll.php");
    
    $moduloText = explode('/',$_SERVER['REQUEST_URI']);
    $moduloText = end($moduloText);
    $moduloText = substr($moduloText,3);
	$module = Doctrine_Query::create()->from('Modules')->where('link = ?', $moduloText)->execute()->getFirst();
	if(!isset($_SESSION['user']['id']) || !tienePermisos($module,$_SESSION['user']['id']))header('Location: '.$_config->base_url);
?>
<?php
    if(isset($_POST['editToken'])){
	    $reg = Doctrine_Query::create()->from($module->tableName)->where('token = ?',$_POST['editToken'])->execute()->getFirst();
        $img = Doctrine_Query::create()->from('Files')->where('token = ?', $reg->token)->execute()->getFirst();
    }
?>
<?php include("../../includes/doc_header.php"); ?>
</head>
<body class=" sidebar_main_open sidebar_main_swipe">
    <?php include("../../includes/site_header.php"); ?>
    <?php include("../../includes/menu.php"); ?>

	<div id="page_content">
        <div id="top_bar">
		    <ul id="breadcrumbs">
		        <li><a href=""><i class="material-icons">home</i></a></li>
		        <li><a style="color:#1e88e5; font-weight: 600;" href="<?=$module->link?>"> Listado <?=$module->title?></a></li>
		        <li><a style="color:#1e88e5; font-weight: 600;" href="add<?=$module->link?>">Añadir <?=$module->title?></a></li>
		    </ul>
		</div>
	    <div id="page_content_inner" style="display: none;">
	
	        <h3 class="heading_b uk-margin-bottom uk-margin-left"><?=$module->title?></h3>
	
	        <div class="md-card">
	            <div class="md-card-content">
	                <div class="uk-grid"><div class="uk-width-medium"><?=$module->description?></div></div>
	                <form class="uk-form-stacked" id="wizard_advanced_form" method="post" action="javascript:void(0);">
                        <div id="wizard_advanced" data-uk-observe>

                            <!-- first section -->
                            <h3>Datos básicos</h3>
                            <section style="display: none;">
                                
                                <div class="uk-grid" data-uk-grid-margin>
									<h3 class="uk-width-medium-1-1">Información de contacto</h3>
									
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                        </span>
                                        <label>Nombre</label>
                                        <input type="text" class="md-input" name="name" value="<?=(isset($reg))?$reg->name:''?>" />
                                    </div>
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                        </span>
                                        <label>Apellidos</label>
                                        <input type="text" class="md-input" name="lastname" value="<?=(isset($reg))?$reg->lastname:''?>" />
                                    </div>
                                    
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                        </span>
                                        <label>User (para login)</label>
                                        <input type="text" class="md-input" name="user" value="<?=(isset($reg))?$reg->user:''?>" />
                                    </div>
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                        </span>
                                        <label>Contraseña <?=(isset($reg))?'(Dejar vacío para no modificar)':'<span class="req">*</span>'?></label>
                                        <input type="password" class="md-input" name="password" />
                                    </div>
                                    
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                        </span>
                                        <label>Email</label>
                                        <input type="text" class="md-input" name="email" value="<?=(isset($reg))?$reg->email:''?>" />
                                    </div>
                                        
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon material-icons">&#xE0CD;</i>
                                        </span>
                                        <label>Teléfono</label>
                                        <input type="text" class="md-input" name="phone" value="<?=(isset($reg))?$reg->phone:''?>" />
                                    </div>
								</div>
                                
                                
                                <div class="uk-grid" data-uk-grid-margin>
									<h3 class="uk-width-medium-1-1">Información social</h3>
									
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon uk-icon-facebook-official"></i>
                                        </span>
                                        <label>Facebook</label>
                                        <input type="text" class="md-input" name="facebook" value="<?=(isset($reg))?$reg->facebook:''?>" />
                                    </div>
                                        
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon uk-icon-twitter"></i>
                                        </span>
                                        <label>Twitter</label>
                                        <input type="text" class="md-input" name="twitter" value="<?=(isset($reg))?$reg->twitter:''?>" />
                                    </div>
                                        
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon uk-icon-linkedin"></i>
                                        </span>
                                        <label>Linkdin</label>
                                        <input type="text" class="md-input" name="linkdin" value="<?=(isset($reg))?$reg->linkedin:''?>" />
                                    </div>
                                        
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon uk-icon-google-plus"></i>
                                        </span>
                                        <label>Google+</label>
                                        <input type="text" class="md-input" name="google_plus" value="<?=(isset($reg))?$reg->googleplus:''?>" />
                                    </div>
								</div>
								
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-1 parsley-row">
			                            <h3 class="heading_a uk-margin-small-bottom">
			                                Sube la imagen del usuario
			                            </h3>
			                            <input type="file" id="input-file-a" class="dropify" name="file" <?=(isset($img->filename) ? 'data-default-file="'. $_config->websitemm.$img->filepath.$img->filename .'"':'')?> />
                                    </div>
                                </div>
                                
                            </section>

                            <!-- third section -->
                            <h3>Comportamiento</h3>
                            <section style="display: none;">
                                <div class="uk-grid" data-uk-grid-margin>
					                <div class="uk-width-medium-1-3">
					                    <input type="checkbox" data-switchery id="switch_demo_1" name="isActive"  <?=(isset($reg) && $reg->isActive == 0)?'':'checked="cheked"'?> />
					                    <label for="switch_demo_1" class="inline-label">Usuario activo</label>
					                </div>
                                </div>
                                
                                <div class="uk-grid" data-uk-grid-margin>
									<h3 class="uk-width-medium-1-1">Permisos</h3>
									
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <label>Tipo</label>
                                        <select id="type" name="type">
	                                        <option value="10" <?=(isset($reg) && $reg->type == 10)?'selected':''?>>Gestor de hermandad</option>
	                                        <option value="1" <?=(isset($reg) && $reg->type == 1)?'selected':''?>>Administrador</option>
                                        </select>
                                    </div>
                                    
                                    <div class="uk-input-group uk-width-medium-1-2">
                                        <label>Contenido asociado</label>
                                        <select id="asociado" name="asociado">
	                                        <option value="null">Sin contenido asociado...</option>
	                                        <?php
				                                $seleccionado=(isset($reg))?$reg->asignedContent:'null';
				                            	listadoRecursivoOptions('PageDynamic', $seleccionado);
			                                ?>
                                        </select>
                                    </div>
									
									
								</div>
                            </section>

                        </div>
                        <?=(isset($reg))?'<input type="hidden" value="'.$reg->token.'" name="editToken" id="editToken">':''?>
						<input type="hidden" value="<?=$module->link?>" name="form_ajax" id="form_ajax">
                    </form>
	            </div>
	        </div>
	
	    </div>
	</div>

    
    <?php
        include("../../includes/footer.php");
    ?>
    
    <!-- page specific plugins -->
    <!-- parsley (validation) -->
    <script>
    // load parsley config (altair_admin_common.js)
    altair_forms.parsley_validation_config();
    // load extra validators
    altair_forms.parsley_extra_validators();
    </script>
    <script src="bower_components/parsleyjs/dist/parsley.min.js"></script>
    <!-- jquery steps -->
    <script src="assets/js/custom/wizard_steps.min.js"></script>
    <!--  forms wizard -->
    <script src="assets/js/pages/forms_wizard.js"></script> 
    
    <!-- dropify -->
    <link rel="stylesheet" href="assets/skins/dropify/css/dropify.css">
    <script src="assets/js/custom/dropify/dist/js/dropify.min.js"></script>
    <!--  form file input functions -->
    <script src="assets/js/pages/forms_file_input.min.js"></script>
    
    
</body>
</html>