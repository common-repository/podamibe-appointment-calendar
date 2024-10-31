<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/**
* Form data
*/

global $wpdb;
$pac_user_table  =  $wpdb->prefix.'pac_user';

$pagenum  = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit    = 15; // number of rows in page
$offset   = ( $pagenum - 1 ) * $limit;
$total    = $wpdb->get_var( "SELECT COUNT(id) FROM $pac_user_table" );
$num_of_pages = ceil( $total / $limit );

if(isset( $_POST['pac_search'] ) ){
	if( $_POST['pac_search_user'] != '' ){
		$pac_search_user = sanitize_text_field( $_POST['pac_search_user'] );
	}
}

if(isset( $_POST['pac_search'] )){
	$pac_user_datas  =  $wpdb->get_results(" SELECT * FROM $pac_user_table WHERE name LIKE '%".$pac_search_user."%' LIMIT $offset, $limit");
}else{	
	$pac_user_datas  =  $wpdb->get_results(" SELECT * FROM $pac_user_table LIMIT $offset, $limit");
} ?>

<div class="pac-search-user">
	<form action="" method="post">
		<input type="text" class="pac-text" name="pac_search_user" value="" />
		<input type="submit" class="button-primary" name="pac_search" value="<?php esc_html_e('Search', PAC_TEXT_DOMAIN);?>" />
	</form>
</div>

<table class="wp-list-table widefat fixed striped users">
	<thead>
		<tr>
			<th scope="col" class="manage-column column-username column-primary desc">
				<span><?php esc_html_e('Id ', PAC_TEXT_DOMAIN );?></span>
			</th>
			<th scope="col" class="manage-column column-username column-primary desc">
				<span><?php esc_html_e('Name ', PAC_TEXT_DOMAIN );?></span>
			</th>
			<th scope="col" class="manage-column column-username column-primary desc">
				<span><?php esc_html_e('Email ', PAC_TEXT_DOMAIN );?></span>
			</th>
			<th scope="col" class="manage-column column-username column-primary desc">
				<span><?php esc_html_e('Booked Date ', PAC_TEXT_DOMAIN );?></span>
			</th>
			<th scope="col" class="manage-column column-username column-primary desc">
				<span><?php esc_html_e('Subject ', PAC_TEXT_DOMAIN );?></span>
			</th>
			<th scope="col" class="manage-column column-username column-primary desc">
				<span><?php esc_html_e('Details ', PAC_TEXT_DOMAIN );?></span>
			</th>
		</tr>
	</thead>
	<tbody id="the-list" data-wp-lists="list:user">
		<?php
		$pac_form_options   = '';
		$pac_form_options   = get_option('pac_form_options');
		$pac_form_shortcode = !empty($pac_form_options['pac_form_shortcode'])? $pac_form_options['pac_form_shortcode']:'';
		$pac_cform7_display = !empty($pac_form_options['pac_form_option_display'])? $pac_form_options['pac_form_option_display']:'';

		if( class_exists('WPCF7') && $pac_form_shortcode && $pac_cform7_display){

			echo '<tr><td colspan="6">'.esc_html__('You have installed contact form7 so please configure email settings and check your email for users detail', PAC_TEXT_DOMAIN).'</td></tr>'; 

		}elseif($pac_user_datas){ 
			foreach( $pac_user_datas as $pac_user_data ){ ?>
			<tr>
				<td><?php echo $pac_user_data->id; ?></td>
				<td><?php echo $pac_user_data->name; ?></td>
				<td><?php echo $pac_user_data->email; ?></td>
				<td><?php echo $pac_user_data->booked_date; ?></td>
				<td><?php echo $pac_user_data->subject; ?></td>
				<td><?php echo $pac_user_data->remarks; ?></td>
			</tr>
			<?php } 
		} else { 
			echo '<tr><td colspan="6">'.esc_html__('No users found', PAC_TEXT_DOMAIN).'</td></tr>'; 
		} ?>
	</tbody>
</table>

<?php if($total > $limit){

	$page_links     =  paginate_links( array(
		'base'      => add_query_arg( 'pagenum', '%#%' ),
		'format'    => '',
		'prev_text' => __( '&laquo;', PAC_TEXT_DOMAIN ),
		'next_text' => __( '&raquo;', PAC_TEXT_DOMAIN ),
		'total'     => $num_of_pages,
		'current'   => $pagenum,
		) );
	if ( $page_links ) {
		echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
	}
}