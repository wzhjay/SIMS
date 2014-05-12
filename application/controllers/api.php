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
	 * Get all admin users
	 */
	function getAllAdminUsers() {
		$users = $this->apis->get_all_admin_users();
		if($users != NULL) {
			echo json_encode($users);
		}
		return NULL;
	}

	/**
	 * Get all new registered users, which unassigned rolw yet
	 */
	function getAllUnassignedRoleUsers() {
		$users = $this->apis->get_all_unassigned_role_users();
		if($users != NULL) {
			echo json_encode($users);
		}
		return NULL;
	}

	/**
	 * Get all admin's roles
	 */
	function getAllAdminRoles() {
		$roles = $this->apis->get_all_admin_roles();
		if($roles != NULL) {
			echo json_encode($roles);
		}
		return NULL;
	}

	/**
	 * Get all branches
	 */
	function getAllBranches() {
		$branches = $this->apis->get_all_branches();
		if($branches != NULL) {
			echo json_encode($branches);
		}
		return NULL;
	}
}