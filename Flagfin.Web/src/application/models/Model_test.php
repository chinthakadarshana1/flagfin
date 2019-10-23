<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2019-03-23
 * Time: 11:48 AM
 */

class Model_test extends CI_Model{

    public function searchTest($pageNo,$pageSize,$sortBy,$freeText,$testId,$testName,$testEmail){
        $ret = null;

        $qry = "CALL test_search($pageNo,$pageSize,$sortBy,'$freeText',$testId,'$testName','$testEmail');";
        $ret = $this->mysqlsp->CallSp($qry);

        return $ret;
    }

    public function getTest($testId){
        $ret = null;

        $this->db->select('*');
        $this->db->from('test');
        $this->db->where('test_id', $testId);
        $query= $this->db->get();
        $ret=$query->result();

        $error = $this->db->error();

        // If an error occurred, $error will now have 'code' and 'message' keys...
        if (isset($error['message'])&& $error['message'] != "") {
            throw new Exception($error['message']);
        }

        return $ret;
    }

    public function saveTest($testId,$testName,$testEmail)
    {
        $ret = null;

        $cols = array('name'=>$testName, 'email'=>$testEmail
        ,'updated_date'=>date("Y-m-d H:i:s"),'updated_user_id'=>$_SESSION[SESSION_USER]["user_id"]);

        $this->db->where('test_Id', $testId);
        $this->db->update('test',$cols);

        $error = $this->db->error();

        if (isset($error['message'])&& $error['message'] != "") {
            throw new Exception($error['message']);
        }else{
            $ret = $this->getTest($testId);
        }

        return $ret;
    }

    public function addTest($testName,$testEmail)
    {
        $ret = null;

        $cols = array('name'=>$testName, 'email'=>$testEmail
        ,'created_date'=>date("Y-m-d H:i:s"),'created_user_id'=>$_SESSION[SESSION_USER]["user_id"]);

        $this->db->insert('test',$cols);
        $insert_id = $this->db->insert_id();

        $error = $this->db->error();

        if (isset($error['message'])&& $error['message'] != "") {
            throw new Exception($error['message']);
        }else{
            $ret = $this->getTest($insert_id);
        }

        return $ret;
    }

}

