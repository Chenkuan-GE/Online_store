<?php
// application/controllers/Zip.php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zip extends CI_Controller {
    // Load Library.
    function __construct() {
        parent::__construct();
        $this->load->library('zip');

    }
    function download() {

        // pass second argument as FALSE if want to ignore preceding directories
        $this->zip->read_dir('./uploads/',FALSE);
        // create zip file on server
        $this->zip->archive('./downloads/'.'images.zip');
        // prompt user to download the zip file
        $this->zip->download('images.zip');
    }
}