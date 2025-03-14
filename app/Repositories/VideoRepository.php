<?php

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class VideoRepository implements VideoRepositoryInterface
{
    public function find(): Collection
    {
        return Cache::remember('videos:all', 60 * 5, function () {
            return Video::all();
        });
    }

    public function findById(int $id): ?Video
    {
        return Cache::remember("video:{$id}", 60 * 5, function () use ($id) {
            return Video::find($id);
        });
    }

    public function update(Video $video, array $data): Video
    {
        $video->update($data);
        Cache::forget("video:{$video->id}");
        return $video;
    }

    public function incrementField(Video $video, string $field, int $amount = 1): Video
    {
        $video->increment($field, $amount);
        Cache::forget("video:{$video->id}");
        return $video->fresh();
    }
}
