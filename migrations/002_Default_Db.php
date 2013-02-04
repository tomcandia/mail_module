<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Migration_Default_Db extends Migration {

	public $migration_type = 'sql';
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;
		$user_id = $this->auth->user_id();
		
		$this->load->model('user_model');
		$user = $this->user_model->find($user_id);
		if($user->display_name !== null ){
			$name = $user->username;
		} else {
			$name = $user->display_name;
		}
		$created_on = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO {$prefix}mail (email,nombre,created_on) VALUES ('{$user->email}','{$name}','{$created_on}')";
		
		$template_name = 'Bienvenida';
		$temlate_subject = '¡Bienvenido!';
		$template_message = '<h1><strong>Bienvenido</strong></h1><p><strong>Muchas gracias por preferirnos</strong></p>';
		$template_description = 'Mail enviado al momento del registro';
	
		$sql .= "; INSERT INTO {$prefix}mail_template (name,subject,message,description,created_on,user) VALUES ('{$template_name}','{$temlate_subject}','{$template_message}','{$template_description}','{$created_on}','{$user_id}')";
		
		$list_name = 'Todo';
		$list_slug = 'todo';
		$list_description = 'Lista para contener a todos los inscritos';
		
		
		$sql .= "; INSERT INTO {$prefix}lists (name,slug,description,user,created_on) VALUES ('{$list_name}','{$list_slug}','{$list_description}','{$user_id}','{$created_on}')";
		
		$tx_term = 1;
		$tx_object = 1;
		$tx_tx = 'list';
		
		$sql .= "; INSERT INTO {$prefix}tx (term_id,object_id,taxonomy) VALUES ('{$tx_term}','{$tx_object}','{$tx_tx}')";
		
		return $sql;
	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		
	}
	
	//--------------------------------------------------------------------
	
}
?>