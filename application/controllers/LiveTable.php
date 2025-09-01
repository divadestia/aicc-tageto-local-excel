<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LiveTable extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('livetable_model');
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
        $this->load->view('live_table', $data);
    }

    function load_data()
    {
        $data = $this->livetable_model->load_data();
        echo json_encode($data);
    }

    function insert()
    {
        $data = array(

            //'procces_date'  => $this->input->post('process_date'),
            //'charging_date' => $this->input->post('charging_date'),
            //'type_product'  => $this->input->post('type_product'),
            //'core_no'       => $this->input->post('core_no'),
            //'cav1'       => $this->input->post('cav1'),
            //'process1_a'       => $this->input->post('process1_a'),
            //'process1_b'       => $this->input->post('process1_b'),
            //'process2_c'       => $this->input->post('process2_c'),
            //'process2_c'       => $this->input->post('process2_c'),
            //'process3_e'       => $this->input->post('process3_e'),
            //'oil_pump'       => $this->input->post('oil_pump'),
            //'kijun_bosu'       => $this->input->post('kijun_bosu'),
            //'bosu_cope'       => $this->input->post('bosu_cope'),
            //'by_gauge'       => $this->input->post('by_gauge'),
            //'process2'       => $this->input->post('process2'),
            //'sampling'       => $this->input->post('sampling'),
            //'remark'       => $this->input->post('remark'),
            //'gabari'       => $this->input->post('gabari'),
            'first_name'     => $this->input->post('first_name'),
            'last_name'      => $this->input->post('last_name'),
            'age'            => $this->input->post('age'),
            'process_date'  => $this->input->post('process_date'),
            'charging_date' => $this->input->post('charging_date'),
            'product_type'  => $this->input->post('product_type'),
            'gabari' => $this->input->post('gabari'),
            'process_date' => date('Y-m-d H:i:s'),
            'created_at'   => date('Y-m-d H:i:s'),
            'created_log'  => $this->session->userdata('username')

        );

        $this->livetable_model->insert($data);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
    }

    function update()
    {
        $data = array(
            $this->input->post('table_column')    =>    $this->input->post('value'),
            'updated_at'   => date('Y-m-d H:i:s'),
            'updated_log'  => $this->session->userdata('username')
        );

        $this->livetable_model->update($data, $this->input->post('id'));
    }

    function delete()
    {
        $this->livetable_model->delete($this->input->post('id'));
    }
}
