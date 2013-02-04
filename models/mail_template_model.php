<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail_template_model extends MY_model {

	protected $table			= 'mail_template';
	protected $key				= 'mail_template_id';
	protected $set_created		= true;
	protected $set_modified		= true;
	protected $soft_deletes		= true;
	protected $date_format		= 'datetime';

}

?>