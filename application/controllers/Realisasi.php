<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Realisasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Realisasi_model');
        $this->load->library('form_validation');
        $this->load->library('template');
        
        is_logged_in();
        
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'realisasi/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'realisasi/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'realisasi/index.html';
            $config['first_url'] = base_url() . 'realisasi/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Realisasi_model->total_rows($q);
        $realisasi = $this->Realisasi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'user' => $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array(),
            'realisasi_data' => $realisasi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('realisasi/realisasi_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Realisasi_model->get_by_id($id);
        if ($row) {
            $data = array(
                'user' => $this->db->get_where('user', ['email' =>
                $this->session->userdata('email')])->row_array(),
                
		'id_realisasi' => $row->id_realisasi,
		'fisical_year' => $row->fisical_year,
		'period' => $row->period,
		'posting_date' => $row->posting_date,
		'dokumen_date' => $row->dokumen_date,
		'cost_element' => $row->cost_element,
		'cost_element_descr' => $row->cost_element_descr,
		'object_type' => $row->object_type,
		'wbs_element' => $row->wbs_element,
		'project_devinition' => $row->project_devinition,
		'co_object_name' => $row->co_object_name,
		'name' => $row->name,
		'co_area_curency' => $row->co_area_curency,
		'Val_coarea_crcy' => $row->Val_coarea_crcy,
	    );
            $this->template->load('realisasi/realisasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('realisasi'));
        }
    }

    public function create() 
    {
        $data = array(
            'user' => $this->db->get_where('user', ['email' =>
                $this->session->userdata('email')])->row_array(),
            'button' => 'Create',
            'action' => site_url('realisasi/create_action'),
	    'id_realisasi' => set_value('id_realisasi'),
	    'fisical_year' => set_value('fisical_year'),
	    'period' => set_value('period'),
	    'posting_date' => set_value('posting_date'),
	    'dokumen_date' => set_value('dokumen_date'),
	    'cost_element' => set_value('cost_element'),
	    'cost_element_descr' => set_value('cost_element_descr'),
	    'object_type' => set_value('object_type'),
	    'wbs_element' => set_value('wbs_element'),
	    'project_devinition' => set_value('project_devinition'),
	    'co_object_name' => set_value('co_object_name'),
	    'name' => set_value('name'),
	    'co_area_curency' => set_value('co_area_curency'),
	    'Val_coarea_crcy' => set_value('Val_coarea_crcy'),
	);
        $this->template->load('realisasi/realisasi_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'fisical_year' => $this->input->post('fisical_year',TRUE),
		'period' => $this->input->post('period',TRUE),
		'posting_date' => $this->input->post('posting_date',TRUE),
		'dokumen_date' => $this->input->post('dokumen_date',TRUE),
		'cost_element' => $this->input->post('cost_element',TRUE),
		'cost_element_descr' => $this->input->post('cost_element_descr',TRUE),
		'object_type' => $this->input->post('object_type',TRUE),
		'wbs_element' => $this->input->post('wbs_element',TRUE),
		'project_devinition' => $this->input->post('project_devinition',TRUE),
		'co_object_name' => $this->input->post('co_object_name',TRUE),
		'name' => $this->input->post('name',TRUE),
		'co_area_curency' => $this->input->post('co_area_curency',TRUE),
		'Val_coarea_crcy' => $this->input->post('Val_coarea_crcy',TRUE),
	    );

            $this->Realisasi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('realisasi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Realisasi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'user' => $this->db->get_where('user', ['email' =>
                $this->session->userdata('email')])->row_array(),
                'button' => 'Update',
                'action' => site_url('realisasi/update_action'),
		'id_realisasi' => set_value('id_realisasi', $row->id_realisasi),
		'fisical_year' => set_value('fisical_year', $row->fisical_year),
		'period' => set_value('period', $row->period),
		'posting_date' => set_value('posting_date', $row->posting_date),
		'dokumen_date' => set_value('dokumen_date', $row->dokumen_date),
		'cost_element' => set_value('cost_element', $row->cost_element),
		'cost_element_descr' => set_value('cost_element_descr', $row->cost_element_descr),
		'object_type' => set_value('object_type', $row->object_type),
		'wbs_element' => set_value('wbs_element', $row->wbs_element),
		'project_devinition' => set_value('project_devinition', $row->project_devinition),
		'co_object_name' => set_value('co_object_name', $row->co_object_name),
		'name' => set_value('name', $row->name),
		'co_area_curency' => set_value('co_area_curency', $row->co_area_curency),
		'Val_coarea_crcy' => set_value('Val_coarea_crcy', $row->Val_coarea_crcy),
	    );
            $this->template->load('realisasi/realisasi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('realisasi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_realisasi', TRUE));
        } else {
            $data = array(
		'fisical_year' => $this->input->post('fisical_year',TRUE),
		'period' => $this->input->post('period',TRUE),
		'posting_date' => $this->input->post('posting_date',TRUE),
		'dokumen_date' => $this->input->post('dokumen_date',TRUE),
		'cost_element' => $this->input->post('cost_element',TRUE),
		'cost_element_descr' => $this->input->post('cost_element_descr',TRUE),
		'object_type' => $this->input->post('object_type',TRUE),
		'wbs_element' => $this->input->post('wbs_element',TRUE),
		'project_devinition' => $this->input->post('project_devinition',TRUE),
		'co_object_name' => $this->input->post('co_object_name',TRUE),
		'name' => $this->input->post('name',TRUE),
		'co_area_curency' => $this->input->post('co_area_curency',TRUE),
		'Val_coarea_crcy' => $this->input->post('Val_coarea_crcy',TRUE),
	    );

            $this->Realisasi_model->update($this->input->post('id_realisasi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('realisasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Realisasi_model->get_by_id($id);

        if ($row) {
            $this->Realisasi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('realisasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('realisasi'));
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

	$this->form_validation->set_rules('id_realisasi', 'id_realisasi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "realisasi.xls";
        $judul = "realisasi";
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

	foreach ($this->Realisasi_model->get_all() as $data) {
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

}

/* End of file Realisasi.php */
/* Location: ./application/controllers/Realisasi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-12-23 13:03:35 */
/* http://harviacode.com */