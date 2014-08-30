<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 02.05.2014 
 -->
 
 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Systems extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->template->title('Welcome to SIMS')
				->set('currentSection', 'classes')
				->set_layout('default');
	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			if($this->apis->check_user_role() == 'admin') {
				$data['user_id']	= $this->tank_auth->get_user_id();
				$data['username']	= $this->tank_auth->get_username();
				$this->template->build('systems', $data);
        	} else {
        		redirect('/systems/userProfile');
        	}
		}
	}

	function userProfile() {
		$this->template->build('/partials/systems/user_profile');
	}
}
