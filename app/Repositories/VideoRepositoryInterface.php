<?php

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Pagination\LengthAwarePaginator;

interface VideoRepositoryInterface
{
    public function findWithFilters(array $filters, array $pagination): LengthAwarePaginator;
    public function findById(int $id): ?Video;
    public function update(Video $video, array $data): Video;
    public function incrementField(Video $video, string $field, int $amount = 1): Video;
}
