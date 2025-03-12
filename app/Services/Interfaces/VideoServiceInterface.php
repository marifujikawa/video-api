<?php

namespace App\Services\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Video;

interface VideoServiceInterface
{
    public function listVideos(array $filters, array $pagination): LengthAwarePaginator;
    public function getVideo(int $id): Video;
    public function updateVideo(int $id, array $data): Video;
    public function incrementLikes(int $id): Video;
}
