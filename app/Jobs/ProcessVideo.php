<?php

namespace App\Jobs;

use App\Article;
use App\RealWorld\Video\VideoHelperInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Article
     */
    private $article;

    /**
     * @var string
     */
    private $videoFilePath;

    /**
     * Create a new job instance.
     *
     * @param Article $article
     * @param string $videoFilePath
     */
    public function __construct(Article $article, $videoFilePath)
    {
        $this->article = $article;
        $this->videoFilePath = $videoFilePath;
    }

    /**
     * Execute the job.
     *
     * @param VideoHelperInterface $videoHelper
     * @return void
     */
    public function handle(VideoHelperInterface $videoHelper)
    {
        $videoHelper->uploadToStorage($this->article, $this->videoFilePath);
    }
}
