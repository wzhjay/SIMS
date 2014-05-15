<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Apis extends CI_Model
{
	private $table_admin_users	= 'admin_users';		
	private $table_users		= 'users';

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get all users from users table
	 *
	 * @param	none
	 * @return	object
	 */
	function get_all_users()
	{
		if($this->session->userdata('session_id')) {
			$query = $this->db->get($this->table_users);
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * Get all admin users
	 *
	 * @param	none
	 * @return	object
	 */
	function get_all_unassigned_role_users() {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query("SELECT * FROM users WHERE users.id NOT IN (SELECT user_id FROM admin_users) ORDER BY users.id");
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * Get all admin roles
	 *
	 * @param	none
	 * @return	array
	 */
	function get_all_admin_roles() {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query("SELECT * FROM admin_role ORDER BY id");
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * Get all branches
	 *
	 * @param	none
	 * @return	array
	 */
	function get_all_branches() {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query("SELECT * FROM branch ORDER BY id");
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * create new admin user, map/assign role and branch to new registered users
	 *
	 * @param	user_id, role_id, branch_id
	 * @return	boolean
	 */
	function assign_role_branch_to_new_admin_user($user_id, $role_id, $branch_id, $status_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query("INSERT INTO admin_users (user_id, role_id, branch_id, status_id) VALUES ($user_id, $role_id, $branch_id, $status_id)");
			if ($this->db->affected_rows()) return TRUE;
		}
		return FLASE;
	}

	/**
	 * get all admin users
	 *
	 * @param	none
	 * @return	array
	 */
	function get_all_admins() {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query("SELECT * FROM admin_users a, users u, branch b, admin_role r, status s WHERE (a.user_id = u.id) AND (a.branch_id = b.id) AND (a.role_id = r.id) AND (a.status_id = s.id) GROUP BY r.id ORDER BY r.id");
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search admin users by username or email
	 *
	 * @param	key_word
	 * @return	array
	 */
	function search_admins_by_username_email($key_word) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query("SELECT * FROM admin_users a, users u, branch b, admin_role r, status s WHERE (a.user_id = u.id) AND (a.branch_id = b.id) AND (a.role_id = r.id) AND (a.status_id = s.id) AND ((u.username LIKE '%".$key_word."%') OR (u.email LIKE '%".$key_word."%')) GROUP BY r.id ORDER BY r.id");
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get all the courses from course table
	 *
	 * @param	none
	 * @return	array
	 */
	function get_all_courses() {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query("SELECT * FROM course ORDER BY id");
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}
}