<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListVideoRequest;
use App\Http\Requests\IncrementVideoRequest;
use App\Http\Resources\VideoResource;
use App\Services\Interfaces\VideoServiceInterface;
use App\Exceptions\VideoNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VideoController extends Controller
{
    public function __construct(
        private readonly VideoServiceInterface $videoService
    ) {}

    public function index(ListVideoRequest $request): ResourceCollection
    {
        $videos = $this->videoService->listVideos(
            $request->only(['title_contains', 'category', 'sort', 'order']),
            $request->only(['_per_page', '_page'])
        );

        return VideoResource::collection($videos);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $video = $this->videoService->getVideo($id);
            return response()->json(['data' => new VideoResource($video)]);
        } catch (VideoNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function increment(int $id, string $field): JsonResponse
    {
        try {
            $video = $this->videoService->incrementField($id, $field);
            return response()->json(['data' => new VideoResource($video)]);
        } catch (VideoNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}