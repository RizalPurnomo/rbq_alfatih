<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core Controller Base Class
 *
 * Induk dari seluruh controller internal dan publik di RBQ Al Fatih.
 * Memuat anotasi properti PHPDoc untuk autocompletion dan static analysis.
 *
 * @property CI_DB_query_builder   $db
 * @property CI_DB_forge           $dbforge
 * @property CI_Benchmark          $benchmark
 * @property CI_Config             $config
 * @property CI_Controller         $controller
 * @property CI_Exceptions         $exceptions
 * @property CI_Hooks              $hooks
 * @property CI_Input              $input
 * @property CI_Lang               $lang
 * @property CI_Loader             $load
 * @property CI_Log                $log
 * @property CI_Output             $output
 * @property CI_Router             $router
 * @property CI_Security           $security
 * @property CI_URI                $uri
 * @property CI_Utf8               $utf8
 * @property CI_Form_validation    $form_validation
 * @property CI_Session            $session
 * @property CI_Upload             $upload
 * @property CI_Pagination         $pagination
 *
 * Custom Library
 * @property Auth_lib              $auth_lib
 *
 * Models
 * @property User_model            $User_model
 * @property Santri_model          $Santri_model
 * @property Kelas_model           $Kelas_model
 * @property Kelompok_model        $Kelompok_model
 * @property Semester_model        $Semester_model
 * @property TahunAjaran_model     $TahunAjaran_model
 * @property Kas_model             $Kas_model
 * @property Tabungan_model        $Tabungan_model
 * @property Raport_model          $Raport_model
 * @property Berita_model          $Berita_model
 * @property Pengajar_model        $Pengajar_model
 *
 * @package    RBQ Al Fatih
 * @subpackage Core
 * @category   Base Controller
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class MY_Controller extends CI_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
}
