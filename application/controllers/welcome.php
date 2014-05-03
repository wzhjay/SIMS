<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 02.05.2014 
 -->
 
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->template->title('Welcome to SIMS')
				->set('currentSection', 'welcome')
				->set_layout('default');
	}

	function index()
	{
		$this->template->build('welcome');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */