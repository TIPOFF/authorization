<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Tests\Unit\Providers;


use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tipoff\Authorization\Models\EmailAddress;
use Tipoff\Authorization\Models\User;
use Tipoff\Authorization\Tests\TestCase;

class TipoffUserProviderTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @dataProvider dataProviderForLoginByUsername
     * @test
     */
    public function login_by_username(array $credentials, bool $expected)
    {
        User::factory()->create([
            'username' => 'username',
            'password' => bcrypt('password'),
        ]);

        $isValid = Auth::validate($credentials);

        $this->assertEquals($expected, $isValid);
    }

    public function dataProviderForLoginByUsername()
    {
        return [
            [ ['username' => 'username', 'password' => 'password'], true, ],
            [ ['username' => 'badname', 'password' => 'password'], false, ],
            [ ['username' => 'username', 'password' => 'badpass'], false, ],
            [ ['username' => 'badname', 'password' => 'badpass'], false, ],
            [ ['email' => 'test@test.com', 'password' => 'password'], false, ],
        ];
    }

    /**
     * @dataProvider dataProviderForLoginBySingleEmail
     * @test
     */
    public function login_with_single_email(array $credentials, bool $expected)
    {
        $user = User::factory()->create([
            'username' => 'username',
            'password' => bcrypt('password'),
        ]);

        EmailAddress::factory()->create([
            'email' => 'test@test.com',
            'user_id' => $user,
        ]);

        $isValid = Auth::validate($credentials);

        $this->assertEquals($expected, $isValid);
    }

    public function dataProviderForLoginBySingleEmail()
    {
        return [
            [ ['email' => 'test@test.com', 'password' => 'password'], true, ],
            [ ['email' => 'bad@test.com', 'password' => 'password'], false, ],
            [ ['email' => 'test@test.com', 'password' => 'badpass'], false, ],
            [ ['email' => 'bad@test.com', 'password' => 'badpass'], false, ],
            [ ['username' => 'username', 'password' => 'password'], true, ],
            [ ['username' => 'badname', 'password' => 'password'], false, ],
        ];
    }

    /**
     * @dataProvider dataProviderForLoginWithMultipleEmails
     * @test
     */
    public function login_with_multiple_email(array $credentials, bool $expected)
    {
        $user = User::factory()->create([
            'username' => 'username',
            'password' => bcrypt('password'),
        ]);

        EmailAddress::factory()->create([
            'email' => 'test1@test.com',
            'user_id' => $user,
        ]);

        EmailAddress::factory()->create([
            'email' => 'test2@test.com',
            'user_id' => $user,
        ]);

        $isValid = Auth::validate($credentials);

        $this->assertEquals($expected, $isValid);
    }

    public function dataProviderForLoginWithMultipleEmails()
    {
        return [
            [ ['email' => 'test1@test.com', 'password' => 'password'], true, ],
            [ ['email' => 'test2@test.com', 'password' => 'password'], true, ],
            [ ['email' => 'bad@test.com', 'password' => 'password'], false, ],
            [ ['email' => 'test1@test.com', 'password' => 'badpass'], false, ],
            [ ['email' => 'test2@test.com', 'password' => 'badpass'], false, ],
            [ ['email' => 'bad@test.com', 'password' => 'badpass'], false, ],
            [ ['username' => 'username', 'password' => 'password'], true, ],
            [ ['username' => 'badname', 'password' => 'password'], false, ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanResetPassword
     * @test
     */
    public function can_reset_password(array $credentials, string $expected)
    {
        Notification::fake();

        $user = User::factory()->create([
            'username' => 'username',
            'password' => bcrypt('password'),
        ]);

        EmailAddress::factory()->create([
            'email' => 'test1@test.com',
            'user_id' => $user,
            'primary' => true,
        ]);

        EmailAddress::factory()->create([
            'email' => 'test2@test.com',
            'user_id' => $user,
            'primary' => false,
        ]);

        /** @var PasswordBroker $broker */
        $broker = $this->app->make('auth.password.broker');
        $result = $broker->sendResetLink($credentials);

        $this->assertEquals($expected, $result);

        if ($expected === PasswordBroker::RESET_LINK_SENT) {
            Notification::assertSentTo($user, ResetPassword::class);
        } else {
            Notification::assertNothingSent();
        }
    }

    public function dataProviderForCanResetPassword()
    {
        return [
            [ ['email' => 'test1@test.com'], PasswordBroker::RESET_LINK_SENT, ],
            [ ['email' => 'test2@test.com'], PasswordBroker::RESET_LINK_SENT, ],
            [ ['email' => 'bad@test.com'], PasswordBroker::INVALID_USER, ],
            [ ['username' => 'username'], PasswordBroker::RESET_LINK_SENT, ],
            [ ['username' => 'badname'], PasswordBroker::INVALID_USER, ],
        ];
    }
}
