<?php 
/**
 * Plugin Name: Doctorpedia Exporter
 * Plugin URI: https://www.doctorpedia.com
 * Description: Export data from the database to a XLSX file.
 * Version: 1.0
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('DOCTORPEDIA_GF_FIELD_VERSION', '1.0');
define('DOCTORPEDIA_PLUGIN_DIR', dirname( __FILE__ ) );
define('DOCTORPEDIA_EXPORTER_LOG_FILE', DOCTORPEDIA_PLUGIN_DIR .'/logs/log_'.date("j.n.Y", current_time( 'timestamp', 0 )).'.log' );
define('DOCTORPEDIA_EXPORTER_TMP_FILE', DOCTORPEDIA_PLUGIN_DIR .'/tmp' );
define('DOCTORPEDIA_EXPORTER_LOG_ERROR_FILE', DOCTORPEDIA_PLUGIN_DIR .'/logs/log_error_'.date("j.n.Y", current_time( 'timestamp', 0 )).'.log' );

if ( !class_exists( 'Doctorpedia_exporter_Class' ) ) {
    require_once( DOCTORPEDIA_PLUGIN_DIR . '/includes/doctorpedia-exporter-class.php' );
}

/**
 * Load plugin
 */
$Doctorpedia = new Doctorpedia_exporter();
$Doctorpedia->init();