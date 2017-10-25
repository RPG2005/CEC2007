<?php
    require "includes/class/NavbarClass.php";
    $navbarphpfilenameactive = basename($_SERVER['PHP_SELF']);
    $navabar01 = new \Navbar\Navbar("$navbarphpfilenameactive");
    $navabar01->navbarname();
    $navabar01->navbargenerate();
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
            <li class="dropdown"><a href="<?php echo $navabar01->navbarfilename; ?>" class="dropdown-toggle js-activated"><?php echo $navabar01->navbarname; ?></a>
              <ul class="dropdown-menu">
                  <?php echo $navabar01->navbarmenu; ?>
              </ul>
            </li>
            <li><a href="blog4.php" class="dropdown-toggle js-activated">Blog</a> </li>
            <li><a href="#" data-toggle="modal" data-target="#<?php echo $_SESSION['navbarmodal']; ?>"><i class="<?php echo $_SESSION['navbariconlogin']; ?>" style="color:#f0333b"></i></a></li>
          </ul>
            <?php
if (isset($_SESSION['email'])){
     echo '<ul class="social pull-right">
             <li><a href="#" data-toggle="modal" data-target="#myModalLogout"><i class="fa fa-sign-out" style="color:#f0333b"></i></a></li>
          </ul>';
     }
?>
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
  <!--/.modal -->
  <?php include "includes/login.php";?>
  <?php include "includes/logout.php";?>
  <!--/.modal -->