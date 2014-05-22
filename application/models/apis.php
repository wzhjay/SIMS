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
		return FLASE;
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
		return FLASE;
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
		return FLASE;
	}

	/**
	 * insert new reg info into registration table
	 *
	 * @param	$ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $start_date_wanted, $remark
	 * @return	bool
	 */
	function create_new_registration($ic, $reg_date, $student_branch_id, $reg_branch_id, $reg_op_id, $reg_no, $start_date_wanted, $remark) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('INSERT INTO registration (ic, reg_date, student_branch_id, reg_branch_id, reg_op_id, reg_no, start_date_wanted, remark) VALUES ("'.$ic.'", "'.$reg_date.'", "'.$student_branch_id.'", "'.$reg_branch_id.'", "'.$reg_op_id.'", "'.$reg_no.'", "'.$start_date_wanted.'", "'.$remark.'")');
			if ($this->db->affected_rows()) return TRUE;
		}
		return FLASE;
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
	function search_reg_info($from, $to) {
		if($this->session->userdata('session_id')) {
			$query = $this->db->query('SELECT r.ic, r.reg_date, r.reg_no, b1.name AS reg_branch, b2.name AS assigned_branch, r.start_date_wanted, r.remark, u.username  FROM registration r, branch b1, branch b2, users u WHERE (DATE(r.reg_date) BETWEEN "'.$from.'" AND "'.$to.'") AND (r.reg_branch_id = b1.id) AND (r.student_branch_id = b2.id) AND (r.reg_op_id = u.id) ORDER BY -DATE(r.reg_date)');
			if ($query->num_rows() > 0) return $query->result_array();
		}
		return NULL;
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
		return FLASE;
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
		return FLASE;
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
		return FLASE;
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
}