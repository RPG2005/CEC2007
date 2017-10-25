<?php
	include "includes/head.php";

    if (!isset($_SESSION['email'])){
        $_SESSION['navbariconlogin'] = "fa fa-user";
        $_SESSION['navbarmodal'] = "myModal";
    }

    $sliders = Doctrine_Query::create()->from('Headers')->where('isActive = 1')->execute();
    foreach($sliders as $slider){
        $img = Doctrine_Query::create()->from('Files')->where('token = ?', $slider->token)->execute()->getFirst();
    }

?>
<body>
<?php
	include "includes/navbar.php";
    include "includes/infostatus.php";
?>

  <div class="fullscreenbanner-container revolution">
    <div class="fullscreenbanner">
      <ul>
        <?php
            foreach ($sliders as $slider) {
                $img = Doctrine_Query::create()->from('Files')->where('token = ?', $slider->token)->execute()->getFirst();
                echo '<li data-transition="fade"> <img src="'. $imgUrl . $img->filepath . $img->filename .'" alt="" />';
                echo '  <div class="caption sfb upper opacity-bg" data-x="845" data-y="300" data-speed="900" data-start="800" data-easing="Sine.easeOut"><a href="'. $slider->link .'">Aprende conmgio</a></div>';
                echo '  <div class="caption sfb lower opacity-bg" data-x="845" data-y="355" data-speed="900" data-start="1300" data-easing="Sine.easeOut">'. $slider->title .'</div>';
                echo '</li>';
            }
        ?>
      </ul>
      <div class="tp-bannertimer tp-bottom"></div>
    </div>
    <!-- /.fullscreenbanner --> 
  </div>
  <!-- /.fullscreenbanner-container -->
<?php
    if(isset($_GET['activar'])){
        include "includes/emailstatus.php";
    }
?>
<?php
    if (isset($_SESSION['email'])){
        include "includes/mymodaluser.php";
    }
?>
<?php
	include "includes/footer.php";
?>
