<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

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

    public function create() 
    {
        $p = $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array();

        $role_data = $this->db->where('id', $this->session->userdata('role_id'))->get('user_role')->row();
        $data = array(
            'user' => $p,
            'button' => 'Buat',
    	    'id_pengajuan' => '',   
    	    'data_pengajuan' => set_value('data_pengajuan'),
    	    'jenis_pengajuan' => set_value('jenis_pengajuan'),
            'nama_penginput' => $p['name'],
            'role' => $role_data->role,
    	    'pengimput' => set_value('pengimput'),
    	    'status_kirim' => set_value('status_kirim'),
    	    'tanggal' => set_value('tanggal'),
            'keterangan' => set_value('keterangan'),
    	);
        $this->template->load('pengajuan/pengajuan_form', $data);
    }
    
    public function update($id) 
    {
        $row = $this->Pengajuan_model->get_by_id($id);
        $p = $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array();

        if ($row) {
            $p = $this->db->get_where('user', [
                'id' => $row->user_id
            ])->row_array();

            $role_data = $this->db->where('id', $row->pengimput)->get('user_role')->row();
            $data = array(
                'user' => $p,
                'button' => 'Edit',
        		'id_pengajuan' => $row->id_pengajuan,
                'nama_penginput' => $p['name'],
                'role' => $role_data->role,
        		'data_pengajuan' => $row->data_pengajuan,
        		'jenis_pengajuan' => set_value('jenis_pengajuan', $row->jenis_pengajuan),
        		'pengimput' => set_value('pengimput', $row->pengimput),
        		'status_kirim' => set_value('status_kirim', $row->status_kirim),
        		'tanggal' => set_value('tanggal', $row->tanggal),
                'keterangan' => set_value('keterangan', $row->keterangan),
    	    );
            $this->template->load('pengajuan/pengajuan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengajuan'));
        }
    }
    
    public function send_pengajuan() 
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $row = $this->Pengajuan_model->get_by_id($id_pengajuan);

        if ($row) {
            $datatoupdate = array(
                'status_kirim' => 1
            );

            $this->Pengajuan_model->update($id_pengajuan,$datatoupdate);

            $arr = array(
                'response' => 'ok'
            );

            echo json_encode($arr);
            // $this->session->set_flashdata('message', 'Pengajuan Berhasil Dikirim');
            // redirect(site_url('pengajuan'));

        } else {
            echo 'error sending pengajuan';
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

    public function update_listdata_pengajuan()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $jenis_pengajuan = $this->input->post('jenis_pengajuan');
        $keterangan = $this->input->post('keterangan');

        $listpengajuannya = $this->input->post('data_pengajuan');
        // print_r($listpengajuannya);

        $status = 'ok';
        $message = 'new code';

        if ($id_pengajuan) {
            $message = 'using old code';

            $getdata = $this->Pengajuan_model->get_by_id($id_pengajuan);

            if ($getdata) {
                $datatoupdate = array(
                    'data_pengajuan' => json_encode($listpengajuannya),
                    'jenis_pengajuan' => $jenis_pengajuan,
                    'tanggal' => date('Y-m-d H:i:s'),
                    'keterangan' => $keterangan
                );

                $this->Pengajuan_model->update($id_pengajuan,$datatoupdate);
            }
        } else {

            $datatoinsert = array(
                'data_pengajuan' => json_encode($listpengajuannya),
                'jenis_pengajuan' => $jenis_pengajuan,
                'pengimput' => $this->session->userdata('role_id'),
                'user_id' => $this->session->userdata('user_id'),
                'status_kirim' => 0,
                'tanggal' => date('Y-m-d H:i:s'),
                'keterangan' => $keterangan
            );

            $this->Pengajuan_model->insert($datatoinsert);

            $id_pengajuan_generated = $this->db->insert_id();

            $id_pengajuan = $id_pengajuan_generated;
        }

        $arr = array(
            'status' => $status,
            'message' => $message,
            'id_pengajuan' => $id_pengajuan
        );

        echo json_encode($arr);
    }


    public function save_pengajuan_as_draft()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $jenis_pengajuan = $this->input->post('jenis_pengajuan');
        $keterangan = $this->input->post('keterangan');

        
        $status = 'ok';
        $message = 'new code';

        if ($id_pengajuan) {
            $message = 'using old code';

            $getdata = $this->Pengajuan_model->get_by_id($id_pengajuan);

            if ($getdata) {
                $datatoupdate = array(
                    'jenis_pengajuan' => $jenis_pengajuan,
                    'tanggal' => date('Y-m-d H:i:s'),
                    'keterangan' => $keterangan
                );

                $this->Pengajuan_model->update($id_pengajuan,$datatoupdate);
            }

            // echo 'UPDATING!';
        } else {
            $datatoinsert = array(
                'jenis_pengajuan' => $jenis_pengajuan,
                'pengimput' => $this->session->userdata('role_id'),
                'user_id' => $this->session->userdata('user_id'),
                'status_kirim' => 0,
                'tanggal' => date('Y-m-d H:i:s'),
                'keterangan' => $keterangan
            );

            $this->Pengajuan_model->insert($datatoinsert);

            $id_pengajuan_generated = $this->db->insert_id();

            $id_pengajuan = $id_pengajuan_generated;
        }

        $arr = array(
            'status' => $status,
            'message' => $message,
            'id_pengajuan' => $id_pengajuan
        );

        echo json_encode($arr);
    }

    public function success()
    {
        $doing = $this->input->get('thing');
        $operation = $this->input->get('operation');

        if ($operation == 'send') {
            $this->session->set_flashdata('success', $doing.' berhasil dikirim');
        }

        redirect(site_url('pengajuan'));
    }

}

/* End of file Pengajuan.php */
/* Location: ./application/controllers/Pengajuan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-01-13 06:33:55 */
/* http://harviacode.com */