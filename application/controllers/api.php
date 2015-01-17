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
	 * Get current admin users, combine with their branch, role, status
	 */
	function getCurrentAdmin() {
		$branch_op_id = $this->tank_auth->get_user_id();
		$admins = $this->apis->get_current_admin($branch_op_id);
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
		if($this->apis->check_user_role() == 'admin') {
			$student_branch_id = $this->input->post('student_branch_id');
		} else if($this->apis->check_user_role() == 'operator'){
			$student_branch_id = $this->apis->get_user_branch_id();
		}
		// $reg_branch_id = $this->input->post('reg_branch_id');
		// $reg_op_id = $this->input->post('reg_op_id');
		$reg_branch_id = $this->apis->get_user_branch_id();
		$reg_op_id = $this->tank_auth->get_user_id();
		$reg_no = $this->input->post('reg_no');
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

		$success = $this->apis->create_new_registration($ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime);
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
		if($this->apis->check_user_role() == 'admin') {
			$student_branch_id = $this->input->post('student_branch_id');
		} else if($this->apis->check_user_role() == 'operator'){
			$student_branch_id = $this->apis->get_user_branch_id();
		}
		// $reg_branch_id = $this->input->post('reg_branch_id');
		// $reg_op_id = $this->input->post('reg_op_id');
		$reg_branch_id = $this->apis->get_user_branch_id();
		$reg_op_id = $this->tank_auth->get_user_id();
		$reg_no = $this->input->post('reg_no');
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

		$success = $this->apis->update_registration($reg_id, $ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime);
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
		$records = $this->apis->search_reg_info($from,$to,$any_am,$any_pm,$any_eve,$sat_am,$sat_pm,$sat_eve,$sun_am,$sun_pm,$sun_eve,$anytime);
		if($records != NULL) {
			echo json_encode($records);
		}
		echo NULL;
	}

	/**
	 *  search registration info
	 */
	function searchRegistrationInfoDownload() {
		$from = $_POST['from'];
		$to = $_POST['to'];
		if(trim($from) == "") {
			$from = '0000-00-00';
		}

		if(trim($to) == "") {
			$to = '2100-01-01';
		}
		if(isset($_POST['any_am']) && $_POST['any_am'] == "1") { $any_am = "1"; } else { $any_am = "0"; }
		if(isset($_POST['any_pm']) && $_POST['any_pm'] == "1") { $any_pm = "1"; } else { $any_pm = "0"; }
		if(isset($_POST['any_eve']) && $_POST['any_eve'] == "1") { $any_eve = "1"; } else { $any_eve = "0"; }
		if(isset($_POST['sat_am']) && $_POST['sat_am'] == "1") { $sat_am = "1"; } else { $sat_am = "0"; }
		if(isset($_POST['sat_pm']) && $_POST['sat_pm'] == "1") { $sat_pm = "1"; } else { $sat_pm = "0"; }
		if(isset($_POST['sat_eve']) && $_POST['sat_eve'] == "1") { $sat_eve = "1"; } else { $sat_eve = "0"; }
		if(isset($_POST['sun_am']) && $_POST['sun_am'] == "1") { $sun_am = "1"; } else { $sun_am = "0"; }
		if(isset($_POST['sun_pm']) && $_POST['sun_pm'] == "1") { $sun_pm = "1"; } else { $sun_pm = "0"; }
		if(isset($_POST['sun_eve']) && $_POST['sun_eve'] == "1") { $sun_eve = "1"; } else { $sun_eve = "0"; }
		if(isset($_POST['anytime']) && $_POST['anytime'] == "1") { $anytime = "1"; } else { $anytime = "0"; }
		// $from = '2014-05-12';
		// $to = '2014-06-07';

		$records = $this->apis->search_reg_info_download($from,$to,$any_am,$any_pm,$any_eve,$sat_am,$sat_pm,$sat_eve,$sun_am,$sun_pm,$sun_eve,$anytime);
		$rowArray = array('IC', '注册日期', '注册号', '分部', '备注');
		if($records != NULL) {
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray,   // The data to set
			        NULL
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $records,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A3'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );
			$filename = 'Registrations_'.date('Y-m-d H:i:s').'.xls';	
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			             
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			$objWriter->save('php://output');
		}
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
		// $student_branch_id = $this->input->post('student_branch_id');
		// $student_op_id = $this->input->post('student_op_id');
		$student_branch_id = $this->apis->get_user_branch_id();
		$student_op_id = $this->tank_auth->get_user_id();
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
		// $student_branch_id = $this->input->post('student_branch_id');
		// $student_op_id = $this->input->post('student_op_id');
		$student_branch_id = $this->apis->get_user_branch_id();
		$student_op_id = $this->tank_auth->get_user_id();
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
	 *  delete student by student_id
	 */
	function deleteStudentInfoByID() {
		$student_id = $this->input->post('student_id');
		$delete = $this->apis->delete_student_info_by_id($student_id);
		if($delete){
			echo 3;
		}
		else echo 0;
	}

	/**
	 *  search singel student info by ic and download
	 */
	function searchStudentInfoDownload() {
		$keyword = $_POST['keyword'];
		$students = $this->apis->search_single_students_by_keyword_download($keyword);
		$rowArray1 = array('来源', '注册号', 'IC', '分部', '姓', '名', '其他名字/全名', '电话', '家里电话', '性别', '称呼', '生日', '年龄', 'IC类型', '公民类型', '国籍', '种族', '华文水平', '教育水平', '语言', '政府信', '工作状态', '公司名字', '公司类型', '公司注册号', '行业', '职称', '工资水平', 'Block', 'Floor_Unit', '街道', 'Building', '邮编', '备注');
		if($students != NULL) {
			$this->excel->getActiveSheet()
			    ->fromArray(
			        array('基本信息'),   // The data to set
			        NULL
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray1,   // The data to set
			        NULL,
			        'A2'
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $students,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A3'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );

			$student_records = $this->apis->get_student_records_by_ic_download($keyword);
			$rowArray2 = array('IC', '考试时间', '听力', '阅读', '数学', '会话', '读写', '综合等级', '会话等级', '读写等级', '数学等级', '备注');
			$this->excel->getActiveSheet()
			    ->fromArray(
			        array('考试记录'),   // The data to set
			        NULL,
			        'A5'
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray2,   // The data to set
			        NULL,
			        'A6'
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $student_records,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A7'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );

			$start = 8 + sizeof($student_records); + 1;

			$classes = $this->apis->get_all_class_by_student_ic_download($keyword);
			$rowArray3 = array('班级代码', '班级名字', '班级类型', '班级水平', '开始日期', '结束日期', '开始时间', '结束时间', '老师名字', '老是电话', '上课地点', '班级状态', '备注');
			$this->excel->getActiveSheet()
			    ->fromArray(
			        array('所在班级信息'),   // The data to set
			        NULL,
			        'A'.$start
			    );
			$start += 1;
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray3,   // The data to set
			        NULL,
			        'A'.$start
			    );
			$start += 1;
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $classes,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A'.$start         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );
			$start += sizeof($classes) + 1;
			
			$atos = $this->apis->get_student_atos_by_ic_download($keyword);
			$rowArray4 = array('IC', 'Pre / Post Assessment','Class ID', 'Attendance Percentage', '是否改期', 'EL', 'ER', 'EN', 'ES', 'EW', 'Exam Location', 'Exam Date', 'Exam Time', 'Remark');
			$this->excel->getActiveSheet()
			    ->fromArray(
			        array('ATO信息'),   // The data to set
			        NULL,
			        'A'.$start
			    );
			$start += 1;
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray4,   // The data to set
			        NULL,
			        'A'.$start
			    );
			$start += 1;
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $atos,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A'.$start         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );
		}
		$filename = 'Student_All_Info_'.date('Y-m-d H:i:s').'.xls';	
			
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	/**
	 *  search student info by ic or name and download
	 */
	function searchStudentInfoDownload1() {
		$keyword = $_POST['keyword'];
		$students = $this->apis->search_students_by_keyword_download($keyword);
		$rowArray = array('来源', '注册号', 'IC', '分部', '姓', '名', '其他名字/全名', '电话', '家里电话', '性别', '称呼', '生日', '年龄', 'IC类型', '公民类型', '国籍', '种族', '华文水平', '教育水平', '语言', '政府信', '工作状态', '公司名字', '公司类型', '公司注册号', '行业', '职称', '工资水平', 'Block', 'Floor_Unit', '街道', 'Building', '邮编', '备注');
		if($students != NULL) {
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray,   // The data to set
			        NULL
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $students,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A3'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );
			$filename = 'Students_'.date('Y-m-d H:i:s').'.xls';	
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			             
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			$objWriter->save('php://output');
		}
	}

	/**
	 *  search student info by multi varibles and download
	 */
	function searchStudentInfoDownload2() {
		$course_type = $_POST['course_type'];
		$level = $_POST['level'];
		$slot = $_POST['slot'];
		$from = $_POST['from'];
		$to = $_POST['to'];
		if(trim($from) == "") {
			$from = '0000-00-00';
		}

		if(trim($to) == "") {
			$to = '0000-00-00';
		}
		if(isset($_POST['have_class'])) {
			$have_class = 'YES';
		} else {
			$have_class = 'NO';
		}
		$students = $this->apis->search_class_students_by_multiple_var_download($course_type, $level, $slot, $from, $to, $have_class);
		$rowArray = array('来源', '注册号', 'IC', '分部', '姓', '名', '其他名字/全名', '电话', '家里电话', '性别', '称呼', '生日', '年龄', 'IC类型', '公民类型', '国籍', '种族', '华文水平', '教育水平', '语言', '政府信', '工作状态', '公司名字', '公司类型', '公司注册号', '行业', '职称', '工资水平', 'Block', 'Floor_Unit', '街道', 'Building', '邮编', '备注');
		if($students != NULL) {
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray,   // The data to set
			        NULL
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $students,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A3'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );
			$filename = 'Students_'.date('Y-m-d H:i:s').'.xls';	
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			             
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			$objWriter->save('php://output');
		}
	}

	/**
	 *  create ato info by student
	 */
	function createATOInfo() {
		$ic = $this->input->post('ic').trim(" ");
		$pre_post = $this->input->post('pre_post');
		// $recommend_level = $this->input->post('recommend_level');
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
		// $ato_branch_id = $this->input->post('ato_branch_id');
		// $ato_op_id = $this->input->post('ato_op_id');
		$ato_branch_id = $this->apis->get_user_branch_id();
		$ato_op_id = $this->tank_auth->get_user_id();
		$remark = $this->input->post('remark');
		
		// create
		$create = $this->apis->create_new_ato(
			$ic,
			$pre_post,
			// $recommend_level,
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
		// $recommend_level = $this->input->post('recommend_level');
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
		// $ato_branch_id = $this->input->post('ato_branch_id');
		// $ato_op_id = $this->input->post('ato_op_id');
		$ato_branch_id = $this->apis->get_user_branch_id();
		$ato_op_id = $this->tank_auth->get_user_id();
		$remark = $this->input->post('remark');

		// update
		$update = $this->apis->update_ato(
			$id,
			$pre_post,
			// $recommend_level,
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
		// $branch_id = $this->input->post('branch_id');
		// $branch_op_id = $this->input->post('branch_op_id');
		$branch_id = $this->apis->get_user_branch_id();
		$branch_op_id = $this->tank_auth->get_user_id();
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
		// $branch_id = $this->input->post('branch_id');
		// $branch_op_id = $this->input->post('branch_op_id');
		$branch_id = $this->apis->get_user_branch_id();
		$branch_op_id = $this->tank_auth->get_user_id();
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
	 *  delete exam record by id
	 */
	function deleteExamRecordByID() {
		$id = $this->input->post('id');
		// delete
		$delete = $this->apis->delete_exam_record_by_id($id);
		if($delete){
			echo 3;
		}
		else echo 0;
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
		$have_class = $this->input->post('have_class');
		$from = $_POST['from'];
		$to = $_POST['to'];
		if($have_class !='YES') {
			$have_class = 'NO';
		}
		$students = $this->apis->search_class_students_by_multiple_var($course_type, $level, $slot, $from, $to, $have_class);
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
			$from = '0000-00-00';
		}

		if(trim($to) == "") {
			$to = '2100-01-01';
		}
		$class_code = $_POST["class_code"];
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('ATO');
		$je_09 = $this->apis->search_atos_by_time_download($from, $to, $class_code, 'JE', '09');
		if($je_09[0] == NULL) { $je_09[0] = array(NULL); };
		$je_14 = $this->apis->search_atos_by_time_download($from, $to, $class_code, 'JE', '14');
		if($je_14[0] == NULL) { $je_14[0] = array(NULL); };
		$je_19 = $this->apis->search_atos_by_time_download($from, $to, $class_code, 'JE', '19');
		if($je_19[0] == NULL) { $je_19[0] = array(NULL); };
		$pi_09 = $this->apis->search_atos_by_time_download($from, $to, $class_code, 'PY', '09');
		if($pi_09[0] == NULL) { $pi_09[0] = array(NULL); };
		$pi_14 = $this->apis->search_atos_by_time_download($from, $to, $class_code, 'PY', '14');
		if($pi_14[0] == NULL) { $pi_14[0] = array(NULL); };
		$pi_19 = $this->apis->search_atos_by_time_download($from, $to, $class_code, 'PY', '19');
		if($pi_19[0] == NULL) { $pi_19[0] = array(NULL); };
		$title_row = array('Exam Date', 'Pre / Post Assessment', 'Class ID', 'Training Start Date (DD/MM/YYYY)', 'Training End Date (DD/MM/YYYY)', 'Course Code', 'Attendance Percentage', 'Transfer Flag (Yes/No)', 'Training Recommendation', 'ATO Org ID', 'EL', 'ER', 'EN', 'ES', 'EW', 'Salutation', 'ID Type (Select from dropdown list)', 'NRIC/Fin No.', 'Expiry Date (DD/MM/YYYY)', 'SurName', 'GivenName', 'Name', 'Gender', 'DOB (DD/MM/YYYY)', 'Age', 'Citizenship', 'Nationality', 'Ethnic Group', 'Highest Chinese Education Level', 'Highest Education Level', 'Language Proficiency', 'Blk', 'Street Name', '#Floor - Unit No', 'Building Name', 'Postal Code', 'Contact No', 'Contact Email', 'Employment Status', 'Company Registration Type', 'Company Name', 'Company Registration No', 'Industry Sector', 'Designation', 'Salary Range');
		$arrayData = array(
		    $title_row,
		    array(NULL),
		    array('JE'),
		    array('09:00'),
		);
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $arrayData,   // The data to set
		        NULL
		    );
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $je_09,   // The data to set
		        NULL,
		        'A5'
		    );
		$start = 5 + sizeof($je_09); + 1;
		$this->excel->getActiveSheet()
		    ->fromArray(
		       	array('14:00'),   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 1; 
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $je_14,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($je_14);
		$this->excel->getActiveSheet()
		    ->fromArray(
		       	array('19:00'),   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 1; 
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $je_19,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($je_19);
		$arrayData = array(
		    array(NULL),
		    array('PY'),
		    array('09:00'),
		);
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $arrayData,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 3;
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $pi_09,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($pi_09);
		$this->excel->getActiveSheet()
		    ->fromArray(
		       	array('14:00'),   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 1; 
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $pi_14,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($pi_14);
		$this->excel->getActiveSheet()
		    ->fromArray(
		       	array('19:00'),   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 1;
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $pi_19,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($pi_19);
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

	/**
	 *  search ato info by ic and download as excel file
	 */
	function searchATOByICInfoDownload() {
		$ic = $_POST["ic"];

		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('ATO');
		$je_09 = $this->apis->search_atos_by_ic_download($ic, 'JE', '09');
		if($je_09[0] == NULL) { $je_09[0] = array(NULL); };
		$je_14 = $this->apis->search_atos_by_ic_download($ic, 'JE', '14');
		if($je_14[0] == NULL) { $je_14[0] = array(NULL); };
		$je_19 = $this->apis->search_atos_by_ic_download($ic, 'JE', '19');
		if($je_19[0] == NULL) { $je_19[0] = array(NULL); };
		$pi_09 = $this->apis->search_atos_by_ic_download($ic, 'PY', '09');
		if($pi_09[0] == NULL) { $pi_09[0] = array(NULL); };
		$pi_14 = $this->apis->search_atos_by_ic_download($ic, 'PY', '14');
		if($pi_14[0] == NULL) { $pi_14[0] = array(NULL); };
		$pi_19 = $this->apis->search_atos_by_ic_download($ic, 'PY', '19');
		if($pi_19[0] == NULL) { $pi_19[0] = array(NULL); };
		$title_row = array('Pre / Post Assessment', 'Class ID', 'Training Start Date (DD/MM/YYYY)', 'Training End Date (DD/MM/YYYY)', 'Course Code', 'Attendance Percentage', 'Transfer Flag (Yes/No)', 'Training Recommendation', 'ATO Org ID', 'EL', 'ER', 'EN', 'ES', 'EW', 'Salutation', 'ID Type (Select from dropdown list)', 'NRIC/Fin No.', 'Expiry Date (DD/MM/YYYY)', 'SurName', 'GivenName', 'Name', 'Gender', 'DOB (DD/MM/YYYY)', 'Age', 'Citizenship', 'Nationality', 'Ethnic Group', 'Highest Chinese Education Level', 'Highest Education Level', 'Language Proficiency', 'Blk', 'Street Name', '#Floor - Unit No', 'Building Name', 'Postal Code', 'Contact No', 'Contact Email', 'Employment Status', 'Company Registration Type', 'Company Name', 'Company Registration No', 'Industry Sector', 'Designation', 'Salary Range');
		$arrayData = array(
		    $title_row,
		    array(NULL),
		    array('JE'),
		    array('09:00'),
		);
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $arrayData,   // The data to set
		        NULL
		    );
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $je_09,   // The data to set
		        NULL,
		        'A5'
		    );
		$start = 5 + sizeof($je_09); + 1;
		$this->excel->getActiveSheet()
		    ->fromArray(
		       	array('14:00'),   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 1; 
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $je_14,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($je_14);
		$this->excel->getActiveSheet()
		    ->fromArray(
		       	array('19:00'),   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 1; 
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $je_19,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($je_19);
		$arrayData = array(
		    array(NULL),
		    array('PY'),
		    array('09:00'),
		);
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $arrayData,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 3;
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $pi_09,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($pi_09);
		$this->excel->getActiveSheet()
		    ->fromArray(
		       	array('14:00'),   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 1; 
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $pi_14,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($pi_14);
		$this->excel->getActiveSheet()
		    ->fromArray(
		       	array('19:00'),   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += 1;
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $pi_19,   // The data to set
		        NULL,
		        'A'.$start
		    );
		$start += sizeof($pi_19);
		$filename = 'ATO_IC_'.$ic.'_Date_'.date('Y-m-d H:i:s').'.xls';	
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
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
	 *  search class info by multiple variables and download as excel
	 */
	function searchClassInfoDownload() {
		$code = $_POST['code'];
		$type = $_POST['type'];
		$level = $_POST['level'];
		$status = $_POST['status'];
		$branch_id = $_POST['branch_id'];
		$start_from = $_POST['start_from'];
		$start_to = $_POST['start_to'];
		$end_from = $_POST['end_from'];
		$end_to = $_POST['end_to'];
		if(trim($start_from) == "") {
			$start_from = '0000-00-00';
		}
		if(trim($start_to) == "") {
			$start_to = '2100-01-01';
		}
		if(trim($end_from) == "") {
			$end_from = '0000-00-00';
		}
		if(trim($end_to) == "") {
			$end_to = '2100-01-01';
		}

		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Classes');
		$classes = $this->apis->search_class_by_multiple_var_download($code, $type, $level, $status, $branch_id, $start_from, $start_to, $end_from, $end_to);
		$rowArray = array('班级代码', '班级名字', '班级类型', '班级水平', '开班时间', '闭班时间', '上课开始时间', '上课结束时间', '老师名字', '老师电话', '所在地点', '分部', '班级状态', '备注');
		if($classes != NULL) {
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray,   // The data to set
			        NULL
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $classes,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A3'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );

			$filename = 'Classes_'.date('Y-m-d H:i:s').'.xls';	
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			             
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			$objWriter->save('php://output');
		}
	}

	/**
	 *  create new class
	 */
	function createNewClass() {
		$code = $this->input->post('code').trim(" ");
		$class_name = $this->input->post('class_name');
		if($this->apis->check_user_role() == 'admin') {
			$branch_id = $this->input->post('branch_id');
		} else if($this->apis->check_user_role() == 'operator'){
			$branch_id = $this->apis->get_user_branch_id();
		}
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
		if($this->apis->check_user_role() == 'admin') {
			$branch_id = $this->input->post('branch_id');
		} else if($this->apis->check_user_role() == 'operator'){
			$branch_id = $this->apis->get_user_branch_id();
		}
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
	 *  delete class by class id
	 */
	function deleteClassByID() {
		$id = $this->input->post('id');
		// delete
		$delete = $this->apis->delete_class_info($id);
		if($delete){
			echo 3;
		}
		else echo 0;
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

	function getClassStudentsByClassIDToExcel() {
		$class_id = $_POST['class_id'];
		$class_name = $_POST['class_name'];
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Class Students');
		$students = $this->apis->get_all_class_students_by_class_id_to_excel($class_id);
		$rowArray = array('来源', '注册号', 'IC', '分部', '名', '姓', '其他名字/全名', '电话', '家里电话', '性别', '称呼', '生日', '年龄', 'IC类型', '公民类型', '国籍', '种族', '华文水平', '教育水平', '语言', '政府信', '工作状态', '公司名字', '公司类型', '公司注册号', '行业', '职称', '工资水平', 'Block', 'Floor_Unit', '街道', 'Building', '邮编', '备注');
		if($students != NULL) {
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $rowArray,   // The data to set
			        NULL
			    );
			$this->excel->getActiveSheet()
			    ->fromArray(
			        $students,   // The data to set
			        NULL,        // Array values with this value will not be set
			        'A3'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
			    );
			$filename = 'Class_'.$class_name.'_Students_'.date('Y-m-d H:i:s').'.xls';	
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			             
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			$objWriter->save('php://output');
		}
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
	 *  remove student from class
	 */
	function removeStudentFromClassByID() {
		$class_id = $this->input->post('class_id');
		$student_id = $this->input->post('student_id');
		$delete = $this->apis->delete_student_class_record($class_id, $student_id);
		if($delete){
			echo 3;
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
		$branch_id = $this->apis->get_user_branch_id();
		$branch_op_id = $this->tank_auth->get_user_id();
		$exp_remark = $this->input->post('exp_remark');
		// create
		$create = $this->apis->create_new_expense_record($exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $branch_id, $branch_op_id, $exp_remark);
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
		$branch_id = $this->apis->get_user_branch_id();
		$branch_op_id = $this->tank_auth->get_user_id();
		$exp_remark = $this->input->post('exp_remark');
		// update
		$update = $this->apis->update_expense_record($exp_id, $exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $branch_id, $branch_op_id, $exp_remark);
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
	 *  delete receipt record by receipt_id
	 */
	function deleteExpenseInfoByID() {
		$expense_id = $this->input->post('expense_id');
		// create
		$delete = $this->apis->delete_student_expense_record($expense_id);
		if($delete) {
			echo 3;
		}
		else echo 0;
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
		// $receipt_branch_id = $this->input->post('receipt_branch_id');
		// $receipt_op_id = $this->input->post('receipt_op_id');
		$receipt_branch_id = $this->apis->get_user_branch_id();
		$receipt_op_id = $this->tank_auth->get_user_id();
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
	 *  delete receipt record by receipt_id
	 */
	function deleteReceiptInfoByID() {
		$receipt_id = $this->input->post('receipt_id');
		// create
		$delete = $this->apis->delete_student_receipt_record($receipt_id);
		if($delete) {
			echo 3;
		}
		else echo 0;
	}

	/**
	 *  get receipt record by ic
	 */
	function getStudentRecepitsByIC() {
		$ic = $this->input->post('ic');
		$records = $this->apis->get_receipt_record_by_ic($ic);
		if($records != NULL) {
			echo json_encode($records);
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
			$receipt_date_from = '0000-00-00';
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
		// $receipt_branch_id = $this->input->post('receipt_branch_id');
		// $receipt_op_id = $this->input->post('receipt_op_id');
		$receipt_branch_id = $this->apis->get_user_branch_id();
		$receipt_op_id = $this->tank_auth->get_user_id();
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

	/* --------------------- exam management ------------------------- */

	/**
	 *  create or update seat booking info of spercific date
	 */
	function createOrUpdateSeatBookingInfo() {
		$on_off = $this->input->post('on_off');
		$je_09 = $this->input->post('je_09');
		$pi_09 = $this->input->post('pi_09');
		$je_14 = $this->input->post('je_14');
		$pi_14 = $this->input->post('pi_14');
		$je_19 = $this->input->post('je_19');
		$pi_19 = $this->input->post('pi_19');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$day = $this->input->post('day');

		// create_update
		$create_update = $this->apis->create_update_seat_booking_info(
			$on_off,
			$je_09, 
			$pi_09, 
			$je_14, 
			$pi_14, 
			$je_19, 
			$pi_19,
			$year,
			$month,
			$day);
		if($create_update) {
			echo 1;
		}
		else echo 0;		
	}

	function updateSeatBookingInfo() {
		$on_off = $this->input->post('on_off');
		$je_09 = $this->input->post('je_09');
		$pi_09 = $this->input->post('pi_09');
		$je_14 = $this->input->post('je_14');
		$pi_14 = $this->input->post('pi_14');
		$je_19 = $this->input->post('je_19');
		$pi_19 = $this->input->post('pi_19');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$day = $this->input->post('day');

		// update
		$update = $this->apis->update_seat_booking_info(
			$on_off,
			$je_09, 
			$pi_09, 
			$je_14, 
			$pi_14, 
			$je_19, 
			$pi_19,
			$year,
			$month,
			$day);
		if($update) {
			echo 2;
		}
		else echo 0;
	}

	/**
	 *  get seat booking info by giving year, month and day
	 */
	function getSeatBookingInfoByYearMonthDay() {
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$day = $this->input->post('day');
		$record = $this->apis->get_seat_booking_record_by_date($year, $month, $day);
		if($record != NULL) {
			echo json_encode($record);
		}
		echo NULL;
	}

	/**
	 *  upload exam file, update student_records table
	 */
	function uploadExamResults() {
		$config['upload_path'] = './uploads/';
		// $config['allowed_types'] = 'xls|xlsx';
		$config['allowed_types'] = '*';
		$config['max_size']	= '2048';
		$config['file_name']	= 'exams.xls';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload()) {
			$result = array('result' => $this->upload->display_errors());
			$this->load->view('/partials/students/student_upload_result', $result);
		}
		else {
			$result = array('result' => $this->upload->data());
			$this->load->view('/partials/students/student_upload_result', $result);

			// read upload excel file (exams results), insert into database, delete the temp file
			$path = "./uploads/";
			$objPHPExcel = PHPExcel_IOFactory::load($path."exams.xls");

			$branch_id = $this->apis->get_user_branch_id();
			$branch_op_id = $this->tank_auth->get_user_id();
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			    $worksheetTitle     = $worksheet->getTitle();
			    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
			    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
			    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			    $nrColumns = ord($highestColumn) - 64;

			    $title = date_parse($worksheet->getTitle());
			    $test_data = $title["year"].'-'.$title["month"].'-'.$title["day"];
			    echo "<br>The worksheet ".$worksheetTitle." has ";
			    echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
			    echo ' and ' . $highestRow . ' row.';
			    echo '<br>Data: <table border="1"><tr>';
			    for ($row = 1; $row <= $highestRow; ++ $row) {
			        echo '<tr>';
			        $exam_record = array();
			        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			            $cell = $worksheet->getCellByColumnAndRow($col, $row);
			            $val = $cell->getValue();
			            // $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
			            echo '<td>' . (string)$val . '<br></td>';

			            // insert into array exam_record, extract only the data
			            if($row > 2 && $col > 0) {
			            	array_push($exam_record, (string)$val);
			            }
			        }
			        echo '</tr>';

			        if($row > 2) {
				       	//get data from array exam_record and insert into db
				        $ic = $exam_record[1];
				        $exam_date = $test_data;
				        $er = substr($exam_record[6],0,1);
				        if($er == 'E') { $er = 'EXE'; } else if($er == 'U') { $er = 'UN'; } else if($er == 'B') { $er = 'B1'; } else if($er == 'N') { $er = 'N/A'; }
				        $el = substr($exam_record[5],0,1);
				        if($el == 'E') { $el = 'EXE'; } else if($el == 'U') { $el = 'UN'; } else if($el == 'B') { $el = 'B1'; } else if($el == 'N') { $el = 'N/A'; }
				        $es = substr($exam_record[8],0,1);
				        if($es == 'E') { $es = 'EXE'; } else if($es == 'U') { $es = 'UN'; } else if($es == 'B') { $es = 'B1'; } else if($es == 'N') { $es = 'N/A'; }
				        $ew = substr($exam_record[9],0,1);
				        if($ew == 'E') { $ew = 'EXE'; } else if($ew == 'U') { $ew = 'UN'; } else if($ew == 'B') { $ew = 'B1'; } else if($ew == 'N') { $ew = 'N/A'; }
				        $en = substr($exam_record[4],0,1);
				        if($en == 'E') { $en = 'EXE'; } else if($en == 'U') { $en = 'UN'; } else if($en == 'B') { $en = 'B1'; } else if($en == 'N') { $en = 'N/A'; }
				        $cmp = $exam_record[10];
				        $con = $exam_record[11];
				        $wri = $exam_record[12];
				        $wpn = $exam_record[13];
				        $remark = $exam_record[17];
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
							echo '<p>Worksheet'.$worksheetTitle.' Record'.($row - 2).' insert successed!<p>';
						}
						else echo '<p>Worksheet'.$worksheetTitle.' Record'.($row - 2).' insert failed!<p>';
			        }
			    }
			    echo '</table>';
			}

			// delete temple file
			foreach (glob($path."exams*.*") as $filename) {
			    unlink($filename);
			}
		}
	}


	/**
	 *  upload student info file, update student table
	 */
	function uploadStudentBasicInfo() {
		$config['upload_path'] = './uploads/';
		// $config['allowed_types'] = 'xls|xlsx';
		$config['allowed_types'] = '*';
		$config['max_size']	= '2048';
		$config['file_name']	= 'students.xls';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload()) {
			$result = array('result' => $this->upload->display_errors());
			$this->load->view('/partials/students/student_upload_result', $result);
		}
		else {
			$result = array('result' => $this->upload->data());
			$this->load->view('/partials/students/student_upload_result', $result);

			// read upload excel file (students basic info), insert into database, delete the temp file
			$path = "./uploads/";
			$objPHPExcel = PHPExcel_IOFactory::load($path."students.xls");

			//$branch_id = $this->apis->get_user_branch_id();
			//$branch_op_id = $this->tank_auth->get_user_id();

			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			    $worksheetTitle     = $worksheet->getTitle();
			    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
			    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
			    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			    $nrColumns = ord($highestColumn) - 64;

			    //$title = date_parse($worksheet->getTitle());
			    //$test_data = $title["year"].'-'.$title["month"].'-'.$title["day"];
			    echo "<br>The worksheet ".$worksheetTitle." has ";
			    echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
			    echo ' and ' . $highestRow . ' row.';
			    echo '<br>Data: <table border="1"><tr>';
			    for ($row = 1; $row <= $highestRow; ++ $row) {
			        echo '<tr>';
			        $student = array();
			        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			            $cell = $worksheet->getCellByColumnAndRow($col, $row);
			            $val = $cell->getValue();
			            // $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
			            echo '<td>' . (string)$val . '<br></td>';

			            // insert into array student, extract only the data
			            if($row > 2 && $col > 0) {
			            	array_push($student, (string)$val);
			            }
			        }
			        echo '</tr>';

			        if($row > 2) {
				       	//get data from array student and insert into db
				        $ic = $student[0];
				        $firstname = $student[1];
				        $lastname = $student[2];
				        $othername = $student[3];
				        $tel = $student[4];
				        $tel_home = $student[5];
				        if($student[6] == '') { $gender = 'NA'; } else { $gender = $student[6]; }
				        if($student[7] == '') { $salutation = 'NA'; } else { $salutation = $student[7]; }
				        //echo "<h3>".gmdate("Y-m-d", $UNIX_DATE)."</h3>";
				        if($student[8] == '') {	
				        	$birthday = '0000-00-00'; 
				        } else {
				        	$UNIX_DATE = ($student[8] - 25569) * 86400;
			    			$birthday = gmdate("Y-m-d", $UNIX_DATE);
			    			//echo "<h3>".$birthday."</h3>";
				        }
			    		$age = $student[9];
			    		if($student[10] == '') { $ic_type = 'NA'; } else { $ic_type = $student[10]; }
			    		if($student[11] == '') { $citizenship = 'NA'; } else { $citizenship = $student[11]; }
			    		if($student[12] == '') { $nationality = 'NA'; } else { $nationality = $student[12]; }
			    		if($student[13] == '') { $race = 'NA'; } else { $race = $student[13]; }
						if($student[14] == '') { $cn_level = 'NA'; } else { $cn_level = $student[14]; }
						if($student[15] == '') { $edu_level = 'NA'; } else { $edu_level = $student[15]; }
						if($student[16] == '') { $lang = 'NA'; } else { $lang = $student[16]; }
						if($student[17] == '') { $gov_letter = 'NO'; } else { $gov_letter = 'YES'; }
						$remark = $student[18];
						$status = 1;
						$source = $student[22];
						$emp_status = $student[23];
						$company_name = $student[24];
						if($student[25] == '') { $company_type = 'NA'; } else { $company_type = $student[25]; }
						$company_reg_no = $student[26];
						if($student[27] == '') { $industry = 'NA'; } else { $industry = $student[27]; }
						if($student[28] == '') { $designation = 'NA'; } else { $designation = $student[28]; }
						if($student[29] == '') { $salary_range = 'NA'; } else { $salary_range = $student[29]; }
						$blk = $student[30];
						$street = $student[31];
						$floor_unit_no = $student[32];
						$building = $student[33];
						$postcode = $student[34];
						$student_branch_id = $student[35];
						$student_op_id = 1;
						$student_remark = $student[37];
				        
				        //create
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
						if($create) {
							echo '<p>Worksheet'.$worksheetTitle.' Record'.($row - 2).' insert successed!<p>';
						}
						else echo '<p>Worksheet'.$worksheetTitle.' Record'.($row - 2).' insert failed!<p>';
			        }
			    }
			    echo '</table>';
			}

			// delete temple file
			foreach (glob($path."students*.*") as $filename) {
			    unlink($filename);
			}
		}
	}

	/**
	 *  search exam info by exam time
	 */
	function searchExamInfo() {
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$exams = $this->apis->search_exams_by_time($from, $to);
		if($exams != NULL) {
			echo json_encode($exams);
		}
		echo NULL;
	}

	function searchExamInfoDownload() {
		$from = $_POST["from"];
		$to = $_POST["to"];

		if(trim($from) == "") {
			$from = '0000-00-00';
		}

		if(trim($to) == "") {
			$to = '2100-01-01';
		}
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Exam Records');
		$exams = $this->apis->search_exams_by_time_download($from, $to);
		$title_row = array('IC', 'Last Name', 'First Name', 'Other Name/Full Name', 'Exam Date', 'EL', 'ER', 'EN', 'ES', 'EW', 'CMP', 'CON', 'WRI', 'WPN', 'Remark');
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $title_row,   // The data to set
		        NULL
		    );
		$this->excel->getActiveSheet()
		    ->fromArray(
		        $exams,   // The data to set
		        NULL,
		        'A3'
		    );
		
		$filename = 'Exams_Date_'.date('Y-m-d H:i:s').'.xls';	
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	/* =================== header =================== */

	/**
	 *  create new public message
	 */
	function createNewPublicMessage() {
		$title = $this->input->post('title');
		$content = $this->input->post('content');
		// create
		$create = $this->apis->create_new_public_message($title, $content);
		if($create) {
			echo 1;
		}
		else echo 0;
	}

	/**
	 *  get all public message within one week
	 */
	function getPublicMessageOneWeek() {
		$messages = $this->apis->get_public_message_one_week();
		if($messages != NULL) {
			echo json_encode($messages);
		}
		echo NULL;
	}

	/**
	 *  delete public message by giving message id
	 */
	function deletePublicMessage() {
		$id = $this->input->post('id');
		// create
		$delete = $this->apis->delete_public_message($id);
		if($delete) {
			echo 3;
		}
		else echo 0;
	}

	/**
	 *  get student imcomplated info name list
	 */
	function getStudentInfoWarningList() {
		$results = $this->apis->get_student_info_warning_list();
		if($results != NULL) {
			echo json_encode($results);
		}
		echo NULL;
	}
}