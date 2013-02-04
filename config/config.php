<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
    'name'          => 'Mail',          
    'description'   => 'Formulario de mails',
    'author'        => 'Tomás Candia',     
    'homepage'      => 'http://www.tomcandia.cl',    
    'version'       => '1.0',         
    'menus'          => array(           
        'content'   => 'mail/content/menu'
    ),
    'weights'     => array(
        'context' => 'weight'
    )
);

?>