<?php
session_start();
ini_set('default_charset', 'utf-8');

include_once '../../../lib/own/php/loadAllPhp.php';

$token = (isset($_POST['token']))?$_POST['token']:date('dmyHis');
 
 if(isset($_GET['data'])){
	 parse_str(desencriptarGet($_GET['data']), $get);
	 
	 $dato=Doctrine_Core::getTable($get['tabla'])->find($get['id']);
	 $token=$dato->token;
	 if(isset($_POST['contenido'])){ 
		 //error_log($_POST['contenido']);
		 if($get['idioma']=='es'){
			 $dato->description=stripslashes($_POST['contenido']);
		 }else{
			 $dato->description_en=stripslashes($_POST['contenido']);
		 }
		 $dato->trySave();
	 }
	 
	 if($get['idioma']=='es'){
		 $desc=$dato->description;
	 }else{
		 $desc=$dato->description_en;
	 }
	 
 }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Default Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">  

    <link href='//fonts.googleapis.com/css?family=Open+Sans:300,600,800' rel='stylesheet' type='text/css'>
    <link href="assets/default/content.css" rel="stylesheet" type="text/css" />

    <link href="scripts/contentbuilder.css" rel="stylesheet" type="text/css" />
</head>
<body>

<br />
<br />
<br />

<div id="contentarea" class="container">
<?php if($desc){
	echo $desc;
	}else{ ?>
    <div class="row clearfix">
        <div class="column full display">
            <h1>The Cafe</h1>
            <p>Fresh roasted coffee, exclusive teas &amp; light meals</p>
        </div>
    </div>
    <div class="row clearfix">
        <div class="column half">
            <img src="assets/cafe.jpg">  
        </div>
        <div class="column half">
            <p>Welcome to the website of the Cafe on the Corner. We are situated, yes you've guessed it, on the corner of This Road and That Street in The Town.</p>
            <p>We serve freshly brewed tea and coffee, soft drinks and a section of light meals and tasty treats and snacks. We are open for breakfast, lunch and afternoon tea from 8 am to 5 pm and unlike any other cafe in the town, we are open 7 days per week.</p>
       </div>
    </div>
    <div class="row clearfix">
        <div class="column full">
            <p>A truly family run business, we aim to create a cosy and friendly atmosphere in the cafe with Mum and Auntie doing the cooking and Dad and the (grown-up) children serving front of house. We look forward to welcoming you to the Cafe on the Corner very soon.</p>
        </div>
    </div>
<?php } ?>

</div>
<br /><br />
<form action="#" method="post" id="formulario">
	<input type="hidden" value="" name="contenido" id="contenido">
</form>
<!-- CUSTOM PANEL (can be used for "save" button or your own custom buttons) -->
<style>
    body {margin:0 0 57px} /* give space 70px on the bottom for panel */
    #panelCms {width:100%;height:57px;border-top: #eee 1px solid;background:rgba(255,255,255,0.95);position:fixed;bottom:0;padding:10px;box-sizing:border-box;text-align:center;white-space:nowrap;z-index:10001;}
    #panelCms button {border-radius:4px;padding: 10px 15px;text-transform:uppercase;font-size: 11px;letter-spacing: 1px;line-height: 1;}
</style>

<div id="panelCms">    
   <!-- <button onclick="alert('Sample of custom button')" class="btn btn-default"> Custom Button </button> &nbsp;
    <button onclick="view()" class="btn btn-default"> View HTML </button> &nbsp;-->
    <button onclick="save()" class="btn btn-primary"> Guardar </button> &nbsp;
</div>

<script src="scripts/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui.min.js" type="text/javascript"></script>
<script src="scripts/contentbuilder.js" type="text/javascript"></script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
		//Load saved Content
        if (localStorage.getItem('content') != null) {
            $("#contentarea").html(localStorage.getItem('content'));
        }
        $("#contentarea").contentbuilder({
            zoom: 0.85, 
            snippetOpen: true,
            snippetFile: 'assets/default/snippets.php'
        });

    });

    function view() {
        var sHTML = $('#contentarea').data('contentbuilder').viewHtml();
        //alert(sHTML);
    }
    
    function save() {
        //Save Content
        var sHTML = $('#contentarea').data('contentbuilder').html();
        
        $('#contenido').val(sHTML);
        $('#formulario').submit();
        //localStorage.setItem('content', sHTML);

        //alert('Saved Successfully');
    }
    
</script>



</body>
</html>
