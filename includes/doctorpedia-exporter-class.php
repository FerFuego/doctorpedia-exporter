<?php

class Doctorpedia_Exporter {

    public function __construct() {
        require_once( DOCTORPEDIA_PLUGIN_DIR . '/includes/doctorpedia-exporter-errors-trait.php' );
        require_once( DOCTORPEDIA_PLUGIN_DIR . '/includes/doctorpedia-exporter-settings-class.php' );
        require_once( DOCTORPEDIA_PLUGIN_DIR . '/includes/doctorpedia-exporter-process-class.php' );
        add_action('doctorpedia_exporter_hook', array( $this, 'doctorpedia_exporter_hook' ) );
        add_action('wp_ajax_nopriv_run_exporter', array( $this, 'doctorpedia_exporter_cron_manually' ) );
        add_action('wp_ajax_run_exporter', array( $this, 'doctorpedia_exporter_cron_manually' ) );
    }
    
    public function init() {    
        new Doctorpedia_Exporter_Settings;
    }

    /**
     * Actuivation Manual
     * @param $action
     */
    public static function doctorpedia_exporter_cron_manually() {
        do_action( 'doctorpedia_exporter_hook' );
    }

    /**
     * Init Process of importing.
     */
    public function doctorpedia_exporter_hook() {
        $Doctorpedia_exporter_process = new Doctorpedia_Exporter_Process;
        $Doctorpedia_exporter_process->Doctorpedia_exporter_process_init();
    }
}
