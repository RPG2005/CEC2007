<?php
/**
 * Created by PhpStorm.
 * User: practicas
 * Date: 3/10/17
 * Time: 19:04
 */

namespace Navbar;


class Navbar {

    public $navbarfilename;
    public $navbarname = "";
    public $navbarmenu;
    private $navbararray  = array("index.php"=>"SurfWave",
                                  "surfshop.php"=>"Tienda",
                                  "teachme.php"=>"Cursos",
                                  "surfcalendar.php"=>"Eventos");

    function __construct($navbarphpfilenameactive) {
        $this->navbarfilename = $navbarphpfilenameactive;
    }

    public function navbargenerate (){
        foreach($this->navbararray as $x => $x_value) {
            if ($this->navbarfilename != $x) {
                $this->navbarmenu = $this->navbarmenu . '<li><a href="' .$x. '">' .$x_value. '</a></li>' ;
            }
        }
    }

    public function navbarname (){
        foreach($this->navbararray as $x => $x_value) {
            if ($this->navbarfilename == $x) {
                $this->navbarname = $x_value;
            }
        }
        //echo $this->navbarname;
    }
}