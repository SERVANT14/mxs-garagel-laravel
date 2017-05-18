<?php

namespace Tests\Feature;

use App\Services\Tracks\Models\Track;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FindTracks extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    function user_can_get_a_paginated_list_of_tracks()
    {
        // Arrange
        $track = factory(Track::class)->create();

        // Execute
        $response = $this->getJson('api/tracks');

        // Check
        $response->assertJsonFragment(['name' => $track->name]);
        $response->assertJsonStructure(['current_page', 'data', 'total', 'next_page_url', 'per_page']);
    }

    /** @test */
    function user_can_filter_track_list_by_name()
    {
        // Arrange
        $track = factory(Track::class)->create([
            'name' => 'Cypress Hollows',
        ]);

        // Execute
        $response = $this->getJson('api/tracks?name=press');
        $responseCaseSensitivity = $this->getJson('api/tracks?name=cypres');

        // Check
        $response->assertJsonFragment(['name' => $track->name]);
        $responseCaseSensitivity->assertJsonFragment(['name' => $track->name]);
    }

    /** @test */
    function user_can_filter_track_list_by_category()
    {
        // Arrange
        $track = factory(Track::class)->create();

        // Execute
        $response = $this->getJson('api/tracks?category_id=' . $track->category->getKey());

        // Check
        $response->assertJsonFragment(['name' => $track->name]);
    }

    /** @test */
    function user_can_filter_track_list_by_creator()
    {
        // Arrange
        $track = factory(Track::class)->create();

        // Execute
        $response = $this->getJson('api/tracks?creator_id=' . $track->creator->getKey());

        // Check
        $response->assertJsonFragment(['name' => $track->name]);
    }

    /** @test */
    function user_can_filter_track_list_by_all_criteria_available()
    {
        // Arrange
        $track = factory(Track::class)->create(['name' => 'just a test']);

        // Execute
        $response = $this->getJson('api/tracks' .
            '?name=just' .
            '&creator_id=' . $track->creator->getKey() .
            '&category_id=' . $track->creator->getKey()
        );

        // Check
        $response->assertJsonFragment(['name' => $track->name]);
    }

    /** @test */
    function user_can_view_a_track()
    {
        // Arrange
        $track = factory(Track::class)->create();

        // Execute
        $response = $this->getJson('api/tracks/' . $track->getKey());

        // Check
        $response->assertJsonFragment(['name' => $track->name]);
        $response->assertJsonStructure([
            'download_links',
            'description',
            'creator' => 'name',
            'category' => 'name',
        ]);
    }
}
