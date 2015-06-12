<?php
class Redux_Options_google_webfonts {

    /**
     * Field Constructor.
     *
     * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
     *
     * @since Redux_Options 1.0.0
    */
    function __construct($field = array(), $value ='', $parent) {
        $this->field = $field;
		$this->value = $value;
		$this->args = $parent->args;
    }

    /**
     * Field Render Function.
     *
     * Takes the vars and outputs the HTML for the field in the settings
     *
     * @since Redux_Options 1.0.0
    */
    function render() {
        $class = (isset($this->field['class'])) ? $this->field['class'] : '';
        echo '<input type="hidden" id="' . $this->field['id'] . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . ']" class="fontselect '.$class.'"  ' . 'value="' . esc_attr($this->value) . '" />';
		echo '<br /><input type="text" id="' . $this->field['id'] . '-example" class="redux-font-select fs-example" value="Lorem Ipsum is simply dummy text" /><input type="button" id="' . $this->field['id'] . '-smaller" class="redux-font-select fs-size button" value="A-" /><input type="button" id="' . $this->field['id'] . '-bigger" class="redux-font-select fs-size button" value="A+" />';
        echo (isset($this->field['desc']) && !empty($this->field['desc'])) ? ' <span class="description">' . $this->field['desc'] . '</span>' : '';
    }

    /**
     * Enqueue Function.
     *
     * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
     *
     * @since Redux_Options 1.0.0
    */
    function enqueue() {
				


				//This part allows you to add array of Google font dynamicaly from googles servise
				$all_fonts = array();
				$url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAvRKPIUQKsGjDYIwa41GnWm3gr8-bUzXI';

                if  (in_array  ('curl', get_loaded_extensions())) { //get those with curl by default

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    $data = curl_exec($curl);
                    curl_close($curl);
                    $fonts = json_decode(  $data, ARRAY_A);

                    
                }
                else //if curl not available get with file get contents
                {
                    $fonts = json_decode( 
						file_get_contents( $url ),
						ARRAY_A
				    );


                }


                if(is_array($fonts))
				foreach ($fonts['items'] as $font){
						if(count($font['variants']) > 1){
								foreach($font['variants'] as $single_variant){
										$all_fonts[] = $font['family'].':'.$single_variant;
								}
						}
				}
				wp_register_script( 'dynamic_fonts_add', get_template_directory_uri().'/inc/admin/options/fields/google_webfonts/jquery.fontselect.js' );
				wp_localize_script( 'dynamic_fonts_add', '_fonts', $all_fonts );
				wp_enqueue_script( 'dynamic_fonts_add' );
				
        // wp_enqueue_script(
        //     'redux-opts-googlefonts-js', 
        //     Redux_OPTIONS_URL . 'fields/google_webfonts/jquery.fontselect.js', 
        //     array('jquery'),
        //     time(),
        //     true
        // );
    }
}
