<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Escpos {
    public function __construct() {
        require_once APPPATH . 'third_party/mike42pos/autoload.php';
    }
}

?>