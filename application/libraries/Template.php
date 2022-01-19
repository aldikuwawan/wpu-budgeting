<?php
class Template{
    protected $_ci;

    function __construct()
    {
        $this->_ci = &get_instance();
    }

    function load($content, $data = NULL){
        $data['contentnya'] = $this->_ci->load->view($content, $data, TRUE);
        $this->_ci->load->view('template', $data);
    }
}
?>