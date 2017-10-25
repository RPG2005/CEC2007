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
                                        <div class="uk-width-medium-9-10 parsley-row">
                                            <label for="title">Título<span class="req">*</span></label>
                                            <input type="text" name="title" id="title" required class="md-input" value="<?=(isset($reg))?$reg->title:''?>" />
                                        </div>
                                        <div class="uk-width-medium-1-10 parsley-row">
                                            <div class="uk-grid">
                                                <div class="uk-container-center">
                                                    <label for="switch_demo_1" class="inline-label">Visible</label>
                                                </div>
                                                <div class="uk-container-center">
                                                    <input type="checkbox" data-switchery id="switch_isActive" name="isActive"  <?=(isset($reg) && $reg->isActive == 0)?'':'checked="cheked"'?> />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-7-10 parsley-row">
                                            <label for="title">Autor</label>
                                            <input type="text" name="author" id="author" required class="md-input" value="<?=(isset($reg))?$reg->author:''?>" />
                                        </div>
                                        <div class="uk-width-medium-2-10 parsley-row">
                                            <label for="title">Fecha</label>
                                            <input type="text" name="createdAt" id="createdAt" class="md-input" data-parsley-date-message="Tiene que ser una fecha válida" data-uk-datepicker="{format:'YYYY-MM-DD'}" <?=(isset($reg) && $reg->createdAt != null)?'value="'.date('Y-m-d', strtotime ($reg->createdAt)).'"':''?>/>
                                        </div>
                                        <div class="uk-width-medium-1-10 parsley-row">
                                            <div class="uk-grid">
                                                <div class="uk-container-center">
                                                    <label for="switch_demo_1" class="inline-label">Posicion</label>
                                                </div>
                                                <div class="uk-container-center">
                                                    <input type="checkbox" data-switchery id="switch_position" name="position"  <?=(isset($reg) && $reg->position == 0)?'':'checked="cheked"'?> />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-width-medium-9-10">
                                            <label for="title">Entradilla</label>
                                            <input type="text" name="sortText" id="sortText" required class="md-input uk-text-break" value="<?=(isset($reg))?$reg->sortText:''?>" />
                                        </div>
                                        <div class="uk-width-medium-1-10 parsley-row">
                                            <div class="uk-grid">
                                                <div class="uk-container-center">
                                                    <label for="switch_demo_1" class="inline-label">Likes</label>

                                                    <input type="number" name="countLike" class="md-input" value="<?=(isset($reg))?$reg->countLike:'0'?>" /><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-grid">
                                            <div class="uk-width-medium-1-1 parsley-row">
                                                <h3 class="heading_a uk-margin-small-bottom">
                                                    Sube la imagen que usarás en la noticia
                                                </h3>
                                                <input type="file" id="input-file-a" class="dropify" name="file" <?=(isset($img->filename) ? 'data-default-file="'. $_config->websitemm.$img->filepath.$img->filename .'"':'')?> />
                                            </div>
                                        </div>
                                    </div>

                            </section>
                            <!-- first section -->
                            <h3>Texto Blog</h3>
                            <section style="display: none;">

                                    <div class="uk-grid" data-uk-grid-margin>

                                            <div class="uk-width-large-1-1">
                                                <label for="title">Texto</label>
                                                <textarea type="text" name="text" id="text" required class="md-input uk-text-break"><?=(isset($reg))?$reg->text:''?></textarea>
                                            </div>

                                    </div>
                                    <div class="uk-width-medium-1-2 parsley-row" data-uk-grid-margin>
                                        <label for="position">Posición</label>
                                        <input type="number" name="position" id="position" class="md-input" value="<?=(isset($reg))?$reg->position:''?>" />
                                    </div>

                            </section>

 <?php /*
                            <!-- second section -->
                            <h3>Contenido</h3>
                            <section style="display: none;">
									<div class="uk-form-row uk-margin-bottom">
		                                <label>Texto</label>
		                                <textarea cols="30" rows="4" class="md-input" name="description"><?=(isset($reg))?$reg->description:''?></textarea>
		                            </div>
	                           
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2 parsley-row">
                                        <label for="link">Link</label>
                                        <input type="text" name="link" id="link" class="md-input"  value="<?=(isset($reg))?$reg->link:''?>"/>
                                    </div>
                                    <div class="uk-width-medium-1-2 parsley-row">
                                        <label for="target">Target</label>
                                        <input type="text" name="target" id="target" class="md-input" value="<?=(isset($reg))?$reg->target:''?>" />
                                    </div>
                                </div>
                            </section>

                                */ ?>

                        </div>
                        <?=(isset($reg))?'<input type="hidden" value="'.$reg->token.'" name="editToken" id="editToken">':''?>
						<input type="hidden" value="blog" name="form_ajax" id="form_ajax">
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