<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Import Dompdf namespace
use Dompdf\Dompdf;

class Pdf extends Dompdf {
    public function __construct() {
        parent::__construct();
    }
}
