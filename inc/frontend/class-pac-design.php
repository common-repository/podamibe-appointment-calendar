<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/**
 * Custom style file
 */
if(!function_exists('pac_custom_style')){
	function pac_custom_style(){
		$pac_settings_options  = get_option('pac_settings');
		$pac_color    = !empty($pac_settings_options['pac_color'] )? $pac_settings_options['pac_color'] : '';
		$pac_theme    = !empty($pac_settings_options['pac_theme'] )? $pac_settings_options['pac_theme'] : 'theme_one'; ?>

		<style type="text/css">
			<?php if($pac_color){ ?>
				.pac-front-calendar .pac_front_booked a.ui-state-default,.pac-front-calendar .pac_front_booked .ui-state-default.ui-state-active{
					background:<?php echo $pac_color; ?>;
				}

				.pac-na-text-box{
					background:<?php echo $pac_color; ?>;
				}
				<?php } ?>
			</style>
			<?php 
		}
	}