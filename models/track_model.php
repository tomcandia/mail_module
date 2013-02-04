<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Track_model extends MY_model {

	protected $table			= 'track';
	protected $key				= 'track_id';
	protected $set_created		= false;
	protected $set_modified		= false;
	protected $soft_deletes		= false;
	protected $date_format		= 'datetime';

}