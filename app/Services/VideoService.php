<?php

namespace App\Services;

use App\Models\Video;
use App\Services\Interfaces\VideoServiceInterface;
use App\Repositories\VideoRepositoryInterface;
use App\Exceptions\VideoNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class VideoService implements VideoServiceInterface
{
    public function __construct(
        private readonly VideoRepositoryInterface $repository
    ) {}

    public function listVideos(array $filters, array $pagination): LengthAwarePaginator
    {
        return $this->repository->findWithFilters($filters, $pagination);
    }

    public function getVideo(int $id): Video
    {
        $video = $this->repository->findById($id);
        
        if (!$video) {
            throw new VideoNotFoundException("Video with ID {$id} not found");
        }

        return $video;
    }

    public function incrementField(int $id, string $field): Video
    {
        $video = $this->repository->findById($id);
        
        if (!$video) {
            throw new VideoNotFoundException("Video with ID {$id} not found");
        }

        return $this->repository->incrementField($video, $field);
    }
}
