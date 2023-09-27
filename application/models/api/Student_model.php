<?php

class Student_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_data() {
        return $this->db->get('rest')->result(); 
    }

    public function get_single_data($student_id) {
        $query = $this->db->get_where('rest', array('id' => $student_id), 1);

       // echo $this->db->last_query();

        if ($query->num_rows() === 1) {
            return $query->row_array();
        } else {
            return false; 
    }
}

    public function post_data($value) {
      return $this->db->insert('rest', $value);
       
    }

    public function update_data($student_id, $data) {
        $this->db->where('id', $student_id);
        return $this->db->update('rest', $data);
        
    }

    public function delete_data($student_id) {
        $this->db->where('id', $student_id);
      return $this->db->delete('rest');

        
    }
}
?>
