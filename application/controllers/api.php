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
	 *
	 */
	function getAllAdminUsers() {
		$users = $this->admin_users->get_all_admin_users();
		if($users != NULL) {
			echo json_encode($users);
			// return json_encode($users);
		}
		return NULL;
	}
}