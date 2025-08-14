<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable
{
	use Queueable;
	use SerializesModels;

	public function __construct(public User $user)
	{
	}

	public function build(): self
	{
		return $this->subject('Kayıt Başarılı — Kutuphane')
			->view('emails.welcome');
	}
}


