<?php
function is_logged_in()

{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    }
}

function get_fungsiname($role_id)
{
    $ci = get_instance();
    $query = $ci->db->get_where('user_role', ['id' => $role_id])->row_array();
    return $query['role'];
}
