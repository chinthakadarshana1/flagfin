<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/23/2019
 * Time: 1:17 PM
 */

class User extends CI_Controller
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
        $this->load->view('user/login');
    }

    public function loginUser(){
        $validateStatus = $this->validateUser();
        sendJson($validateStatus);
    }

    public function logoutUser(){
        unset(
            $_SESSION[SESSION_USER],
            $_SESSION[SESSION_TOKEN]
        );
        redirect('/user', 'refresh');
    }

    private function validateUser(){
        $ret = [];
        $ret["status"] = ["isSuccessfull"=>false,"message"=> ""];

        try{
            if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
                $userName = $_REQUEST['username'];
                $password = $_REQUEST['password'];

                $authResult = callAuth($userName,$password);
                if(isset($authResult)){
                    $authResult = json_decode($authResult);
                    if(isset( $authResult->error)){
                        $ret["status"]["message"] = $authResult->error_description;
                    }
                    else if(isset( $authResult->access_token)){
                        $_SESSION[SESSION_TOKEN] = $authResult->access_token;
                        $loggedInUser = $this->getUserDetails($authResult->access_token);
                        if(isset($loggedInUser)){
                            $_SESSION[SESSION_USER] = $loggedInUser;

                            $ret["data"] = $loggedInUser;
                            $ret["status"]["isSuccessfull"] = true;
                        }else{
                            $ret["status"]["message"] = "Authentication Error";
                        }
                    }
                    else
                        $ret["status"]["message"] = json_encode($ret);
                }else{
                    $ret["status"]["message"] = $ret;
                }
            }else{
                throw new Exception("Api Parameters are incorrect");
            }
        }catch (Exception $e){
            $ret["status"]["message"] = $e->getMessage();
        }
        return $ret;
    }

    private function getUserDetails($token){
        $userDataUrl = API_URL."Employee/GetCurrentUser";
        $userData = callAPI("POST",$userDataUrl,$token,false);
        return json_decode($userData);
    }

}