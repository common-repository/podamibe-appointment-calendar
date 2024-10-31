<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/**
* Shortcode file for book date plugin
*
* Function to create the shortcode
*/

if(!function_exists('pac_calendar_shortcode')){
	function pac_calendar_shortcode($is_widget=false){
		// form options data
		$pac_front_form_elements = '';

		$pac_front_form_elements = pbd_front_form_fields();
		
		$pac_form_options      = get_option('pac_form_options');
		
		// settings data
		$pac_settings_options  = get_option('pac_settings');
		$pac_color             = !empty($pac_settings_options['pac_color'])? $pac_settings_options['pac_color'] : '';
		$pac_na_text           = !empty($pac_settings_options['pac_na_text'])? $pac_settings_options['pac_na_text'] : '';
		$pac_form_title        = !empty($pac_form_options['pac_form_title'])? $pac_form_options['pac_form_title'] : 'Booking Form';
		$pac_form_shortcode    = !empty($pac_form_options['pac_form_shortcode'])? $pac_form_options['pac_form_shortcode']:'';
		$pac_cform7_display    = !empty($pac_form_options['pac_form_option_display'])? $pac_form_options['pac_form_option_display']:'';
		
		// selected date
		$pac_get_inserted_date = get_option('pac_selected_date');

		$html  = '';
		$html .= '<div class="pac-calendar-sc-wrapper pac-front-calendar">';
		if($is_widget){
			$html .= '<div class="pac-front-widget-calendar"></div>';
		}else{	
			$html .= '<div class="pac-frontcalendar"></div>';
		}
		$html .= '<div class="pac-na-text-box"></div>';
		$html .= '<div class="pac-na-text">'.$pac_na_text.'</div>';
		$html .= '</div>';
		
		if($is_widget){
			$html .= '<div class="pac-book-form-widget" title="'.$pac_form_title.'">';
		}
		else{
			$html .= '<div class="pac-book-form" title="'.$pac_form_title.'">';
		}
		
		if(class_exists('WPCF7') && $pac_form_shortcode && $pac_cform7_display){

			$html .= do_shortcode(stripslashes($pac_form_shortcode));
			
		}else{
			$html .= '<form class="pac_front_form" action="" method="post">';
			foreach($pac_front_form_elements as $key=>$fields){

				if(isset($fields['attribute']) && $fields['attribute'] != ''){
					$attribute = '';
					$attributes = array();
					$attribute_array = array_filter($fields['attribute']);
					foreach($attribute_array as $attr_key => $attr_val){
						$attributes[] = "$attr_key = '$attr_val'";
					}
					$attribute = implode(' ', $attributes);
				}

				switch ($fields['type']) {
					case 'text':
					if($fields['option'] == 1){
						$html.= '<label '.$attribute.' for="'.$fields['label'].'">'.$fields['label'].'</label>
						<input '.$attribute.' type="text" name="'.$fields['name'].'" value="'.$fields['value'].'"/>';
					}else{
						continue;
					}
					break;

					case 'textarea':
					if($fields['option'] == 1){
						$html.= '<label '.$attribute.' for="'.$fields['label'].'">'.$fields['label'].'</label>
						<textarea rows="4" cols="50" '.$attribute.'name="'.$fields['name'].'">'.$fields['value'].'</textarea>';
					}else{
						continue;
					}
					break;

					default:
					$html.= '';
					break;
				}

			}	
			$html .= '<input type="hidden" name="pac_user_form[pac_booked_date]" class="pac_hidden_booked_date" value="" >';
			$html .= '<input type="submit" class="button-primary pac-btn" id="pac_front_btn" name="pac_front_btn" value="'.__('Submit', PAC_TEXT_DOMAIN).'">';
			$html .= '</form>';
		}
		$html .= '</div>';

		return $html;
	}
}

add_shortcode('pac_calendar','pac_calendar_shortcode');