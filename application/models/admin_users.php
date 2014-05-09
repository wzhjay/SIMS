<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 08.05.2014 
 -->


<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Model
{
	private $table_admin_user	= 'admin_users';		
	private $table_users		= 'users';

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get all admin users
	 *
	 * @param	none
	 * @return	object
	 */
	function get_all_admin_users()
	{
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0) return $query->row();
		return NULL;
	}
}