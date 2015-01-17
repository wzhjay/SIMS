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
	 * get current admin
	 *
	 * @param	user if
	 * @return	array
	 */
	function get_current_admin($userid) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM users u, admin_users au, admin_role ar, branch b WHERE (u.id = "'.$userid.'") AND (u.id = au.user_id) AND (au.role_id = ar.id) AND (au.branch_id = b.id)');
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
			$query = $this->db->query('DELETE FROM users WHERE id = "'.$user_id.'"');
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
	function create_new_registration($ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO registration (ic, reg_date, student_branch_id, reg_branch_id, reg_op_id, reg_no, reg_remark, any_am, any_pm, any_eve, sat_am, sat_pm, sat_eve, sun_am, sun_pm, sun_eve, anytime, created, modified) VALUES ("'.$ic.'", "'.$reg_date.'", "'.$student_branch_id.'", "'.$reg_branch_id.'", "'.$reg_op_id.'", "'.$reg_no.'", "'.$reg_remark.'", "'.$any_am.'", "'.$any_pm.'", "'.$any_eve.'", "'.$sat_am.'", "'.$sat_pm.'", "'.$sat_eve.'", "'.$sun_am.'", "'.$sun_pm.'", "'.$sun_eve.'", "'.$anytime.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
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
	function update_registration($reg_id, $ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $reg_remark, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE registration SET ic = "'.$ic.'", reg_date = "'.$reg_date.'", student_branch_id = "'.$student_branch_id.'", reg_branch_id = "'.$reg_branch_id.'", reg_op_id = "'.$reg_op_id.'", reg_no = "'.$reg_no.'", reg_remark = "'.$reg_remark.'", any_am = "'.$any_am.'", any_pm = "'.$any_pm.'", any_eve = "'.$any_eve.'", sat_am = "'.$sat_am.'", sat_pm = "'.$sat_pm.'", sat_eve = "'.$sat_eve.'", sun_am = "'.$sun_am.'", sun_pm = "'.$sun_pm.'", sun_eve = "'.$sun_eve.'", anytime = "'.$anytime.'", modified = "'.date('Y-m-d H:i:s').'" WHERE reg_id = "'.$reg_id.'"');
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
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT * FROM registration r WHERE r.ic = "'.$ic.'"');	
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT * FROM registration r WHERE r.ic = "'.$ic.'" AND (r.student_branch_id = "'.$op_branch_id.'")');
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get registration info from regstration table where reg_id equals to given reg_id
	 *
	 * @param	reg_id
	 * @return	array or NULL
	 */
	function get_registration_by_id($reg_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM registration WHERE reg_id = "'.$reg_id.'"');
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
			$query_partial = "";
			if($any_am == "0" && $any_pm == "0" && $any_eve == "0" && $sat_am == "0" && $sat_pm == "0" && $sat_eve == "0" && $sun_am == "0" && $sun_pm == "0" && $sun_eve == "0" && $anytime == "0") {
				$query_partial.="1";
			}
			else {
				$query_partial.= "0 ";
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
			}
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT r.reg_id, r.ic, r.reg_date, r.reg_no, b1.name AS reg_branch, b2.name AS assigned_branch, r.reg_remark, u.username, r.created, r.modified, r.any_am, r.any_pm, r.any_eve, r.sat_am, r.sat_pm, r.sat_eve, r.sun_am, r.sun_pm, r.sun_eve, r.anytime  FROM registration r, branch b1, branch b2, users u WHERE (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (r.reg_branch_id = b1.id) AND (r.student_branch_id = b2.id) AND (r.reg_op_id = u.id) AND ('.$query_partial.') ORDER BY -DATE(r.reg_date) LIMIT 100');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT r.reg_id, r.ic, r.reg_date, r.reg_no, b1.name AS reg_branch, b2.name AS assigned_branch, r.reg_remark, u.username, r.created, r.modified, r.any_am, r.any_pm, r.any_eve, r.sat_am, r.sat_pm, r.sat_eve, r.sun_am, r.sun_pm, r.sun_eve, r.anytime  FROM registration r, branch b1, branch b2, users u WHERE (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (r.reg_branch_id = b1.id) AND (r.student_branch_id = b2.id) AND (r.reg_op_id = u.id) AND ('.$query_partial.') AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search registration info by setting time range for download
	 *
	 * @param	from, to
	 * @return	array or NULL
	 */
	function search_reg_info_download($from, $to, $any_am, $any_pm, $any_eve, $sat_am, $sat_pm, $sat_eve, $sun_am, $sun_pm, $sun_eve, $anytime) {
		if($this->session->userdata('session_id')) {
			$query_partial = "";
			if($any_am == "0" && $any_pm == "0" && $any_eve == "0" && $sat_am == "0" && $sat_pm == "0" && $sat_eve == "0" && $sun_am == "0" && $sun_pm == "0" && $sun_eve == "0" && $anytime == "0") {
				$query_partial.="1";
			}
			else {
				$query_partial.= "0 ";
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
			}
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT r.ic, DATE_FORMAT(r.reg_date,"%d/%m/%Y"), r.reg_no, b.name, r.reg_remark FROM registration r, branch b WHERE (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (r.student_branch_id = b.id) AND ('.$query_partial.') ORDER BY -DATE(r.reg_date)');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT r.ic, DATE_FORMAT(r.reg_date,"%d/%m/%Y"), r.reg_no, b.name, r.reg_remark FROM registration r, branch b WHERE (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (r.student_branch_id = b.id) AND ('.$query_partial.') AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * delete registration info by given reg_id
	 *
	 * @param	reg_id
	 * @return	bool
	 */
	function delete_reg_info($reg_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM registration WHERE reg_id = "'.$reg_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
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
	 * delete student info from student table
	 *
	 * @param	student_id
	 * @return	bool
	 */
	function delete_student_info_by_id($student_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM student WHERE student_id = "'.$student_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * insert info to ato table
	 *
	 * @param	$ic, $pre_post, $recommend_level, $class_start_date,  $class_end_date, $class_code, $attendance, $el, $er, $en, $es, $ew, $exam_location, $exam_date, $exam_time, $remark
	 * @return	bool
	 * @rules   same IC with PRE type, if exist same booking info (same module) in 7 days backward and forward period, create new ATO failed.
	 */
	function create_new_ato($ic, $pre_post, $class_code, $attendance, $post_change_date, $el, $er, $en, $es, $ew, $exam_location, $exam_date, $exam_time, $ato_branch_id, $ato_op_id, $remark) {
		if($this->session->userdata('session_id')) {
			$query1 = $this->db->query('SELECT * FROM ato WHERE ic = "'.$ic.'" AND ((el = "YES" AND el = "'.$el.'") OR (er = "YES" AND er = "'.$er.'") OR (en = "YES" AND en = "'.$en.'") OR (es = "YES" AND es = "'.$es.'") OR (ew = "YES" AND ew = "'.$ew.'")) AND pre_post = "PRE" AND (("'.$exam_date.'" < exam_date AND DATE_ADD("'.$exam_date.'", INTERVAL 7 DAY) >= exam_date) OR ("'.$exam_date.'" >= exam_date AND DATE_ADD(exam_date, INTERVAL 7 DAY) >= "'.$exam_date.'"))');
			if ($query1->num_rows() > 0) {
				return FALSE;
			} else {
				$query = $this->db->query('INSERT INTO ato (ic, pre_post, class_code, attendance, post_change_date, el, er, en, es, ew, exam_location, exam_date, exam_time, branch_id, branch_op_id, ato_created, ato_modified, ato_remark) VALUES ("'.$ic.'", "'.$pre_post.'", "'.$class_code.'", "'.$attendance.'", "'.$post_change_date.'", "'.$el.'", "'.$er.'", "'.$en.'", "'.$es.'", "'.$ew.'", "'.$exam_location.'", "'.$exam_date.'", "'.$exam_time.'", "'.$ato_branch_id.'", "'.$ato_op_id.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$remark.'")');
				if ($this->db->affected_rows()) return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * update ato table
	 *
	 * @param	$ic, $pre_post, $recommend_level, $class_start_date,  $class_end_date, $class_code, $attendance, $el, $er, $en, $es, $ew, $exam_location, $exam_date, $exam_time, $remark
	 * @return	bool where ato.id = get id by ic
	 */
	function update_ato($id, $pre_post, $class_code, $attendance, $post_change_date, $el, $er, $en, $es, $ew, $exam_location, $exam_date, $exam_time, $ato_branch_id, $ato_op_id, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE ato SET pre_post = "'.$pre_post.'", class_code = "'.$class_code.'", attendance = "'.$attendance.'", post_change_date = "'.$post_change_date.'", el = "'.$el.'", er = "'.$er.'", en = "'.$en.'", es = "'.$es.'", ew = "'.$ew.'", exam_location = "'.$exam_location.'", exam_date = "'.$exam_date.'", exam_time = "'.$exam_time.'", branch_id = "'.$ato_branch_id.'", branch_op_id = "'.$ato_op_id.'", ato_modified = "'.date('Y-m-d H:i:s').'", ato_remark = "'.$remark.'" WHERE id = "'.$id.'"');
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
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT * FROM ato a, student s WHERE a.ic = "'.$ic.'" AND a.ic = s.ic');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT * FROM ato a, student s WHERE a.ic = "'.$ic.'" AND (branch_id = "'.$op_branch_id.'" AND a.ic = s.ic)');
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get ato info by ic 
	 *
	 * @param	$ic
	 * @return	array or NULL
	 */
	function get_student_atos_by_ic_download($ic) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT ic, pre_post, class_code, attendance, DATE_FORMAT(post_change_date,"%d/%m/%Y"), el, er, en, es, ew, exam_location, DATE_FORMAT(exam_date,"%d/%m/%Y"), exam_time, ato_remark FROM ato WHERE ic = "'.$ic.'"');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT ic, pre_post, class_code, attendance, DATE_FORMAT(post_change_date,"%d/%m/%Y"), el, er, en, es, ew, exam_location, DATE_FORMAT(exam_date,"%d/%m/%Y"), exam_time, ato_remark FROM ato WHERE ic = "'.$ic.'" AND (branch_id = "'.$op_branch_id.'")');
			}
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
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT * FROM student s, registration r WHERE (s.ic = "'.$ic.'") AND (s.ic = r.ic)');	
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT * FROM student s, registration r WHERE (s.ic = "'.$ic.'") AND (s.ic = r.ic) AND (r.student_branch_id = "'.$op_branch_id.'")');
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get student records from student_records table, by given ic number
	 *
	 * @param	ic
	 * @return	array or NULL
	 */
	function get_student_records_by_ic($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM student_records WHERE student_ic = "'.$ic.'" ORDER BY exam_date');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get student records from student_records table, by given ic number
	 *
	 * @param	ic
	 * @return	array or NULL
	 */
	function get_student_records_by_ic_download($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT sr.student_ic, DATE_FORMAT(sr.exam_date,"%d/%m/%Y"), sr.el_best, sr.er_best, sr.en_best, sr.es_best, sr.ew_best, sr.wpn, sr.con, sr.wri, sr.wpn, sr.exam_remark FROM student_records sr WHERE sr.student_ic = "'.$ic.'" ORDER BY sr.exam_date');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * create new student records, insert into student_records table
	 * @param	$ic, $exam_date, $er, $el, $es, $ew, $en, $cmp, $con, $wri, $wpn, $branch_id, $branch_op_id, $remark
	 * @return	bool
	 */
	function create_new_student_exam_record($ic, $exam_date, $er, $el, $es, $ew, $en, $cmp, $con, $wri, $wpn, $branch_id, $branch_op_id, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO student_records (student_ic, exam_date, el_best, er_best,  en_best, es_best, ew_best, cmp, con, wri, wpn, branch_id, branch_op_id, exam_created, exam_modified, exam_remark) VALUES ("'.$ic.'", "'.$exam_date.'", "'.$el.'", "'.$er.'", "'.$en.'", "'.$es.'", "'.$ew.'", "'.$cmp.'", "'.$con.'", "'.$wri.'", "'.$wpn.'", "'.$branch_id.'", "'.$branch_op_id.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$remark.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * update record table
	 *
	 * @param	$id, $exam_date, $er, $el, $es, $ew, $en, $cmp, $con, $wri, $wpn, $branch_id, $branch_op_id, $remark
	 * @return	bool where student_records.id = given id
	 */
	function update_student_exam_record($id, $exam_date, $er, $el, $es, $ew, $en, $cmp, $con, $wri, $wpn, $branch_id, $branch_op_id, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE student_records SET exam_date = "'.$exam_date.'", er_best = "'.$er.'", el_best = "'.$el.'", es_best = "'.$es.'", ew_best = "'.$ew.'", en_best = "'.$en.'", cmp = "'.$cmp.'", con = "'.$con.'", wri = "'.$wri.'", wpn = "'.$wpn.'", branch_id = "'.$branch_id.'", branch_op_id = "'.$branch_op_id.'", exam_modified = "'.date('Y-m-d H:i:s').'", exam_remark = "'.$remark.'" WHERE id = "'.$id.'"');
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
			$query = $this->db->query('SELECT * FROM student_records WHERE id = "'.$id.'"');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * delete exam record by given id
	 *
	 * @param	id
	 * @return	bool
	 */
	function delete_exam_record_by_id($id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM student_records WHERE id = "'.$id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * search exam record by exam time
	 *
	 * @param	from, to
	 * @return	array
	 */
	function search_exams_by_time($from, $to) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT DISTINCT * FROM student_records a, student s WHERE (a.student_ic = s.ic) AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") ORDER BY -DATE(a.exam_date) LIMIT 100');
				if ($query->num_rows() > 0) return $query->result_array();
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT DISTINCT * FROM student_records a, student s WHERE (a.student_ic = s.ic) AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(a.exam_date) LIMIT 100');
				if ($query->num_rows() > 0) return $query->result_array();
			}
		}
		return NULL;	
	}

	/**
	 * search ato info by time for download
	 *
	 * @param	from, to, $class_code, location, slot
	 * @return	array or NULL
	 */
	function search_exams_by_time_download($from, $to) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
					$query = $this->db->query('SELECT DISTINCT a.student_ic, s.lastname, s.firstname, s.othername, DATE_FORMAT(a.exam_date,"%d/%m/%Y"), a.el_best, a.er_best, a.en_best, a.es_best, a.ew_best, a.cmp, a.con, a.wri, a.wpn, a.exam_remark FROM student_records a, student s WHERE (a.student_ic = s.ic) AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") ORDER BY -DATE(a.exam_date)');
					if ($query->num_rows() > 0) return $query->result_array();
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT DISTINCT a.student_ic, s.lastname, s.firstname, s.othername, DATE_FORMAT(a.exam_date,"%d/%m/%Y"), a.el_best, a.er_best, a.en_best, a.es_best, a.ew_best, a.cmp, a.con, a.wri, a.wpn, a.exam_remark FROM student_records a, student s WHERE (a.student_ic = s.ic) AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (a.branch_id = "'.$op_branch_id.'") ORDER BY -DATE(a.exam_date)');
				if ($query->num_rows() > 0) return $query->result_array();
			}
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
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT *  FROM registration r, student s WHERE (r.ic = s.ic) AND (s.ic = "'.$ic.'") ORDER BY -DATE(r.reg_date)');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT *  FROM registration r, student s WHERE (r.ic = s.ic) AND (s.ic = "'.$ic.'") AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
			}
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
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT *  FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND ((s.ic LIKE "%'.$keyword.'%") OR (s.firstname LIKE "%'.$keyword.'%") OR (s.lastname LIKE "%'.$keyword.'%") OR (s.tel LIKE "%'.$keyword.'%")) ORDER BY -DATE(r.reg_date) LIMIT 100');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT *  FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND ((s.ic LIKE "%'.$keyword.'%") OR (s.firstname LIKE "%'.$keyword.'%") OR (s.lastname LIKE "%'.$keyword.'%") OR (s.tel LIKE "%'.$keyword.'%")) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search students by keyword in ic number/firstname/lastname, from table registration, student for download
	 *
	 * @param	key word 
	 * @return	array or NULL
	 */
	function search_single_students_by_keyword_download($keyword) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (s.ic = "'.$keyword.'") ORDER BY -DATE(r.reg_date)');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (s.ic = "'.$keyword.'") AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search students by keyword in ic number/firstname/lastname, from table registration, student for download
	 *
	 * @param	key word 
	 * @return	array or NULL
	 */
	function search_students_by_keyword_download($keyword) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND ((s.ic LIKE "%'.$keyword.'%") OR (s.firstname LIKE "%'.$keyword.'%") OR (s.lastname LIKE "%'.$keyword.'%") OR (s.tel LIKE "%'.$keyword.'%")) ORDER BY -DATE(r.reg_date)');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND ((s.ic LIKE "%'.$keyword.'%") OR (s.firstname LIKE "%'.$keyword.'%") OR (s.lastname LIKE "%'.$keyword.'%") OR (s.tel LIKE "%'.$keyword.'%")) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search students by keyword in ic number/firstname/lastname, from table registration, student, student_records
	 *
	 * @param	$course_type, $level, $slot
	 * @return	array or NULL
	 */
	function search_class_students_by_multiple_var($course_type, $level, $slot, $from, $to, $have_class) {
		if($this->session->userdata('session_id')) {
			if(trim($from, " ") == "") {
				$from = "0000-00-00";
			}
			if(trim($to, " ") == "") {
				$to = "2100-01-01";
			}

			if($this->apis->check_user_role() == 'admin') {
				if($have_class == "YES") {
					if($course_type != "NA" && $level != "NA") {
						if($slot != "NA") {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b, student_records sr WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (s.ic = sr.student_ic) AND (sr.'.$course_type.'="'.$level.'") AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date) LIMIT 100');
						} else {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b, student_records sr WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (s.ic = sr.student_ic) AND (sr.'.$course_type.'="'.$level.'") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date) LIMIT 100');
						}
					} else {
						if($slot != "NA") {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date) LIMIT 100');
						} else {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date) LIMIT 100');
						}
					}
				} else {
					if($course_type != "NA" && $level != "NA") {
						if($slot != "NA") {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b, student_records sr WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (s.ic = sr.student_ic) AND (sr.'.$course_type.'="'.$level.'") AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date) LIMIT 100');
						} else {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b, student_records sr WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (s.ic = sr.student_ic) AND (sr.'.$course_type.'="'.$level.'") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date) LIMIT 100');
						}
					} else {
						if($slot != "NA") {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date) LIMIT 100');
						} else {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date) LIMIT 100');
						}
					}
				}
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				if($have_class == "YES") {
					if($course_type != "NA" && $level != "NA") {
						if($slot != "NA") {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b, student_records sr WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (s.ic = sr.student_ic) AND (sr.'.$course_type.'="'.$level.'") AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
						} else {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b, student_records sr WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (s.ic = sr.student_ic) AND (sr.'.$course_type.'="'.$level.'") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
						}
					} else {
						if($slot != "NA") {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
						} else {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
						}
					}
				} else {
					if($course_type != "NA" && $level != "NA") {
						if($slot != "NA") {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b, student_records sr WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
						} else {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b, student_records sr WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
						}
					} else {
						if($slot != "NA") {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
						} else {
							$query = $this->db->query('SELECT * FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date) LIMIT 100');
						}
					}
				}
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search students by keyword in ic number/firstname/lastname, from table registration, student, student_records, branch, for downloading format
	 *
	 * @param	$course_type, $level, $slot
	 * @return	array or NULL
	 */
	function search_class_students_by_multiple_var_download($course_type, $level, $slot, $from, $to, $have_class) {
		if($this->session->userdata('session_id')) {
			if(trim($from, " ") == "") {
				$from = "0000-00-00";
			}
			if(trim($to, " ") == "") {
				$to = "2100-01-01";
			}

			if($this->apis->check_user_role() == 'admin') {
				if($have_class == "YES") {
					if($course_type != "NA" && $level != "NA") {
						if($slot != "NA") {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date)');
						} else {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date)');
						}
					} else {
						if($slot != "NA") {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date)');
						} else {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date)');
						}
					}
				} else {
					if($course_type != "NA" && $level != "NA") {
						if($slot != "NA") {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date)');
						} else {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date)');
						}
					} else {
						if($slot != "NA") {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date)');
						} else {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, branch b WHERE (r.ic = s.ic) AND (r.student_branch_id = b.id) AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) ORDER BY -DATE(r.reg_date)');
						}
					}
				}
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				if($have_class == "YES") {
					if($course_type != "NA" && $level != "NA") {
						if($slot != "NA") {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, student_records sr, branch b WHERE (r.ic = s.ic) AND (s.ic = sr.student_ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
						} else {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, student_records sr, branch b WHERE (r.ic = s.ic) AND (s.ic = sr.student_ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
						}
					} else {
						if($slot != "NA") {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, student_records sr, branch b WHERE (r.ic = s.ic) AND (s.ic = sr.student_ic) AND (r.student_branch_id = b.id) AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
						} else {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, student_records sr, branch b WHERE (r.ic = s.ic) AND (s.ic = sr.student_ic) AND (r.student_branch_id = b.id) AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
						}
					}
				} else {
					if($course_type != "NA" && $level != "NA") {
						if($slot != "NA") {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, student_records sr, branch b WHERE (r.ic = s.ic) AND (s.ic = sr.student_ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
						} else {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, student_records sr, branch b WHERE (r.ic = s.ic) AND (s.ic = sr.student_ic) AND (r.student_branch_id = b.id) AND (sr.'.$course_type.'="'.$level.'") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
						}
					} else {
						if($slot != "NA") {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, student_records sr, branch b WHERE (r.ic = s.ic) AND (s.ic = sr.student_ic) AND (r.student_branch_id = b.id) AND (r.'.$slot.' = "1") AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
						} else {
							$query = $this->db->query('SELECT s.source, r.reg_no, s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM registration r, student s, student_records sr, branch b WHERE (r.ic = s.ic) AND (s.ic = sr.student_ic) AND (r.student_branch_id = b.id) AND (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (s.student_id NOT IN (SELECT sc2.student_id FROM student_class sc2)) AND (r.student_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.reg_date)');
						}
					}
				}
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * search ato info by time
	 *
	 * @param	from, to, $class_code
	 * @return	array or NULL
	 */
	function search_atos_by_time($from, $to, $class_code) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				if($class_code == "") {
					// search ato info by time only (pre), if post ato change date, this ato also can be found
					$query = $this->db->query('SELECT DISTINCT * FROM ato a, student s WHERE (a.ic = s.ic) AND ((a.pre_post = "PRE") OR ((a.pre_post = "POST") AND (a.post_change_date = "YES"))) AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") GROUP BY a.id ORDER BY -DATE(a.exam_date) LIMIT 100');
					if ($query->num_rows() > 0) return $query->result_array();
				} else {
					// search ato info by time and class (post), info post ato change date, this ato also cannot be found
					$query = $this->db->query('SELECT DISTINCT * FROM ato a, student s, class c, student_class sc WHERE (a.ic = s.ic) AND (c.code = "'.$class_code.'") AND (c.class_id = sc.class_id) AND (sc.student_id = s.student_id) AND (a.pre_post = "POST") AND (a.post_change_date = "NO") AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") ORDER BY -DATE(a.exam_date) LIMIT 100');
					if ($query->num_rows() > 0) return $query->result_array();
				}
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				if($class_code == "") {
					// search ato info by time only (pre), if post ato change date, this ato also can be found
					$query = $this->db->query('SELECT DISTINCT * FROM ato a, student s WHERE (a.ic = s.ic) AND ((a.pre_post = "PRE") OR ((a.pre_post = "POST") AND (a.post_change_date = "YES"))) AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (a.branch_id = "'.$op_branch_id.'") GROUP BY a.id ORDER BY -DATE(a.exam_date) LIMIT 100');
					if ($query->num_rows() > 0) return $query->result_array();
				} else {
					// search ato info by time and class (post), info post ato change date, this ato also cannot be found
					$query = $this->db->query('SELECT DISTINCT * FROM ato a, student s, class c, student_class sc WHERE (a.ic = s.ic) AND (c.code = "'.$class_code.'") AND (c.class_id = sc.class_id) AND (sc.student_id = s.student_id) AND (a.pre_post = "POST") AND (a.post_change_date = "NO") AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (a.branch_id = "'.$op_branch_id.'") ORDER BY -DATE(a.exam_date) LIMIT 100');
					if ($query->num_rows() > 0) return $query->result_array();
				}
			}
		}
		return NULL;	
	}

	/**
	 * search ato info by time for download
	 *
	 * @param	from, to, $class_code, location, slot
	 * @return	array or NULL
	 */
	function search_atos_by_time_download($from, $to, $class_code, $location, $slot) {
		if($this->session->userdata('session_id')) {
			$email = $this->apis->get_admin_user_email();
			if($this->apis->check_user_role() == 'admin') {
				if($class_code == "") {
					// search ato info by time only (pre), if post ato change date, this ato also can be found
					$query = $this->db->query('SELECT DISTINCT a.exam_date, a.pre_post, "x", "xx", "xxx", "Etest Training", a.attendance, "N", "Waiting for the result", "198400164G", SUBSTRING(a.el, 1, 1) , SUBSTRING(a.er, 1, 1) , SUBSTRING(a.en, 1, 1) , SUBSTRING(a.es, 1, 1) , SUBSTRING(a.ew, 1, 1) , s.salutation, s.ic_type, s.ic, "00/00/0000",s.lastname, s.firstname, s.othername, s.gender, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, UCASE(SUBSTRING(s.lang, 1, 3)), s.block, s.street, s.floor_unit_no, s.building, s.postcode, s.tel, "test@changchun.edu.sg", s.emp_status, s.company_type, s.company_name, s.company_reg_no, s.industry, s.designation, s.salary_range FROM ato a, student s WHERE (a.ic = s.ic) AND ((a.pre_post = "PRE") OR ((a.pre_post = "POST") AND (a.post_change_date = "YES"))) AND (a.exam_location = "'.$location.'") AND (a.exam_time = "'.$slot.'") AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") GROUP BY a.id ORDER BY -DATE(a.exam_date)');
					if ($query->num_rows() > 0) return $query->result_array();
				} else {
					// search ato info by time and class (post), info post ato change date, this ato also cannot be found
					$query = $this->db->query('SELECT DISTINCT a.exam_date, a.pre_post, c.code, DATE_FORMAT(c.start_date,"%d/%m/%Y"), DATE_FORMAT(c.end_date,"%d/%m/%Y"), c.type, a.attendance, "N", c.level, "198400164G", SUBSTRING(a.el, 1, 1), SUBSTRING(a.er, 1, 1), SUBSTRING(a.en, 1, 1), SUBSTRING(a.es, 1, 1), SUBSTRING(a.ew, 1, 1), s.salutation, s.ic_type, s.ic, "00/00/0000",s.lastname, s.firstname, s.othername, s.gender, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, UCASE(SUBSTRING(s.lang, 1, 3)), s.block, s.street, s.floor_unit_no, s.building, s.postcode, s.tel, "test@changchun.edu.sg", s.emp_status, s.company_type, s.company_name, s.company_reg_no, s.industry, s.designation, s.salary_range FROM ato a, student s, class c, student_class sc WHERE (a.ic = s.ic) AND (c.code = "'.$class_code.'") AND (c.class_id = sc.class_id) AND (sc.student_id = s.student_id) AND (a.pre_post = "POST") AND (a.post_change_date = "No") AND (a.exam_location = "'.$location.'") AND (a.exam_time = "'.$slot.'") AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") ORDER BY -DATE(a.exam_date)');
					if ($query->num_rows() > 0) return $query->result_array();
				}
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				if($class_code == "") {
					// search ato info by time only (pre), if post ato change date, this ato also can be found
					$query = $this->db->query('SELECT DISTINCT a.exam_date, a.pre_post, "x", "xx", "xxx", "Etest Training", a.attendance, "N", "Waiting for the result", "198400164G", SUBSTRING(a.el, 1, 1), SUBSTRING(a.er, 1, 1), SUBSTRING(a.en, 1, 1), SUBSTRING(a.es, 1, 1), SUBSTRING(a.ew, 1, 1), s.salutation, s.ic_type, s.ic, "00/00/0000",s.lastname, s.firstname, s.othername, s.gender, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, UCASE(SUBSTRING(s.lang, 1, 3)), s.block, s.street, s.floor_unit_no, s.building, s.postcode, s.tel, "'.$email.'", s.emp_status, s.company_type, s.company_name, s.company_reg_no, s.industry, s.designation, s.salary_range FROM ato a, student s WHERE (a.ic = s.ic) AND ((a.pre_post = "PRE") OR ((a.pre_post = "POST") AND (a.post_change_date = "YES"))) AND (a.exam_location = "'.$location.'") AND (a.exam_time = "'.$slot.'") AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (a.branch_id = "'.$op_branch_id.'") GROUP BY a.id ORDER BY -DATE(a.exam_date)');
					if ($query->num_rows() > 0) return $query->result_array();
				} else {
					// search ato info by time and class (post), info post ato change date, this ato also cannot be found
					$query = $this->db->query('SELECT DISTINCT a.exam_date, a.pre_post, c.code, DATE_FORMAT(c.start_date,"%d/%m/%Y"), DATE_FORMAT(c.end_date,"%d/%m/%Y"), c.type, a.attendance, "N", c.level, "198400164G", SUBSTRING(a.el, 1, 1), SUBSTRING(a.er, 1, 1), SUBSTRING(a.en, 1, 1), SUBSTRING(a.es, 1, 1), SUBSTRING(a.ew, 1, 1), s.salutation, s.ic_type, s.ic, "00/00/0000",s.lastname, s.firstname, s.othername, s.gender, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, UCASE(SUBSTRING(s.lang, 1, 3)), s.block, s.street, s.floor_unit_no, s.building, s.postcode, s.tel, "'.$email.'", s.emp_status, s.company_type, s.company_name, s.company_reg_no, s.industry, s.designation, s.salary_range FROM ato a, student s, class c, student_class sc WHERE (a.ic = s.ic) AND (c.code = "'.$class_code.'") AND (c.class_id = sc.class_id) AND (sc.student_id = s.student_id) AND (a.pre_post = "POST") AND (a.post_change_date = "NO") AND (a.exam_location = "'.$location.'") AND (a.exam_time = "'.$slot.'") AND (DATE(a.exam_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (a.branch_id = "'.$op_branch_id.'") ORDER BY -DATE(a.exam_date)');
					if ($query->num_rows() > 0) return $query->result_array();
				}
			}
		}
		return NULL;	
	}

	/**
	 * search ato info by ic for download
	 *
	 * @param	ic, location, slot
	 * @return	array or NULL
	 */
	function search_atos_by_ic_download($ic, $location, $slot) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				// search ato info by ic only (pre), if post ato change date, this ato also can be found
				$query = $this->db->query('SELECT DISTINCT a.pre_post, "x", "xx", "xxx", "Etest Training", a.attendance, "N", "Waiting for the result", "198400164G", SUBSTRING(a.el, 1, 1) , SUBSTRING(a.er, 1, 1) , SUBSTRING(a.en, 1, 1) , SUBSTRING(a.es, 1, 1) , SUBSTRING(a.ew, 1, 1) , s.salutation, s.ic_type, s.ic, "00/00/0000",s.lastname, s.firstname, s.othername, s.gender, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, UCASE(SUBSTRING(s.lang, 1, 3)), s.block, s.street, s.floor_unit_no, s.building, s.postcode, s.tel, "changchun@changchun.edu.sg", s.emp_status, s.company_type, s.company_name, s.company_reg_no, s.industry, s.designation, s.salary_range FROM ato a, student s WHERE (a.ic = s.ic) AND (a.ic = "'.$ic.'") AND (a.exam_location = "'.$location.'") AND (a.exam_time = "'.$slot.'") GROUP BY a.id ORDER BY -DATE(a.exam_date)');
				if ($query->num_rows() > 0) return $query->result_array();
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				// search ato info by time only (pre), if post ato change date, this ato also can be found
				$query = $this->db->query('SELECT DISTINCT a.pre_post, "x", "xx", "xxx", "Etest Training", a.attendance, "N", "Waiting for the result", "198400164G", SUBSTRING(a.el, 1, 1), SUBSTRING(a.er, 1, 1), SUBSTRING(a.en, 1, 1), SUBSTRING(a.es, 1, 1), SUBSTRING(a.ew, 1, 1), s.salutation, s.ic_type, s.ic, "00/00/0000",s.lastname, s.firstname, s.othername, s.gender, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, UCASE(SUBSTRING(s.lang, 1, 3)), s.block, s.street, s.floor_unit_no, s.building, s.postcode, s.tel, "changchun@changchun.edu.sg", s.emp_status, s.company_type, s.company_name, s.company_reg_no, s.industry, s.designation, s.salary_range FROM ato a, student s WHERE (a.ic = s.ic) AND (a.ic = "'.$ic.'") AND (a.exam_location = "'.$location.'") AND (a.exam_time = "'.$slot.'") AND (a.branch_id = "'.$op_branch_id.'") GROUP BY a.id ORDER BY -DATE(a.exam_date)');
				if ($query->num_rows() > 0) return $query->result_array();
			}
		}
		return NULL;	
	}

	/**
	 * delete ato info by given id
	 *
	 * @param	reg_id
	 * @return	bool
	 */
	function delete_ato_info($id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM ato WHERE id = "'.$id.'" AND ((pre_post = "POST") OR (pre_post = "PRE" AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) < exam_date))');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
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

			if($this->apis->check_user_role() == 'admin') {
				if($branch_id == 'ALL') {
					$query1 = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") ORDER BY -DATE(c.created) LIMIT 100');
					if ($query1->num_rows() > 0) return $query1->result_array();
				}
				else {
					$query2 = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.branch_id = "'.$branch_id.'") AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") ORDER BY -DATE(c.created) LIMIT 100');
					if ($query2->num_rows() > 0) return $query2->result_array();
				}
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				if($branch_id == 'ALL') {
					$query1 = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") AND (c.branch_id = "'.$op_branch_id.'") ORDER BY -DATE(c.created) LIMIT 100');
					if ($query1->num_rows() > 0) return $query1->result_array();
				}
				else {
					$query2 = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.branch_id = "'.$branch_id.'") AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") AND (c.branch_id = "'.$op_branch_id.'") ORDER BY -DATE(c.created) LIMIT 100');
					if ($query2->num_rows() > 0) return $query2->result_array();
				}
			}
		}
		return NULL;
	}

	/**
	 * search class info by moultiple var for downloading
	 *
	 * @param	$code, $type, $level, $status, $start_from, $start_to, $end_from, $end_to
	 * @return	array or NULL
	 */
	function search_class_by_multiple_var_download($code, $type, $level, $status, $branch_id, $start_from, $start_to, $end_from, $end_to) {
		if($this->session->userdata('session_id')) {
			if(trim($code, " ") == "") { $code = "";}
			if($type == 'NA') { $type = "";}
			if($level == 'NA') { $level = "";}
			if($status == 'NA') { $status = "";}

			if($this->apis->check_user_role() == 'admin') {
				if($branch_id == 'ALL') {
					$query1 = $this->db->query('SELECT c.code, c.class_name, c.type, c.level, DATE_FORMAT(c.start_date,"%d/%m/%Y"), DATE_FORMAT(c.end_date,"%d/%m/%Y"), c.start_time, c.end_time, c.teacher_name, c.teacher_tel, c.location, b.name, c.status, c.remark FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") ORDER BY -DATE(c.created)');
					if ($query1->num_rows() > 0) return $query1->result_array();
				}
				else {
					$query2 = $this->db->query('SELECT c.code, c.class_name, c.type, c.level, DATE_FORMAT(c.start_date,"%d/%m/%Y"), DATE_FORMAT(c.end_date,"%d/%m/%Y"), c.start_time, c.end_time, c.teacher_name, c.teacher_tel, c.location, b.name, c.status, c.remark FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.branch_id = "'.$branch_id.'") AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") ORDER BY -DATE(c.created)');
					if ($query2->num_rows() > 0) return $query2->result_array();
				}
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				if($branch_id == 'ALL') {
					$query1 = $this->db->query('SELECT c.code, c.class_name, c.type, c.level, DATE_FORMAT(c.start_date,"%d/%m/%Y"), DATE_FORMAT(c.end_date,"%d/%m/%Y"), c.start_time, c.end_time, c.teacher_name, c.teacher_tel, c.location, b.name, c.status, c.remark FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") AND (c.branch_id = "'.$op_branch_id.'") ORDER BY -DATE(c.created)');
					if ($query1->num_rows() > 0) return $query1->result_array();
				}
				else {
					$query2 = $this->db->query('SELECT c.code, c.class_name, c.type, c.level, DATE_FORMAT(c.start_date,"%d/%m/%Y"), DATE_FORMAT(c.end_date,"%d/%m/%Y"), c.start_time, c.end_time, c.teacher_name, c.teacher_tel, c.location, b.name, c.status, c.remark FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.branch_id = "'.$branch_id.'") AND (c.code LIKE "%'.$code.'%") AND (c.type LIKE "%'.$type.'%") AND (c.level LIKE "%'.$level.'%") AND (c.status LIKE "%'.$status.'%") AND (DATE(c.start_date) BETWEEN "'.$start_from.'" AND "'.$start_to.'") AND (DATE(c.end_date) BETWEEN "'.$end_from.'" AND "'.$end_to.'") AND (c.branch_id = "'.$op_branch_id.'") ORDER BY -DATE(c.created)');
					if ($query2->num_rows() > 0) return $query2->result_array();
				}
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
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.code = "'.$code.'") ORDER BY c.class_id');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) AND (c.code = "'.$code.'") AND (c.branch_id = "'.$op_branch_id.'") ORDER BY c.class_id');
			}
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
			$query = $this->db->query('SELECT *  FROM class c, branch b WHERE (c.branch_id = b.id) ORDER BY -c.created LIMIT 100');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * delete class info by provide id
	 *
	 * @param	class_id
	 * @return	bool
	 */
	function delete_class_info($id){
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM student_class WHERE class_id = "'.$id.'"');
			$query = $this->db->query('DELETE FROM class WHERE class_id = "'.$id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get all class students info from student table by given class_id
	 *
	 * @param	class_id
	 * @return	array or NULL
	 */
	function get_all_class_students_by_class_id($class_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM student s WHERE s.student_id IN (SELECT sc.student_id FROM student_class sc WHERE sc.class_id = "'.$class_id.'") ORDER BY s.othername');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;	
	}

	function get_all_class_students_by_class_id_to_excel($class_id) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT s.source, "A000000", s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM student s, branch b WHERE s.student_id IN (SELECT sc.student_id FROM student_class sc WHERE sc.class_id = "'.$class_id.'") AND (s.student_branch_id = b.id) ORDER BY s.othername');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT s.source, "A000000", s.ic, b.name, s.firstname, s.lastname, s.othername, s.tel, s.tel_home, s.gender, s.salutation, DATE_FORMAT(s.birthday,"%d/%m/%Y"), s.age, s.ic_type, s.citizenship, s.nationality, s.race, s.cn_level, s.edu_level, s.lang, s.gov_letter, s.emp_status, s.company_name, s.company_type, s.company_reg_no, s.industry, s.designation, s.salary_range, s.block, s.floor_unit_no, s.street, s.building, s.postcode, s.remark FROM student s, branch b WHERE s.student_id IN (SELECT sc.student_id FROM student_class sc WHERE sc.class_id = "'.$class_id.'") AND (s.student_branch_id = b.id) AND (s.student_branch_id = "'.$op_branch_id.'") ORDER BY s.othername');
			}
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
			return FALSE;
		}
		return FALSE;
	}

	/**
	 * delete record from student_class table
	 *
	 * @param	class_id, student_id
	 * @return	bool
	 */
	function delete_student_class_record($class_id, $student_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM student_class WHERE (student_id = "'.$student_id.'") AND (class_id = "'.$class_id.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}
	/**
	 * insert into expense table new record
	 *
	 * @param	$exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $exp_remark
	 * @return	bool
	 */
	function create_new_expense_record($exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $branch_id, $branch_op_id, $exp_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO expense (exp_type, exp_name, exp_sign_name, exp_date, exp_amount, created, modified, branch_id, branch_op_id, exp_remark) VALUES ("'.$exp_type.'", "'.$exp_name.'", "'.$exp_sign_name.'", "'.$exp_date.'", "'.$exp_amount.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$branch_id.'", "'.$branch_op_id.'", "'.$exp_remark.'")');
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
	function update_expense_record($exp_id, $exp_type, $exp_name, $exp_sign_name, $exp_date, $exp_amount, $branch_id, $branch_op_id, $exp_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE expense SET exp_type = "'.$exp_type.'", exp_name = "'.$exp_name.'", exp_sign_name = "'.$exp_sign_name.'", exp_date = "'.$exp_date.'", exp_amount = "'.$exp_amount.'", branch_id = "'.$branch_id.'", branch_op_id = "'.$branch_op_id.'", exp_remark = "'.$exp_remark.'", modified = "'.date('Y-m-d H:i:s').'" WHERE exp_id = "'.$exp_id.'"');
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
	 * delete expense record from expense table by ID
	 *
	 * @param	$expense_id
	 * @return	bool
	 */
	function delete_student_expense_record($expense_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM expense WHERE exp_id = "'.$expense_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * search expense records by multiple variables
	 *
	 * @param	$exp_type, $exp_name, $exp_sign_name, $exp_date_from, $exp_date_to
	 * @return	array or null
	 */
	function search_expense_by_multiple_var($exp_type, $exp_name, $exp_sign_name, $exp_date_from, $exp_date_to) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				if($exp_type == 'NA') { 
					$query1 = $this->db->query('SELECT *  FROM expense e WHERE (e.exp_name LIKE "%'.$exp_name.'%") AND (e.exp_sign_name LIKE "%'.$exp_sign_name.'%") AND (DATE(e.exp_date) BETWEEN "'.$exp_date_from.'" AND "'.$exp_date_to.'") ORDER BY -DATE(e.exp_date) LIMIT 100');
					if ($query1->num_rows() > 0) return $query1->result_array();
				}
				else {
					$query2 = $this->db->query('SELECT *  FROM expense e WHERE (e.exp_name LIKE "%'.$exp_name.'%") AND (e.exp_type = "'.$exp_type.'") AND (e.exp_sign_name LIKE "%'.$exp_sign_name.'%") AND (DATE(e.exp_date) BETWEEN "'.$exp_date_from.'" AND "'.$exp_date_to.'") ORDER BY -DATE(e.exp_date) LIMIT 100');
					if ($query2->num_rows() > 0) return $query2->result_array();	
				}
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				if($exp_type == 'NA') { 
					$query1 = $this->db->query('SELECT *  FROM expense e WHERE (e.exp_name LIKE "%'.$exp_name.'%") AND (e.exp_sign_name LIKE "%'.$exp_sign_name.'%") AND (DATE(e.exp_date) BETWEEN "'.$exp_date_from.'" AND "'.$exp_date_to.'") AND (e.branch_id = "'.$op_branch_id.'") ORDER BY -DATE(e.exp_date) LIMIT 100');
					if ($query1->num_rows() > 0) return $query1->result_array();
				}
				else {
					$query2 = $this->db->query('SELECT *  FROM expense e WHERE (e.exp_name LIKE "%'.$exp_name.'%") AND (e.exp_type = "'.$exp_type.'") AND (e.exp_sign_name LIKE "%'.$exp_sign_name.'%") AND (DATE(e.exp_date) BETWEEN "'.$exp_date_from.'" AND "'.$exp_date_to.'") AND (e.branch_id = "'.$op_branch_id.'") ORDER BY -DATE(e.exp_date) LIMIT 100');
					if ($query2->num_rows() > 0) return $query2->result_array();	
				}
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
	function create_new_receipt_record($student_ic, $receipt_type, $receipt_no, $payee_name, $receipt_date, $receipt_amount, $makeup, $student_before, $course_type, $letter_type, $reg_no, $receipt_branch_id, $receipt_op_id, $receipt_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO receipt (student_ic, receipt_type, receipt_no, payee_name, receipt_date, receipt_amount, makeup, student_before, course_type, letter_type, reg_no, receipt_branch_id, receipt_op_id, created, modified, receipt_remark) VALUES ("'.$student_ic.'", "'.$receipt_type.'", "'.$receipt_no.'", "'.$payee_name.'", "'.$receipt_date.'", "'.$receipt_amount.'", "'.$makeup.'", "'.$student_before.'", "'.$course_type.'", "'.$letter_type.'", "'.$reg_no.'", "'.$receipt_branch_id.'", "'.$receipt_op_id.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'", "'.$receipt_remark.'")');
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
			if($this->apis->check_user_role() == 'admin') {
				if($receipt_branch == 'ALL') {	
					$query1 = $this->db->query('SELECT *  FROM receipt r, branch b WHERE (b.id = r.receipt_branch_id) AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") ORDER BY -DATE(r.receipt_date) LIMIT 100');
					if ($query1->num_rows() > 0) return $query1->result_array();
				} else {
					$query2 = $this->db->query('SELECT *  FROM receipt r, branch b WHERE (b.id = r.receipt_branch_id) AND (r.receipt_branch_id = "'.$receipt_branch.'") AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") ORDER BY -DATE(r.receipt_date) LIMIT 100');
					if ($query2->num_rows() > 0) return $query2->result_array();
				}	
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				if($receipt_branch == 'ALL') {	
					$query1 = $this->db->query('SELECT *  FROM receipt r, branch b WHERE (b.id = r.receipt_branch_id) AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") AND (r.receipt_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.receipt_date) LIMIT 100');
					if ($query1->num_rows() > 0) return $query1->result_array();
				} else {
					$query2 = $this->db->query('SELECT *  FROM receipt r, branch b WHERE (b.id = r.receipt_branch_id) AND (r.receipt_branch_id = "'.$receipt_branch.'") AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") AND (r.receipt_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.receipt_date) LIMIT 100');
					if ($query2->num_rows() > 0) return $query2->result_array();
				}
			}
		}
		return NULL;
	}

	/**
	 * search receipt records by multiple variables for download
	 *
	 * @param	$student_ic, $receipt_no, $receipt_branch, $course_type, $receipt_date_from, $receipt_date_to
	 * @return	array or null
	 */
	function search_receipt_by_multiple_var_download($student_ic, $receipt_no, $receipt_branch, $course_type, $receipt_date_from, $receipt_date_to) {
		if($this->session->userdata('session_id')) {
			if($course_type == 'ALL') { $course_type = "";}
			if($this->apis->check_user_role() == 'admin') {
				if($receipt_branch == 'ALL') {	
					$query1 = $this->db->query('SELECT r.receipt_type, DATE_FORMAT(r.receipt_date,"%d/%m/%Y"), r.receipt_no, r.receipt_amount, r.student_ic, r.payee_name, s.tel, r.makeup, r.student_before, r.course_type, u.username, b.name, r.receipt_remark FROM receipt r, branch b, student s, users u WHERE (b.id = r.receipt_branch_id) AND (r.student_ic = s.ic) AND (r.receipt_op_id = u.id) AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") ORDER BY -DATE(r.receipt_date)');
					if ($query1->num_rows() > 0) return $query1->result_array();
				} else {
					$query2 = $this->db->query('SELECT r.receipt_type, DATE_FORMAT(r.receipt_date,"%d/%m/%Y"), r.receipt_no, r.receipt_amount, r.student_ic, r.payee_name, s.tel, r.makeup, r.student_before, r.course_type, u.username, b.name, r.receipt_remark FROM receipt r, branch b, student s, users u WHERE (b.id = r.receipt_branch_id) AND (r.student_ic = s.ic) AND (r.receipt_op_id = u.id) AND (r.receipt_branch_id = "'.$receipt_branch.'") AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") ORDER BY -DATE(r.receipt_date)');
					if ($query2->num_rows() > 0) return $query2->result_array();
				}	
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				if($receipt_branch == 'ALL') {	
					$query1 = $this->db->query('SELECT r.receipt_type, DATE_FORMAT(r.receipt_date,"%d/%m/%Y"), r.receipt_no, r.receipt_amount, r.student_ic, r.payee_name, s.tel, r.makeup, r.student_before, r.course_type, u.username, b.name, r.receipt_remark FROM receipt r, branch b, student s, users u WHERE (b.id = r.receipt_branch_id) AND (r.student_ic = s.ic) AND (r.receipt_op_id = u.id) AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") AND (r.receipt_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.receipt_date)');
					if ($query1->num_rows() > 0) return $query1->result_array();
				} else {
					$query2 = $this->db->query('SELECT r.receipt_type, DATE_FORMAT(r.receipt_date,"%d/%m/%Y"), r.receipt_no, r.receipt_amount, r.student_ic, r.payee_name, s.tel, r.makeup, r.student_before, r.course_type, u.username, b.name, r.receipt_remark FROM receipt r, branch b, student s, users u WHERE (b.id = r.receipt_branch_id) AND (r.student_ic = s.ic) AND (r.receipt_op_id = u.id) AND (r.receipt_branch_id = "'.$receipt_branch.'") AND (r.student_ic LIKE "%'.$student_ic.'%") AND (r.receipt_no LIKE "%'.$receipt_no.'%") AND (r.course_type LIKE "%'.$course_type.'%") AND (DATE(r.receipt_date) BETWEEN "'.$receipt_date_from.'" AND "'.$receipt_date_to.'") AND (r.receipt_branch_id = "'.$op_branch_id.'") ORDER BY -DATE(r.receipt_date)');
					if ($query2->num_rows() > 0) return $query2->result_array();
				}
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
	 * delete receipt record from receipt table by ID
	 *
	 * @param	$receipt_id
	 * @return	bool
	 */
	function delete_student_receipt_record($receipt_id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM receipt WHERE receipt_id = "'.$receipt_id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get receipt records from receipt table by IC
	 *
	 * @param	$ic
	 * @return	array or null
	 */
	function get_receipt_record_by_ic($ic) {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT * FROM receipt r, student s WHERE r.student_ic = "'.$ic.'" AND r.student_ic = s.ic');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT * FROM receipt r, student s WHERE r.student_ic = "'.$ic.'" AND (r.receipt_branch_id = "'.$op_branch_id.'" AND r.student_ic = s.ic)');
			}
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
	function update_receipt_record($receipt_id, $student_ic, $receipt_type, $receipt_no, $payee_name, $receipt_date, $receipt_amount, $makeup, $student_before, $course_type, $letter_type, $reg_no, $receipt_branch_id, $receipt_op_id, $receipt_remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('UPDATE receipt SET student_ic = "'.$student_ic.'", receipt_type="'.$receipt_type.'", receipt_no = "'.$receipt_no.'", payee_name = "'.$payee_name.'", receipt_date = "'.$receipt_date.'", receipt_amount = "'.$receipt_amount.'", makeup = "'.$makeup.'", student_before = "'.$student_before.'", course_type = "'.$course_type.'", letter_type = "'.$letter_type.'", reg_no = "'.$reg_no.'", receipt_branch_id = "'.$receipt_branch_id.'", receipt_op_id = "'.$receipt_op_id.'", receipt_remark = "'.$receipt_remark.'", modified = "'.date('Y-m-d H:i:s').'" WHERE receipt_id = "'.$receipt_id.'"');
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
			$query = $this->db->query('SELECT * FROM class c, student_class sc, branch b WHERE (c.class_id = sc.class_id) AND (sc.student_id = (SELECT student_id FROM student s WHERE s.ic = "'.$ic.'")) AND (c.branch_id = b.id) ORDER BY c.created');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get classes from class, student_class and branch table by student IC
	 *
	 * @param	$ic
	 * @return	array or null
	 */
	function get_all_class_by_student_ic_download($ic) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT c.code, c.class_name, c.type, c.level, DATE_FORMAT(c.start_date,"%d/%m/%Y"), DATE_FORMAT(c.end_date,"%d/%m/%Y"), c.start_time, c.end_time, c.teacher_name, c.teacher_tel, c.location, c.status, c.remark FROM class c, student_class sc, branch b WHERE (c.class_id = sc.class_id) AND (sc.student_id = (SELECT student_id FROM student s WHERE s.ic = "'.$ic.'")) AND (c.branch_id = b.id) ORDER BY c.created');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get seat_booking_id from seat_booking table by year, month and day
	 *
	 * @param	$year, $month, $day
	 * @return	bool
	 */
	function get_seat_booking_info_id($year, $month, $day) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM seat_booking sb WHERE sb.year = "'.$year.'" AND sb.month = "'.$month.'" AND sb.day = "'.$day.'"');
			if ($query->num_rows() == 1) {
				foreach ($query->result_array() as $row)
				{
				   return $row['seat_booking_id'];				}
			}
		}
		return 0;
	}

	/**
	 * if sear booking info not created (identified by year, month and day), create otehrwise update
	 *
	 * @param	$on_off, $je_09, $pi_09, $je_14, $pi_14, $je_19, $pi_19,$year,$month, $day
	 * @return	bool
	 */
	function create_update_seat_booking_info($on_off, $je_09, $pi_09, $je_14, $pi_14, $je_19, $pi_19,$year,$month, $day) {
		if($this->session->userdata('session_id')) {
			$id = $this->get_seat_booking_info_id($year, $month, $day);
			if($id != 0) {
				// update exit record
				$query = $this->db->query('UPDATE seat_booking SET on_off = "'.$on_off.'", je_09="'.$je_09.'", pi_09 = "'.$pi_09.'", je_14 = "'.$je_14.'", pi_14 = "'.$pi_14.'", je_19 = "'.$je_19.'", pi_19 = "'.$pi_19.'", modified = "'.date('Y-m-d H:i:s').'" WHERE seat_booking_id = "'.$id.'"');
				if ($this->db->affected_rows()) return TRUE;
			} else {
				// create new record
				$query = $this->db->query('INSERT INTO seat_booking (on_off, je_09, pi_09, je_14, pi_14, je_19, pi_19, year, month, day, created, modified) VALUES ("'.$on_off.'", "'.$je_09.'", "'.$pi_09.'", "'.$je_14.'", "'.$pi_14.'", "'.$je_19.'", "'.$pi_19.'", "'.$year.'", "'.$month.'", "'.$day.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
				if ($this->db->affected_rows()) return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * update exist seat booking info (identified by year, month and day)
	 *
	 * @param	$on_off, $je_09, $pi_09, $je_14, $pi_14, $je_19, $pi_19,$year,$month, $day
	 * @return	bool
	 */
	function update_seat_booking_info($on_off, $je_09, $pi_09, $je_14, $pi_14, $je_19, $pi_19,$year,$month, $day) {
		if($this->session->userdata('session_id')) {
			$id = $this->get_seat_booking_info_id($year, $month, $day);
			if($id != 0) {
				// update exit record
				$query = $this->db->query('UPDATE seat_booking SET on_off = "'.$on_off.'", je_09="'.$je_09.'", pi_09 = "'.$pi_09.'", je_14 = "'.$je_14.'", pi_14 = "'.$pi_14.'", je_19 = "'.$je_19.'", pi_19 = "'.$pi_19.'", modified = "'.date('Y-m-d H:i:s').'" WHERE seat_booking_id = "'.$id.'"');
				if ($this->db->affected_rows()) return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * get seat booking info by date info from seat_booking table
	 *
	 * @param	$year, $month, $day
	 * @return	array or null
	 */
	function get_seat_booking_record_by_date($year, $month, $day) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM seat_booking sb WHERE (sb.year = "'.$year.'") AND (sb.month = "'.$month.'") AND (sb.day = "'.$day.'")');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * get role of admin user
	 *
	 * @param	null
	 * @return	role
	 */
	function check_user_role() {
		if($this->session->userdata('session_id')) {
			$userid = $this->tank_auth->get_user_id();
			$query = $this->db->query('SELECT * FROM users u, admin_users au, admin_role ar WHERE (u.id = "'.$userid.'") AND (u.id = au.user_id) AND (au.role_id = ar.id)');
			if ($query->num_rows() == 1) {
				foreach ($query->result_array() as $row)
				{
				   return $row['role'];
				}
			}
		}
		return 0;
	}

	/**
	 * get email of admin user
	 *
	 * @param	null
	 * @return	role
	 */
	function get_admin_user_email() {
		if($this->session->userdata('session_id')) {
			$userid = $this->tank_auth->get_user_id();
			$query = $this->db->query('SELECT * FROM users u WHERE (u.id = "'.$userid.'")');
			if ($query->num_rows() == 1) {
				foreach ($query->result_array() as $row)
				{
				   return $row['email'];
				}
			}
		}
		return 0;
	}

	/**
	 * get seat booking info by date info from seat_booking table
	 *
	 * @param	null
	 * @return	branch id
	 */
	function get_user_branch_id() {
		if($this->session->userdata('session_id')) {
			$userid = $this->tank_auth->get_user_id();
			$query = $this->db->query('SELECT * FROM users u, admin_users au WHERE (u.id = "'.$userid.'") AND (u.id = au.user_id)');
			if ($query->num_rows() == 1) {
				foreach ($query->result_array() as $row)
				{
				   return $row['branch_id'];
				}
			}
		}
		return 0;
	}

	/**
	 * insert new record into publics
	 * @param	$title, $content
	 * @return	bool
	 */
	function create_new_public_message($title, $content) {
		if($this->session->userdata('session_id')) {
			$branch_id = $this->apis->get_user_branch_id();
			$branch_op_id = $this->tank_auth->get_user_id();
			$query = $this->db->query('INSERT INTO publics (publics_title, publics_content, branch_id, branch_op_id, created, modified) VALUES ("'.$title.'", "'.$content.'", "'.$branch_id.'", "'.$branch_op_id.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * get pass seven days' message
	 * @param	null
	 * @return	null or array
	 */
	function get_public_message_one_week() {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT * FROM publics p WHERE p.modified >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY p.modified DESC');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}

	/**
	 * delete record from table publics by id
	 * @param	id
	 * @return	bool
	 */
	function delete_public_message($id) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('DELETE FROM publics WHERE id = "'.$id.'"');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FALSE;
	}

	/**
	 * delete record from table publics by id
	 * @param	id
	 * @return	bool
	 */
	function get_student_info_warning_list() {
		if($this->session->userdata('session_id')) {
			if($this->apis->check_user_role() == 'admin') {
				$query = $this->db->query('SELECT DISTINCT s.ic FROM student s, ato a WHERE (s.ic = a.ic) AND ((a.pre_post = "PRE") OR ((a.pre_post = "POST") AND (a.post_change_date = "YES"))) AND (s.othername = "" OR s.nationality = "NA" OR s.tel = "" OR s.age = "" OR s.postcode = "") ORDER BY -s.modified');
			} else {
				$op_branch_id = $this->apis->get_user_branch_id();
				$query = $this->db->query('SELECT DISTINCT s.ic FROM student s, ato a WHERE (s.ic = a.ic) AND ((a.pre_post = "PRE") OR ((a.pre_post = "POST") AND (a.post_change_date = "YES"))) AND (s.othername = "" OR s.nationality = "NA" OR s.tel = "" OR s.age = "" OR s.postcode = "") AND (s.student_branch_id = "'.$op_branch_id.'") ORDER BY -s.modified');
			}
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
	}
}