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
            
            try {
                Video::create([
                    'title' => $videoData->title ?? 'Sem título',
                    'description' => $videoData->description ?? '',
                    'url' => $videoData->hls_path ?? '',
                    'thumbnail' => $videoData->thumbnail ?? 'https://example.com/thumbnail.jpg',
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