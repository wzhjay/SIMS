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
	function get_all_admin_users()
	{
		if($this->session->userdata('session_id')) {
			$query = $this->db->query("SELECT * FROM users WHERE users.id IN (SELECT user_id FROM admin_users) ORDER BY users.id");
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
			$query = $this->db->query('INSERT INTO admin_users (user_id, role_id, branch_id, status_id) VALUES ("'.$user_id.'", "'.$role_id.'", "'.$branch_id.'", "'.$status_id.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get all admin users
	 *
	 * @param	none
	 * @return	array
	 */
	function get_all_admins() {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query("SELECT * FROM admin_users a, users u, branch b, admin_role r, status s WHERE (a.user_id = u.id) AND (a.branch_id = b.id) AND (a.role_id = r.id) AND (a.status_id = s.id) ORDER BY a.id");
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

	/**
	 * get all the courses from course table
	 *
	 * @param	user_id, new_role, new_branch_id
	 * @return	bool
	 */
	function update_single_admin_role_branch($user_id, $new_role_id, $new_branch_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE admin_users SET role_id = "'.$new_role_id.'", branch_id = "'.$new_branch_id.'" WHERE user_id = "'.$user_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * delete single admin user by user_id
	 *
	 * @param	user_id
	 * @return	bool
	 */
	function delete_single_admin_user($user_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM admin_users WHERE user_id = "'.$user_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * insert new reg info into registration table
	 *
	 * @param	$ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $start_date_wanted, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime
	 * @return	bool
	 */
	function create_new_registration($ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $start_date_wanted, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO registration (ic, reg_date, student_branch_id, reg_branch_id, reg_op_id, reg_no, start_date_wanted, reg_remark, any_am, any_pm, any_eve, sat_am, sat_pm, sat_eve, sun_am, sun_pm, sun_eve, anytime, created, modified) VALUES ("'.$ic.'", "'.$reg_date.'", "'.$student_branch_id.'", "'.$reg_branch_id.'", "'.$reg_op_id.'", "'.$reg_no.'", "'.$start_date_wanted.'", "'.$reg_remark.'", "'.$any_am.'", "'.$any_pm.'", "'.$any_eve.'", "'.$sat_am.'", "'.$sat_pm.'", "'.$sat_eve.'", "'.$sun_am.'", "'.$sun_pm.'", "'.$sun_eve.'", "'.$anytime.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}


	/**
	 * update reg info into registration table via reg_id
	 *
	 * @param	$ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $start_date_wanted, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime
	 * @return	bool
	 */
	function update_registration($reg_id, $ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $start_date_wanted, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE registration SET ic = "'.$ic.'", reg_date = "'.$reg_date.'", student_branch_id = "'.$student_branch_id.'", reg_branch_id = "'.$reg_branch_id.'", reg_op_id = "'.$reg_op_id.'", reg_no = "'.$reg_no.'", start_date_wanted = "'.$start_date_wanted.'", reg_remark = "'.$reg_remark.'", any_am = "'.$any_am.'", any_pm = "'.$any_pm.'", any_eve = "'.$any_eve.'", sat_am = "'.$sat_am.'", sat_pm = "'.$sat_pm.'", sat_eve = "'.$sat_eve.'", sun_am = "'.$sun_am.'", sun_pm = "'.$sun_pm.'", sun_eve = "'.$sun_eve.'", anytime = "'.$anytime.'", modified = "'.date('Y-m-d H:i:s').'" WHERE reg_id = "'.$reg_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get registration info from regstration table where ic equals to given ic
	 *
	 * @param	ic
	 * @return	array or NULL
	 */
	function get_registration_by_ic($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM registration WHERE ic = "'.$ic.'"');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search registration info by setting time range
	 *
	 * @param	from, to
	 * @return	array or NULL
	 */
	function search_reg_info($from, $to, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime) {
		if($this->session->userdata('session_id')) {
			$query_partial= "0 ";
			if($any_am == "1") { $query_partial.=" OR r.any_am = 1"; };
			if($any_pm == "1") { $query_partial.=" OR r.any_pm = 1"; };
			if($any_eve == "1") { $query_partial.=" OR r.any_eve = 1"; };
			if($sat_am == "1") { $query_partial.=" OR r.sat_am = 1"; };
			if($sat_pm == "1") { $query_partial.=" OR r.sat_pm = 1"; };
			if($sat_eve == "1") { $query_partial.=" OR r.sat_eve = 1"; };
			if($sun_am == "1") { $query_partial.=" OR r.sun_am = 1"; };
			if($sun_pm == "1") { $query_partial.=" OR r.sun_pm = 1"; };
			if($sun_eve == "1") { $query_partial.=" OR r.sun_eve = 1"; };
			if($anytime == "1") { $query_partial.=" OR r.anytime = 1"; };
			$query = $this->db->query('SELECT r.ic, r.reg_date, r.reg_no, b1.name AS reg_branch, b2.name AS assigned_branch, r.start_date_wanted, r.reg_remark, u.username, r.created, r.modified, r.any_am, r.any_pm, r.any_eve, r.sat_am, r.sat_pm, r.sat_eve, r.sun_am, r.sun_pm, r.sun_eve, r.anytime  FROM registration r, branch b1, branch b2, users u WHERE (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (r.reg_branch_id = b1.id) AND (r.student_branch_id = b2.id) AND (r.reg_op_id = u.id) AND ('.$query_partial.') ORDER BY -DATE(r.reg_date)');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * insert new student basic info
	 *
	 * @param	$source, $gov_letter, $ic, $ic_type, $firstname, $lastname, $othername, $tel, $tel_home, $gender, $salutation, $birthday, $age, $citizenship, $nationality, $race,$cn_level, $edu_level, $lang, $blk, $street, $floor_unit_no, $building, $postcode, $emp_status, $company_name, $company_type,$company_reg_no, $industry, $designation, $salary_range, student_branch_id, student_op_id, student_remark
	 * @return	bool
	 */
	function create_new_student_basic_info(
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
			$student_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO student (source, gov_letter, ic, ic_type, firstname, lastname, othername, tel, tel_home, gender, salutation, birthday, age, citizenship, nationality, race, cn_level, edu_level, lang, block, street, floor_unit_no, building, postcode, emp_status, company_name, company_type, company_reg_no, industry, designation, salary_range, student_branch_id, student_op_id, created, modified, student_remark) VALUES ("'.$source.'", "'.$gov_letter.'", "'.$ic.'", "'.$ic_type.'", "'.$firstname.'", "'.$lastname.'", "'.$othername.'", "'.$tel.'", "'.$tel_home.'", "'.$gender.'", "'.$salutation.'", "'.$birthday.'", "'.$age.'", "'.$citizenship.'", "'.$nationality.'", "'.$race.'", "'.$cn_level.'", "'.$edu_level.'", "'.$lang.'", "'.$blk.'", "'.$street.'", "'.$floor_unit_no.'", "'.$building.'", "'.$postcode.'", "'.$emp_status.'", "'.$company_name.'", "'.$company_type.'", "'.$company_reg_no.'", "'.$industry.'", "'.$designation.'", "'.$salary_range.'", "'.$student_branch_id.'", "'.$student_op_id.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$student_remark.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 *  update student basic info
	 *
	 * @param	$student_id, $source, $gov_letter, $ic, $ic_type, $firstname, $lastname, $othername, $tel, $tel_home, $gender, $salutation, $birthday, $age, $citizenship, $nationality, $race,$cn_level, $edu_level, $lang, $blk, $street, $floor_unit_no, $building, $postcode, $emp_status, $company_name, $company_type,$company_reg_no, $industry, $designation, $salary_range, student_branch_id, student_op_id, student_remark
	 * @return	bool
	 */
	function update_student_basic_info(
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
			$student_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE student SET source = "'.$source.'", gov_letter = "'.$gov_letter.'", ic = "'.$ic.'", ic_type = "'.$ic_type.'", firstname = "'.$firstname.'", lastname = "'.$lastname.'", othername = "'.$othername.'", tel = "'.$tel.'", tel_home = "'.$tel_home.'", gender = "'.$gender.'", salutation = "'.$salutation.'", birthday = "'.$birthday.'", age = "'.$age.'", citizenship = "'.$citizenship.'", nationality = "'.$nationality.'", floor_unit_no = "'.$floor_unit_no.'", cn_level = "'.$cn_level.'", edu_level = "'.$edu_level.'", lang = "'.$lang.'", block = "'.$blk.'", street = "'.$street.'", building = "'.$building.'", postcode = "'.$postcode.'", emp_status = "'.$emp_status.'", company_name = "'.$company_name.'", company_type = "'.$company_type.'", company_reg_no = "'.$company_reg_no.'", industry = "'.$industry.'", designation = "'.$designation.'", salary_range = "'.$salary_range.'", student_branch_id = "'.$student_branch_id.'", student_op_id = "'.$student_op_id.'", student_remark = "'.$student_remark.'", modified = "'.date('Y-m-d H:i:s').'" WHERE student_id = "'.$student_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * insert info to ato table
	 *
	 * @param	$ic, $pre_post, $recommend_level, $class_start_date,  $class_end_date, $class_code, $attendance, $el, $er, $en, $es, $ew, $exam_location, $exam_date, $exam_time, $remark
	 * @return	bool
	 */
	function create_new_ato($ic, $pre_post, $recommend_level, $class_start_date,  $class_end_date, $class_code, $attendance, $el, $er, $en, $es, $ew, $exam_location, $exam_date, $exam_time, $ato_branch_id, $ato_op_id, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO ato (ic, pre_post, recommend_level, class_start_date,  class_end_date, class_code, attendance, el, er, en, es, ew, exam_location, exam_date, exam_time, branch_id, branch_op_id, created, modified, remark) VALUES ("'.$ic.'", "'.$pre_post.'", "'.$recommend_level.'", "'.$class_start_date.'", "'.$class_end_date.'", "'.$class_code.'", "'.$attendance.'", "'.$el.'", "'.$er.'", "'.$en.'", "'.$es.'", "'.$ew.'", "'.$exam_location.'", "'.$exam_date.'", "'.$exam_time.'", "'.$ato_branch_id.'", "'.$ato_op_id.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$remark.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * update ato table
	 *
	 * @param	$ic, $pre_post, $recommend_level, $class_start_date,  $class_end_date, $class_code, $attendance, $el, $er, $en, $es, $ew, $exam_location, $exam_date, $exam_time, $remark
	 * @return	bool where ato.id = get id by ic
	 */
	function update_ato($id, $pre_post, $recommend_level, $class_start_date,  $class_end_date, $class_code, $attendance, $el, $er, $en, $es, $ew, $exam_location, $exam_date, $exam_time, $ato_branch_id, $ato_op_id, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE ato SET pre_post = "'.$pre_post.'", recommend_level = "'.$recommend_level.'", class_start_date = "'.$class_start_date.'", class_end_date = "'.$class_end_date.'", class_code = "'.$class_code.'", attendance = "'.$attendance.'", el = "'.$el.'", er = "'.$er.'", en = "'.$en.'", es = "'.$es.'", ew = "'.$ew.'", exam_location = "'.$exam_location.'", exam_date = "'.$exam_date.'", exam_time = "'.$exam_time.'", branch_id = "'.$ato_branch_id.'", branch_op_id = "'.$ato_op_id.'", modified = "'.date('Y-m-d H:i:s').'", remark = "'.$remark.'" WHERE id = "'.$id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get ato id by ic 
	 *
	 * @param	$ic
	 * @return	id or NULL
	 */
	function get_ato_id_by_ic($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT id FROM ato WHERE ic = "'.$ic.'"');
			if ($query->num_rows() > 0)
			{
			   $row = $query->row(); 
			   return $row->id;
			}
		}
		return NULL;
	}

	/**
	 * get ato info by ic 
	 *
	 * @param	$ic
	 * @return	array or NULL
	 */
	function get_student_atos_by_ic($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM ato WHERE ic = "'.$ic.'"');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get ato info by id
	 *
	 * @param	id
	 * @return	array or NULL
	 */
	function get_ato_info_by_id($id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM ato WHERE id = "'.$id.'"');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get student info from student table only, by given ic number
	 *
	 * @param	ic
	 * @return	array or NULL
	 */
	function get_student_info_by_ic($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM student WHERE ic = "'.$ic.'"');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get student records from student_record table, by given ic number
	 *
	 * @param	ic
	 * @return	array or NULL
	 */
	function get_student_records_by_ic($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM student_record WHERE student_ic = "'.$ic.'" ORDER BY id');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * create new student records, insert into student_record table
	 * @param	$ic, $exam_date, $er, $el, $es, $ew, $en, $cmp, $con, $wri, $wpn, $branch_id, $branch_op_id, $remark
	 * @return	bool
	 */
	function create_new_student_exam_record($ic, $exam_date, $er, $el, $es, $ew, $en, $cmp, $con, $wri, $wpn, $branch_id, $branch_op_id, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO student_record (student_ic, exam_date, el_best, er_best,  en_best, es_best, ew_best, cmp, con, wri, wpn, branch_id, branch_op_id, created, modified, remark) VALUES ("'.$ic.'", "'.$exam_date.'", "'.$el.'", "'.$er.'", "'.$en.'", "'.$es.'", "'.$ew.'", "'.$cmp.'", "'.$con.'", "'.$wri.'", "'.$wpn.'", "'.$branch_id.'", "'.$branch_op_id.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$remark.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * update record table
	 *
	 * @param	$id, $exam_date, $er, $el, $es, $ew, $en, $cmp, $con, $wri, $wpn, $branch_id, $branch_op_id, $remark
	 * @return	bool where student_record.id = given id
	 */
	function update_student_exam_record($id, $exam_date, $er, $el, $es, $ew, $en, $cmp, $con, $wri, $wpn, $branch_id, $branch_op_id, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE student_record SET exam_date = "'.$exam_date.'", er_best = "'.$er.'", el_best = "'.$el.'", es_best = "'.$es.'", ew_best = "'.$ew.'", en_best = "'.$en.'", cmp = "'.$cmp.'", con = "'.$con.'", wri = "'.$wri.'", wpn = "'.$wpn.'", branch_id = "'.$branch_id.'", branch_op_id = "'.$branch_op_id.'", modified = "'.date('Y-m-d H:i:s').'", remark = "'.$remark.'" WHERE id = "'.$id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get record info by id
	 *
	 * @param	id
	 * @return	array or NULL
	 */
	function get_student_record_by_id($id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM student_record WHERE id = "'.$id.'"');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search students by ic number(equal, one result), from table registration, student
	 *
	 * @param	key word (ic)
	 * @return	array or NULL
	 */
	function search_students_by_ic($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT *  FROM registration r, student s WHERE (r.ic = s.ic) AND (s.ic = "'.$ic.'") ORDER BY -DATE(r.reg_date)');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search students by keyword in ic number/firstname/lastname, from table registration, student
	 *
	 * @param	key word 
	 * @return	array or NULL
	 */
	function search_students_by_keyword($keyword) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT *  FROM registration r, student s WHERE (r.ic = s.ic) AND ((s.ic LIKE "%'.$keyword.'%") OR (s.firstname LIKE "%'.$keyword.'%") OR (s.lastname LIKE "%'.$keyword.'%")) ORDER BY -DATE(r.reg_date)');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search ato info by time
	 *
	 * @param	from, to
	 * @return	array or NULL
	 */
	function search_atos_by_time($from, $to) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT *  FROM ato a, student s WHERE (a.ic = s.ic) AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") ORDER BY -DATE(a.exam_date)');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;	
	}

	/**
	 * search class info by time
	 *
	 * @param	$code, $type, $level, $status, $start_from, $start_to, $end_from, $end_to
	 * @return	array or NULL
	 */
	function search_class_by_multiple_var($code, $type, $level, $status, $branch_id, $start_from, $start_to, $end_from, $end_to) {
		if($this->session->userdata('session_id')) {
			if(trim($code, " ") == "") { $code = "";}
			if($type == 'NA') { $type = "";}
			if($level == 'NA') { $level = "";}
			if($status == 'NA') { $status = "";}

			if($branch_id == 'ALL') {
				$query1 = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") ORDER BY -DATE(c.created)');
				if ($query1->num_rows() > 0) return $query1->result_array();
			}
			else {
				$query2 = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.branch_id = "'.$branch_id.'") AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") ORDER BY -DATE(c.created)');
				if ($query2->num_rows() > 0) return $query2->result_array();
			}
		}
		return NULL;
	}

	/**
	 * create new class, inseart new data into class table
	 *
	 * @param	$code, $class_name, $branch_id, $type, $level, $status, $location, $start_date, $end_date, $start_time, $end_time, $teacher_name, $teacher_tel, $remark
	 * @return	bool
	 */
	function create_new_class($code, $class_name, $branch_id, $type, $level, $status, $location, $start_date, $end_date, $start_time, $end_time, $teacher_name, $teacher_tel, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO class (code, class_name, type, level,  start_date, end_date, start_time, end_time, teacher_name, teacher_tel, location, branch_id, status, created, modified, remark) VALUES ("'.$code.'", "'.$class_name.'", "'.$type.'", "'.$level.'", "'.$start_date.'", "'.$end_date.'", "'.$start_time.'", "'.$end_time.'", "'.$teacher_name.'", "'.$teacher_tel.'", "'.$location.'", "'.$branch_id.'", "'.$status.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$remark.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * update existed class by given class_id
	 *
	 * @param	$class_id, $code, $class_name, $branch_id, $type, $level, $status, $location, $start_date, $end_date, $start_time, $end_time, $teacher_name, $teacher_tel, $remark
	 * @return	bool
	 */
	function update_class_by_id($class_id, $code, $class_name, $branch_id, $type, $level, $status, $location, $start_date, $end_date, $start_time, $end_time, $teacher_name, $teacher_tel, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE class SET code = "'.$code.'", class_name = "'.$class_name.'", branch_id = "'.$branch_id.'", type = "'.$type.'", level = "'.$level.'", status = "'.$status.'", location = "'.$location.'", start_date = "'.$start_date.'", end_date = "'.$end_date.'", start_time = "'.$start_time.'", end_time = "'.$end_time.'", teacher_name = "'.$teacher_name.'", teacher_tel = "'.$teacher_tel.'", modified = "'.date('Y-m-d H:i:s').'", remark = "'.$remark.'" WHERE class_id = "'.$class_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get class info by code from class and branch table
	 *
	 * @param	$code
	 * @return	array or NULL
	 */
	function get_class_info_by_code($code) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.code = "'.$code.'") ORDER BY c.class_id');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get class info by id from class table
	 *
	 * @param	$class_id
	 * @return	array or NULL
	 */
	function get_class_info_by_id($class_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT *  FROM class c WHERE (c.class_id = "'.$class_id.'")');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get all class info from class and branch table
	 *
	 * @param	null
	 * @return	array or NULL
	 */
	function get_all_class_info() {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) ORDER BY c.created');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get all class students info from student table by given class_id
	 *
	 * @param	class_id
	 * @return	array or NULL
	 */
	function get_all_class_students_by_class_id($class_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM student s WHERE s.id = (SELECT sc.student_id FROM student_class sc WHERE sc.class_id = "'.$class_id.'" ORDER BY s.created)');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;	
	}

	/**
	 *  check if record in table student_class where class_id and student_id both eauals to passed values
	 *
	 * @param	class_id, student_id
	 * @return	bool
	 */
	function check_student_class_exist($class_id, $student_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM student_class sc WHERE sc.class_id = "'.$class_id.'" AND sc.student_id = "'.$student_id.'" ');
			if ($query->num_rows() > 0) return TRUE;
		}
		return FALSE;
	}

	/**
	 * insert into student_class table if not dubilicated
	 *
	 * @param	class_id, student_id
	 * @return	bool
	 */
	function assign_student_to_class($class_id, $student_id) {
		if($this->session->userdata('session_id')) {
			if(!$this->apis->check_student_class_exist($class_id, $student_id)) {
				$query = $this->db->query('INSERT INTO student_class (student_id, class_id) VALUES ("'.$student_id.'", "'.$class_id.'")');
				if ($this->db->affected_rows()){
					return TRUE;
				} else {
					return FALSE;
				}
			}
		}
		return FALSE;
	}

	/**
	 * insert into expense table new record
	 *
	 * @param	$exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $exp_remark
	 * @return	bool
	 */
	function create_new_expense_record($exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $exp_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO expense (exp_type, exp_name, exp_sign_name, exp_date, exp_amount, created, modified, exp_remark) VALUES ("'.$exp_type.'", "'.$exp_name.'", "'.$exp_sign_name.'", "'.$exp_date.'", "'.$exp_amount.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$exp_remark.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * update expense record by given exp_id
	 *
	 * @param	$exp_id, $exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $exp_remark
	 * @return	bool
	 */
	function update_expense_record($exp_id, $exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $exp_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE expense SET exp_type = "'.$exp_type.'", exp_name = "'.$exp_name.'", exp_sign_name = "'.$exp_sign_name.'", exp_date = "'.$exp_date.'", exp_amount = "'.$exp_amount.'", exp_remark = "'.$exp_remark.'", modified = "'.date('Y-m-d H:i:s').'" WHERE exp_id = "'.$exp_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get expense record from expense table, by given exp_id
	 *
	 * @param	$exp_id
	 * @return	array or null
	 */
	function get_expense_record_by_id($exp_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM expense e WHERE e.exp_id = "'.$exp_id.'"');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;	
	}

	/**
	 * search expense records by multiple variables
	 *
	 * @param	$exp_type, $exp_name, $exp_sign_name, $exp_date_from, $exp_date_to
	 * @return	array or null
	 */
	function search_expense_by_multiple_var($exp_type, $exp_name, $exp_sign_name, $exp_date_from, $exp_date_to) {
		if($this->session->userdata('session_id')) {
			if($exp_type == 'NA') { 
				$query1 = $this->db->query('SELECT *  FROM expense e WHERE (e.exp_name LIKE "%'.$exp_name.'%") AND (e.exp_sign_name LIKE "%'.$exp_sign_name.'%") AND (DATE(e.exp_date) BETWEEN "'.$exp_date_from.'" AND "'.$exp_date_to.'") ORDER BY -DATE(e.exp_date)');
				if ($query1->num_rows() > 0) return $query1->result_array();
			}
			else {
				$query2 = $this->db->query('SELECT *  FROM expense e WHERE (e.exp_name LIKE "%'.$exp_name.'%") AND (e.exp_type = "'.$exp_type.'") AND (e.exp_sign_name LIKE "%'.$exp_sign_name.'%") AND (DATE(e.exp_date) BETWEEN "'.$exp_date_from.'" AND "'.$exp_date_to.'") ORDER BY -DATE(e.exp_date)');
				if ($query2->num_rows() > 0) return $query2->result_array();	
			}
			return NULL;
		}
	}

	/**
	 *  insert new data into receipt table
	 *
	 * @param	$student_ic, $receipt_no, $payee_name, $receipt_date, $receipt_amount, $makeup, $student_before, $course_type, $letter_type, $reg_no, $related_receipt, $related_receipt_amount, $receipt_remark
	 * @return	bool
	 */
	function create_new_receipt_record($student_ic, $receipt_no, $payee_name, $receipt_date, $receipt_amount, $makeup, $student_before, $course_type, $letter_type, $reg_no, $receipt_branch_id, $receipt_op_id, $receipt_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO receipt (student_ic, receipt_no, payee_name, receipt_date, receipt_amount, makeup, student_before, course_type, letter_type, reg_no, receipt_branch_id, receipt_op_id, created, modified, receipt_remark) VALUES ("'.$student_ic.'", "'.$receipt_no.'", "'.$payee_name.'", "'.$receipt_date.'", "'.$receipt_amount.'", "'.$makeup.'", "'.$student_before.'", "'.$course_type.'", "'.$letter_type.'", "'.$reg_no.'", "'.$receipt_branch_id.'", "'.$receipt_op_id.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$receipt_remark.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 *  ger receipt record from receipt table, given receipt_no
	 *
	 * @param	$receipt_no
	 * @return	array or null
	 */
	function get_receipt_by_receipt_no($receipt_no) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM receipt r WHERE r.receipt_no = "'.$receipt_no.'"');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search receipt records by multiple variables
	 *
	 * @param	$student_ic, $receipt_no, $receipt_branch, $course_type, $receipt_date_from, $receipt_date_to
	 * @return	array or null
	 */
	function search_receipt_by_multiple_var($student_ic, $receipt_no, $receipt_branch, $course_type, $receipt_date_from, $receipt_date_to) {
		if($this->session->userdata('session_id')) {
			if($course_type == 'ALL') { $course_type = "";}
			if($receipt_branch == 'ALL') {	
				$query1 = $this->db->query('SELECT *  FROM receipt r, branch b WHERE (b.id = r.receipt_branch_id) AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") ORDER BY -DATE(r.receipt_date)');
				if ($query1->num_rows() > 0) return $query1->result_array();
			} else {
				$query2 = $this->db->query('SELECT *  FROM receipt r, branch b WHERE (b.id = r.receipt_branch_id) AND (r.receipt_branch_id = "'.$receipt_branch.'") AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") ORDER BY -DATE(r.receipt_date)');
				if ($query2->num_rows() > 0) return $query2->result_array();
			}
		}
		return NULL;
	}

	/**
	 * get receipt record from receipt table by ID
	 *
	 * @param	$receipt_id
	 * @return	array or null
	 */
	function get_receipt_record_by_id($receipt_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM receipt r WHERE r.receipt_id = "'.$receipt_id.'"');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;	
	}

	/**
	 * update receipt record
	 *
	 * @param	$receipt_id, $student_ic, $receipt_no, $payee_name, $receipt_date, $receipt_amount, $makeup, $student_before, $course_type, $letter_type, $reg_no, $related_receipt, $related_receipt_amount, $receipt_branch_id, $receipt_op_id, $receipt_remark
	 * @return	bool
	 */
	function update_receipt_record($receipt_id, $student_ic, $receipt_no, $payee_name, $receipt_date, $receipt_amount, $makeup, $student_before, $course_type, $letter_type, $reg_no, $receipt_branch_id, $receipt_op_id, $receipt_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE receipt SET student_ic = "'.$student_ic.'", receipt_no = "'.$receipt_no.'", payee_name = "'.$payee_name.'", receipt_date = "'.$receipt_date.'", receipt_amount = "'.$receipt_amount.'", makeup = "'.$makeup.'", student_before = "'.$student_before.'", course_type = "'.$course_type.'", letter_type = "'.$letter_type.'", reg_no = "'.$reg_no.'", receipt_branch_id = "'.$receipt_branch_id.'", receipt_op_id = "'.$receipt_op_id.'", receipt_remark = "'.$receipt_remark.'", modified = "'.date('Y-m-d H:i:s').'" WHERE receipt_id = "'.$receipt_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get classes from class, student_class and branch table by student IC
	 *
	 * @param	$ic
	 * @return	array or null
	 */
	function get_all_class_by_student_ic($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM class c, student_class sc, branch b WHERE (c.class_id = sc.class_id) AND (sc.student_id = (SELECT id FROM student s WHERE s.ic = "'.$ic.'")) AND (c.branch_id = b.id) ORDER BY c.created');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}
}