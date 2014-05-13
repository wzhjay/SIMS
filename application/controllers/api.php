<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->template->title('Welcome to SIMS')
				->set('currentSection', 'apis');
		$this->load->model('apis');
	}

	/**
	 * Get all users from users table
	 */
	function getAllUsers() {
		$users = $this->apis->get_all_admin_users();
		if($users != NULL) {
			echo json_encode($users);
		}
		echo NULL;
	}

	/**
	 * Get all new registered users, which unassigned rolw yet
	 */
	function getAllUnassignedRoleUsers() {
		$users = $this->apis->get_all_unassigned_role_users();
		if($users != NULL) {
			echo json_encode($users);
		}
		echo NULL;
	}

	/**
	 * Get all admin's roles
	 */
	function getAllAdminRoles() {
		$roles = $this->apis->get_all_admin_roles();
		if($roles != NULL) {
			echo json_encode($roles);
		}
		echo NULL;
	}

	/**
	 * Get all branches
	 */
	function getAllBranches() {
		$branches = $this->apis->get_all_branches();
		if($branches != NULL) {
			echo json_encode($branches);
		}
		echo NULL;
	}

	/**
	 * Get all branches
	 */
	function createNewAdmin() {
		$user_id = $this->input->post('user_id');
		$role_id = $this->input->post('role_id');
		$branch_id = $this->input->post('branch_id');
		$status_id = $this->input->post('status_id');
		$success = $this->apis->assign_role_branch_to_new_admin_user($user_id, $role_id, $branch_id, $status_id);
		if($success) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 * Get all admin users, combine with their branch, role, status
	 */
	function getAllAdminUsers() {
		$admins = $this->apis->get_all_admins();
		if($admins != NULL) {
			echo json_encode($admins);
		}
		echo NULL;
	}

	/**
	 * Search admin user by username or email
	 */
	function searchAdminUser() {
		$key_word = $this->input->post('key_word');
		$admins = $this->apis->search_admins_by_username_email($key_word);
		if($admins != NULL) {
			echo json_encode($admins);
		}
		echo NULL;
	}
}