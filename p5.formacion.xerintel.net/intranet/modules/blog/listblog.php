<?php
	$_intranet=true;
    require_once("../../../lib/php/loadAll.php");

    $moduloText = explode('/',$_SERVER['REQUEST_URI']);
    $moduloText = end($moduloText);
    //$moduloText =substr($moduloText,3);
	$module = Doctrine_Query::create()->from('Modules')->where('link = ?', $moduloText)->execute()->getFirst();
	if(!isset($_SESSION['user']['id']) || !tienePermisos($module,$_SESSION['user']['id']))header('Location: '.$_config->base_url);
    $list = Doctrine_Query::create()->from($module->tableName . ' t')->where('deleted = 0')->execute();

?>
<?php include("../../includes/doc_header.php"); ?>
    <!-- additional styles for plugins -->
    <!-- htmleditor (codeMirror) -->
    <link rel="stylesheet" href="bower_components/codemirror/lib/codemirror.css">
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

            <h3 class="heading_b uk-margin-bottom uk-margin-left">
                <?=$module->title?>
            </h3>

            <div class="md-card">
                <div class="md-card-content">
	                <div class="uk-grid"><div class="uk-width-medium"><?=$module->description?></div></div>
                    <?php
                    // TIENE PERMISO
                    //if($modulePermissions->Count() == 1 || $_SESSION['user']['id_group'] == $_config->superadmin_group)
                    if(true)
                    {
                    //include("../../includes/recursos/modulos/list/menuRapido.php");
                    ?>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium">
                        <table class="table" data-show-toggle="true">
                        	<thead>
                        		<tr>
                                    <th>Posición</th>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th data-breakpoints="xs sm">Fecha Creacion</th>
                                    <th data-breakpoints="xs">Entradilla</th>
                                    <th data-breakpoints="xs">Imagen</th>
                                    <th data-breakpoints="xs">Video-URL</th>
                                    <th>Likes</th>
                                    <th data-type="html">Opciones</th>
                        			<th data-breakpoints="xs sm md lg">Texto</th>
                        			<th data-breakpoints="xs">

                        		</tr>
                        	</thead>
                        	<tbody>
                            <?php
                                 foreach($list as $row)
                                 {
                                    $img = null;
                                    $img = Doctrine_Query::create()->from('Files')->where('token = ?', $row->token)->execute()->getFirst();

                            ?>

                        		<tr id="rowdelForm<?=$list->token?>">
                                    <td><?=$row->position?></td>
                                    <td><?=$row->title?></td>
                                    <td><?=$row->author?></td>
                                    <td><?=(!empty($row->createdAt) ? date('d-m-Y H:i:s', strtotime($row->createdAt)):'')?></td>
                                    <td><?=$row->sortText?></td>
                                    <td><?=($row->image == 1)? "YES":'NO'?></td>
                                    <td><?=($row->movieUrl == 1)? "YES":'NO'?></td>
                                    <td><?=$row->countLike?></td>


                                    <td>
                                        <form action="add<?=$module->link?>" method="POST">
                                            <input type="hidden" name="editMode">
                                            <input type="hidden" name="editToken" value="<?=$row->token?>">
                                            <input type="hidden" name="tableName" value="<?=$tableName?>">
                                            <button type="submit" class="md-btn md-btn-primary md-btn-mini md-btn-wave-light waves-effect waves-button waves-light">
                                                <i class="material-icons">mode_edit</i>
                                            </button>
                                        </form>
                 
                                        <form id="delForm<?=$row->token?>">
                                            <input type="hidden" name="form_ajax" id="form_ajax" value="delete<?=$module->tableName?>">
                                            <input type="hidden" name="deleteToken" value="<?=$row->token?>">
                                            <input type="hidden" name="tableName" value="<?=$module->tableName?>">
                                            <button type="button" class="md-btn md-btn-danger md-btn-mini md-btn-wave-light waves-effect waves-button waves-light" onclick="UIkit.modal.confirm('¿Está seguro de eliminar el registro?', function(){ enviarFormulario('delForm<?=$row->token?>') })">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </form>
                          
                                    </td>
                                    <td><?=$row->text?></td>
                        		</tr>
                                <?php
                                }
                                ?>
                        	</tbody>
                        </table>
                        </div>
                    </div>
                    <?php
                        // TIENE PERMISO - FIN
                    }
                    else
                    {
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <?php
    //        include("../../includes/recursos/secondary_sidebar.php");
    include("../../includes/footer.php");
    ?>

    <script>
        jQuery(function($){
            $('.table').footable({
                "paging": {
                    "enabled": true
                },
                "filtering": {
                    "enabled": true
                },
                "sorting": {
                    "enabled": true
                }
                /*,
                 "rows": $.get("<?=$_config->website?>intranet/cargas.php?form_ajax=listGroupPermission&pag=")
                 */
            });
        });
    </script>
    <!-- page specific plugins -->
    <!-- ionrangeslider -->
    <script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
    <!-- htmleditor (codeMirror) -->
    <script src="assets/js/uikit_htmleditor_custom.min.js"></script>
    <!-- inputmask-->
    <script src="bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>

    <!--  forms advanced functions -->
    <script src="assets/js/pages/forms_advanced.min.js"></script>
</body>
</html>