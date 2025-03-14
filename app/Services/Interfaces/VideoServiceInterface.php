<?php

namespace App\Services\Interfaces;

use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;

interface VideoServiceInterface
{
    public function listVideos(): Collection;
    public function getVideo(int $id): Video;
    public function incrementField(int $id, string $field): Video;
}
