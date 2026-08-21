<?php

namespace App\Notify;
use App\Notify\NotifyProcess;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\Exception;

class Email extends NotifyProcess{

    /**
    * Email of receiver
    *
    * @var string
    */
	public $email;

    /**
    * Assign value to properties
    *
    * @return void
    */
	public function __construct(){
		$this->statusField = 'email_status';
		$this->body = 'email_body';
		$this->globalTemplate = 'email_template';
		$this->notifyConfig = 'mail_config';
	}

    /**
    * Send notification
    *
    * @return void|bool
    */
	public function send(){

		//get message from parent
		$message = $this->getMessage();
		if ($message) {
			//Send mail using Laravel's Mail facade (which uses Pawlly's config from AppServiceProvider)
			try{
                Mail::html($this->finalMessage, function ($mail) {
                    $mail->to($this->email, $this->receiverName)
                         ->subject($this->subject)
                         ->from(config('mail.from.address'), config('mail.from.name'));
                });
				$this->createLog('email');
			}catch(\Exception $e){
				$this->createErrorLog($e->getMessage());
				session()->flash('mail_error',$e->getMessage());
			}
		}

	}

    /**
    * Configure some properties
    *
    * @return void
    */
	protected function prevConfiguration(){
		if ($this->user) {
			$this->email = $this->user->email;
			$this->receiverName = $this->user->first_name . ' ' . $this->user->last_name;
		}
		$this->toAddress = $this->email;
	}
}

