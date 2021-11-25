<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan_model extends CI_Model
{
    function __construct()
    {
     parent::__construct();
    }

    public function simpan($table,$data)
    {
      $this->db->insert($table,$data);
    }

    // update data
    function update($id_pengajuan, $data) 
    {
        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->update('pengajuan', $data);
    }

    // delete data
    function delete($id_pengajuan)
    {
        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->delete('pengajuan');
    }

    function get_by_id($id_pengajuan)
    {
        $this->db->where('id_pengajuan',$id_pengajuan);
        $this->db->get('pengajuan')->row();
    }
}