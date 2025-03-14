<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListVideoRequest;
use App\Http\Resources\VideoResource;
use App\Services\Interfaces\VideoServiceInterface;
use App\Exceptions\VideoNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function __construct(
        private readonly VideoServiceInterface $videoService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = Video::query();

        // Aplicar filtros
        if ($request->has('title_contains')) {
            $query->where('title', 'like', '%' . $request->title_contains . '%');
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Aplicar paginação
        $perPage = $request->_per_page ?? 10;
        $page = $request->_page ?? 1;

        $videos = $query->paginate($perPage, ['*'], '_page', $page);

        return response()->json($videos);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $video = $this->videoService->getVideo($id);
            $video = $this->videoService->incrementViews($video);
            
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