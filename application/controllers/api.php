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

	/**
	 *  create ato info by student
	 */
	function createATOInfo() {
		$ic = $this->input->post('ic').trim(" ");
		$pre_post = $this->input->post('pre_post');
		$recommend_level = $this->input->post('recommend_level');
		$class_start_date = $this->input->post('class_start_date');
		$class_end_date = $this->input->post('class_end_date');
		$class_code = $this->input->post('class_code');
		$attendance = $this->input->post('attendance');
		$el = $this->input->post('el');
		$er = $this->input->post('er');
		$en = $this->input->post('en');
		$es = $this->input->post('es');
		$ew = $this->input->post('ew');
		$exam_location = $this->input->post('exam_location');
		$exam_date = $this->input->post('exam_date');
		$exam_time = $this->input->post('exam_time');
		$ato_branch_id = $this->input->post('ato_branch_id');
		$ato_op_id = $this->input->post('ato_op_id');
		$remark = $this->input->post('remark');
		
		// create
		$create = $this->apis->create_new_ato(
			$ic,
			$pre_post,
			$recommend_level,
			$class_start_date, 
			$class_end_date, 
			$class_code, 
			$attendance, 
			$el, 
			$er, 
			$en, 
			$es, 
			$ew, 
			$exam_location, 
			$exam_date, 
			$exam_time, 
			$ato_branch_id,
		    $ato_op_id,
			$remark);
		if($create) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  update ato info by student ic
	 */
	function updateATOInfo() {
		// $ic = $this->input->post('ic').trim(" ");
		$id = $this->input->post('id');
		$pre_post = $this->input->post('pre_post');
		$recommend_level = $this->input->post('recommend_level');
		$class_start_date = $this->input->post('class_start_date');
		$class_end_date = $this->input->post('class_end_date');
		$class_code = $this->input->post('class_code');
		$attendance = $this->input->post('attendance');
		$el = $this->input->post('el');
		$er = $this->input->post('er');
		$en = $this->input->post('en');
		$es = $this->input->post('es');
		$ew = $this->input->post('ew');
		$exam_location = $this->input->post('exam_location');
		$exam_date = $this->input->post('exam_date');
		$exam_time = $this->input->post('exam_time');
		$ato_branch_id = $this->input->post('ato_branch_id');
		$ato_op_id = $this->input->post('ato_op_id');
		$remark = $this->input->post('remark');

		// update
		$update = $this->apis->update_ato(
			$id,
			$pre_post,
			$recommend_level,
			$class_start_date, 
			$class_end_date, 
			$class_code, 
			$attendance, 
			$el, 
			$er, 
			$en, 
			$es, 
			$ew, 
			$exam_location, 
			$exam_date, 
			$exam_time, 
			$ato_branch_id,
			$ato_op_id,
			$remark);
		if($update) {
			echo 2;
		}
		else echo 0;
	}

	/**
	 *  get student all ato info by givening student's ic
	 */
	function getStudentATOInfoByIC() {
		$ic = $this->input->post('ic').trim(" ");
		$atos = $this->apis->get_student_atos_by_ic($ic);
		if($atos != NULL) {
			echo json_encode($atos);
		}
		echo NULL;
	}

	/**
	 *  get ato info by givening id
	 */
	function getATOInfoByID() {
		$id = $this->input->post('id');
		$ato = $this->apis->get_ato_info_by_id($id);
		if($ato != NULL) {
			echo json_encode($ato);
		}
		echo NULL;
	}

	/**
	 *  get student basic info by givening ic
	 */
	function getStudentByIC() {
		$ic = $this->input->post('ic');
		$student = $this->apis->get_student_info_by_ic($ic);
		if($student != NULL) {
			echo json_encode($student);
		}
		echo NULL;
	}

	/**
	 *  get student records info by givening ic
	 */
	function getStudentRecordsByIC() {
		$ic = $this->input->post('ic');
		$records = $this->apis->get_student_records_by_ic($ic);
		if($records != NULL) {
			echo json_encode($records);
		}
		echo NULL;
	}

	/**
	 *  create new student exam record
	 */
	function createStudentExamRecord() {
		$ic = $this->input->post('ic').trim(" ");
		$exam_date = $this->input->post('exam_date');
		$er = $this->input->post('er');
		$el = $this->input->post('el');
		$es = $this->input->post('es');
		$ew = $this->input->post('ew');
		$en = $this->input->post('en');
		$cmp = $this->input->post('cmp');
		$con = $this->input->post('con');
		$wri = $this->input->post('wri');
		$wpn = $this->input->post('wpn');
		$branch_id = $this->input->post('branch_id');
		$branch_op_id = $this->input->post('branch_op_id');
		$remark = $this->input->post('remark');
		
		// create
		$create = $this->apis->create_new_student_exam_record(
			$ic,
			$exam_date,
			$er,
			$el, 
			$es, 
			$ew, 
			$en, 
			$cmp, 
			$con, 
			$wri, 
			$wpn, 
			$branch_id, 
			$branch_op_id, 
			$remark);
		if($create) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  update new student exam record
	 */
	function updateStudentExamRecord() {
		$id = $this->input->post('id');
		$exam_date = $this->input->post('exam_date');
		$er = $this->input->post('er');
		$el = $this->input->post('el');
		$es = $this->input->post('es');
		$ew = $this->input->post('ew');
		$en = $this->input->post('en');
		$cmp = $this->input->post('cmp');
		$con = $this->input->post('con');
		$wri = $this->input->post('wri');
		$wpn = $this->input->post('wpn');
		$branch_id = $this->input->post('branch_id');
		$branch_op_id = $this->input->post('branch_op_id');
		$remark = $this->input->post('remark');
		
		// update
		$update = $this->apis->update_student_exam_record(
			$id,
			$exam_date,
			$er,
			$el, 
			$es, 
			$ew, 
			$en, 
			$cmp, 
			$con, 
			$wri, 
			$wpn, 
			$branch_id, 
			$branch_op_id, 
			$remark);
		if($update) {
			echo 2;
		}
		else echo 0;
	}

	/**
	 *  update new student record id
	 */
	function getStudentRecordID() {
		$id = $this->input->post('id');
		$record = $this->apis->get_student_record_by_id($id);
		if($record != NULL) {
			echo json_encode($record);
		}
		echo NULL;	
	}

	/**
	 *  search student info by ic
	 */
	function searchStudentInfo() {
		$ic = $this->input->post('ic');
		$students = $this->apis->search_students_by_ic($ic);
		if($students != NULL) {
			echo json_encode($students);
		}
		echo NULL;
	}

	/**
	 *  search student info by keyword in ic/first name/last name
	 */
	function searchStudentInfoByKeyword() {
		$keyword = $this->input->post('keyword');
		$students = $this->apis->search_students_by_keyword($keyword);
		if($students != NULL) {
			echo json_encode($students);
		}
		echo NULL;
	}

	/**
	 *  search ato info by time
	 */
	function searchATOInfo() {
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$atos = $this->apis->search_atos_by_time($from, $to);
		if($atos != NULL) {
			echo json_encode($atos);
		}
		echo NULL;
	}

	/**
	 *  search class info by multiple variables
	 */
	function searchClassInfo() {
		$code = $this->input->post('code');
		$type = $this->input->post('type');
		$level = $this->input->post('level');
		$status = $this->input->post('status');
		$branch_id = $this->input->post('branch_id');
		$start_from = $this->input->post('start_from');
		$start_to = $this->input->post('start_to');
		$end_from = $this->input->post('end_from');
		$end_to = $this->input->post('end_to');
		$results = $this->apis->search_class_by_multiple_var($code, $type, $level, $status, $branch_id, $start_from, $start_to, $end_from, $end_to);
		
		if($results != NULL) {
			echo json_encode($results);
		}
		echo NULL;
	}

	/**
	 *  create new class
	 */
	function createNewClass() {
		$code = $this->input->post('code').trim(" ");
		$class_name = $this->input->post('class_name');
		$branch_id = $this->input->post('branch_id');
		$type = $this->input->post('type');
		$level = $this->input->post('level');
		$status = $this->input->post('status');
		$location = $this->input->post('location');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
		$teacher_name = $this->input->post('teacher_name');
		$teacher_tel = $this->input->post('teacher_tel');
		$remark = $this->input->post('remark');
		
		// create
		$create = $this->apis->create_new_class(
			$code,
			$class_name,
			$branch_id,
			$type,
			$level, 
			$status, 
			$location, 
			$start_date, 
			$end_date, 
			$start_time, 
			$end_time, 
			$teacher_name, 
			$teacher_tel, 
			$remark);
		if($create) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  get class info by code
	 */
	function getClassInfoByCode() {
		$code = $this->input->post('code');
		$classes = $this->apis->get_class_info_by_code($code);
		if($classes != NULL) {
			echo json_encode($classes);
		}
		echo NULL;
	}

	/**
	 *  get class info by class_id, for update
	 */
	function getClassInfoByID() {
		$class_id = $this->input->post('class_id');
		$class = $this->apis->get_class_info_by_id($class_id);
		if($class != NULL) {
			echo json_encode($class);
		}
		echo NULL;
	}

	/**
	 *  update class info by class_id
	 */
	function updateClassByID() {
		$class_id = $this->input->post('class_id');
		$code = $this->input->post('code').trim(" ");
		$class_name = $this->input->post('class_name');
		$branch_id = $this->input->post('branch_id');
		$type = $this->input->post('type');
		$level = $this->input->post('level');
		$status = $this->input->post('status');
		$location = $this->input->post('location');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
		$teacher_name = $this->input->post('teacher_name');
		$teacher_tel = $this->input->post('teacher_tel');
		$remark = $this->input->post('remark');
		
		// update
		$update = $this->apis->update_class_by_id(
			$class_id,
			$code,
			$class_name,
			$branch_id,
			$type,
			$level, 
			$status, 
			$location, 
			$start_date, 
			$end_date, 
			$start_time, 
			$end_time, 
			$teacher_name, 
			$teacher_tel, 
			$remark);
		if($update) {
			echo 2;
		}
		else echo 0;
	}

	/**
	 *  get all class info
	 */
	function getAllClassInfo() {
		$classes = $this->apis->get_all_class_info();
		if($classes != NULL) {
			echo json_encode($classes);
		}
		echo NULL;
	}
}