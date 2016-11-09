<?php
	/*
	Plugin Name: Marketo Forms 2.0 Integrator
	Plugin URI: http://www.atre.net/
	Description: Allows Marketo's Forms2.0 to be generated via Shortcode.
	Version: 0.1
	Author: AtreNet, Inc.
	Author URI: http://www.atre.net/
	License: Private
	*/
	
	add_shortcode( 'm2form', 'mf2i_gen_form_handler' );
	
	function mf2i_gen_form_handler( $atts ) {
		
		$html = '';
		if ($atts['debug'] == 'true'):
			$html .= 'Debug: <br><div id="mkt-debug"></div>';
		endif;
		$html .= '<script src="//app-sj01.marketo.com/js/forms2/js/forms2.min.js"></script>';
    $html .= '<style>.mktoForm .mktoRequiredField label.mktoLabel {display:none !important;} .mktoForm .mktoFieldWrap {margin-bottom:15px !important;}</style>';
		$html .= '<form id="mktoForm_'.$atts['formid'].'"></form>';
		
		$html .= '<script>MktoForms2.loadForm("//app-sj01.marketo.com", "'.$atts['campaign'].'", '.$atts['formid'].', function(form) {
			
			var initStateVal = new Option("State *", "");
			$(initStateVal).html("State *");

						var countryFieldBehavior = {
							init: function () {
								
								countryFieldBehavior.showHideState($("#Country"));
								
							},
							showHideState: function (countryField) {
								
								countryField.change( function () {
									
									
									if ( $(this).val() == "US" ) {
										$(this).parent().parent().parent().animate({"width": "58%", "margin-right": "2%"}).css({"float": "left", "clear": "none"});
										$("#State").parent().parent().parent().css({"float": "left", "clear": "none", "display": "none"}).animate({"width": "40%"}).fadeIn();
										$("#State").prepend(initStateVal);
									} else {
										$(this).parent().parent().parent().animate({"width": "100%"});
									}
								});
								
							}
						};
						$(countryFieldBehavior.init());
						
						
						
						var mfi = {
							init: function () {
								
								mfi.ajaxSubmitURLParams();
								
							},
							ajaxSubmitURLParams: function () {
								
								var protocol = "http:";
								var response;
								
								if(window.location.protocol == "https:") {
									protocol = "https:";
								}
						
								var postAjax = {"ajaxurl":protocol+"\/\/"+window.location.host+"\/wp-admin\/admin-ajax.php"};
								
								var postData = { 
									\'action\': \'upts_set_params_to_session\',
									\'urlparams\' : mfi.fetchURLParametersAsString()
								};
						
								jQuery.ajax({
									url: postAjax.ajaxurl,
									type: "POST",
									data: postData,
									success: function ( data ) {
										
										//console.log(data);
										response = jQuery.parseJSON(data);
										
										jQuery.each(response, function (key, data) {
											console.log(key);
												console.log(data);
												
												//if ( jQuery("#mktoForm_'.$atts['formid'].'").find(\'[name="\'+key+\'"]\').val() == \'\' ) {
													//jQuery("#mktoForm_'.$atts['formid'].'").find(\'[name="\'+key+\'"]\').val(data);
												//}
												form.setValues({
													key : data
												});
										});
										/* form.setValues({
											\'Lead_Source__c\': \'Test\'
										}); */
										
										console.log(form.getValues());
										
									}
								});
								
								return response;
							},
							fetchURLParametersAsArray: function () {
								
								var params = [], hash;
								var hashes = window.location.href.slice(window.location.href.indexOf(\'?\') + 1).split(\'&\');
								
								for(var i = 0; i < hashes.length; i++)
								{
										hash = hashes[i].split(\'=\');
										params.push(hash[0]);
										params[hash[0]] = hash[1];
								}
								
								return params;
								
							},
							fetchURLParametersAsString: function () {
								
								var hashes = window.location.href.slice(window.location.href.indexOf(\'?\') + 1);
								
								return hashes;
								
							}
						};
						$(mfi.init());
			
		
			
			
		});</script>';
		
		return $html;
		
	}