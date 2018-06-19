<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->dbutil();
		//$this->psql = $this->load->database('psql');
	}
	public function index()
	{
		//var_dump($this->psql);
		$this->load->view('welcome_message');
	}
}
