<?php
add_shortcode( 'vc_price_block', 'price_block');

echo price_block($atts, $content);

function price_block( $atts, $content = null ) {

	$predefined_atts = array(
		'title' => 'New Plan',
		'price' => '0',
		'currency' => '$',
		'period' => 'mo',
		'description' => 'sample plan description',
		'make_featured' => false,
		'featured_badge_text' => '',
		'bg_color' => '',
		'text_color' => '',
		'title_bg_color' => '',
		'title_text_color' => '',
		'el_class' => '',
	);

	$make_featured = false;
	$output = $title = $price = $currency = $period = $description = $featured_badge_text = $bg_color = $text_color = $el_class = '';
	extract(shortcode_atts($predefined_atts, (array)$atts));

	$featured_badge = ($make_featured == true) ? ("<span class='priceblock-badge brand-bgcolor brand-color-contrast'>".$featured_badge_text."</span>") : "";

	// Add colors to style attr
	$style_text = $style_block = $bg_color_css = $text_color_css = '';
	$title_style_text = $title_style_block = $title_bg_color_css = $title_text_color_css = '';


	// Plan title custom background
	if($title_bg_color != ''){
		$title_bg_color_css = "background-color:$title_bg_color;";
		$title_style_block = " style='$title_bg_color_css'";
	}

	// Pricing title custom text color
	if($title_text_color != ''){
		$title_text_color_css = "color:$title_text_color;";
		$title_style_text = " style='$title_text_color_css'";
	}

	// Pricing block custom background
	if($bg_color != ''){
		$bg_color_css = "background-color:$bg_color;";
		$style_block = " style='$bg_color_css'";
	}

	// Pricing block custom text color
	if($text_color != ''){
		$text_color_css = "color:$text_color;";
		$style_text = " style='$text_color_css'";

		if($title_text_color == ''){
			$title_style_text = $style_text;
		}
	}

	$output .= "<div class='pricingtable-priceblock' $style_block>";
	$output .= $featured_badge;
	// $output .= "<h3 class='priceblock-plan' $style>$title</h3>";
	$output .= "<h3 class='priceblock-plan'$title_style_block><span$title_style_text>$title</span></h3>";
	$output .= "<h4 class='priceblock-price'$style_text>";
	$output .= "<sup>$currency</sup>";
	$output .= "<strong>$price</strong>";
	$output .= "<sub>$period</sub></h4>";
	$output .= "<p class='priceblock-description'$style_text>$description</p></div>";

	return $output;
}

?>