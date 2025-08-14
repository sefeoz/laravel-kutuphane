<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use App\Models\User;

class UserRegistrationMailTest extends TestCase
{
	use RefreshDatabase;
	public function test_it_sends_welcome_mail_on_register(): void
	{
		Mail::fake();

		$response = $this->post('/register', [
			'name' => 'Test User',
			'email' => 'test@example.com',
			'password' => 'password123',
		]);

		$response->assertRedirect('/login');

		$this->assertDatabaseHas('users', [
			'email' => 'test@example.com',
		]);

		$user = User::where('email', 'test@example.com')->first();

		Mail::assertSent(WelcomeUserMail::class, function ($mail) use ($user) {
			return $mail->hasTo('test@example.com') && $mail->user->is($user);
		});
	}
}


