<?php


    $navbarfilename = basename($_SERVER['PHP_SELF']);

    $navbararray  = array("index.php"=>"SurfWave",
        "surfshop.php"=>"Tienda",
        "teachme.php"=>"Cursos",
        "surfcalendar.php"=>"Eventos");

    foreach($navbararray as $x => $x_value) {
        if ($navbarfilename == $x) {
            $navbarname = $x_value;
			echo $x_value;
        }
        echo $x . " x y su valor" .$x_value . " ";
    }
    echo $navbarname . " ";
	echo $navbarfilename . " ";


                    ?>

<div class="body-wrapper">
  <div class="navbar">
    <div class="navbar-header">
      <div class="container-fluid">
        <div class="basic-wrapper">
            <a class="btn responsive-menu pull-right" data-toggle="collapse" data-target=".navbar-collapse"><i class='icon-menu-1'></i></a>
            <a class="navbar-brand" href="index.php"><img src="style/images/logo_wavesurf_bn_crop_negative.png" alt="" data-src="style/images/logo_wavesurf_bn_crop_negative.png" /></a>
        </div>
        <nav class="collapse navbar-collapse pull-right">
          <ul class="nav navbar-nav">
            <li class="dropdown"><a href="<?php echo $navbarfilename ?>" class="dropdown-toggle js-activated"><?php echo $navbarname ?></a>
              <ul class="dropdown-menu">
                <li><a href="about.php">SurfShop</a></li>
                <li><a href="teachme.php">Aprende conmigo</a></li>
                <li><a href="surfcalendar.php">Eventos</a></li>
              </ul>
            </li>
            <li><a href="blog4.php" class="dropdown-toggle js-activated">Blog</a> </li>
          </ul>
          <ul class="social pull-right">
            <li><a href="#"><i class="icon-s-instagram"></i></a></li>
            <li><a href="#"><i class="icon-s-flickr"></i></a></li>
            <li><a href="#"><i class="icon-s-twitter"></i></a></li>
            <li><a href="#"><i class="icon-s-facebook"></i></a></li>
          </ul>
        </nav>
      </div>
    </div>
    <!--/.nav-collapse -->
  </div>
  <!--/.navbar -->