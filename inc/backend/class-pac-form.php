<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );

/**
 * Form data
 */

if(isset($_POST['pacFormSetting']) ){
	if( isset( $_POST['pac_form_nonce_field'] ) || wp_verify_nonce( $_POST['pac_form_nonce_field'], 'pac_form_nonce' ) ){
		if(isset($_POST['pac_form_option']) ){ 
			foreach( $_POST['pac_form_option'] as $key => $val ){
				$form_post_data[$key] = sanitize_text_field($val);
			}
			update_option( 'pac_form_options', $form_post_data );
		}
		echo "<div class='updated notice'>".__('Settings saved successfully', PAC_TEXT_DOMAIN )."</div>";
	}
}

$pac_form_options   = '';
$pac_form_options   = get_option('pac_form_options');
$pac_form_title     = !empty($pac_form_options['pac_form_title'])? $pac_form_options['pac_form_title']:'';
$pac_form_shortcode = !empty($pac_form_options['pac_form_shortcode'])? $pac_form_options['pac_form_shortcode']:'';
?>

<div id="poststuff">
	<form action="" method="post" >
		<div class="postbox">
			<h3 class="hndle"><span><?php esc_html_e('Form fields options', PAC_TEXT_DOMAIN );?> </span></h3>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th>
								<label>
									<?php esc_html_e('Form title ', PAC_TEXT_DOMAIN );?>
								</label>
							</th>
							<td>
								<input type="text" name="pac_form_option[pac_form_title]" class="pac-text" value="<?php echo $pac_form_title; ?>">
							</td>
						</tr>
						<tr>
							<th>
								<label>
									<?php esc_html_e('Display Contact Form7 ', PAC_TEXT_DOMAIN );?>
								</label>
							</th>
							<td>
								<input type="checkbox" class="pac-checkform" name="pac_form_option[pac_form_option_display]" value="1" <?php if(isset($pac_form_options['pac_form_option_display'])){ echo "checked"; } ?> >
							</td>
						</tr>						
						<tr class="psc-cf7-display">
							<th>						
							</th>
							<td>
								<?php esc_html_e('Note :- ', PAC_TEXT_DOMAIN );?>
								<?php if(!class_exists('WPCF7')){
									esc_html_e("You hasn't installed Contact form7 so please install Contact form7 to insert the shortcode below ", PAC_TEXT_DOMAIN );
								}else{
									esc_html_e("Please paste the shortcode below from Contact form7 ", PAC_TEXT_DOMAIN );
								} ?>
							</td>
						</tr>
						<tr class="psc-cf7-display">
							<th>
								<label>
									<?php esc_html_e('Contact Form7 shortcode ', PAC_TEXT_DOMAIN );?>
								</label>
							</th>
							<td>
								<input type="text" name="pac_form_option[pac_form_shortcode]" class="pac-text" value='<?php echo stripslashes($pac_form_shortcode); ?>'>
							</td>
						</tr>					
						<tr class="psc-form-fields">
							<th>
								<label>
									<?php esc_html_e('Display name field ', PAC_TEXT_DOMAIN );?>
								</label>
							</th>
							<td>
								<input type="checkbox" name="pac_form_option[pac_form_option1]" value="1" <?php if(isset($pac_form_options['pac_form_option1'])){ echo "checked"; } ?> >
							</td>
						</tr>
						<tr class="psc-form-fields">
							<th>
								<label>
									<?php esc_html_e('Display email field ', PAC_TEXT_DOMAIN );?> 
								</label>
							</th>
							<td>
								<input type="checkbox" name="pac_form_option[pac_form_option2]" value="1" <?php if(isset($pac_form_options['pac_form_option2'])){ echo "checked"; } ?> >
							</td>
						</tr>
						<tr class="psc-form-fields">
							<th>
								<label>
									<?php esc_html_e('Display subject field ', PAC_TEXT_DOMAIN );?>
								</label>
							</th>
							<td>
								<input type="checkbox" name="pac_form_option[pac_form_option3]" value="1" <?php if(isset($pac_form_options['pac_form_option3'])){ echo "checked"; } ?> >
							</td>
						</tr>
						<tr class="psc-form-fields">
							<th>
								<label>
									<?php esc_html_e('Display details field ', PAC_TEXT_DOMAIN );?>
								</label>
							</th>
							<td>
								<input type="checkbox" name="pac_form_option[pac_form_option4]" value="1" <?php if(isset($pac_form_options['pac_form_option4'])){ echo "checked"; } ?> >
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<?php wp_nonce_field('pac_form_nonce', 'pac_form_nonce_field') ?>
								<input type="submit" name="pacFormSetting" class="button-primary">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>