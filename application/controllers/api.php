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
	 * Get all admin users from admin_users table only
	 */
	function getAllAdminUsers() {
		$admins = $this->apis->get_all_admin_users();
		if($admins != NULL) {
			echo json_encode($admins);
		}
		echo NULL;
	}

	/**
	 * Get all admin users, combine with their branch, role, status
	 */
	function getAllAdmins() {
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

	/**
	 * get all the course information
	 */
	function getAllCourses() {
		$courses = $this->apis->get_all_courses();
		if($courses != NULL) {
			echo json_encode($courses);
		}
		echo NULL;
	}

	/**
	 * update admin's role and branch
	 */
	function updateAdminRoleBranch() {
		$user_id = $this->input->post('user_id');
		$new_role_id = $this->input->post('role_id');
		$new_branch_id = $this->input->post('branch_id');
		$success = $this->apis->update_single_admin_role_branch($user_id, $new_role_id, $new_branch_id);
		if($success) {
			echo 1;
		}
		else {
			echo 0;
		}
	}

	/**
	 * delete single admin user
	 */
	function deleteSingleAdminUser() {
		$user_id = $this->input->post('user_id');
		$success = $this->apis->delete_single_admin_user($user_id);
		if($success) {
			echo 1;
		}
		else {
			echo 0;
		}
	}

	/**
	 *  create new registration for student
	 */
	function createNewRegister() {
		$ic = $this->input->post('ic');
		$reg_date = $this->input->post('reg_date');
		$student_branch_id = $this->input->post('student_branch_id');
		$reg_branch_id = $this->input->post('reg_branch_id');
		$reg_op_id = $this->input->post('reg_op_id');
		$reg_no = $this->input->post('reg_no');
		$start_date_wanted = $this->input->post('start_date_wanted');
		$remark = $this->input->post('remark');
		$success = $this->apis->create_new_registration($ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $start_date_wanted, $remark);
		if($success) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  get single registration info by IC number
	 */
	function getRegistrationByIC() {
		$ic = $this->input->post('ic');
		$reg_info = $this->apis->get_registration_by_ic($ic);
		if($reg_info != NULL) {
			echo json_encode($reg_info);
		}
		echo NULL;
	}

	/**
	 *  search registration info
	 */
	function searchRegistrationInfo() {
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		// $from = '2014-05-12';
		// $to = '2014-06-07';
		$courses = $this->apis->search_reg_info($from, $to);
		if($courses != NULL) {
			echo json_encode($courses);
		}
		echo NULL;
	}
}