<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 08.05.2014 
 -->

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Model
{
	private $table_student	= 'student';		
	private $table_student	= 'student_record';

	function __construct()
	{
		parent::__construct();
	}
}