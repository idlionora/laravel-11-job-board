<?php

namespace Tests\Feature;

use App\Models\Employer;
use App\Models\Placement;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private User $jobSeeker;
    private User $toBeEmployerUser;
    private User $employerUser;
    private string $password;

    private string $jobSeekerName;
    private string $jobSeekerEmail;

    private string $toBeEmployerUserName;
    private string $toBeEmployerUserEmail;
    private string $toBeEmployerUserCompany;
    
    private string $employerUserName;
    private string $employerUserEmail;
    private string $employerUserCompany;

    protected function setUp(): void
    {
        parent::setUp();
        $jobSeekerName = 'Nurul Azizah';
        $jobSeekerEmail = 'nuruaizaa_pmrfi@mailsac.com';
        $toBeEmployerUserName = 'Test Employer 1';
        $toBeEmployerUserEmail = 'test.employer01@mailsac.com';
        $toBeEmployerUserCompany = 'Test Company 1';
        $employerUserName = 'Test Employer 2';
        $employerUserEmail = 'test.employer02@mailsac.com';
        $employerUserCompany = 'Test Company 2';
        $placementsNum = 3;
        $this->password = 'password';

        $this->jobSeeker = User::factory()->create([
            'name' => $jobSeekerName,
            'email' => $jobSeekerEmail
        ]);
        $this->jobSeekerName = $jobSeekerName;
        $this->jobSeekerEmail = $jobSeekerEmail;

        $this->toBeEmployerUser = User::factory()->create([
            'name' => $toBeEmployerUserName,
            'email' => $toBeEmployerUserEmail
        ]);
        $this->toBeEmployerUserName = $toBeEmployerUserName;
        $this->toBeEmployerUserEmail = $toBeEmployerUserEmail;
        $this->toBeEmployerUserCompany = $toBeEmployerUserCompany;

        $employerUser = User::factory()->create([
            'name' => $employerUserName,
            'email' => $employerUserEmail
        ]);
        $employer = Employer::factory()->create([
            'company_name' => $employerUserCompany
        ]);
        Placement::factory($placementsNum)->create([
            'employer_id' => $employer->id
        ]);
    }

    public function test_login_page_returns_200(): void
    {
        $response = $this->get('/auth/create');

        $response->assertStatus(200);
    }

    public function test_login_with_blank_fields_returns_errors(): void 
    {
        $response = $this->from('/auth/create')->post('/auth', [
            'email' => '',
            'password' => ''
        ]);

        $response->assertRedirect('/auth/create');
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_login_with_wrong_password_returns_error_message(): void
    {
        $response = $this->from('/auth/create')->post('/auth', [
            'email' => $this->jobSeekerEmail,
            'password' => 'notpassword'
        ]);
        
        $response->assertRedirect('/auth/create');
        $response->assertSessionHas('error', 'Invalid credentials');
    }

    public function test_login_redirect_to_homepage(): void
    {
        $response = $this->post('/auth', [
            'email' => $this->jobSeekerEmail,
            'password' => $this->password,
            'remember' => true
        ]);

        $response->assertRedirect('/');
    }

    public function test_logout_user_redirects_to_homepage(): void
    {
        $this->be($this->jobSeeker);

        $response = $this->actingAs($this->jobSeeker)->from('/placements/1')->delete('/auth');
        
        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
