<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tx_model extends MY_model {

	protected $table			= 'tx';
	protected $key				= 'tx_id';
	protected $set_created		= false;
	protected $set_modified		= false;
	protected $soft_deletes		= false;
	protected $date_format		= 'datetime';

}

?>