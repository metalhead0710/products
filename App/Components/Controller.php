<?php

namespace App\Components;

use App\Components\Db;

class Controller
{
	public $view;
	public $db;

	function __construct() {
		$this->view = new View();
		$this->db = Db::getConnection();
	}
}