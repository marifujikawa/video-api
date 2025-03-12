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

        $this->repository->incrementField($video, 'views');
        return $video;
    }

    public function updateVideo(int $id, array $data): Video
    {
        $video = $this->repository->findById($id);
        
        if (!$video) {
            throw new VideoNotFoundException("Video with ID {$id} not found");
        }

        return $this->repository->update($video, $data);
    }

    public function incrementLikes(int $id): Video
    {
        $video = $this->repository->findById($id);
        
        if (!$video) {
            throw new VideoNotFoundException("Video with ID {$id} not found");
        }

        return $this->repository->incrementField($video, 'likes');
    }
}
