<?php

class Mail 
{

	private $_mailer;
	private $_transport;
	private $_message;

	public function __construct($message)
	{	
		if($message !== null ) {
			$this->_message  = $message;
		}
	}

	public function setMessage($message)
	{
		$this->_message = $message;
	}	

	public function send()
	{
		$mailer = Swift_Mailer::newInstance($this->detectTransport());
		return $mailer->send($this->_message); //return true or false.
	}

	private function detectTransport()
	{	
		if($_SERVER['HTTP_HOST'] == 'localhost') {
			//use gmail for local
			$transport = Swift_SmtpTransport::newInstance('smtpdsl4.pldtdsl.net')
						->setPort(587);
		} else {
			$transport = Swift_SmtpTransport::newInstance('smtp.concepts.nl')
						->setPort(587);
		}

		return $transport;
	}
}