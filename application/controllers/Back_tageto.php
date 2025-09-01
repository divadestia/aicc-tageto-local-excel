<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Back_tageto extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_tageto');
        $this->load->library('session');
    }

    function index()
    {
        $data = array(
            'title_bar'       => 'Data Tageto',
            'title'           => 'Data Tageto', //H4
            'br_title'           => $this->uri->segment('2'), //Breadcumb
            'br_title_active' => $this->uri->segment('3'), //Breadcumb

        );
        $this->load->view('back/data_tageto', $data);
    }

    function load_data()
    {
        $data = $this->M_tageto->load_data();
        echo json_encode($data);
    }

    function insert()
    {
        $data = array(

            'process_date'  => $this->input->post('process_date'),
            'charging_date' => $this->input->post('charging_date'),
            'model_id'  => $this->input->post('model_id'),
            'core_no'       => $this->input->post('core_no'),
            'cav'       => $this->input->post('cav'),
            'process1_a'       => $this->input->post('process1_a'),
            'process1_b'       => $this->input->post('process1_b'),
            'process2_c'       => $this->input->post('process2_c'),
            'process2_d'       => $this->input->post('process2_d'),
            'process3_e'       => $this->input->post('process3_e'),
            'oil_pump'       => $this->input->post('oil_pump'),
            'kijun_bosu3'       => $this->input->post('kijun_bosu3'),
            'bosu_cope'       => $this->input->post('bosu_cope'),
            'by_gauge'       => $this->input->post('by_gauge'),
            'slope_angel'       => $this->input->post('slope_angel'),
            'sampling'       => $this->input->post('sampling'),
            'remark'       => $this->input->post('remark'),
            'gabari'       => $this->input->post('gabari'),
            //'process_date' => date('Y-m-d H:i:s'),
            'created_at'   => date('Y-m-d H:i:s'),
            'created_log'  => $this->session->userdata('username')

        );

        $this->M_tageto->insert($data);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Successfully Added Data']);
    }

    function update()
    {
        $data = array(
            $this->input->post('table_column')    =>    $this->input->post('value'),
            'updated_at'   => date('Y-m-d H:i:s'),
            'updated_log'  => $this->session->userdata('username')
        );

        $this->M_tageto->update($data, $this->input->post('id'));
    }

    function delete()
    {
        $this->M_tageto->delete($this->input->post('id'));
    }


    //Get Data From DB Molding 
    public function get_model_data()
    {
        $db2 = $this->load->database('molding', TRUE);

        $query = $db2->get('model');

        if (!$query) {
            $error = $db2->error();
            echo json_encode(['error' => $error['message']]);
            return;
        }

        $result = $query->result_array();
        $formatted = array_map(function ($row) {
            return [
                'model' => $row['model'],
                'cav1' => $row['cav1'],
                'cav2' => $row['cav2']
            ];
        }, $result);

        echo json_encode($formatted);
    }
}
