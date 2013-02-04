<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('mail_model');
		$this->load->model('mail_template_model');
		$this->load->model('tx_model');
		
		$this->load->helper('form');
		
		$this->load->library('form_validation');
		
	}
	
	//------------------------------------------------------------------
	
	public function index()
	{
		if($this->input->post('submit'))
		{
			if($this->save_mail())
			{
				Template::set_message('Gracias por ingresar');
				redirect('/mail');
			} else {
				Template::set_message($this->error);
			}
		}
		Template::render();
	}

	//------------------------------------------------------------------

	public function save_mail()
	{
		$this->form_validation->set_rules('nombre','Nombre','required|trim|xss_clean');
		$this->form_validation->set_rules('mail','Mail','required|trim|valid_email|callback_unique_email');
		
		if($this->form_validation->run() === false)
		{
			return false;
		}
		
		$data = array(
				'nombre'	=> $this->input->post('nombre'),
				'email'		=> $this->input->post('mail'),
			);
			
		if($this->mail_model->find_by('email',$this->input->post('mail')))
		{
			$this->error = 'Este mail ya está inscrito';
			return FALSE;
		}
		$this->mail_model->insert($data);
		$mail = $this->mail_model->find_by($data);
		$tx = array(
				'term_id'	=> 1,
				'object_id'	=> $mail->mail_id,
				'taxonomy'	=> 'list',
			);
		$this->tx_model->insert($tx);
		
		$this->load->library('emailer/emailer');
		$template = $this->mail_template_model->find_by('name','Bienvenida');
		
		$queue = array(
				'to'		=> $this->input->post('mail'),
				'subject'	=> $template->subject,
				'message'	=> $template->message
			);
			
		$return = $this->emailer->send($queue);
		
		
		
		return $return;
	}
	
	public function unique_email($email)
    {
		
        if ($this->mail_model->where(array('email' => $email,'deleted' => 0)) === false)
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('unique_email', 'Email is already in use.');
            return false;
        }
    }

}

?>