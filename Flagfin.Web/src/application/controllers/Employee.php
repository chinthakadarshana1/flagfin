<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/23/2019
 * Time: 1:17 PM
 */

class Employee extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('employee/employee');
    }


}