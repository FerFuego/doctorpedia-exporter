<?php 

class Doctorpedia_Exporter_Settings {

    public $settings = array();

    public function __construct() {
        add_action('admin_menu', array( $this, 'Doctorpedia_exporter_admin_menu' ) );
        add_action('admin_init', array($this, 'settings_init'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        $this->settings = get_option('Doctorpedia_exporter_settings');
    }

    /*--------------------------------*/
    /* Add Admin Menu
    /*--------------------------------*/

    public function Doctorpedia_exporter_admin_menu() {
        add_options_page( 'Doctorpedia Exporter', 'Doctorpedia Exporter', 'manage_options', 'Doctorpedia-exporter', array( $this, 'options_page' ) );
    }
    
    public function settings_init() {
        register_setting( 'Doctorpedia_exporter_settings', 'Doctorpedia_exporter_settings' );
    }

    public function settings_section_callback() {
        echo '<p>' . __( '', 'Doctorpedia-exporter' ) . '</p>';
    }

    public function options_page() {
        ?>
        <div class="wrap">
            <div class="container">
                <div class="postbox-container">
                    <h1>Doctorpedia Exporter</h1>
                    <h4>This plugin is responsible for generate an users report.</h4>
                    <hr>
                    <a href="#" onclick="Doctorpedia_exporter_run();" class="button btn button-primary">Run Report Builder</a>
                    <div id="response_import"></div>
                </div>
            </div>
        </div>
        <?php
    }

    /*--------------------------------*/
    /* Enqueue Scripts
    /*--------------------------------*/

    public function enqueue_scripts() {

        wp_enqueue_script('Doctorpedia-exporter-script', plugin_dir_url( __FILE__ ) . '../assets/js/doctorpedia-exporter.js', array('jquery'), '1.0.0', true);
        wp_localize_script('Doctorpedia_exporter_script', 'Doctorpedia_exporter_ajax', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce('Doctorpedia_exporter_nonce'),
        ));

        ?>
        <script type='text/javascript'>
        /* <![CDATA[ */
        var bms_vars = {"ajaxurl":"<?php echo bloginfo('url');?>\/wp-admin\/admin-ajax.php"};
        /* ]]> */
        </script>
    <?php }

}