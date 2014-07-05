<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->template->title('Welcome to SIMS')
				->set('currentSection', 'apis');
		$this->load->model('apis');

		//load our new PHPExcel library
		$this->load->library('excel');
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
	function createNewRegistrationInfo() {
		$ic = $this->input->post('ic');
		$reg_date = $this->input->post('reg_date');
		$student_branch_id = $this->input->post('student_branch_id');
		$reg_branch_id = $this->input->post('reg_branch_id');
		$reg_op_id = $this->input->post('reg_op_id');
		$reg_no = $this->input->post('reg_no');
		$start_date_wanted = $this->input->post('start_date_wanted');
		$reg_remark = $this->input->post('reg_remark');

		$any_am = $this->input->post('any_am');
		$any_pm = $this->input->post('any_pm');
		$any_eve = $this->input->post('any_eve');
		$sat_am = $this->input->post('sat_am');
		$sat_pm = $this->input->post('sat_pm');
		$sat_eve = $this->input->post('sat_eve');
		$sun_am = $this->input->post('sun_am');
		$sun_pm = $this->input->post('sun_pm');
		$sun_eve = $this->input->post('sun_eve');
		$anytime = $this->input->post('anytime');

		$success = $this->apis->create_new_registration($ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $start_date_wanted, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime);
		if($success) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  update registration for student
	 */
	function updateRegistrationInfo() {
		$reg_id = $this->input->post('reg_id');
		$ic = $this->input->post('ic');
		$reg_date = $this->input->post('reg_date');
		$student_branch_id = $this->input->post('student_branch_id');
		$reg_branch_id = $this->input->post('reg_branch_id');
		$reg_op_id = $this->input->post('reg_op_id');
		$reg_no = $this->input->post('reg_no');
		$start_date_wanted = $this->input->post('start_date_wanted');
		$reg_remark = $this->input->post('reg_remark');

		$any_am = $this->input->post('any_am');
		$any_pm = $this->input->post('any_pm');
		$any_eve = $this->input->post('any_eve');
		$sat_am = $this->input->post('sat_am');
		$sat_pm = $this->input->post('sat_pm');
		$sat_eve = $this->input->post('sat_eve');
		$sun_am = $this->input->post('sun_am');
		$sun_pm = $this->input->post('sun_pm');
		$sun_eve = $this->input->post('sun_eve');
		$anytime = $this->input->post('anytime');

		$success = $this->apis->update_registration($reg_id, $ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $start_date_wanted, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime);
		if($success) {
			echo 2;
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
	 *  get single registration info by ID
	 */
	function getRegistrationByID() {
		$reg_id = $this->input->post('reg_id');
		$reg_info = $this->apis->get_registration_by_id($reg_id);
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
		$any_am = $this->input->post('any_am');
		$any_pm = $this->input->post('any_pm');
		$any_eve = $this->input->post('any_eve');
		$sat_am = $this->input->post('sat_am');
		$sat_pm = $this->input->post('sat_pm');
		$sat_eve = $this->input->post('sat_eve');
		$sun_am = $this->input->post('sun_am');
		$sun_pm = $this->input->post('sun_pm');
		$sun_eve = $this->input->post('sun_eve');
		$anytime = $this->input->post('anytime');
		// $from = '2014-05-12';
		// $to = '2014-06-07';
		$courses = $this->apis->search_reg_info($from,$to,$any_am,$any_pm,$any_eve,$sat_am,$sat_pm,$sat_eve,$sun_am,$sun_pm,$sun_eve,$anytime);
		if($courses != NULL) {
			echo json_encode($courses);
		}
		echo NULL;
	}

	/**
	 *  delete registration info
	 */
	function deleteRegistrationByID() {
		$reg_id = $this->input->post('reg_id');
		// delete
		$delete = $this->apis->delete_reg_info($reg_id);
		if($delete){
			echo 3;
		}
		else echo 0;
	}

	/**
	 *  create new student basic info
	 */
	function createStudentBasicInfo() {
		$source = $this->input->post('source');
		$gov_letter = $this->input->post('gov_letter');
		$ic = $this->input->post('ic');
		$ic_type = $this->input->post('ic_type');
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$othername = $this->input->post('othername');
		$tel = $this->input->post('tel');
		$tel_home = $this->input->post('tel_home');
		$gender = $this->input->post('gender');
		$salutation = $this->input->post('salutation');
		$birthday = $this->input->post('birthday');
		$age = $this->input->post('age');
		$citizenship = $this->input->post('citizenship');
		$nationality = $this->input->post('nationality');
		$race = $this->input->post('race');
		$cn_level = $this->input->post('cn_level');
		$edu_level = $this->input->post('edu_level');
		$lang = $this->input->post('lang');
		$blk = $this->input->post('blk');
		$street = $this->input->post('street');
		$floor_unit_no = $this->input->post('floor_unit_no');
		$building = $this->input->post('building');
		$postcode = $this->input->post('postcode');
		$emp_status = $this->input->post('emp_status');
		$company_name = $this->input->post('company_name');
		$company_type = $this->input->post('company_type');
		$company_reg_no = $this->input->post('company_reg_no');
		$industry = $this->input->post('industry');
		$designation = $this->input->post('designation');
		$salary_range = $this->input->post('salary_range');
		$student_branch_id = $this->input->post('student_branch_id');
		$student_op_id = $this->input->post('student_op_id');
		$student_remark = $this->input->post('student_remark');

		// create
		$create = $this->apis->create_new_student_basic_info(
			$source,
			$gov_letter,
			$ic,
			$ic_type,
			$firstname,
			$lastname,
			$othername,
			$tel,
			$tel_home,
			$gender,
			$salutation,
			$birthday,
			$age,
			$citizenship,
			$nationality,
			$race,
			$cn_level,
			$edu_level,
			$lang,
			$blk,
			$street,
			$floor_unit_no,
			$building,
			$postcode,
			$emp_status,
			$company_name,
			$company_type,
			$company_reg_no,
			$industry,
			$designation,
			$salary_range,
			$student_branch_id,
			$student_op_id,
			$student_remark);
		if($create){
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  update student basic info
	 */
	function updateStudentBasicInfo() {
		$student_id = $this->input->post('student_id');
		$source = $this->input->post('source');
		$gov_letter = $this->input->post('gov_letter');
		$ic = $this->input->post('ic');
		$ic_type = $this->input->post('ic_type');
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$othername = $this->input->post('othername');
		$tel = $this->input->post('tel');
		$tel_home = $this->input->post('tel_home');
		$gender = $this->input->post('gender');
		$salutation = $this->input->post('salutation');
		$birthday = $this->input->post('birthday');
		$age = $this->input->post('age');
		$citizenship = $this->input->post('citizenship');
		$nationality = $this->input->post('nationality');
		$race = $this->input->post('race');
		$cn_level = $this->input->post('cn_level');
		$edu_level = $this->input->post('edu_level');
		$lang = $this->input->post('lang');
		$blk = $this->input->post('blk');
		$street = $this->input->post('street');
		$floor_unit_no = $this->input->post('floor_unit_no');
		$building = $this->input->post('building');
		$postcode = $this->input->post('postcode');
		$emp_status = $this->input->post('emp_status');
		$company_name = $this->input->post('company_name');
		$company_type = $this->input->post('company_type');
		$company_reg_no = $this->input->post('company_reg_no');
		$industry = $this->input->post('industry');
		$designation = $this->input->post('designation');
		$salary_range = $this->input->post('salary_range');
		$student_branch_id = $this->input->post('student_branch_id');
		$student_op_id = $this->input->post('student_op_id');
		$student_remark = $this->input->post('student_remark');

		// update
		$update = $this->apis->update_student_basic_info(
			$student_id,
			$source,
			$gov_letter,
			$ic,
			$ic_type,
			$firstname,
			$lastname,
			$othername,
			$tel,
			$tel_home,
			$gender,
			$salutation,
			$birthday,
			$age,
			$citizenship,
			$nationality,
			$race,
			$cn_level,
			$edu_level,
			$lang,
			$blk,
			$street,
			$floor_unit_no,
			$building,
			$postcode,
			$emp_status,
			$company_name,
			$company_type,
			$company_reg_no,
			$industry,
			$designation,
			$salary_range,
			$student_branch_id,
			$student_op_id,
			$student_remark);
		if($update){
			echo 2;
		}
		else echo 0;
	}

	/**
	 *  create ato info by student
	 */
	function createATOInfo() {
		$ic = $this->input->post('ic').trim(" ");
		$pre_post = $this->input->post('pre_post');
		$recommend_level = $this->input->post('recommend_level');
		$class_code = $this->input->post('class_code');
		$attendance = $this->input->post('attendance');
		$post_change_date = $this->input->post('post_change_date');
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
			$class_code, 
			$attendance, 
			$post_change_date,
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
		$class_code = $this->input->post('class_code');
		$attendance = $this->input->post('attendance');
		$post_change_date = $this->input->post('post_change_date');
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
			$class_code, 
			$attendance, 
			$post_change_date,
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
	 *  search student info by multiple variables
	 */
	function searchStudentInfoByMultipleVar() {
		$course_type = $this->input->post('course_type');
		$level = $this->input->post('level');
		$slot = $this->input->post('slot');
		$students = $this->apis->search_class_students_by_multiple_var($course_type, $level, $slot);
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
		$class_code = $this->input->post('class_code');
		$atos = $this->apis->search_atos_by_time($from, $to, $class_code);
		if($atos != NULL) {
			echo json_encode($atos);
		}
		echo NULL;
	}

	/**
	 *  search ato info by time and download as excel file
	 */
	function searchATOInfoDownload() {
		$from = $_POST["from"];
		$to = $_POST["to"];

		if(trim($from) == "") {
			$from = '2000-01-01';
		}

		if(trim($to) == "") {
			$to = '2100-01-01';
		}
		$class_code = $_POST["class_code"];
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('ATO');
		$atos = $this->apis->search_atos_by_time($from, $to, $class_code);
		$rowArray = array('Pre / Post Assessment', 'Exam Location', 'Class ID', 'Training Start Date (DD/MM/YYYY)', '>Training End Date (DD/MM/YYYY)', 'Course Code', 'Attendance Percentage', 'Training Recommendation', 'EL', 'ER', 'EN', 'ES', 'EW', 'NRIC/Fin No.', 'ID Type (Select from dropdown list)', 'Salutation', 'SurName', 'GivenName', 'OtherName', 'Gender', 'DOB (DD/MM/YYYY)', 'Age', 'Citizenship', 'Nationality', 'Ethnic Group', 'Highest Chinese Education Level', 'Highest Education Level', 'Language Proficiency', 'Blk', 'Street Name', '#Floor - Unit No', 'Building Name', 'Postal Code', 'Contact No', 'Employment Status', 'Company Registration Type', 'Company Name', 'Company Registration No', 'Industry Sector', 'Designation', 'Salary Range');
		if($atos != NULL) {
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray,   // The data to set
			        NULL
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $atos,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A3'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );
			if(trim($class_code) == "") {
				$filename = 'ATO_Date_'.date('Y-m-d H:i:s').'.xls';	
			} else {
				$filename = 'ATO_Class_'.date('Y-m-d H:i:s').'.xls';		
			}
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			             
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			$objWriter->save('php://output');
		}
	}

	/**
	 *  delete ato info
	 */
	function deleteATOByID() {
		$id = $this->input->post('id');
		// delete
		$delete = $this->apis->delete_ato_info($id);
		if($delete){
			echo 3;
		}
		else echo 0;
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

	/**
	 *  get all class students
	 */
	function getClassStudentsByClassID() {
		$class_id = $this->input->post('class_id');
		$students = $this->apis->get_all_class_students_by_class_id($class_id);
		if($students != NULL) {
			echo json_encode($students);
		}
		echo NULL;
	}

	/**
	 *  get all class info by student ic, where student are in these classes
	 */
	function getStudentClassesInfoByIC() {
		$ic = $this->input->post('ic');
		$classes = $this->apis->get_all_class_by_student_ic($ic);
		if($classes != NULL) {
			echo json_encode($classes);
		}
		echo NULL;
	}

	/**
	 *  assign student to class
	 */
	function assignStudentToClass() {
		$class_id = $this->input->post('class_id');
		$student_id = $this->input->post('student_id');
		// assign
		$assign = $this->apis->assign_student_to_class($class_id, $student_id);
		if($assign) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  create new expense record
	 */
	function createExpenseRecord() {
		$exp_type = $this->input->post('exp_type');
		$exp_name = $this->input->post('exp_name');
		$exp_sign_name = $this->input->post('exp_sign_name');
		$exp_date = $this->input->post('exp_date');
		$exp_amount = $this->input->post('exp_amount');
		$exp_remark = $this->input->post('exp_remark');
		// create
		$create = $this->apis->create_new_expense_record($exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $exp_remark);
		if($create) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  update expense record
	 */
	function updateExpenseRecord() {
		$exp_id = $this->input->post('exp_id');
		$exp_type = $this->input->post('exp_type');
		$exp_name = $this->input->post('exp_name');
		$exp_sign_name = $this->input->post('exp_sign_name');
		$exp_date = $this->input->post('exp_date');
		$exp_amount = $this->input->post('exp_amount');
		$exp_remark = $this->input->post('exp_remark');
		// update
		$update = $this->apis->update_expense_record($exp_id, $exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $exp_remark);
		if($update) {
			echo 2;
		}
		else echo 0;
	}

	/**
	 *  get expense record by id
	 */
	function getExpenseRecordByID() {
		$exp_id = $this->input->post('exp_id');
		$record = $this->apis->get_expense_record_by_id($exp_id);
		if($record != NULL) {
			echo json_encode($record);
		}
		echo NULL;
	}

	/**
	 *  search expense records by tpes
	 */
	function searchExpenseRecords() {
		$exp_type = $this->input->post('exp_type');
		$exp_name = $this->input->post('exp_name');
		$exp_sign_name = $this->input->post('exp_sign_name');
		$exp_date_from = $this->input->post('exp_date_from');
		$exp_date_to = $this->input->post('exp_date_to');
		
		$results = $this->apis->search_expense_by_multiple_var($exp_type, $exp_name, $exp_sign_name, $exp_date_from, $exp_date_to);
		
		if($results != NULL) {
			echo json_encode($results);
		}
		echo NULL;
	}

	/**
	 *  create new receipt record
	 */
	function createNewReceiptRecord() {
		$student_ic = $this->input->post('student_ic');
		$receipt_type = $this->input->post('receipt_type');
		$receipt_no = $this->input->post('receipt_no');
		$payee_name = $this->input->post('payee_name');
		$receipt_date = $this->input->post('receipt_date');
		$receipt_amount = $this->input->post('receipt_amount');
		$makeup = $this->input->post('makeup');
		$student_before = $this->input->post('student_before');
		$course_type = $this->input->post('course_type');
		$letter_type = $this->input->post('letter_type');
		$reg_no = $this->input->post('reg_no');
		// $related_receipt = $this->input->post('related_receipt');
		// $related_receipt_amount = $this->input->post('related_receipt_amount');
		$receipt_branch_id = $this->input->post('receipt_branch_id');
		$receipt_op_id = $this->input->post('receipt_op_id');
		$receipt_remark = $this->input->post('receipt_remark');

		// create
		$create = $this->apis->create_new_receipt_record(
			$student_ic,
			$receipt_type, 
			$receipt_no, 
			$payee_name, 
			$receipt_date, 
			$receipt_amount, 
			$makeup,
			$student_before,
			$course_type,
			$letter_type,
			$reg_no,
			// $related_receipt,
			// $related_receipt_amount,
			$receipt_branch_id, 
			$receipt_op_id,
			$receipt_remark);
		if($create) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  get receipt by receipt number
	 */
	function getReceiptByNo() {
		$receipt_no = $this->input->post('receipt_no');
		$receipt = $this->apis->get_receipt_by_receipt_no($receipt_no);
		
		if($receipt != NULL) {
			echo json_encode($receipt);
		}
		echo NULL;
	}

	/**
	 *  search receipt records
	 */
	function searchReceiptRecords() {
		$student_ic = $this->input->post('student_ic');
		$receipt_no = $this->input->post('receipt_no');
		$receipt_branch = $this->input->post('receipt_branch');
		$course_type = $this->input->post('course_type');
		$receipt_date_from = $this->input->post('receipt_date_from');
		$receipt_date_to = $this->input->post('receipt_date_to');
		
		$results = $this->apis->search_receipt_by_multiple_var($student_ic, $receipt_no, $receipt_branch, $course_type, $receipt_date_from, $receipt_date_to);
		
		if($results != NULL) {
			echo json_encode($results);
		}
		echo NULL;
	}

	/**
	 *  get receipt record by receipt_id
	 */
	function getReceiptRecordByID() {
		$receipt_id = $this->input->post('receipt_id');
		$record = $this->apis->get_receipt_record_by_id($receipt_id);
		if($record != NULL) {
			echo json_encode($record);
		}
		echo NULL;
	}

	/**
	 *  search receipt records and download as excel file
	 */
	function searchReceiptRecordsDownload() {
		$student_ic = $_POST['student_ic'];
		$receipt_no = $_POST['receipt_no'];
		$receipt_branch = $_POST['receipt_branch'];
		$course_type = $_POST['course_type'];
		$receipt_date_from = $_POST['receipt_date_from'];
		$receipt_date_to = $_POST['receipt_date_to'];

		if(trim($receipt_date_from) == "") {
			$receipt_date_from = '2000-01-01';
		}

		if(trim($receipt_date_to) == "") {
			$receipt_date_to = '2100-01-01';
		}
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Receipt');
		$receipts = $this->apis->search_receipt_by_multiple_var_download($student_ic, $receipt_no, $receipt_branch, $course_type, $receipt_date_from, $receipt_date_to);
		$rowArray = array('收据类型', '收据时间', '收据号码', '收费金额', '学员IC', '付款人姓名', '学员电话', '是否补交学费', '是否老学员', '课程类型', '收款人', '分部', '备注');
		if($receipts != NULL) {
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray,   // The data to set
			        NULL
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $receipts,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A3'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );
			$filename = 'Receipt_'.date('Y-m-d H:i:s').'.xls';	
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			             
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			$objWriter->save('php://output');
		}
	}

	/**
	 *  update receipt record by receipt_id
	 */
	function updateReceiptRecord() {
		$receipt_id = $this->input->post('receipt_id');
		$student_ic = $this->input->post('student_ic');
		$receipt_type = $this->input->post('receipt_type');
		$receipt_no = $this->input->post('receipt_no');
		$payee_name = $this->input->post('payee_name');
		$receipt_date = $this->input->post('receipt_date');
		$receipt_amount = $this->input->post('receipt_amount');
		$makeup = $this->input->post('makeup');
		$student_before = $this->input->post('student_before');
		$course_type = $this->input->post('course_type');
		$letter_type = $this->input->post('letter_type');
		$reg_no = $this->input->post('reg_no');
		// $related_receipt = $this->input->post('related_receipt');
		// $related_receipt_amount = $this->input->post('related_receipt_amount');
		$receipt_branch_id = $this->input->post('receipt_branch_id');
		$receipt_op_id = $this->input->post('receipt_op_id');
		$receipt_remark = $this->input->post('receipt_remark');

		// update
		$update = $this->apis->update_receipt_record(
			$receipt_id,
			$student_ic,
			$receipt_type, 
			$receipt_no, 
			$payee_name, 
			$receipt_date, 
			$receipt_amount, 
			$makeup,
			$student_before,
			$course_type,
			$letter_type,
			$reg_no,
			// $related_receipt,
			// $related_receipt_amount,
			$receipt_branch_id, 
			$receipt_op_id,
			$receipt_remark);
		if($update) {
			echo 2;
		}
		else echo 0;
	}

	function testExcelDownload() {
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('ATO');

		$rowArray = array('Value1', 'Value2', 'Value3', 'Value4');
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $rowArray,   // The data to set
		        NULL,        // Array values with this value will not be set
		        'C3'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
		    );
		//set cell A1 content with some text
		// $this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
		// //change the font size
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
		$filename='just_some_random_name.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
}