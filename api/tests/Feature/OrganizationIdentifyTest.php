<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Yaml\Yaml;
use Tests\TestCase;

/**
 * Class OrganizationIdentifyTest
 * @package Tests\Feature
 * @group organizationIdentify
 */
class OrganizationIdentifyTest extends TestCase
{
    public function testNoOrganizationProvided()
    {
        $response = $this->get('/');
        $response
            ->assertStatus(200)
            ->assertJson([
                'organization' => null
            ]);
    }

    public function testInvalidOrganizationProvided()
    {

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Invalid organization');

        $response = $this->get('/', ['X-Wflow-Organization' => 123454789]);
        $response
            ->assertStatus(404)
            ->assertJson([]); // force the exception
    }

    public function testLoggedUserNotAMember()
    {

        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage('The user is not a member of this organization.');


        // find Freddie Mercury
        /** @var User $user */
        $user = User::where('email', 'freddiemercury@gmail.com')->first();
        $badCompanyId = 3;

        $response = $this->actingAs($user, 'api')->get('/', ['X-Wflow-Organization' => $badCompanyId]);

        // Freddie mercury is not member of Bad Company, so get a 403 (forbidden)
        $response
            ->assertStatus(403)
            ->assertJson([]); // force the exception
    }

    /**
     * Test a logged user trying to access his current organization
     */
    public function testLoggedUser()
    {
        // find Freddie Mercury
        /** @var User $user */
        $user = User::where('email', 'freddiemercury@gmail.com')->first();
        $queenId = 1;

        $response = $this->actingAs($user, 'api')->get('/', ['X-Wflow-Organization' => $queenId]);

        // Freddie mercury is a member of Queen, so get a 200
        $response
            ->assertStatus(200)
            ->assertJson([
                'organization' => [
                    'id' => 1
                ]
            ]);
    }

    public function testOrganizationRequired()
    {

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Organization is required');

        // try to get the organization settings without passing an organization header
        $response = $this->get('/current-organization/settings');
        $response
            ->assertStatus(400)
            ->assertJson([]); //force the exeception
    }

}
