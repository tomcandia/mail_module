<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_model extends MY_model {

	protected $table			= 'lists';
	protected $key				= 'list_id';
	protected $set_created		= true;
	protected $set_modified		= true;
	protected $soft_deletes		= true;
	protected $date_format		= 'datetime';

}

?>