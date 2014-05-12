<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->template->title('Welcome to SIMS')
				->set('currentSection', 'api');
		$this->load->model('admin_users');
	}

	/**
	 * Get all admin users
	 */
	function getAllAdminUsers() {
		$users = $this->admin_users->get_all_admin_users();
		if($users != NULL) {
			echo json_encode($users);
		}
		return NULL;
	}

	/**
	 * Get all new registered users, which unassigned rolw yet
	 */
	function getAllUnassignedRoleUsers() {
		$users = $this->admin_users->get_all_unassigned_role_users();
		if($users != NULL) {
			echo json_encode($users);
		}
		return NULL;
	}

	/**
	 * Get all admin's roles
	 */
	function getAllAdminRoles() {
		$roles = $this->admin_users->get_all_admin_roles();
		if($roles != NULL) {
			echo json_encode($roles);
		}
		return NULL;
	}
}