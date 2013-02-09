<?php

class Admin_Controller extends Base_Controller {
	
	public $restful = true;
	public $layout = 'admin.default';
	
	public function get_index()
	{
		$this->layout->title = 'Hi.';
		$this->layout->content = View::make('admin.index');
	}
	
}