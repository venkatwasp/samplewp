(function ($) {
	$(document).ready(function ($) {

		/* ------------------------------------------------------------ */
		
		// Ensure 'Latin' is always selected for Google Fonts character set - if all other options are switched off
		if(!$('input[id^=lbmn_googlefonts_charset_]:checked').length) {
			$('#lbmn_googlefonts_charset_0').prop('checked', true);
		}
		$('[id^=lbmn_googlefonts_charset_]').change(function() {
			if(!$('input[id^=lbmn_googlefonts_charset_]:checked').length) {
				$('#lbmn_googlefonts_charset_0').prop('checked', true);
			}
		});
		
		/* ------------------------------------------------------------ */

		// Fix Redux options panel bug when it render empty table elements
		// here we remove these table tr elements if td inside is empty
		$('#redux-opts-main .form-table td:empty').parent().remove();
                
                $('#lbmn_layoutoption_boxed_layout').change(function(){
                    var $this = $(this);
                    if($this.attr('checked') != 'checked'){
                        $('#lbmn_content_boxed_outer_type option:first').attr('selected', 'selected').change();
                        $('#lbmn_content_boxed_outer_bg_pattern_0').attr('checked','checked').change();                        
                    }
                });
                
                $('#lbmn_content_boxed_outer_bg_pattern_12').next().css('width','50px');
                
                $('#lbmn_content_boxed_outer_type').change(function(){
                            $('#lbmn_content_boxed_outer_bg_pattern_0').attr('checked','checked').change();
                });


		/* ------------------------------------------------------------ */

		// Fuction:
		// Conditionaly show controls based on selected drop-down value
		function checkControlVisibility( element ) {
			$(element).hide(); // not all elements we work with have parent 'tr'
			$(element).parents('tr:eq(0)').hide();

			// extract classes
			var element_classes = $(element).attr('class');

			// find regulator's id
			var parent_regulator = element_classes.match(/\bparent___(\w*)\b/g);
			parent_regulator = parent_regulator.toString();
			parent_regulator = parent_regulator.replace("parent___","");

			// find the value when to show this field (can be multiplty)
			var element_activator = element_classes.match(/\bvalue___([\w'-]*)\b/g);

			var length = element_activator.length;
			    // element_activator_instance = null;
			for (var i = 0; i < length; i++) {
			  // element_activator_instance = element_activator[i];
			  element_activator[i] = element_activator[i].replace("value___","");
			}


			// get regulator's value
			if ( $( '#' + parent_regulator ).hasClass('radio') ) {
				// extract selected radio input
				var regulator_selected = $( '#' + parent_regulator + ' input:checked' ).val();
                        }else if ($( '#' + parent_regulator ).hasClass('checkbox')){
                            var regulator_selected = $( 'input:checked#' + parent_regulator ).val();                        
			} else {
				// extract selected dropdown input
				var regulator_selected = $( '#' + parent_regulator ).val();
			}



			// compare with value we know
			// if ( regulator_selected === element_activator ) {
			// console.log('regulator_selected:' + regulator_selected + '; element_activator:' + element_activator);
			if ( jQuery.inArray(regulator_selected, element_activator) != -1) {
				// console.log('SHOW');
				// show
				$(element).show(); // not all elements we work with have parent 'tr'
				$(element).parents('tr:eq(0)').show(800);
			}
			// console.log('======================================================');
		}

		// Set the right state for each conditional field on load
		$('#redux-opts-main .redux-opts-group-tab .conditional').each(function(){
			checkControlVisibility( $(this) );
		});


			$(".conditionals-regulator input:radio").change(function() {
				var regulator_id = $(this).closest('.conditionals-regulator').attr('id');

				// find all conditionals who depend on this regulator
				$('.parent___' + regulator_id).each(function(){
					checkControlVisibility( $(this) );
				});
			});

			// listen for drop-down change
			$(".conditionals-regulator").change(function() {
				var regulator_id = $(this).attr('id');

				// find all conditionals who depend on this regulator
				$('.parent___' + regulator_id).each(function(){
					checkControlVisibility( $(this) );
				});
			});

	});
})(jQuery);