<?php

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Support\Collection;

interface VideoRepositoryInterface
{
    public function find(): Collection;
    public function findById(int $id): ?Video;
    public function update(Video $video, array $data): Video;
    public function incrementField(Video $video, string $field, int $amount = 1): Video;
}
