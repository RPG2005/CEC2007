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
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-1 parsley-row">
                                        <label for="title">Título<span class="req">*</span></label>
                                        <input type="text" name="title" id="title" required class="md-input" value="<?=(isset($reg))?$reg->title:''?>" />
                                    </div>
                                </div>
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-1 parsley-row">
			                            <h3 class="heading_a uk-margin-small-bottom">
			                                Sube la imagen que usarás en el slider
			                            </h3>
			                            <input type="file" id="input-file-a" class="dropify" name="file" <?=(isset($img->filename) ? 'data-default-file="'. $_config->websitemm.$img->filepath.$img->filename .'"':'')?> />
                                    </div>
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
                            <!-- third section -->
                            <h3>Comportamiento</h3>
                            <section style="display: none;">
                                <div class="uk-grid" data-uk-grid-margin>
					                <div class="uk-width-medium-1-3">
					                    <input type="checkbox" data-switchery id="switch_demo_1" name="isActive"  <?=(isset($reg) && $reg->isActive == 0)?'':'checked="cheked"'?> />
					                    <label for="switch_demo_1" class="inline-label">Slider activo</label>
					                </div>
                                    <div class="uk-width-medium-1-2 parsley-row">
                                        <label for="position">Posición</label>
                                        <input type="number" name="position" id="position" class="md-input" value="<?=(isset($reg))?$reg->position:''?>" />
                                    </div>
                                </div>
                                 
								<div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-3 parsley-row">
                                        <label for="mostrar_desde">Mostrar desde </label>
                                        <input type="text" name="startAt" id="mostrar_desde" class="md-input" data-parsley-date-message="Tiene que ser una fecha válida" data-uk-datepicker="{format:'YYYY-MM-DD'}" <?=(isset($reg) && $reg->startAt != null)?'value="'.date('Y-m-d', strtotime ($reg->startAt)).'"':''?>/>
                                    </div>
                                    <div class="uk-width-medium-1-3 parsley-row">
                                        <label for="mostrar_hasta">Mostrar hasta </label>
                                        <input type="text" name="endAt" id="mostrar_hasta" class="md-input" data-parsley-date-message="Tiene que ser una fecha válida" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="<?=(isset($reg) && $reg->endAt != null)?date('Y-m-d', strtotime ($reg->endAt)):''?>"/>
                                    </div>
								</div>
                            </section>
                            <h3>Enlaces</h3>
                            <section style="display: none;">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-3">
                                        <label for="link">Enlace web<span class="req">*</span></label>
                                        <input type="text" name="link" id="link" required class="md-input" value="<?=(isset($reg))?$reg->link:''?>" />
                                    </div>
                                </div>
                            </section>
                        </div>
                        <?=(isset($reg))?'<input type="hidden" value="'.$reg->token.'" name="editToken" id="editToken">':''?>
						<input type="hidden" value="headers" name="form_ajax" id="form_ajax">
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