$(function() {
    // wizard
    altair_wizard.advanced_wizard();
    altair_wizard.vertical_wizard();
});

// wizard
altair_wizard = {
    content_height: function(this_wizard,step) {
        var this_height = $(this_wizard).find('.step-'+ step).actual('outerHeight');
        $(this_wizard).children('.content').animate({ height: this_height }, 280, bez_easing_swiftOut);
    },
    advanced_wizard: function() {
        var $wizard_advanced = $('#wizard_advanced'),
            $wizard_advanced_form = $('#wizard_advanced_form');

        if ($wizard_advanced.length) {
            $wizard_advanced.steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                trigger: 'change',
                onInit: function(event, currentIndex) {
                    altair_wizard.content_height($wizard_advanced,currentIndex);
                    // reinitialize textareas autosize
                    altair_forms.textarea_autosize();
                    // reinitialize checkboxes
                    altair_md.checkbox_radio($(".wizard-icheck"));
                    $(".wizard-icheck").on('ifChecked', function(event){
                        console.log(event.currentTarget.value);
                    });
                    // reinitialize uikit margin
                    altair_uikit.reinitialize_grid_margin();
                    // reinitialize selects
                    altair_forms.select_elements($wizard_advanced);
                    // reinitialize switches
                    $wizard_advanced.find('span.switchery').remove();
                    altair_forms.switches();
                    // resize content when accordion is toggled
                    $('.uk-accordion').on('toggle.uk.accordion',function() {
                        $window.resize();
                    });
                    setTimeout(function() {
                        $window.resize();
                    },100);
                },
                onStepChanged: function (event, currentIndex) {
                    altair_wizard.content_height($wizard_advanced,currentIndex);
                    setTimeout(function() {
                        $window.resize();
                    },100)
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    var step = $wizard_advanced.find('.body.current').attr('data-step'),
                        $current_step = $('.body[data-step=\"'+ step +'\"]');

                    // check input fields for errors
                    /*
                    $current_step.find('[data-parsley-id]').each(function() {
                        $(this).parsley().validate();
                    });
*/
                    // adjust content height
                    $window.resize();

                    return $current_step.find('.md-input-danger').length ? false : true;
                },
                onFinished: function() {
	                procesarMaquetacion($wizard_advanced_form);
                }
            })/*.steps("setStep", 2)*/;

            $window.on('debouncedresize',function() {
                var current_step = $wizard_advanced.find('.body.current').attr('data-step');
                altair_wizard.content_height($wizard_advanced,current_step);
            });

            // wizard
            /*
            $wizard_advanced_form
                .parsley()
                .on('form:validated',function() {
                    setTimeout(function() {
                        altair_md.update_input($wizard_advanced_form.find('.md-input'));
                        // adjust content height
                        $window.resize();
                    },100)
                })
                .on('field:validated',function(parsleyField) {

                    var $this = $(parsleyField.$element);
                    setTimeout(function() {
                        altair_md.update_input($this);
                        // adjust content height
                        var currentIndex = $wizard_advanced.find('.body.current').attr('data-step');
                        altair_wizard.content_height($wizard_advanced,currentIndex);
                    },100);

                });
                */

        }
    },
    vertical_wizard: function() {
        var $wizard_vertical = $('#wizard_vertical');
        if ($wizard_vertical.length) {
            $wizard_vertical.steps({
                headerTag: "h3",
                bodyTag: "section",
                enableAllSteps: true,
                enableFinishButton: false,
                transitionEffect: "slideLeft",
                stepsOrientation: "vertical",
                onInit: function(event, currentIndex) {
                    altair_wizard.content_height($wizard_vertical,currentIndex);
                },
                onStepChanged: function (event, currentIndex) {
                    altair_wizard.content_height($wizard_vertical,currentIndex);
                }
            });
        }
    }

};
$(window).bind("resizeWizard", function( event ) {
	altair_wizard.content_height($('#wizard_advanced'),$('#wizard_advanced').find('.body.current').attr('data-step'));
});
	                
var imagenesProcesadas=[];
var todasProcesadas=true;
function procesarMaquetacion($wizard_advanced_form){
	swal({
	  title: "<i class='uk-icon-cog uk-icon-spin uk-icon-large uk-text-primary'></i>",
	  text: "<span style='font-size:24px;'>Procesando imágenes</span>",
	  html: true,
	  showConfirmButton: false
	});
	var hayBase64=false;
	var contImg=0;
	$('#contentarea').find('img').each(function(){
		var src=$(this).attr('src');
		if(src.indexOf(';base64,') !== -1){
			hayBase64=true;
			imagenesProcesadas[contImg]='send';
			var idImagen='imagenSubida'+contImg;
			$(this).attr('id',idImagen);
			var modulo = $('#form_ajax').val();
			var token = $('#editToken').val();
			$.post("cargas.php", { 'form_ajax': "procesaImagen", 'imagen': src, 'idActual':contImg, 'idImagen':idImagen, 'modulo': modulo, 'token': token},
			function(resultado) {
				console.log(resultado);
				if(resultado.type != undefined && resultado.type == 'ok'){
					todasProcesadas=true;
					var datos=resultado.data;
					$('#contentarea #'+datos.idImagen).attr('src',datos.srcImagen);
					$('#contentarea #'+datos.idImagen).removeAttr('id');
					imagenesProcesadas[datos.idActual]='ok';
					for(var i=0; i<imagenesProcesadas.length; i++){
						if(imagenesProcesadas[i]=='send'){
							todasProcesadas=false;
						}
					}
					if(todasProcesadas==true){
						procesarGuardado($wizard_advanced_form);
					}
				}
			},'json')
			.fail(function(error) {
				console.log(error);
			});
			contImg++;
		}
	});
	if(hayBase64==false){
		procesarGuardado($wizard_advanced_form);
	}
}
function procesarGuardado($wizard_advanced_form){
	if($('#contentarea')[0] != undefined && $('#maquetacion')[0] != undefined){
	    var sHTML = $('#contentarea').data('contentbuilder').html();
	    $('#maquetacion').val(sHTML);
    }
	if($("#wizard_advanced_form input:file[name='file']")[0]==undefined){
	    var form_serialized = $wizard_advanced_form.serialize();
	    var res = $.post( "cargas.php", form_serialized, function(resultado) {
	        if(resultado=='refresh'){document.location=$('#form_ajax').val();}
				swal('','Guardado completo',"success" );
			})
			.fail(function() {
				swal( '','Error al guardar',"error" );
			});
	}else{
	    var datos = new FormData($("#wizard_advanced_form")[0]);
	    var res = $.post( {url:"cargas.php", data: datos, success: function(resultado) {
	        if(resultado=='refresh'){document.location=$('#form_ajax').val();}
			swal('','Guardado completo',"success" );
			},
			processData: false,
			contentType: false
			})
			.fail(function() {
				swal( '','Error al guardar',"error" );
			});
	}
}