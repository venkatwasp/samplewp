/**
 * Created with JetBrains PhpStorm.
 * User: OV
 * Date: 8/19/13
 * Time: 8:07 PM
 * To change this template use File | Settings | File Templates.
 */
(function ($) {

	var topMarginSelector = "select[name='el_top_margin']";
	var rightMarginSelector = "select[name='el_right_margin']";
	var bottomMarginSelector = "select[name='el_bottom_margin']";
	var leftMarginSelector = "select[name='el_left_margin']";
        var rowEditTab3Selector = "[href='#vc-edit-form-tab-2']";
        var backgroundStyleSelector = "[name='bg_type']";

	var allMarginsSelector = topMarginSelector + ',' + rightMarginSelector + ',' + bottomMarginSelector + ',' + leftMarginSelector;

	function onMarginChange(){
		var cssClass = $(allMarginsSelector).map(function() {
			return $(this).val();
		}).get().join(" ");

		// console.log("MARGINS BUG: Margin classes joined: " + cssClass);
		if ($('body').hasClass('vc-editor')) {
			var elClassInput = $("div.wpb-edit-form  input[name='el_class']");
		}
		else{
			var elClassInput = $("div.wpb-element-edit-modal input[name='el_class']");
		}
		console.log(elClassInput);
		var elClassValue = $(elClassInput).attr('value');
		// console.log("MARGINS BUG: El class before modification: " + elClassValue);
		elClassValue = elClassValue.replace( new RegExp(".margin-bottom_[0-9\\-]*px|.m-margin-bottom_[0-9\\-]*px|.margin-top_[0-9\\-]*px|.m-margin-top_[0-9\\-]*px|.margin-right_[0-9\\-]*px|.m-margin-right_[0-9\\-]*px|.margin-left_[0-9\\-]*px|.m-margin-left_[0-9\\-]*px","gm"),"");
		// console.log("MARGINS BUG: El class, removed margin classes: " + elClassValue);
		elClassValue = elClassValue.trim() + " " + cssClass;
		// console.log("MARGINS BUG: El class, final: " + elClassValue);
		$(elClassInput).attr('value', elClassValue);
	}
        
        function onLoadRowBackgroundsTab(){            
            $(backgroundStyleSelector).change();
        }

	$(topMarginSelector).live('change', onMarginChange);
	$(rightMarginSelector).live('change', onMarginChange);
	$(bottomMarginSelector).live('change', onMarginChange);
	$(leftMarginSelector).live('change', onMarginChange);

	$(topMarginSelector).addClass('test');
	$(topMarginSelector).closest('.wpb_el_type_dropdown').css( "background-color", "red" );        
        
        $('body').on('click',rowEditTab3Selector, onLoadRowBackgroundsTab);        
        
})(window.jQuery);