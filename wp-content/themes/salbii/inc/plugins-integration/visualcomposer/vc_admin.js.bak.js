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

	var allMarginsSelector = topMarginSelector + ',' + rightMarginSelector + ',' + bottomMarginSelector + ',' + leftMarginSelector;

	function onMarginChange(){
		var cssClass = $(allMarginsSelector).map(function() {
			return $(this).val();
		}).get().join(" ");

		// console.log("MARGINS BUG: Margin classes joined: " + cssClass);
		var elClassInput = $("div.edit_form_line input[name='el_class']");
		var elClassValue = $(elClassInput).attr('value');
		// console.log("MARGINS BUG: El class before modification: " + elClassValue);
		elClassValue = elClassValue.replace( new RegExp(".margin-bottom_[0-9\\-]*px|.margin-top_[0-9\\-]*px|.margin-right_[0-9\\-]*px|.margin-left_[0-9\\-]*px","gm"),"");
		// console.log("MARGINS BUG: El class, removed margin classes: " + elClassValue);
		elClassValue = elClassValue.trim() + " " + cssClass;
		// console.log("MARGINS BUG: El class, final: " + elClassValue);
		$(elClassInput).attr('value', elClassValue);
	}

	$(topMarginSelector).live('change', onMarginChange);
	$(rightMarginSelector).live('change', onMarginChange);
	$(bottomMarginSelector).live('change', onMarginChange);
	$(leftMarginSelector).live('change', onMarginChange);

	$(topMarginSelector).addClass('test');
	$(topMarginSelector).closest('.wpb_el_type_dropdown').css( "background-color", "red" );

	// .css({
	// 	width: '25%',
	// 	margin-right: '5%'
	// });

})(window.jQuery);