<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_Mail extends Migration {
	
	private $permission_array = array(
        'Mail.Content.Manage' => 'Manage Mail',
        'Mail.Content.Add' => 'Add Mail',
        'Mail.Content.Delete' => 'Delete Mail',
		'Mail.Content.View' => 'To view the Mail Content menu.'
    );

	public function up() 
	{
		$this->load->dbforge();
		
		// Creación tabla *_mail
		$this->dbforge->add_field('mail_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('email VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('nombre VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('created_on DATETIME NOT NULL');
		$this->dbforge->add_key('mail_id', TRUE);
		
		$this->dbforge->create_table('mail');
		
		// Creación tabla *_mail_template
		$this->dbforge->add_field('mail_template_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('name VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('subject VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('message TEXT NOT NULL');
		$this->dbforge->add_field('description TEXT NOT NULL');
		$this->dbforge->add_field('active TINYINT NOT NULL DEFAULT 0');
		$this->dbforge->add_field('user INT(10) NOT NULL');
		$this->dbforge->add_field('created_on DATETIME NOT NULL');
		$this->dbforge->add_field('user_modify INT(10) NULL');
		$this->dbforge->add_field('modified_on DATETIME NULL');
		$this->dbforge->add_field('deleted TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_key('mail_template_id', TRUE);
		
		$this->dbforge->create_table('mail_template');
		
		// Creación tabla *_lists
		$this->dbforge->add_field('list_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('name VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('slug VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('description VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('user INT(10) NOT NULL');
		$this->dbforge->add_field('created_on DATETIME NOT NULL');
		$this->dbforge->add_field('user_modify INT(10) NULL');
		$this->dbforge->add_field('modified_on DATETIME NULL');
		$this->dbforge->add_field('deleted TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_key('list_id',TRUE);
		
		$this->dbforge->create_table('lists');
		
		// Creación tabla *_tx
		$this->dbforge->add_field('tx_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('taxonomy VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('term_id INT(10) NOT NULL');
		$this->dbforge->add_field('object_id INT(10) NOT NULL');
		$this->dbforge->add_key('tx_id',TRUE);
		
		$this->dbforge->create_table('tx');
		
		// Creación tabla *_track
		$this->dbforge->add_field('track_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('ip VARCHAR(60) NOT NULL');
		$this->dbforge->add_field('timestamp DATETIME NOT NULL');
		$this->dbforge->add_field('template_id INT(10) NOT NULL');
		$this->dbforge->add_field('mail_id INT(10) NOt NULL');
		$this->dbforge->add_key('track_id',TRUE);
		
		$this->dbforge->create_table('track');
		
		// Creación y Configuración de Permisos
		$prefix = $this->db->dbprefix;
		foreach ($this->permission_array as $name => $description)
		{
		   $this->db->query("INSERT INTO {$prefix}permissions(name, description) VALUES('".$name."', '".$description."')");
		   // give current role (or administrators if fresh install) full right to manage permissions
		   $this->db->query("INSERT INTO {$prefix}role_permissions VALUES(1,".$this->db->insert_id().")");
		}
		
		
	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$this->load->dbforge();
		
		// Se borran las tablas de la Base de Datos
		$this->dbforge->drop_table('mail');
		$this->dbforge->drop_table('mail_template');
		$this->dbforge->drop_table('lists');
		$this->dbforge->drop_table('tx');
		$this->dbforge->drop_table('track');
		
		// Se quitan los permisos
		$prefix = $this->db->dbprefix;
		foreach ($this->permission_array as $name => $description)
		{
			$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name = '".$name."'");
			foreach ($query->result_array() as $row)
			{
				$permission_id = $row['permission_id'];
				$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
			}
			//delete the role
			$this->db->query("DELETE FROM {$prefix}permissions WHERE (name = '".$name."')");
		}
	}
	
	//--------------------------------------------------------------------
	
}
?>