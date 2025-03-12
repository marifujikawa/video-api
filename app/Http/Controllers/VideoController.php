<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
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
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function update(UpdateVideoRequest $request, int $id): JsonResponse
    {
        try {
            $video = $this->videoService->updateVideo($id, $request->validated());
            return $this->successResponse($video);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Video not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function incrementLikes(int $id): JsonResponse
    {
        try {
            $video = $this->videoService->incrementLikes($id);
            return $this->successResponse($video);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Video not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    private function successResponse($data, array $meta = []): JsonResponse
    {
        $response = ['data' => $data];
        if (!empty($meta)) {
            $response['meta'] = $meta;
        }
        return response()->json($response);
    }

    private function errorResponse(string|array $message, int $status = 500): JsonResponse
    {
        return response()->json([
            'error' => $message
        ], $status);
    }
}