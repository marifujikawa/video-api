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
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'thumbnail', 'views', 'likes']
                ],
                'meta' => ['current_page', 'total']
            ]);
    }

    public function test_can_get_video_details(): void
    {
        $video = Video::factory()->create(['views' => 0]);

        $response = $this->getJson("/api/videos/{$video->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'description', 'thumbnail', 'views', 'likes']
            ]);
    }

    public function test_can_increment_video_views(): void
    {
        $video = Video::factory()->create(['views' => 0]);

        $response = $this->patchJson("/api/videos/{$video->id}/increment/views");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'description', 'thumbnail', 'views', 'likes']
            ]);
        $this->assertEquals(1, $video->fresh()->views);
    }

    public function test_can_increment_video_likes(): void
    {
        $video = Video::factory()->create(['likes' => 0]);

        $response = $this->patchJson("/api/videos/{$video->id}/increment/likes");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'description', 'thumbnail', 'views', 'likes']
            ]);
        $this->assertEquals(1, $video->fresh()->likes);
    }

    public function test_cannot_increment_invalid_field(): void
    {
        $video = Video::factory()->create();

        $response = $this->patchJson("/api/videos/{$video->id}/increment/invalid");

        $response->assertStatus(404);
    }

}