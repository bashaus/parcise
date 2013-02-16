<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('php-activerecord');

        $cfg = ActiveRecord\Config::instance();
        $cfg->set_model_directory(APPPATH . 'models/');
        $cfg->set_connections(array(
            'development' =>'mysql://root:password@localhost/database_name'
        ));
        $cfg->set_default_connection('development');

        $this->load->library('session');
    }
}
