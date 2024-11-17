<?php

namespace Tests\Feature;

use App\Models\Employer;
use App\Models\User;
use App\Models\Placement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlacementTest extends TestCase
{
    use RefreshDatabase;
    
    private User $jobSeeker;
    private User $employerUser1;
    private User $employerUser2;
    private string $password;

    private string $jobSeekerName;
    private string $jobSeekerEmail;

    private string $employerUser1Name;
    private string $employerUser1Email;
    private string $employerUser1Company;
    private int $placements1Num;

    private string $employerUser2Name;
    private string $employerUser2Email;
    private int $placements2Num;
    private string $placement2Title;
    private string $placement2Desc;

    protected function setUp(): void
    {
        parent::setUp();
        $jobSeekerName = 'Nurul Azizah';
        $jobSeekerEmail = 'nuruaizaa_pmrfi@mailsac.com';
        $employerUser1Name = 'Test Employer 1';
        $employerUser1Email = 'test.employer01@mailsac.com';
        $employerUser1Company = 'Test Company 1';
        $placements1Num = 5;
        $employerUser2Name = 'Test Employer 2';
        $employerUser2Email = 'test.employer02@mailsac.com';
        $placements2Num = 10; // including Placements with custom title and desc
        $placement2Title = 'Test Placement Title';
        $placement2Desc = 'Insert test description here.';
        $this->password = 'password';


        $this->jobSeeker = User::factory()->create([
            'name' => $jobSeekerName,
            'email' => $jobSeekerEmail
        ]);
        $this->jobSeekerName = $jobSeekerName;
        $this->jobSeekerEmail = $jobSeekerEmail;


        $employerUser1 = User::factory()->create([
            'name' => $employerUser1Name,
            'email' => $employerUser1Email
        ]);
        $employer1 = Employer::factory()->create([
            'company_name' => $employerUser1Company,
            'user_id' => $employerUser1->id,
        ]);
        Placement::factory($placements1Num)->create([
            'employer_id' => $employer1->id
        ]);
        $this->employerUser1Name = $employerUser1Name;
        $this->employerUser1Email = $employerUser1Email;
        $this->employerUser1 = $employerUser1;
        $this->employerUser1Company = $employerUser1Company;
        $this->placements1Num = $placements1Num;

        $employerUser2 = User::factory()->create([
            'name' => $employerUser2Name,
            'email' => $employerUser2Email
        ]);
        $employer2 = Employer::factory()->create([
            'user_id' => $employerUser2->id,
        ]);
        Placement::factory()->create([
            'title' => $placement2Title,
            'employer_id' => $employer2->id
        ]);
        Placement::factory()->create([
            'description' => $placement2Desc,
            'employer_id' => $employer2->id
        ]);
        Placement::factory($placements2Num-2)->create([
            'employer_id' => $employer2->id
        ]);
        $this->employerUser2Name = $employerUser2Name;
        $this->employerUser2Email = $employerUser2Email;
        $this->employerUser2 = $employerUser2;
        $this->placements2Num = $placements2Num;
        $this->$placement2Title = $placement2Title;
        $this->$placement2Desc = $placement2Desc;        
    }

    public function test_homepage_redirects_to_placement_index(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('placements');
    }

    public function test_placement_index_has_search_filter(): void
    {
        $response = $this->get('/placements');

        $response->assertStatus(200);
        $response->assertSee('Search');
        $response->assertSee('Filter');
    }

    public function test_placement_index_contains_non_empty_table(): void
    {
        $placement = Placement::with('employer')->latest()->first();

        $response = $this->get('/placements');

        $response->assertStatus(200);
        $response->assertViewHas('placements', function ($collection) use ($placement) {
            return $collection->contains($placement);
        });
    }

    // Testing Filter //

    // public function test_placement_index_can_filter_by_placement_title(): void 
    // {

    // }

    // public function test_placement_index_can_filter_by_placement_description(): void 
    // {

    // }

    // public function test_placement_index_can_filter_by_placement_salary(): void 
    // {

    // }

    // public function test_placement_index_can_filter_by_placement_experience(): void 
    // {

    // }

    // public function test_placement_index_can_filter_by_placement_category(): void 
    // {

    // }

    // public function test_placement_index_can_filter_by_employer(): void 
    // {

    // }
}
