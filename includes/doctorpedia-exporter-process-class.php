<?php
require DOCTORPEDIA_PLUGIN_DIR . "/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Doctorpedia_Exporter_Process extends Doctorpedia_Exporter_Settings {

    use Errors;

    private $doctorpedia_products = array();
    private $count_data = 0;
    private $count_error = array();
    public $log_error = array();

    public function __construct() {
        $this->settings = get_option('Doctorpedia_exporter_settings');
    }

    /**
    * Get DB Content
    */
    public function Doctorpedia_exporter_process_init() {

        $users = get_users( array( 'role__in' => array('administrator', 'subscriber', 'author', 'blogger') ) );
        $this->count_data = @count($users);

        if(!empty($users)) {
            $resume = $this->Doctorpedia_exporter_process_products($users);
        }

        wp_send_json_success($resume);
    }

    /**
    * Process Products
    */
    public function Doctorpedia_exporter_process_products($users) {


        // write each row at a time to a file
        $header = "User ID, User Name, User Email, User Role\n";
        $spread = new Spreadsheet();
        $spread ->getProperties()
                ->setCreator("Doctorpedia Team")
                ->setTitle('Doctorpedia User Export');
        
        $sheetData1 = $spread->getActiveSheet();
        $sheetData1->setTitle("Users");
        
        $header = ["User ID", "User Name", "User Email", "User Role"];
        $sheetData1->fromArray($header, null, 'A1');
        $row = 2;

        foreach($users as $user) {
            $sheetData1->setCellValueByColumnAndRow(1, $row, $user->ID);
            $sheetData1->setCellValueByColumnAndRow(2, $row, $user->display_name);
            $sheetData1->setCellValueByColumnAndRow(3, $row, $user->user_email);
            $sheetData1->setCellValueByColumnAndRow(4, $row, $this->Doctorpedia_get_user_roles($user));
            $row++;
        }
        
        $fileName="Doctorpedia-Export-".date("d-m-Y", current_time( 'timestamp', 0 )).".xlsx";

        $writer = new Xlsx($spread);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');

        $writer->save(DOCTORPEDIA_EXPORTER_TMP_FILE .'/'. $fileName);
        //$writer->save('php://output');

        return plugin_dir_url(__DIR__) .'tmp/'. $fileName;
    }

    /**
     * Get ser Roles
     */
    public function Doctorpedia_get_user_roles ($user) {
        $user_meta = get_userdata($user->ID);
        $user_roles = $user_meta->roles;
        return implode('"', $user_roles);
    }

}