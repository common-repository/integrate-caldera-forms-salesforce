<?php
/**
 * Class ICFS file.
 * 
 * @package ICFS
 * @version 0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


if ( ! class_exists( 'ICFS', false ) ) :

    /**
     * ICFS Class
     */
	class ICFS {
		/**
         * Member Variable
         *
         * @var object instance
         */
        private static $instance;

        /**
         * Returns the *Singleton* instance of this class.
         *
         * @return Singleton The *Singleton* instance.
         */
        public static function get_instance() {
            if ( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Class Constructor
         * 
         * @since  0.0.1
         * @return void
         */
		public function __construct() {

			// Load text domain
			add_action( 'plugins_loaded', array( $this, 'icfs_plugin_load_textdomain' ) );
			// Check whether Caldera form is active or not
			register_activation_hook( __FILE__, array( $this, 'icfs_integration_activate' ) );
	    	
	    	//Register Processor Hook
	   		add_filter( 'caldera_forms_get_form_processors',  array( $this, 'icfs_register_processor' ) );
	   		
		}
		/**
		 * Check Caldera Forms is active or not
		 *
		 * @since 1.0
		 */
		public function icfs_integration_activate( $network_wide ) {
			 if( ! function_exists( 'caldera_forms_load' ) ) {
			    wp_die( 'The "Caldera Forms" Plugin must be activated before activating the "Caldera Forms - Salesforce Integration" Plugin.' );
			}
		}

	   	/**
		  * Load plugin textdomain.
		  *
		  * @since 1.0
		  */

		public function icfs_plugin_load_textdomain() {
			load_plugin_textdomain( 'integrate-caldera-forms-salesforce', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		  * Add Our Custom Processor
		  *
		  * @uses "caldera_forms_get_form_processors" filter
		  *
		  * @since 0.0.1
		  *
		  * @param array $processors
		  * @return array Processors
		  *
		  */

		public function icfs_register_processor( $processors ) {
		  	$processors['cf_salesforce_integration'] = array(
				'name'              =>  __( 'Salesforce Integration', 'integrate-caldera-forms-salesforce' ),
				'description'       =>  __( 'Send Caldera Forms submission data to Salesforce using Salesforce REST API.', 'integrate-caldera-forms-salesforce' ),
				'pre_processor'		=>  array( $this, 'cf_salesforce_integration_processor' ),
				'template' 			=>  __DIR__ . '/config.php'
			);
			return $processors;
		}


		/**
	 	 * At process, get the post ID and the data and save in salesforce using salesforce organization id
		 *
		 * @param array $config Processor config
		 * @param array $form Form config
		 * @param string $process_id Unique process ID for this submission
		 *
		 * @return void|array
		 */

		public function cf_salesforce_integration_processor( $config, $form, $process_id ) {

			if( !isset( $config['icfs_salesforce_environment'] ) || empty($config['icfs_salesforce_environment'] ) ) {
			    return;
			}

			if( !isset( $config['icfs_salesforce_org_id'] ) || empty( $config['icfs_salesforce_org_id'] ) ){
			    return;
		  	}

		  	if( !isset( $config['icfs_salesforce_debug_email'] ) || empty( $config['icfs_salesforce_debug_email'] ) ){
			    return;
		  	}

		  	if( !isset( $config['icfs_salesforce_obj'] ) || empty( $config['icfs_salesforce_obj'] ) ){
			    return;
		  	}

			$salesforce_environment = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_environment'] );

			$salesforce_org_id = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_org_id'] );
			$salesforce_debugging_email = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_debug_email'] );

			$salesforce_object = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_obj'] );
			$salesforce_first_name = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_first_name'] );

		  	$salesforce_last_name = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_last_name'] );

		  	$salesforce_email = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_email'] );
		  	$salesforce_company = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_company'] );
		  	$salesforce_title = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_title'] );
		  	$salesforce_mobile = Caldera_Forms::do_magic_tags( $config['icfs_salesforce_mobile'] );

		  	/* Saving form submission data into Salesforce using Salesforce REST API*/

		  	if( $salesforce_environment == "1" ) { 
		  		$obj = "webto";
		  	} else {
		  		$obj = "test";
		  	}
		  	
			//get the wordpress version
			$wp_version = get_bloginfo( 'version' );
			$header = array(
			  	'user-agent' => 'Caldera Salesforce plugin - WordPress/'.$wp_version.'; '.get_bloginfo( 'url' )
			  	);

			// URl for storing data in salesforce account
			$url =  sprintf( 'https://%s.salesforce.com/servlet/servlet.WebTo%s?encoding=UTF-8', $obj, $salesforce_object );

			// Push the organization id and debugging email to $post array
			$post = array(
					'first_name'	=> $salesforce_first_name,
					'last_name'		=> $salesforce_last_name,
					'email'			=> $salesforce_email,
					'title'			=> $salesforce_title,
					'company'		=> $salesforce_company,
					'phone'			=> $salesforce_mobile,
			        'debug' 		=> 1,
			        'debugEmail' 	=> $salesforce_debugging_email,
			        'oid' 			=> $salesforce_org_id
			    );

		  	//Converting array of data into a single line string having no space
		  	if( !empty( $post ) && is_array( $post ) ) {
			    $body = array();
			    foreach( $post as $key => $value ) {
			      	if( is_array( $value ) ) {
			        	foreach( $value as $val ) {
			          		$body[] = urlencode( $key ).'='.urlencode( $val );
			        	}
			      	}
			      	else{
			        	$body[] = urlencode( $key ).'='.urlencode( $value );
			     	}
			    }
			    
			    $post = implode( '&',$body );
			}

			$args = array(
				'body'      => $post,
				'headers'   => $header,
			    'timeout'   => 45,
			);

			// POST the data to Salesforce
			$results = wp_remote_post( $url, $args );

			// Find out what the response code is
			$code = wp_remote_retrieve_response_code( $result );
	        if( intval( $code ) !== 200 ) {
	        	return;
	        }
		}

	}

	/**
     * Calling class using 'get_instance()' method
     */
    ICFS::get_instance();

endif;

