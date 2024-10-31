<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/**
 * Form element file
 */
function pbd_front_form_fields(){

	$pac_form_options      = '';
	$pac_settings_options  = '';
	$pac_form_options      = get_option('pac_form_options');
	$pac_settings_options  = get_option('pac_settings');
	
	$pac_front_form_elements = array(

		array(
			"label" => esc_html__("Name", PAC_TEXT_DOMAIN),				
			"name"  => "pac_user_form[pac_user_form_name]",
			"type"  => "text",
			"option" => ( isset( $pac_form_options['pac_form_option1'] ) ) ? 1 : 0,
			"value" => "",
			"attribute" => array(
				"data-id" => "pac_user_form_name",
				"class"   => "pac-form pac-form-name"
				)
			),
		array(
			"label" => esc_html__("Email", PAC_TEXT_DOMAIN),				
			"name"  => "pac_user_form[pac_user_form_email]",
			"type"  => "text",
			"option" => ( isset( $pac_form_options['pac_form_option2'] ) ) ? 1 : 0,
			"value" => "",
			"attribute" => array(
				"data-id" => "pac_user_form_email",
				"class"   => "pac-form pac-form-email"
				)
			),
		array(
			"label" => esc_html__("Subject", PAC_TEXT_DOMAIN),				
			"name"  => "pac_user_form[pac_user_form_subject]",
			"type"  => "text",
			"option" => ( isset( $pac_form_options['pac_form_option3'] ) ) ? 1 : 0,
			"value" => "",
			"attribute" => array(
				"data-id" => "pac_user_form_subject",
				"class"   => "pac-form pac-form-subject"
				)
			),
		array(
			"label" => esc_html__("Detail", PAC_TEXT_DOMAIN),				
			"name"  => "pac_user_form[pac_user_form_detail]",
			"type"  => "textarea",
			"option" => ( isset( $pac_form_options['pac_form_option4'] ) ) ? 1 : 0,
			"value" => "",
			"attribute" => array(
				"data-id" => "pac_user_form_detail",
				"class"   => "pac-form pac-form-detail"
				)
			)

		);

	return $pac_front_form_elements;

}