<?php

ini_set("display_errors", 1);
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Student_Controller extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('api/Student_model');
    }

    public function index_get() {
       
       // $this->db->db_debug = TRUE;
    
        
        $request_data = json_decode(file_get_contents("php://input"));
    
      
        if (isset($request_data->student_id)) {
            
            $student_id = $this->security->xss_clean($request_data->student_id);

            $data = $this->Student_model->get_single_data($student_id);

            if ($data) {
                $this->response(['status' => 1, 'message' => 'successfull', 'data' => $data], 200);
            } 
            else {
                $this->response(['status' => 0, 'message' => 'unsuccessful'], 404);
            }
        } 
        else {
            
            $data = $this->Student_model->get_all_data();
            
            if ($data) {
                $this->response(['status' => 1, 'message' => 'collected datas', 'data' => $data], 200);
            } 
            else {
                $this->response(['status' => 0, 'message' => 'empty data'], 400);
            }
        }
    }
    
    public function index_post() {

        
        $data =  json_decode(file_get_contents("php://input"));
       
       
        $name = $this->security->xss_clean($data->name);
        $email = $this->security->xss_clean($data->email);
        $password = $this->security->xss_clean($data->password);

if (empty($name) || empty($email) || empty($password)) {
    $this->response(['status' => 0, 'message' => 'data missing'], 400);
    return;
}

    $value = array(
    
    'name' => $name,
    'email' => $email,
    'password' => $password
         );


    $data = $this->Student_model->post_data($value);

    if($data){
    $this->response(['status' => 1, 'message' => 'Data created', 'data' => $data], 201);
} 
    else {
    $this->response(['status' => 0, 'message' => 'Failed to create data'], 500);
}
    }

    public function index_put() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->id) && !empty($data->name) && !empty($data->email) && !empty($data->password)) {
            $data = $this->Student_model->update_data($data->id, $data);

            if ($data) {
                $this->response(['status' => 1, 'message' => 'Data updated', 'data' => $data], 200);
            } else {
                $this->response(['status' => 0, 'message' => 'Failed to update data'], 500);
            }
        } else {
            $this->response(['status' => 0, 'message' => 'empty data'], 400);
        }
    }

    public function index_delete() {


        $data =  json_decode(file_get_contents("php://input"));
        $student_id = $this->security->xss_clean($data->student_id);

        if($this->Student_model->delete_data($student_id)){
            $this->response(['status' => 1, 'message' => 'deleted successfully'], 200);
        } else {
            $this->response(['status' => 0, 'message' => 'not deleted'], 404);
        }

        }
    }

?>
