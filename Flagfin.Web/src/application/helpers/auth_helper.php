<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2018-11-12
 * Time: 06:33 PM
 */

function sendJson($ret){
    //add the header here
    header('Content-Type: application/json');
    echo json_encode( $ret );
}


function authorizeUser($role = ""){
    $ret = array("is_authorized"=>false,"return_url"=>"","user"=>null);

    if(isset($_SESSION[SESSION_USER])){
        $ret["user"] = $_SESSION[SESSION_USER];
        if($role != ""){
            if(isset($_SESSION[SESSION_USER])){
                //todo fetch roles
            }
        }
        else
            $ret["is_authorized"] = true;
    }else{
        $currentUrl = "";
        redirect("/user".($currentUrl != "" ? "?return=$currentUrl":""), 'refresh');
    }
    return $ret;
}


function callAPI($method, $url,$token, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    $headr = array();
    $headr[] = 'Content-length: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Bearer '.$token;

    curl_setopt($curl, CURLOPT_HTTPHEADER,$headr);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

function callAuth($userName,$password){
    $url = AUTH_URL;
    $userName = urlencode($userName);
    $password = urlencode($password);
    $myvars = 'client_id=webapp&client_secret=secret&grant_type=password&scope=AuthAPI&username=' . $userName . '&password=' . $password;

    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec( $ch );

    return $response;
}