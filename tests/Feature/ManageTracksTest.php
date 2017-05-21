<?php

namespace Tests\Feature;

use App\Services\Tracks\Mail\TrackCreated;
use App\Services\Tracks\Mail\TrackDeleted;
use App\Services\Tracks\Mail\TrackEdited;
use App\Services\Tracks\Models\Track;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageTracksTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    function users_can_add_tracks()
    {
        // Arrange
        $trackToAdd = factory(Track::class)->make();
        $user = factory(User::class)->create();
        Auth::login($user);

        // Execute
        $response = $this->postJson('api/tracks', [
            'name' => $trackToAdd->name,
            'category_id' => $trackToAdd->category_id,
            'description' => $trackToAdd->description,
            'released_on' => $trackToAdd->released_on->format('Y-m-d'),
            'download_links' => json_decode($trackToAdd->download_links),
        ]);

        // Check
        $response->assertJsonStructure(['id']);
        $response->assertJsonFragment([
            'name' => $trackToAdd->name,
            'category_id' => $trackToAdd->category_id,
            'creator_id' => $user->getKey(),
        ]);
    }

    /** @test */
    function users_can_modify_tracks()
    {
        // Arrange
        $user = factory(User::class)->create();
        Auth::login($user);
        $track = factory(Track::class)->create([
            'name' => 'Original Name',
            'description' => 'Original Description',
            'creator_id' => $user->getKey(),
        ]);

        // Execute
        $response = $this->putJson('api/tracks/' . $track->getKey(), [
                'name' => 'New Name',
                'description' => 'New Description',
                'download_links' => json_decode($track->download_links),
                'released_on' => $track->released_on->format('Y-m-d'),
            ] + $track->toArray());

        // Check
        $response->assertJsonFragment([
            'name' => 'New Name',
            'description' => 'New Description',
        ]);
    }

    /** @test */
    function users_can_delete_tracks()
    {
        // Arrange
        $user = factory(User::class)->create();
        Auth::login($user);
        $track = factory(Track::class)->create(['creator_id' => $user->getKey()]);

        // Execute
        $response = $this->deleteJson('api/tracks/' . $track->getKey());

        // Check
        $response->assertExactJson(['deleted' => true]);
    }

    /** @test */
    function anonymous_users_cannot_delete_tracks()
    {
        // Arrange
        $track = factory(Track::class)->create();

        // Execute
        $response = $this->putJson('api/tracks/' . $track->getKey(), [
                'download_links' => json_decode($track->download_links),
                'released_on' => $track->released_on->format('Y-m-d'),
            ] + $track->toArray());

        // Check
        $response->assertStatus(403);
    }

    /** @test */
    function non_admin_users_cannot_provide_a_creator_id_when_adding_tracks()
    {
        // Arrange
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        Auth::login($user);
        $trackToAdd = factory(Track::class)->make([
            'creator_id' => $user->getKey(),
        ]);

        // Execute
        $response = $this->postJson('api/tracks', [
                'creator_id' => $otherUser->getKey(),
                'released_on' => $trackToAdd->released_on->format('Y-m-d'),
                'download_links' => json_decode($trackToAdd->download_links),
            ] + $trackToAdd->toArray());

        // Check
        $response->assertJsonFragment(['creator_id' => $user->getKey()]); // ignored provided id.
    }

    /** @test */
    function admin_users_can_provide_a_creator_id_when_adding_tracks()
    {
        // Arrange
        $user = factory(User::class)->states('admin')->create();
        $otherUser = factory(User::class)->create();
        Auth::login($user);
        $trackToAdd = factory(Track::class)->make(['creator_id' => $user->getKey()]);

        // Execute
        $response = $this->postJson('api/tracks', [
                'creator_id' => $otherUser->getKey(),
                'released_on' => $trackToAdd->released_on->format('Y-m-d'),
                'download_links' => json_decode($trackToAdd->download_links),
            ] + $trackToAdd->toArray());

        // Check
        $response->assertJsonFragment(['creator_id' => $otherUser->getKey()]);
    }

    /** @test */
    function users_can_only_modify_their_own_tracks()
    {
        // Arrange
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        Auth::login($user);
        $track = factory(Track::class)->create([
            'creator_id' => $otherUser->getKey(),
        ]);

        // Execute
        $response = $this->putJson('api/tracks/' . $track->getKey(), [
                'download_links' => json_decode($track->download_links),
                'released_on' => $track->released_on->format('Y-m-d'),
            ] + $track->toArray());

        // Check
        $response->assertStatus(403);
    }

    /** @test */
    function users_can_only_delete_their_own_tracks()
    {
        // Arrange
        $track = factory(Track::class)->create();

        // Execute
        $response = $this->putJson('api/tracks/' . $track->getKey(), [
                'download_links' => json_decode($track->download_links),
                'released_on' => $track->released_on->format('Y-m-d'),
            ] + $track->toArray());

        // Check
        $response->assertStatus(403);
    }

    /** @test */
    function email_sent_to_admins_when_track_is_added()
    {
        // Arrange
        Mail::fake();
        factory(User::class)->states('admin')->create();
        $user = factory(User::class)->create();

        // Execute
        factory(Track::class)->create();

        // Check
        Mail::assertSent(TrackCreated::class, function ($mail) use ($user) {
            return (
                !$mail->hasTo($user->email) &&
                User::areAdmins()->get()->reduce(function ($carry, $admin) use ($mail) {
                    return ($carry !== false && $mail->hasTo($admin->email));
                })
            );
        });
    }

    /** @test */
    function email_sent_to_admins_when_track_is_edited()
    {
        // Arrange
        Mail::fake();
        factory(User::class)->states('admin')->create();
        $user = factory(User::class)->create();

        // Execute
        $track = factory(Track::class)->create();
        $track->name .= 'test';
        $track->save();

        // Check
        Mail::assertSent(TrackEdited::class, function ($mail) use ($user) {
            return (
                !$mail->hasTo($user->email) &&
                User::areAdmins()->get()->reduce(function ($carry, $admin) use ($mail) {
                    return ($carry !== false && $mail->hasTo($admin->email));
                })
            );
        });
    }

    /** @test */
    function email_sent_to_admins_when_track_is_deleted()
    {
        // Arrange
        Mail::fake();
        factory(User::class)->states('admin')->create();
        $user = factory(User::class)->create();

        // Execute
        $track = factory(Track::class)->create();
        $track->delete();

        // Check
        Mail::assertSent(TrackDeleted::class, function ($mail) use ($user) {
            return (
                !$mail->hasTo($user->email) &&
                User::areAdmins()->get()->reduce(function ($carry, $admin) use ($mail) {
                    return ($carry !== false && $mail->hasTo($admin->email));
                })
            );
        });
    }
}
