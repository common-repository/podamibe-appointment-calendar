<?php
/*
  Plugin name: Podamibe Appointment Calendar
  Plugin URI: http://podamibenepal.com/wordpress-plugins/
  Description: Display your appointment,availability,book date on calendar with various layout and form in more easier and quicker way.
  Version: 1.1.6
  Author: Podamibe Nepal
  Author URI: http://podamibenepal.com/
  Text Domain: pac-appointment-calendar
  Domain Path: /languages/
  License: GPLv2 or later
 */

  if ( ! defined( 'ABSPATH' ) ) 
  	exit;

  /* Declare neccessary variable */

  !defined('PAC_VERSION') ? define( 'PAC_VERSION', '1.1.4' ) : null;
  !defined('PAC_TEXT_DOMAIN') ? define( 'PAC_TEXT_DOMAIN', 'pac-appointment-calendar' ) : null;
  !defined('PAC_INC_BE_DIR') ? define( 'PAC_INC_BE_DIR', plugin_dir_path( __FILE__ ) .'inc/backend/' ) : null;
  !defined('PAC_INC_FE_DIR') ? define( 'PAC_INC_FE_DIR', plugin_dir_path( __FILE__ ) .'inc/frontend/' ) : null;

  !defined('PAC_AST_DIR') ? define( 'PAC_AST_DIR', plugin_dir_url( __FILE__ ) .'assets' ) : null;

  /* Decleration of the class for necessary configuration of a plugin */

  if ( !class_exists( 'PAC_Class' ) ) {

  	class PAC_Class {

  		/* Declare the required variables */
  		private static $_instance = null;

  		/* Function of constructor */
  		private function __construct(){
  			$this->pac_defineConstants();
  			$this->pac_include_files();
  			register_activation_hook( __FILE__, array( $this, 'pac_plugin_activation' ) );
  			$this->pac_load_hooks();
  			$this->pac_load_front_scripts();
  			$this->pac_load_backend_scripts();
  		}

  		/* Function to get instance */
  		public static function _get_instance(){
  			if(is_null(self::$_instance)){
  				self::$_instance = new self;
  			}
  			return self::$_instance;
  		}

  		/* Function to include required files */
  		private function pac_include_files(){
  			include_once( PAC_INC_BE_DIR . 'class-pac-create-db.php');
  			include_once( PAC_INC_BE_DIR . 'class-pac-widget.php');
  			include_once( PAC_INC_FE_DIR . 'class-pac-form-element.php');
  			include_once( PAC_INC_FE_DIR . 'class-pac-sc.php');
  			include_once( PAC_INC_FE_DIR . 'class-pac-design.php');			
  		}

  		/* Function to load required wordpress hooks */
  		private function pac_load_hooks(){
  			add_action('admin_menu', array($this,'pac_menu_page') );
  			
  			add_action("wp_ajax_pac_insert_selected_date", array($this, "pac_add_selected_date") );
  			
  			add_action("wp_ajax_pac_front_form_data", array( $this, "pac_front_form_callback" ) );
  			
  			add_action("wp_ajax_nopriv_pac_front_form_data", array( $this, "pac_front_form_callback" ) );
  			
  			add_action('widgets_init', 'register_pac_widget');

			  add_action('wp_head', 'pac_custom_style');
			  
			  add_filter("plugin_row_meta", array($this, 'get_extra_meta_links'), 10, 4);
  		}

  		/* Function to load on plugin activation */
  		function pac_plugin_activation(){
  			PAC_Table_Generator::initTableStructureForPAC();
  		}

  		/* Function to enqueue required scripts for frontend */
  		private function pac_load_front_scripts(){
  			add_action( 'wp_enqueue_scripts', array($this,'pac_register_front_scripts') );
  			add_action( "wp_enqueue_scripts", array($this,'pac_localize_frontend') );
  		}

  		/* Function to enqueue required scripts for backend */
  		private function pac_load_backend_scripts(){
  			add_action( 'admin_enqueue_scripts', array($this,'pac_register_backend_scripts') );
  			add_action( "admin_enqueue_scripts", array($this,'pac_localize_backend') );
  		}

  		/* Function to add menu page */
  		public function pac_menu_page() {
  			add_menu_page(
  				esc_html__('Appointment Calendar', PAC_TEXT_DOMAIN ),
  				esc_html__('Appointment Calendar', PAC_TEXT_DOMAIN ),
  				'manage_options',
  				'podamibe-appointment-calendar',
  				array($this,'pac_main_function_callback'),
  				'dashicons-calendar'
  				);
  		}

  		/* Function for pac_load_front_scripts */
  		public function pac_register_front_scripts(){
  			$pbd_settings_options = get_option('pac_settings');
  			$pbd_theme            = !empty($pbd_settings_options['pac_theme']) ? $pbd_settings_options['pac_theme'] : '';

  			wp_enqueue_style( 'pac-front-calendar-style', PAC_AST_DIR. '/pac-calendar.css', true, PAC_VERSION );

  			if($pbd_theme == "theme_one"){
  				wp_enqueue_style( 'pac-front-style1', PAC_AST_DIR. '/pac-front-style.css', false, PAC_VERSION );
  			}elseif($pbd_theme == "theme_two"){
  				wp_enqueue_style( 'pac-front-style2', PAC_AST_DIR. '/pac-front-style-two.css', false, PAC_VERSION );
  			}elseif($pbd_theme == "theme_three"){
  				wp_enqueue_style( 'pac-front-style3', PAC_AST_DIR. '/pac-front-style-three.css', false, PAC_VERSION );
  			}else{
  				wp_enqueue_style( 'pac-front-style', PAC_AST_DIR. '/pac-front-style.css', false, PAC_VERSION );
  			}
  			wp_enqueue_script('jquery-ui-dialog');
  			wp_enqueue_script( 'pac-front-calendar-script', PAC_AST_DIR. '/pac-calendar.js', array( 'jquery'), true ,PAC_VERSION );
  			wp_enqueue_script( 'pac-front-script', PAC_AST_DIR. '/pac-front.js', array( 'jquery'), false ,PAC_VERSION );
  		}

  		/* Enqueue for pac_load_backend_scripts */
  		public function pac_register_backend_scripts(){
  			wp_enqueue_style( 'pac-backend-style', PAC_AST_DIR. '/pac-backend-style.css', true, PAC_VERSION );
  			wp_enqueue_style( 'pac-calendar-style', PAC_AST_DIR. '/pac-calendar.css', true, PAC_VERSION );
  			wp_enqueue_script( 'pac-calendar-script', PAC_AST_DIR. '/pac-calendar.js', array( 'jquery'), true ,PAC_VERSION );
  			wp_enqueue_script( 'pac-extra-script', PAC_AST_DIR. '/pac-extra.js', array( 'jquery'), true ,PAC_VERSION );
  			wp_enqueue_style( 'wp-color-picker' );
  			wp_enqueue_script( 'pac-color-picker-js', PAC_AST_DIR . '/pac-color-picker.js', array( 'wp-color-picker' ) );	
  		}

  		/* Function executed after selecting the date */
  		public	function pac_add_selected_date(){
  			global $wpdb;
  			$pac_get_inserted_date = get_option('pac_selected_date');
  			$pac_inserted_date     = array();
  			if($_POST["selected_date"]){	
  				$selected_date     = date( 'Y-m-d', strtotime($_POST["selected_date"]) );		
  				if(! $pac_get_inserted_date ){
  					array_push( $pac_inserted_date, $selected_date );
  				}
  				else{
  					$pac_inserted_date = $pac_get_inserted_date;
  					$key = array_search($selected_date,$pac_inserted_date);
  					if( $key !== false ){
  						unset($pac_inserted_date[$key]);
  					}else{
  						array_push( $pac_inserted_date, $selected_date );
  					}
  				}
  				update_option('pac_selected_date',$pac_inserted_date);
  			}
  			die();			
  		}

  		/* Function to submit the front form data to pac_user_table */
  		public function pac_front_form_callback(){
  			global $wpdb;
  			$pac_user_table = $wpdb->prefix.'pac_user';
  			$values = array();
  			parse_str($_POST['form_data'], $values);

  			foreach( $values as $value ){
  				$pac_fname       = $value['pac_user_form_name'];
  				$pac_email       = $value['pac_user_form_email'];
  				$pac_subject     = $value['pac_user_form_subject'];
  				$pac_remarks     = $value['pac_user_form_detail'];
  				$pac_booked_date = $value['pac_booked_date'];

  				$wpdb->insert( 
  					$pac_user_table, 
  					array( 
  						'name'        => $pac_fname, 
  						'email'       => $pac_email,
  						'subject'     => $pac_subject,
  						'remarks'     => $pac_remarks,
  						'booked_date' => $pac_booked_date
  						), 
  					array( 
  						'%s','%s','%s','%s','%s',
  						) 
  					);
  			}
  			die();			
  		}

  		/* Localize script of calendar for admin section */
  		public function pac_localize_backend(){
  			$pac_get_inserted_date      = get_option('pac_selected_date');
  			$pac_localize_backend_array = array("pac_inserted_date" => $pac_get_inserted_date );
  			wp_enqueue_script( "pac-extra-script" );
  			wp_localize_script( "pac-extra-script", "pac_date_vars", $pac_localize_backend_array );
  		}

  		/* Localize script of calendar for admin section */
  		public function pac_localize_frontend(){
  			$pac_get_inserted_date      = get_option('pac_selected_date');
  			$pac_localize_backend_array = array(
  				"pac_front_inserted_date"  => $pac_get_inserted_date,
  				'ajaxurl' => admin_url( 'admin-ajax.php' )
  				);
  			wp_enqueue_script( "pac-front-script" );
  			wp_localize_script( "pac-front-script", "pac_front_date_vars", $pac_localize_backend_array );
  		}

  		/* Callback function to add page */
  		public function pac_main_function_callback(){ ?>
  		<div class="pac-main-wrapper">
  			<div class="pac-main-title">
  				<?php esc_html_e('Podamibe Appointment Calendar', PAC_TEXT_DOMAIN); ?>
  			</div>
  			<ul class="tabs">
  				<li class="tab-link" data-tab="tab-1">
  					<?php esc_html_e("Calendar", PAC_TEXT_DOMAIN); ?>
  				</li>
  				<li class="tab-link" data-tab="tab-2">
  					<?php esc_html_e("Calendar setting", PAC_TEXT_DOMAIN); ?>
  				</li>
  				<li class="tab-link" data-tab="tab-3">
  					<?php esc_html_e("Form setting", PAC_TEXT_DOMAIN); ?>
  				</li>
  				<li class="tab-link" data-tab="tab-4">
  					<?php esc_html_e("Users List", PAC_TEXT_DOMAIN); ?>
  				</li>
  				<li class="tab-link" data-tab="tab-5">
  					<?php esc_html_e("How to use", PAC_TEXT_DOMAIN); ?>
  				</li>
  				<li class="tab-link" data-tab="tab-6">
  					<?php esc_html_e("About Us", PAC_TEXT_DOMAIN); ?>
  				</li>
  			</ul>
  			<div id="tab-1" class="tab-content">
  				<?php include_once( PAC_INC_BE_DIR . 'class-pac-calendar.php'); ?>
  			</div>
  			<div id="tab-2" class="tab-content">
  				<?php include_once( PAC_INC_BE_DIR . 'class-pac-setting.php'); ?>
  			</div>
  			<div id="tab-3" class="tab-content">
  				<?php include_once( PAC_INC_BE_DIR. 'class-pac-form.php' ); ?>
  			</div>
  			<div id="tab-4" class="tab-content">
  				<?php include_once( PAC_INC_BE_DIR . 'class-pac-users.php'); ?>
  			</div>
  			<div id="tab-5" class="tab-content">
  				<?php include_once( PAC_INC_BE_DIR . 'class-pac-instruction.php'); ?>
  			</div>
  			<div id="tab-6" class="tab-content">
  				<?php include_once( PAC_INC_BE_DIR . 'class-pac-about.php'); ?>
  			</div>
  		</div>
  		<?php }

  		private function pac_defineConstants() {
  			global $wpdb;
  			!defined('PAC_TABLE_PREFIX') ? define('PAC_TABLE_PREFIX', $wpdb->prefix . 'pac_') : null;
		  }
		  


			/**
			 * Adds extra links to the plugin activation page
			 */
			public function get_extra_meta_links($meta, $file, $data, $status) {

				if (plugin_basename(__FILE__) == $file) {
					$meta[] = "<a href='http://shop.podamibenepal.com/forums/forum/support/' target='_blank'>" . __('Support', 'pac-appointment-calendar') . "</a>";
					$meta[] = "<a href='http://shop.podamibenepal.com/downloads/podamibe-appointment-calendar/' target='_blank'>" . __('Documentation  ', 'pac-appointment-calendar') . "</a>";
					$meta[] = "<a href='https://wordpress.org/support/plugin/podamibe-appointment-calendar/reviews#new-post' target='_blank' title='" . __('Leave a review', 'pac-appointment-calendar') . "'><i class='ml-stars'><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg></i></a>";
				}
				return $meta;
			}


	} // class ends here

	PAC_Class::_get_instance();

} // class check ends here