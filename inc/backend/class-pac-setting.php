<?php
/**
 * setting file 
 */
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
if(isset($_POST['pac_setting']) ){
    if( isset( $_POST['pac_calendar_seting_nonce_field'] ) || wp_verify_nonce( $_POST['pac_calendar_seting_nonce_field'], 'pac_calendar_seting_nonce' ) ){
        foreach( $_POST['pac_setting'] as $key => $val ){
            $pac_settings[$key] = sanitize_text_field($val);
        }
    	update_option('pac_settings', $pac_settings );
    	echo "<div class='updated notice'>".__('Settings saved successfully', PAC_TEXT_DOMAIN )."</div>";
    }
}

$pbd_settings_options = get_option('pac_settings');
$pac_na_text          = !empty($pbd_settings_options['pac_na_text']) ? $pbd_settings_options['pac_na_text'] : '';
$pac_color            = !empty($pbd_settings_options['pac_color']) ? $pbd_settings_options['pac_color'] : '';
$pbd_theme            = !empty($pbd_settings_options['pac_theme']) ? $pbd_settings_options['pac_theme'] : 'theme_one'; ?>

<div id="poststuff">
	<form action="" method="post" >
		<div class="postbox">
			<h3 class="hndle">
				<span>
					<?php esc_html_e('Theme design options', PAC_TEXT_DOMAIN );?>
				</span>
			</h3>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th>
								<label>
									<?php esc_html_e('Select color', PAC_TEXT_DOMAIN );?> 
								</label>
							</th>
							<td>
								<input type="text" name="pac_setting[pac_color]" class="pac-color" value="<?php echo $pac_color; ?>">
							</td>
						</tr>
						<tr>
							<th>
								<label>
									<?php esc_html_e('Enter the indication text for color', PAC_TEXT_DOMAIN );?>
								</label>
							</th>
							<td>
								<input type="text" name="pac_setting[pac_na_text]" class="pac-text" value="<?php echo $pac_na_text; ?>">
							</td>
						</tr>
						<tr>
							<th>
								<label>
									<?php esc_html_e('Select theme', PAC_TEXT_DOMAIN );?> 
								</label>
							</th>
							<td>
								<input type="radio" name="pac_setting[pac_theme]" value="theme_one" <?php if($pbd_theme == "theme_one"){ echo "checked"; } ?>>
								<?php esc_html_e('Theme one', PAC_TEXT_DOMAIN );?><br/>

								<input type="radio" name="pac_setting[pac_theme]" value="theme_two" <?php if($pbd_theme == "theme_two"){ echo "checked"; } ?>>
								<?php esc_html_e('Theme two', PAC_TEXT_DOMAIN );?><br/>

								<input type="radio" name="pac_setting[pac_theme]" value="theme_three" <?php if($pbd_theme == "theme_three"){ echo "checked"; } ?>>
								<?php esc_html_e('Theme three', PAC_TEXT_DOMAIN );?>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
                                <?php wp_nonce_field('pac_calendar_seting_nonce', 'pac_calendar_seting_nonce_field') ?>
								<input type="submit" name="pacSetting" class="button-primary" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>