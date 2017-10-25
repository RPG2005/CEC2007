<!-- google web fonts -->
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <script src="assets/footable-standalone/js/footable.min.js"></script>

    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->
        <!-- d3 -->
        <script src="bower_components/d3/d3.min.js"></script>
        <!-- metrics graphics (charts) -->
        <script src="bower_components/metrics-graphics/dist/metricsgraphics.min.js"></script>
        <!-- chartist (charts) -->
        <script src="bower_components/chartist/dist/chartist.min.js"></script>
        <!-- maplace (google maps) -->
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="bower_components/maplace-js/dist/maplace.min.js"></script>
        <!-- peity (small charts) -->
        <script src="bower_components/peity/jquery.peity.min.js"></script>
        <!-- easy-pie-chart (circular statistics) -->
        <script src="bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        <!-- countUp -->
        <script src="bower_components/countUp.js/dist/countUp.min.js"></script>
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>
        <script>
            // show preloader
            altair_helpers.content_preloader_show();
        </script>
        <!-- CLNDR -->
        <script src="bower_components/clndr/clndr.min.js"></script>
        <!-- fitvids -->
        <script src="bower_components/fitvids/jquery.fitvids.js"></script>

        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>
        
        <!--  sweetalert -->
        <script src="assets/sweetalert/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/sweetalert/sweetalert.css">

    <script>
        $(function() {
            if(isHighDensity) {
                // enable hires images
                altair_helpers.retina_images();
            }
            if(Modernizr.touch) {
                // fastClick (touch devices)
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            // ie fixes
            altair_helpers.ie_fix();
        });
    </script>


    
    <script>
/* AJAX FORM */
function enviarFormulario(id)
{
    var form_serialized = $('#'+id).serialize();
    var res = $.post("cargas.php", form_serialized,
        function(data)
        {
            if(data=='ok')
                swal('','Cambio completado',"success" );
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
</script>
<?php 
	if(isset($_msg)){ ?>
    <script>
	    UIkit.notify('<?=$_msg->text?>'<?=(isset($_msg->type))?",{status:'".$_msg->type."'}":''?>);
    </script>
	<?php	
	}
?>
 <?php
    // PRECARGA
    ?>
    <script>
    $(function()
    {
        $("#page_content_inner").show();
        // hide preloader
        altair_helpers.content_preloader_hide();
    });
    </script>
    <?php
    // PRECARGA - FIN
    ?>