<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Data_masuk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Data_masuk_model');
        $this->load->model('Pengajuan_model');
        $this->load->library('form_validation');
        $this->load->library('template');
        
        is_logged_in();
        
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'data_masuk?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'data_masuk?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'data_masuk';
            $config['first_url'] = base_url() . 'data_masuk';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Data_masuk_model->total_rows($q);
        $data_masuk = $this->Data_masuk_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'user' => $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array(),
            'pengajuan_data' => $data_masuk,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'classnyak' => $this
        );
        $this->template->load('data_masuk/data_masuk_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Pengajuan_model->get_by_id($id);
        $p = $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')
            ])->row_array();

        if ($row) {
            $p = $this->db->get_where('user', [
                'id' => $row->user_id
            ])->row_array();

            $role_data = $this->db->where('id', $row->pengimput)->get('user_role')->row();
            $data = array(
                'user' => $p,
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
            $this->template->load('data_masuk/data_masuk_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_masuk'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Data_masuk_model->get_by_id($id);

        if ($row) {
            $this->Data_masuk_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('data_masuk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_masuk'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('fisical_year', 'fisical year', 'trim|required');
	$this->form_validation->set_rules('period', 'period', 'trim|required');
	$this->form_validation->set_rules('posting_date', 'posting date', 'trim|required');
	$this->form_validation->set_rules('dokumen_date', 'dokumen date', 'trim|required');
	$this->form_validation->set_rules('cost_element', 'cost element', 'trim|required');
	$this->form_validation->set_rules('cost_element_descr', 'cost element descr', 'trim|required');
	$this->form_validation->set_rules('object_type', 'object type', 'trim|required');
	$this->form_validation->set_rules('wbs_element', 'wbs element', 'trim|required');
	$this->form_validation->set_rules('project_devinition', 'project devinition', 'trim|required');
	$this->form_validation->set_rules('co_object_name', 'co object name', 'trim|required');
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('co_area_curency', 'co area curency', 'trim|required');
	$this->form_validation->set_rules('Val_coarea_crcy', 'val coarea crcy', 'trim|required');

	$this->form_validation->set_rules('id_data_masuk', 'id_data_masuk', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "data_masuk.xls";
        $judul = "data_masuk";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Fisical Year");
	xlsWriteLabel($tablehead, $kolomhead++, "Period");
	xlsWriteLabel($tablehead, $kolomhead++, "Posting Date");
	xlsWriteLabel($tablehead, $kolomhead++, "Dokumen Date");
	xlsWriteLabel($tablehead, $kolomhead++, "Cost Element");
	xlsWriteLabel($tablehead, $kolomhead++, "Cost Element Descr");
	xlsWriteLabel($tablehead, $kolomhead++, "Object Type");
	xlsWriteLabel($tablehead, $kolomhead++, "Wbs Element");
	xlsWriteLabel($tablehead, $kolomhead++, "Project Devinition");
	xlsWriteLabel($tablehead, $kolomhead++, "Co Object Name");
	xlsWriteLabel($tablehead, $kolomhead++, "Name");
	xlsWriteLabel($tablehead, $kolomhead++, "Co Area Curency");
	xlsWriteLabel($tablehead, $kolomhead++, "Val Coarea Crcy");

	foreach ($this->Data_masuk_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->fisical_year);
	    xlsWriteNumber($tablebody, $kolombody++, $data->period);
	    xlsWriteLabel($tablebody, $kolombody++, $data->posting_date);
	    xlsWriteLabel($tablebody, $kolombody++, $data->dokumen_date);
	    xlsWriteNumber($tablebody, $kolombody++, $data->cost_element);
	    xlsWriteLabel($tablebody, $kolombody++, $data->cost_element_descr);
	    xlsWriteLabel($tablebody, $kolombody++, $data->object_type);
	    xlsWriteLabel($tablebody, $kolombody++, $data->wbs_element);
	    xlsWriteLabel($tablebody, $kolombody++, $data->project_devinition);
	    xlsWriteLabel($tablebody, $kolombody++, $data->co_object_name);
	    xlsWriteLabel($tablebody, $kolombody++, $data->name);
	    xlsWriteLabel($tablebody, $kolombody++, $data->co_area_curency);
	    xlsWriteNumber($tablebody, $kolombody++, $data->Val_coarea_crcy);

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

/* End of file data_masuk.php */
/* Location: ./application/controllers/data_masuk.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-12-23 13:03:35 */
/* http://harviacode.com */