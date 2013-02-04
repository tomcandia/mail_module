<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('mail_model');
		$this->load->model('mail_template_model');
		$this->load->model('user_model');
		$this->load->model('list_model');
		$this->load->model('tx_model');
		$this->load->model('track_model');
		
		$this->load->helper('crypt');
		
		$this->lang->load('mail');
		
		Template::set('toolbar_title',lang('mail_admin'));
		Template::set_block('sub_nav','content/sub_nav');
		
		Assets::add_css(site_url().'/bonfire/modules/mail/assets/css/admin-mail.css');
		Assets::css();
		
		Assets::add_js(site_url().'/bonfire/modules/mail/assets/js/editor/ckeditor/ckeditor.js');
		Assets::add_js(site_url().'/bonfire/modules/mail/assets/js/mail.js');
		Assets::js();

	}
	
	//------------------------------------------------------------------------
	
	public function index()
	{
		if($this->input->post('delete'))
		{
			foreach($this->input->post('checked') as $id)
			{
				$tx = $this->tx_model->find_by('object_id',$id);
				$this->tx_model->delete($tx->tx_id);
				$this->mail_model->delete($id);
				
			}
			Template::set_message(lang('mail_delete_record'));
		}
		
		if($this->input->post('send'))
		{
			if($this->send($this->input->post('checked')))
			{
				
				Template::set_message(lang('mail_add_queue'));
			}
		}
		if($this->input->post('addToList') !== 'none' && $this->input->post('checked'))
		{
			foreach($this->input->post('checked') as $object_id)
			{
				
				$data = array(
						'term_id'	=> $this->input->post('addToList'),
						'object_id'	=> $object_id,
						'taxonomy'	=> 'list'
					);
				
				if($this->tx_model->where($data)->find_all() === false)
				{
					$this->tx_model->insert($data);
				}
			}
		}
		if($this->input->post('import'))
		{
			$import = $this->import_list();
			if($import != FALSE)
			{
				Template::set('file',$this->importFile);
				Template::set('import',$import);
				Template::set_view('content/import');
			} else {
				Template::set_message($this->error);
			}
		}
		if($this->input->post('import_list'))
		{
			if($this->save_imported_list($this->input->post('column_num'),$this->input->post('importFile')))
			{
				Template::set_message('Lista importada con éxito');
				redirect(SITE_AREA.'/content/mail');
			} else {
				Template::set_message($this->error);
			}
		}
		
		$mails = $this->mail_model->order_by('created_on','DESC')->find_all();
		$lists = $this->list_model->find_all();
		
		Template::set('mails',$mails);
		Template::set('lists',$lists);
		Template::render();
	}
	
	public function template($type = null, $id = null)
	{
		if($id !== null) $id = crypt_decode($id);
		
		if($this->input->post('delete'))
		{
			foreach($this->input->post('checked') as $temp_id)
			{
				$check = $this->mail_template_model->find($temp_id);
				if($check->name != 'Bienvenida')
				{
					$this->mail_template_model->delete($temp_id);
				}
			}
		}
		switch ($type)
		{
			case 'new':
				if($this->save_template('new'))
				{
					Template::set_message('Template Guardado');
					redirect(SITE_AREA.'/content/mail/template');
				}
				$data['title'] = 'Nuevo Template';
				Template::set($data);
				Template::set_view('content/template/template_form');
			break;
			case 'edit':
				if($this->save_template('edit',$id))
				{
					Template::set_message('Template Actualizado');
					redirect(SITE_AREA.'/content/mail/template');
				}
				$data['template'] = $this->mail_template_model->find($id);
				$data['title'] = 'Editar Template';
				Template::set($data);
				Template::set_view('content/template/template_form');
			break;
			case 'activate':
				$old = $this->mail_template_model->find_by('active',1);
				if($old !== false) {
					$old_template['active'] = 0;
					$this->mail_template_model->update($old->mail_template_id,$old_template);
				}
				$data['active'] = 1;
				$data['user_modify'] = $this->auth->user_id();
				$this->mail_template_model->update($id,$data);
				Template::set_message('Template Activado');
				redirect(SITE_AREA.'/content/mail/template');
			break;
			case 'deactivate':
				$data['active'] = 0;
				$data['user_modify'] = $this->auth->user_id();
				$this->mail_template_model->update($id,$data);
				Template::set_message('Template Desactivado');
				redirect(SITE_AREA.'/content/mail/template');
			break;
			case 'stats':
				$data['template'] = $this->mail_template_model->find($id);
				$data['tracks'] = $this->track_model->where('template_id',$id)->find_all();
				$data['tx'] = $this->tx_model->where(array('term_id' => $id,'taxonomy' => 'send'))->find_all();
				$data['send'] = $this->tx_model->find_by(array('term_id' => $id,'taxonomy' => 'send_num'));
				Template::set($data);
				Template::set_view('content/template/stat');
			break;
			default:
			$templates = $this->mail_template_model->where('deleted',0)->find_all();
			Template::set('templates',$templates);
			Template::set_view('content/template/index');
			break;
		}
		
		
		Template::set_block('sidebar','content/template/side_template');
		Template::render('two_left');
	}
	
	public function lists($type = null,$id = null)
	{
		if($id !== null) $id = crypt_decode($id);
		if($this->input->post('send'))
		{
			if($this->send($this->input->post('checked')))
			{
				Template::set_message('Envio realizado');
			}
		}
		if($this->input->post('delete'))
		{
			foreach($this->input->post('checked') as $id_del)
			{
				$this->list_model->delete(crypt_decode($id_del));
				
			}
			Template::set_message('Registro Borrado');
		}
		switch($type){
			case 'new':
				if($this->save_list('new'))
				{
					Template::set_message('Lista guardada');
					redirect(SITE_AREA.'/content/mail/lists');
				}
				$data['title'] = 'Nueva Lista';
				Template::set($data);
				Template::set_view('content/lists/list_form');
			break;
			case 'edit':
				if($this->save_list('edit'))
				{
					Template::set_message('Lista actualizada');
					redirect(SITE_AREA.'/content/mail/lists');
				}
				$data['title'] = 'Editar Lista';
				$data['list'] = $this->list_model->find($id);
				Template::set($data);
				Template::set_view('content/lists/list_form');
			break;
			case 'view':
				$data['txs'] = $this->tx_model->where(array('term_id' => $id,'taxonomy' => 'list'))->find_all();
				$data['list'] = $this->list_model->find($id);
				Template::set($data);
				Template::set_view('content/lists/view');
			break;
			default:
				$lists = $this->list_model->find_all();
				Template::set('lists',$lists);
				Template::set_view('content/lists/index');
			break;
		}
		Template::set_block('sidebar','content/lists/side_list');
		Template::render('two_left');
	}
	
	public function wiki($page = null)
	{
		Template::set_block('sidebar','content/wiki/side_wiki');
		
		if($page != null)
		{
			Template::set_view('content/wiki/'.$page);
		} else {
			Template::set_view('content/wiki/index');
		}
		
		Template::render('two_left');
	}
	
	//------------------------------------------------------------------------
	
	public function send($ids)
	{
		$num_send = 0;
		$this->load->library('emailer/emailer'); 
		$template = $this->mail_template_model->find_by('active',1);
		$term = $template->mail_template_id;
		
		foreach($ids as $id)
		{
			
			$mail = $this->mail_model->find($id);
			
			$message = $template->message;
			$token = base64_encode($term.'|'.$id);
			
			$message .= '<!-- Tracking pixel --><img src="'.site_url().'bonfire/modules/mail/assets/trackpixel.php?token='.$token.'" style="position:absolute; visibility:hidden" ><!-- Tracking pixel -->';
			$data = array(
  				'to'            => $mail->email,      // either string or array
  				'subject'       => $template->subject,      // string
  				'message'       => $message,      // string
			);
			
			if($this->emailer->send($data,true))
			{
				$this->tx($term,$id,'send',FALSE);
				$num_send++;
			}
		}
		$this->tx($term,$num_send,'send_num',TRUE);
		return TRUE;
	}
	
	public function save_template($type,$id = null)
	{
		$this->form_validation->set_rules('name','Nombre','required|xss_clean|trim');
		$this->form_validation->set_rules('descr','Descripcion','required|xss_clean|trim');
		$this->form_validation->set_rules('subject','Asunto','required|xss_clean|trim');
		$this->form_validation->set_rules('message','Mensaje','required|xss_clean');
		
		if($this->form_validation->run() === false)
		{
			return false;
		}
		
		$data = array(
				'name'		=> $this->input->post('name'),
				'subject'	=> $this->input->post('subject'),
				'message'	=> $this->input->post('message'),
				'description'	=> $this->input->post('descr'),
			);
		if ($type == 'new')	{
			$data['user'] = $this->input->post('user');
			$return = $this->mail_template_model->insert($data);
			
		} elseif($type == 'edit') {
			$data['user_modify'] = $this->input->post('user');
			$return = $this->mail_template_model->update($id,$data);
		}
		
		return $return;
	}
	
	public function save_list($type,$id = null)
	{
		
		$this->form_validation->set_rules('name','Nombre de la lista','required|trim|xss_clean');
		$this->form_validation->set_rules('descr','Descripción','required|trim|xss_clean');
		
		if($this->form_validation->run() === false)
		{
			return false;
		}
		
		$data = array(
				'name'		=> $this->input->post('name'),
				'description'	=> $this->input->post('descr'),
			);
		
		if($type == 'new') {
			$data['user'] = $this->input->post('user');
			$return = $this->list_model->insert($data);
		} elseif($type == 'edit') {
			$data['user_modify'] = $this->input->post('user');
			$return = $this->list_model->update($id,$data);
		}
		return $return;
	}
	
	public function import_list()
	{
		$config['upload_path'] = realpath(FCPATH).'/bonfire/modules/mail/assets/upload/temp';
		$config['allowed_types'] = 'csv';
		$config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['max_size'] = '2048';
		
		$this->load->library('upload',$config);
		
		if(!$this->upload->do_upload('import'))
		{
			$this->error = $this->upload->display_errors();
			return FALSE;
		}
		
		$data = $this->upload->data();
		$import = $this->parse_file($data['full_path']);
		$this->importFile = $data['full_path'];
		return $import;
		
	}
	
	public function save_imported_list($column_num,$file)
	{
		$csv = $this->parse_file($file);
		foreach($csv[1] as $ids)
		{
			$email = NULL;
			$nombre = NULL;
			for($i=0;$i<$column_num;$i++)
			{
				$column = 'column'.$i;
				switch($this->input->post($column))
				{
					case '1':
						if($email == NULL){
							$email = $ids[$i];
						} else {
							$this->error = 'No pueden haber 2 campos como email. Intenta importar de nuevo';
							return false;
						}
					break;
					case '2':
						$nombre = $ids[$i]; 
					break;
				}
			}
			if($email == NULL) {
				$this->error = 'Debes seleccionar un campo para Email';
				return FALSE;
			}
			if($nombre == NULL){
				$nombre = 'Sin nombre';
			}
			$data = array(
					'email'		=> $email,
					'nombre'	=> $nombre
				);
			if(!$this->mail_model->find_by($data)) {
				$this->mail_model->insert($data);
				$mail = $this->mail_model->find_by($data);
				
				$this->tx('1',$mail->mail_id,'list',FALSE);
			}

		}
		
		return TRUE;
		
	}
	
	public function parse_file($file)
	{
		$lines = file($file);
		
		$content = FALSE;
		$i = 0;
		foreach($lines as $line_num => $line)
		{
			if($line != '')
			{
				$elements = preg_split('[,]',$line);
				
				if(!is_array($content))
				{
					$fields = $elements;
					$content = array();
					foreach($elements as $element)
					{
						$content[0][] = $element;
					}
				} else {
					$item = array();
					foreach($elements as $id => $field)
					{
						$content[1][$i][] = $elements[$id];
					}
					$i++;
				}
			}
		}
		
		return $content;
	}
	
	public function tx($term,$object,$taxonomy,$type)
	{
		if($type == TRUE)
		{
			$tx = $this->tx_model->find_by(array('term_id' => $term,'taxonomy' => $taxonomy));
			if($tx !== FALSE) 
			{
				$data['object_id'] = $object + $tx->object_id;
				$return = $this->tx_model->update($tx->tx_id,$data);
			} else {
				$return = $this->tx($term,$object,$taxonomy,FALSE);
			}
		} else {
			$data = array(
					'term_id'	=> $term,
					'object_id'	=> $object,
					'taxonomy'	=> $taxonomy,
				);
			$return = $this->tx_model->insert($data);
		}
		return $return;
	}
}

?>