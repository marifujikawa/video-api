<?php

namespace Tests\Feature;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_videos(): void
    {
        Video::factory()->count(5)->create();

        $response = $this->getJson('/api/videos');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function test_can_filter_videos_by_title(): void
    {
        Video::factory()->create(['title' => 'Marketing Digital']);
        Video::factory()->create(['title' => 'Desenvolvimento Web']);

        $response = $this->getJson('/api/videos?title_contains=Marketing');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_get_video_details_and_increment_views(): void
    {
        $video = Video::factory()->create(['views' => 0]);

        $response = $this->getJson("/api/videos/{$video->id}");

        $response->assertStatus(200);
        $this->assertEquals(1, $video->fresh()->views);
    }

    public function test_can_update_video_likes(): void
    {
        $video = Video::factory()->create(['likes' => 0]);

        $response = $this->postJson("/api/videos/{$video->id}/like");

        $response->assertStatus(200);
        $this->assertEquals(1, $video->fresh()->likes);
    }
}