<?php
	$_intranet=true;
    require_once("../../../lib/php/loadAll.php");
	if(!isset($_SESSION['user']['id']) || !tienePermisos($module,$_SESSION['user']['id']))header('Location: '.$_config->base_url);
?>
<?php
    if(isset($_POST['form_modules'])){
	    $modules = Doctrine_Query::create()->update('Modules')->set('isActive',0)->execute();
	    $configs = Doctrine_Core::getTable('Configs');
	    foreach($_POST as $key => $value){
		    if($key=='modules'){
			    foreach($_POST['modules'] as $_m){
				    $reg = Doctrine_Core::getTable('Modules')->find($_m);
				    $reg->isActive=1;
				    $msg=$reg->trySave();
			    }
		    }else if(isset($_configTitle->$key)){
			    $_c=$configs->find($key);
			    $_c->value=$value;
			    $_c->save();
		    }
	    }
	    
	    $_configs = Doctrine_Query::create()->from('Configs')->execute();
		$_configs=(object)$_configs->toArray();
		$_config = new stdClass();
		$_configTitle = new stdClass();
		
		foreach($_configs as $c){
			$_config->$c['param'] = $c['value'];
			$_configTitle->$c['param'] = $c['title'];
		}
        
        if ($msg == 'true'){
			$_msg=new stdClass();
			$_msg->type='success';
			$_msg->text='Guardado correctamente';
        }
		else{
			$_msg=new stdClass();
			$_msg->type='danger';
			$_msg->text='Hubo un error al guardar';
		}
    }
    
    $list = json_decode(file_get_contents('https://raw.githubusercontent.com/google/material-design-icons/master/iconfont/MaterialIcons-Regular.ijmap'), true);
	$icons = [];

	foreach ($list['icons'] as $i => $data) {
	    $icons['&#x'.strtoupper($i).';'] = $data['name']; 
	}
	
    $modules = Doctrine_Query::create()->from('Modules')->execute();
    
?>
<?php include("../../includes/doc_header.php"); ?>
</head>
<body class=" sidebar_main_open sidebar_main_swipe">
    <?php include("../../includes/site_header.php"); ?>
    <?php include("../../includes/menu.php"); ?>

	<div id="page_content">
	    <div id="page_content_inner" style="display: none;">
	
	        <h3 class="heading_b uk-margin-bottom">Configuración</h3>
	
	        <div class="md-card">
	            <div class="md-card-content">
	                <div class="" data-uk-grid-margin>
		                <form method="post" class="uk-grid">
	                    <div class="uk-width-medium-1-2">
							<h3 class="heading_a uk-margin-medium-bottom">Modulos activos</h3>
		                    <?php
							/*foreach($_tablas as $tabla){
							?>
		                        <div class="uk-width-medium-1-1">
		                            <input type="checkbox" data-switchery data-switchery-color="#7cb342" <?=(in_array(strtolower($tabla), $_config->activeModules))?'checked':''?> id="<?=$tabla?>" name="modules[]" value="<?=$tabla?>" />
		                            <label for="<?=$tabla?>" class="inline-label"><?=$tabla?></label>
		                        </div>
							<?php 
							}*/
							foreach($modules as $m){
							?>
		                        <div class="uk-width-medium-1-1">
		                            <input type="checkbox" data-switchery data-switchery-color="#7cb342" <?=($m->isActive)?'checked':''?> id="module<?=$m->id?>" name="modules[]" value="<?=$m->id?>" />
		                            <label for="module<?=$m->id?>" class="inline-label"><i class="material-icons"><?=$m->icon?></i> <?=$m->title?></label>
		                        </div>
							<?php 
							}
							?>
							
	                        <input type="submit" class="md-btn md-btn-primary uk-align-left uk-margin-medium-top" value="Guardar" name="form_modules"/>
	                    </div>
                        <div class="uk-width-medium-1-2">
							<h3 class="heading_a uk-margin-medium-bottom">Campos básicos</h3>
		                    <?php
							foreach($_config as $param => $value){
								if($_configTitle->$param != ''){
							?>
                                <div class="uk-form-row">
                                    <label><?=$_configTitle->$param?></label>
                                    <input type="text" id="<?=$param?>" name="<?=$param?>" value="<?=$value?>" class="md-input label-fixed" />
                                </div>
							<?php 
								}
							}
							?>
                        </div>
                    
						
						
						
						
	                    <div class="uk-width-medium-1-1  uk-margin-medium-top">
                        <div class="uk-form-row">
	                        <input type="submit" class="md-btn md-btn-primary uk-align-right" value="Guardar" name="form_modules"/>
                        </div>
	                    </div>
						
						</form>
	                </div>
	            </div>
	        </div>
	
	    </div>
	</div>
	
	<div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent" href="#nuevoModulo" data-uk-modal="{ center:true }">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>
    <div class="uk-modal" id="nuevoModulo">
        <div class="uk-modal-dialog">
            <form class="uk-form-stacked">
                <div class="uk-margin-medium-bottom">
                    <label for="title">Nombre</label>
                    <input type="text" class="md-input" id="title" name="title"/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="addlink">add Link</label>
                    <input type="text" class="md-input" id="addlink" name="addlink"/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="description">Descripción</label>
                    <input type="text" class="md-input" id="description" name="description"/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="tablename">Nombre tabla</label>
                    <input type="text" class="md-input" id="tablename" name="tablename"/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="icon" class="uk-form-label">Icono</label>
                    <select id="icon" name="icon" >
                        
                    </select>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Cerrar</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save" onclick="nuevoModulo();">Añadir</button>
                </div>
            </form>
        </div>
    </div>

    <!-- secondary sidebar -->
    <aside id="sidebar_secondary" class="tabbed_sidebar">
        <ul class="uk-tab uk-tab-icons uk-tab-grid" data-uk-tab="{connect:'#dashboard_sidebar_tabs', animation:'slide-horizontal'}">
            <li class="uk-active uk-width-1-3"><a href="#"><i class="material-icons">&#xE422;</i></a></li>
            <li class="uk-width-1-3 chat_sidebar_tab"><a href="#"><i class="material-icons">&#xE0B7;</i></a></li>
            <li class="uk-width-1-3"><a href="#"><i class="material-icons">&#xE8B9;</i></a></li>
        </ul>

        <div class="scrollbar-inner">
            <ul id="dashboard_sidebar_tabs" class="uk-switcher">
                <li>
                    <div class="timeline timeline_small uk-margin-bottom">
                        <div class="timeline_item">
                            <div class="timeline_icon timeline_icon_success"><i class="material-icons">&#xE85D;</i></div>
                            <div class="timeline_date">
                                09<span>May</span>
                            </div>
                            <div class="timeline_content">Created ticket <a href="#"><strong>#3289</strong></a></div>
                        </div>
                        <div class="timeline_item">
                            <div class="timeline_icon timeline_icon_danger"><i class="material-icons">&#xE5CD;</i></div>
                            <div class="timeline_date">
                                15<span>May</span>
                            </div>
                            <div class="timeline_content">Deleted post <a href="#"><strong>Id sint et fuga aliquid harum et.</strong></a></div>
                        </div>
                        <div class="timeline_item">
                            <div class="timeline_icon"><i class="material-icons">&#xE410;</i></div>
                            <div class="timeline_date">
                                19<span>May</span>
                            </div>
                            <div class="timeline_content">
                                Added photo
                                <div class="timeline_content_addon">
                                    <img src="assets/img/gallery/Image16.jpg" alt=""/>
                                </div>
                            </div>
                        </div>
                        <div class="timeline_item">
                            <div class="timeline_icon timeline_icon_primary"><i class="material-icons">&#xE0B9;</i></div>
                            <div class="timeline_date">
                                21<span>May</span>
                            </div>
                            <div class="timeline_content">
                                New comment on post <a href="#"><strong>Fugit eum ut aut.</strong></a>
                                <div class="timeline_content_addon">
                                    <blockquote>
                                        Adipisci voluptas voluptates autem id dolores eum aut.&hellip;
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="timeline_item">
                            <div class="timeline_icon timeline_icon_warning"><i class="material-icons">&#xE7FE;</i></div>
                            <div class="timeline_date">
                                29<span>May</span>
                            </div>
                            <div class="timeline_content">
                                Added to Friends
                                <div class="timeline_content_addon">
                                    <ul class="md-list md-list-addon">
                                        <li>
                                            <div class="md-list-addon-element">
                                                <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt=""/>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">Lydia Rowe</span>
                                                <span class="uk-text-small uk-text-muted">Dolore delectus sint iusto.</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <ul class="md-list md-list-addon chat_users">
                        <li>
                            <div class="md-list-addon-element">
                                <span class="element-status element-status-success"></span>
                                <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt=""/>
                            </div>
                            <div class="md-list-content">
                                <div class="md-list-action-placeholder"></div>
                                <span class="md-list-heading">Madelyn Rohan</span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate">Et provident voluptate.</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-addon-element">
                                <span class="element-status element-status-success"></span>
                                <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_09_tn.png" alt=""/>
                            </div>
                            <div class="md-list-content">
                                <div class="md-list-action-placeholder"></div>
                                <span class="md-list-heading">Patience Parker</span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate">Voluptate autem.</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-addon-element">
                                <span class="element-status element-status-danger"></span>
                                <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_04_tn.png" alt=""/>
                            </div>
                            <div class="md-list-content">
                                <div class="md-list-action-placeholder"></div>
                                <span class="md-list-heading">Yasmin Murazik</span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate">Iste dolore officia.</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-addon-element">
                                <span class="element-status element-status-warning"></span>
                                <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_07_tn.png" alt=""/>
                            </div>
                            <div class="md-list-content">
                                <div class="md-list-action-placeholder"></div>
                                <span class="md-list-heading">Bridie McCullough</span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate">Cum est.</span>
                            </div>
                        </li>
                    </ul>
                    <div class="chat_box_wrapper chat_box_small" id="chat">
                        <div class="chat_box chat_box_colors_a">
                            <div class="chat_message_wrapper">
                                <div class="chat_user_avatar">
                                    <img class="md-user-image" src="assets/img/avatars/avatar_11_tn.png" alt=""/>
                                </div>
                                <ul class="chat_message">
                                    <li>
                                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, eum? </p>
                                    </li>
                                    <li>
                                        <p> Lorem ipsum dolor sit amet.<span class="chat_message_time">13:38</span> </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="chat_message_wrapper chat_message_right">
                                <div class="chat_user_avatar">
                                    <img class="md-user-image" src="assets/img/avatars/avatar_03_tn.png" alt=""/>
                                </div>
                                <ul class="chat_message">
                                    <li>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem delectus distinctio dolor earum est hic id impedit ipsum minima mollitia natus nulla perspiciatis quae quasi, quis recusandae, saepe, sunt totam.
                                            <span class="chat_message_time">13:34</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="chat_message_wrapper">
                                <div class="chat_user_avatar">
                                    <img class="md-user-image" src="assets/img/avatars/avatar_11_tn.png" alt=""/>
                                </div>
                                <ul class="chat_message">
                                    <li>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque ea mollitia pariatur porro quae sed sequi sint tenetur ut veritatis.
                                            <span class="chat_message_time">23 Jun 1:10am</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="chat_message_wrapper chat_message_right">
                                <div class="chat_user_avatar">
                                    <img class="md-user-image" src="assets/img/avatars/avatar_03_tn.png" alt=""/>
                                </div>
                                <ul class="chat_message">
                                    <li>
                                        <p> Lorem ipsum dolor sit amet, consectetur. </p>
                                    </li>
                                    <li>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                            <span class="chat_message_time">Friday 13:34</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <h4 class="heading_c uk-margin-small-bottom uk-margin-top">General Settings</h4>
                    <ul class="md-list">
                        <li>
                            <div class="md-list-content">
                                <div class="uk-float-right">
                                    <input type="checkbox" data-switchery data-switchery-size="small" checked id="settings_site_online" name="settings_site_online" />
                                </div>
                                <span class="md-list-heading">Site Online</span>
                                <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <div class="uk-float-right">
                                    <input type="checkbox" data-switchery data-switchery-size="small" id="settings_seo" name="settings_seo" />
                                </div>
                                <span class="md-list-heading">Search Engine Friendly URLs</span>
                                <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <div class="uk-float-right">
                                    <input type="checkbox" data-switchery data-switchery-size="small" id="settings_url_rewrite" name="settings_url_rewrite" />
                                </div>
                                <span class="md-list-heading">Use URL rewriting</span>
                                <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                            </div>
                        </li>
                    </ul>
                    <hr class="md-hr">
                    <h4 class="heading_c uk-margin-small-bottom uk-margin-top">Other Settings</h4>
                    <ul class="md-list">
                        <li>
                            <div class="md-list-content">
                                <div class="uk-float-right">
                                    <input type="checkbox" data-switchery data-switchery-size="small" data-switchery-color="#7cb342" checked id="settings_top_bar" name="settings_top_bar" />
                                </div>
                                <span class="md-list-heading">Top Bar Enabled</span>
                                <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <div class="uk-float-right">
                                    <input type="checkbox" data-switchery data-switchery-size="small" data-switchery-color="#7cb342" id="settings_api" name="settings_api" />
                                </div>
                                <span class="md-list-heading">Api Enabled</span>
                                <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <div class="uk-float-right">
                                    <input type="checkbox" data-switchery data-switchery-size="small" data-switchery-color="#d32f2f" id="settings_minify_static" checked name="settings_minify_static" />
                                </div>
                                <span class="md-list-heading">Minify JS files automatically</span>
                                <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <button type="button" class="chat_sidebar_close uk-close"></button>
        <div class="chat_submit_box">
            <div class="uk-input-group">
                <input type="text" class="md-input" name="submit_message" id="submit_message" placeholder="Send message">
                <span class="uk-input-group-addon">
                    <a href="#"><i class="material-icons md-24">&#xE163;</i></a>
                </span>
            </div>
        </div>

    </aside><!-- secondary sidebar end -->

    <?php
        include("../../includes/footer.php");
    ?>
<script type="text/javascript">
	function nuevoModulo(){
		var title=$('#title').val();
		var addlink=$('#addlink').val();
		var description=$('#description').val();
		var tablename=$('#tablename').val();
		var icon=$('#icon').val();
        var res = $.post("cargas.php", {'form_ajax':'module','title': title,'addlink': addlink,'description': description,'tablename': tablename,'icon': icon},
            function(data)
            {
                if(data=='ok')
                    swal('','Nuevo módulo añadido',"success" );
                else if(data=='refresh')
                	swal({ title: '',text:'Nuevo módulo añadido',type:"success" }, function(){ location.reload();});
                    //UIkit.modal.confirm('Nuevo módulo añadido', function(){ location.reload(); });
                else if(data=='deleted')
                {
                    $("#row"+id).remove();
                    swal('','Registro eliminado',"success" );
                }
                else
                    swal( '','Error al guardar: ' + JSON.stringify(data), "error");
            }
        ).fail(function(data)
        {
            swal( '','Ha ocurrido un error: ' + JSON.stringify(data), "error");
        });
	}
	function muestraEditaCategoria(title, token){
		$('#titleEdit').val(title);
		$('#tokenEdit').val(token);
//		document.getElementById('lanzaEditaCategoria').click;
		$("#lanzaEditaCategoria")[0].click();
	}
	function editaCategoria(){
		var token=$('#tokenEdit').val();
		var title=$('#titleEdit').val();
        var res = $.post("cargas.php", {'form_ajax':'category','editToken': token,'title': title},
            function(data)
            {
                if(data=='ok')
                    swal('','Cambio realizado',"success" );
                else if(data=='refresh')
                    UIkit.modal.confirm('Cambio completado', function(){ location.reload(); });
                else if(data=='deleted')
                {
                    $("#row"+id).remove();
                    swal('','Registro eliminado',"success" );
                }
                else
                    swal( '','Error al guardar: ' + JSON.stringify(data), "error");
            }
        ).fail(function(data)
        {
            swal( '','Ha ocurrido un error: ' + JSON.stringify(data), "error");
        });
	}
	
		$('#icon').selectize({
            plugins: {
                'remove_button': {
                    label     : ''
                }
            },
            persist: false,
            maxItems: 1,
            valueField: 'icono',
            labelField: 'titleo',
            searchField: ['titleo'],
            options: [
    <?php
        foreach ($icons as $i => $data) {
		    echo "{icono: '".$i."', titleo: '".$data."'},";
		}
    ?>
            ],
            render: {
                item: function(item, escape) {
                    return '<div>' +
                        (item.icono ? '<i class="material-icons icono">'+item.icono+'</i>' : '') +
                        (item.titleo ? '<span class="titleo">' + escape(item.titleo) + '</span>' : '') +
                        '</div>';
                },
                option: function(item, escape) {
                    var label = item.icono;
                    var caption = item.titleo;
                    return '<div>' +
                        '<span class="label"><i class="material-icons icono">'+item.icono+'</i> </span>' +
                        ' <span class="caption">' + escape(item.titleo) + '</span>' +
                        '</div>';
                }
            },
            onDropdownOpen: function($dropdown) {
                $dropdown
                    .hide()
                    .velocity('slideDown', {
                        begin: function() {
                            $dropdown.css({'margin-top':'0'})
                        },
                        duration: 200,
                        easing: easing_swiftOut
                    })
            },
            onDropdownClose: function($dropdown) {
                $dropdown
                    .show()
                    .velocity('slideUp', {
                        complete: function() {
                            $dropdown.css({'margin-top':''})
                        },
                        duration: 200,
                        easing: easing_swiftOut
                    })
            }
        });
</script> 
</body>
</html>