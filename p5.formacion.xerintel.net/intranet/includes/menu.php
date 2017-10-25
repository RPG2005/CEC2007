<aside id="sidebar_main">

        <div class="sidebar_main_header">
            <div class="sidebar_logo">
                <a href="index.html" class="sSidebar_hide"><img src="assets/img/logo_main.png" alt="" height="15" width="71"/></a>
                <a href="index.html" class="sSidebar_show"><img src="assets/img/logo_main_small.png" alt="" height="32" width="32"/></a>
            </div>
        </div>

        <div class="menu_section">
            <ul>
	            <?php 
		            $activeModules=Doctrine_Query::create()->from('Modules')->where('isActive = 1')->execute();
		            foreach($activeModules as $_m){ 
			            if(tienePermisos($_m,$_SESSION['user']['id'])){
		            ?>
                <li class="<?php /* current_section */?>" title="<?=$_m->title?>">
                    <a href="<?=$_m->link?>">
                        <span class="menu_icon"><i class="material-icons"><?=$_m->icon?></i></span>
                        <span class="menu_title"><?=$_m->title?></span>
                    </a>
                </li>
		        <?php    
			        	}
	            } ?>
            </ul>
        </div>
    </aside><!-- main sidebar end -->