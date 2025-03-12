<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        // Caminho para o arquivo db.json
        $json = File::get(database_path('data/db.json'));
        $data = json_decode($json);

        // Verifica se a estrutura do JSON tem a chave 'videos'
        $videos = $data->videos ?? $data;
        
        if (!is_array($videos) && !is_object($videos)) {
            $this->command->error('Estrutura do JSON inválida. Verifique o arquivo db.json');
            return;
        }

        foreach ($videos as $videoData) {
            // Imprime a estrutura do objeto para debug
            $this->command->info('Estrutura do objeto: ' . json_encode($videoData));
            
            // Tenta obter a URL do vídeo usando diferentes possíveis nomes de propriedade
            $url = $videoData->url ?? 
                  $videoData->video_url ?? 
                  $videoData->src ?? 
                  $videoData->source ?? 
                  $videoData->stream_url ?? 
                  'https://example.com/video.mp4'; // URL padrão se nenhuma propriedade for encontrada
            
            try {
                Video::create([
                    'title' => $videoData->title ?? 'Sem título',
                    'description' => $videoData->description ?? '',
                    'url' => $url,
                    'thumbnail' => $videoData->thumbnail ?? 
                                  $videoData->image ?? 
                                  $videoData->cover ?? 
                                  'https://example.com/thumbnail.jpg',
                    'category' => $videoData->category ?? 'Sem categoria',
                    'views' => $videoData->views ?? 0,
                    'likes' => $videoData->likes ?? 0,
                ]);
            } catch (\Exception $e) {
                $this->command->error('Erro ao inserir vídeo: ' . $e->getMessage());
                Log::error('Erro ao inserir vídeo: ' . $e->getMessage(), [
                    'video_data' => json_encode($videoData)
                ]);
            }
        }
    }
}