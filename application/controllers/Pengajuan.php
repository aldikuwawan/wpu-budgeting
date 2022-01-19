<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Pengajuan_model');
        $this->load->library('form_validation');
        $this->load->library('template');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'pengajuan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pengajuan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'pengajuan/index.html';
            $config['first_url'] = base_url() . 'pengajuan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pengajuan_model->total_rows($q);
        $pengajuan = $this->Pengajuan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'user' => $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array(),
            'pengajuan_data' => $pengajuan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'classnyak' => $this
        );
        $this->template->load('pengajuan/pengajuan_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Pengajuan_model->get_by_id($id);
        if ($row) {
            $data = array(
                'user' => $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array(),
        		'id_pengajuan' => $row->id_pengajuan,
        		'data_pengajuan' => $row->data_pengajuan,
        		'jenis_pengajuan' => $row->jenis_pengajuan,
        		'pengimput' => $row->pengimput,
                'user_id' => $row->user_id,
        		'status_kirim' => $row->status_kirim,
        		'tanggal' => $row->tanggal,
                'classnyak' => $this,
                'role_data' => $this->db->where('id', $row->pengimput)->get('user_role')->row()
    	    );
            $this->template->load('pengajuan/pengajuan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengajuan'));
        }
    }

    public function create() 
    {
        $data = array(
            'user' => $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array(),
            'button' => 'Create',
            'action' => site_url('pengajuan/create_action'),
    	    'id_pengajuan' => set_value('id_pengajuan'),
    	    'data_pengajuan' => set_value('data_pengajuan'),
    	    'jenis_pengajuan' => set_value('jenis_pengajuan'),
    	    'pengimput' => set_value('pengimput'),
    	    'status_kirim' => set_value('status_kirim'),
    	    'tanggal' => set_value('tanggal'),
            'role_data' => $this->db->where('id', $this->session->userdata('role_id'))->get('user_role')->row()
    	);
        $this->template->load('pengajuan/pengajuan_form', $data);
    }
    
    public function create_action() 
    {

        $arraydatapengajuan = [];

        $cost_center = $this->input->post('cost_center');

        $i = 1;

        foreach ($cost_center as $key => $value) {
            $arraydatapengajuan[] = array(
                'datake' => $i,
                 'cost_center' => $this->input->post('cost_center')[$key], 
                'cost_element_name' => $this->input->post('cost_element_name')[$key], 
                'cost_element' => $this->input->post('cost_element')[$key], 
                'work_activity' => $this->input->post('work_activity')[$key], 
                'value' => $this->input->post('value')[$key], 
            );

            $i++;
        }

        // echo json_encode($arraydatapengajuan);

        $data = array(
    		'data_pengajuan' => json_encode($arraydatapengajuan),
    		'jenis_pengajuan' => $this->input->post('jenis_pengajuan',TRUE),
            'keterangan' => $this->input->post('keterangan',TRUE),
    		'pengimput' => $this->session->userdata('role_id'),
            'user_id' => $this->session->userdata('user_id'),
    		'status_kirim' => 0
       );

        $this->Pengajuan_model->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('pengajuan'));
    }
    
    public function update($id) 
    {
        $row = $this->Pengajuan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pengajuan/update_action'),
        		'id_pengajuan' => set_value('id_pengajuan', $row->id_pengajuan),
        		'data_pengajuan' => set_value('data_pengajuan', $row->data_pengajuan),
        		'jenis_pengajuan' => set_value('jenis_pengajuan', $row->jenis_pengajuan),
        		'pengimput' => set_value('pengimput', $row->pengimput),
        		'status_kirim' => set_value('status_kirim', $row->status_kirim),
        		'tanggal' => set_value('tanggal', $row->tanggal),
    	    );
            $this->template->load('pengajuan/pengajuan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengajuan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pengajuan', TRUE));
        } else {
            $data = array(
    		'data_pengajuan' => $this->input->post('data_pengajuan',TRUE),
    		'jenis_pengajuan' => $this->input->post('jenis_pengajuan',TRUE),
    		'pengimput' => $this->input->post('pengimput',TRUE),
    		'status_kirim' => $this->input->post('status_kirim',TRUE),
    		'tanggal' => $this->input->post('tanggal',TRUE),
    	    );

            $this->Pengajuan_model->update($this->input->post('id_pengajuan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pengajuan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Pengajuan_model->get_by_id($id);

        if ($row) {
            $this->Pengajuan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pengajuan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengajuan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('data_pengajuan', 'data pengajuan', 'trim|required');
	$this->form_validation->set_rules('jenis_pengajuan', 'jenis pengajuan', 'trim|required');
	$this->form_validation->set_rules('pengimput', 'pengimput', 'trim|required');
	$this->form_validation->set_rules('status_kirim', 'status kirim', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');

	$this->form_validation->set_rules('id_pengajuan', 'id_pengajuan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "pengajuan.xls";
        $judul = "pengajuan";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Data Pengajuan");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Pengajuan");
	xlsWriteLabel($tablehead, $kolomhead++, "Pengimput");
	xlsWriteLabel($tablehead, $kolomhead++, "Status Kirim");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");

	foreach ($this->Pengajuan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->data_pengajuan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_pengajuan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->pengimput);
	    xlsWriteNumber($tablebody, $kolombody++, $data->status_kirim);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function get_data_user($id)
    {
        return $this->db->where('id', $id)->get('user')->row();
    }

}

/* End of file Pengajuan.php */
/* Location: ./application/controllers/Pengajuan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-01-13 06:33:55 */
/* http://harviacode.com */