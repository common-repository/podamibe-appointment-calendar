<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/**
 * File loads the how to use how to use tab
 */
?>
<div id="poststuff">
	<div class="postbox">
		<h3 class="hndle">
			<span>
				<?php esc_html_e('Please follow the instruction properly', PAC_TEXT_DOMAIN );?>
			</span>
		</h3>
		<div class="inside">
			<table class="form-table">
				<tbody>
					<tr>
						<th colspan="2">
							<label>
								<?php esc_html_e('In case of using Contact Form7 ', PAC_TEXT_DOMAIN );?>
							</label>
						</th>
					</tr>
					<tr>
						<td colspan="2">
							<?php esc_html_e('- Go to Form setting tab and there you can find checkbox Display contact form7.', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php esc_html_e('- Check the Display option.', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php esc_html_e('- Paste the contact form shortcode on input field.', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php esc_html_e('- Go to Contact form7.', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php esc_html_e('- Select the form you are using.', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>
					<tr>
						<td>
							<?php esc_html_e('- Click form tab and add this code ', PAC_TEXT_DOMAIN );?>
						</td>
						<td><?php esc_html_e(' (  <input type="hidden" class="pac_hidden_booked_date" name="your-date" value="">  ) ', PAC_TEXT_DOMAIN); ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<?php esc_html_e('- Use [your-date] on messaage body on mail tab message body section.', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>

					<tr>
						<th colspan="2">
							<label>
								<?php esc_html_e('To use on new page : - ', PAC_TEXT_DOMAIN );?>
							</label>
						</th>
					</tr>
					<tr>
						<td colspan="2">
							<?php esc_html_e('- Create a new page.', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php _e('- Paste the shortcode <input type="text" readonly value="[pac_calendar]"> on content area.', PAC_TEXT_DOMAIN);?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php esc_html_e('- Publish the page.', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>
					<tr>
						<th colspan="2">
							<label>
								<?php esc_html_e('To use on already created page : - ', PAC_TEXT_DOMAIN );?>
							</label>
						</th>
					</tr>
					<tr>
						<td colspan="2">
							<?php _e('- If you want to use on already created page just place the shortcode <input type="text" readonly value="[pac_calendar]"> any where you desired. ', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>
					<tr>
						<th colspan="2">
							<label>
								<?php esc_html_e('To use on sidebar : - ', PAC_TEXT_DOMAIN );?>
							</label>
						</th>
					</tr>
					<tr>
						<td colspan="2">
							<?php esc_html_e('- Just drag the widget Appointment Calendar on your desired sidebar.', PAC_TEXT_DOMAIN );?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>