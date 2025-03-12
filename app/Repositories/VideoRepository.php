<?php

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class VideoRepository implements VideoRepositoryInterface
{
    public function findWithFilters(array $filters, array $pagination): LengthAwarePaginator
    {
        $cacheKey = 'videos:' . md5(json_encode($filters) . json_encode($pagination));
        
        return Cache::remember($cacheKey, 60 * 5, function () use ($filters, $pagination) {
            $query = Video::query();

            if (isset($filters['title_contains'])) {
                $query->where('title', 'like', '%' . $filters['title_contains'] . '%');
            }

            if (isset($filters['category'])) {
                $query->where('category', $filters['category']);
            }

            if (isset($filters['sort'])) {
                $query->orderBy($filters['sort'], $filters['order'] ?? 'desc');
            }

            return $query->paginate(
                $pagination['per_page'] ?? 10,
                ['*'],
                '_page',
                $pagination['page'] ?? 1
            );
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
