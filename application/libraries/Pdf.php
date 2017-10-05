<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
/**
 * Created by PhpStorm.
 * User: coldware
 * Date: 9/3/17
 * Time: 11:14 PM
 */
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF {
    function __construct(){
        parent::__construct();
    }

}