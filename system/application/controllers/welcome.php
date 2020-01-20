<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'html'));
	}
	
	function index()
	{
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
