<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail_model extends MY_model {

	protected $table			= 'mail';
	protected $key				= 'mail_id';
	protected $set_created		= true;
	protected $set_modified		= false;
	protected $soft_deletes		= false;
	protected $date_format		= 'datetime';

}

?>