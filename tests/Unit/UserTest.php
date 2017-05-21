<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function tells_us_if_user_is_an_administrator()
    {
        // Arrange
        $user = factory(User::class)->make();
        $adminUser = factory(User::class)->states('admin')->make();

        // Execute and Check
        $this->assertFalse($user->isAdmin());
        $this->assertTrue($adminUser->isAdmin());
    }

    /** @test */
    function provides_a_list_of_all_admin_users()
    {
        // Arrange
        $user = factory(User::class)->create();
        $adminUserOne = factory(User::class)->states('admin')->create();
        $adminUserTwo = factory(User::class)->states('admin')->create();

        // Execute
        $admins = User::areAdmins()->get();

        // Check
        $this->assertNotContains($user->getKey(), $admins->pluck('id'));
        $this->assertContains($adminUserOne->getKey(), $admins->pluck('id'));
        $this->assertContains($adminUserTwo->getKey(), $admins->pluck('id'));
    }
}
