<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_users extends CI_Model
{
	private $table_admin_users	= 'admin_users';		
	private $table_users		= 'users';

	function __construct()
	{
		parent::__construct();
		$this->load->model('apis');
	}

	/**
	 * Get all admin users
	 *
	 * @param	none
	 * @return	object
	 */
	function get_all_admin_users()
	{
		if($this->session->userdata('session_id')) {
			$query = $this->db->get($this->table_users);
			if ($query->num_rows() > 0) return $query->row_array();
		}
		return NULL;
	}
}