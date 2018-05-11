<?php

namespace App\Listeners;

use App\Events\ArticleDeleted;
use App\RealWorld\Video\VideoHelperInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteArticleVideo
{
    /**
     * @var VideoHelperInterface
     */
    private $videoHelper;

    /**
     * Create the event listener.
     *
     * @param VideoHelperInterface $videoHelper
     */
    public function __construct(VideoHelperInterface $videoHelper)
    {
        $this->videoHelper = $videoHelper;
    }

    /**
     * Handle the event.
     *
     * @param  ArticleDeleted  $event
     * @return void
     */
    public function handle(ArticleDeleted $event)
    {
        // delete article video if exists
        if ($event->article->video()->exists()) {
            $this->videoHelper->deleteVideo($event->article->video);
        }
    }
}
