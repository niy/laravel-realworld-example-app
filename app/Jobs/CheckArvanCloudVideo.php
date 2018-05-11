<?php

namespace App\Jobs;

use App\RealWorld\Video\VideoHelperInterface;
use App\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckArvanCloudVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @param VideoHelperInterface $videoHelper
     * @return void
     */
    public function handle(VideoHelperInterface $videoHelper)
    {
        $pendingVideos = Video::where('status', Video::UPLOAD_STATUS_UPLOADED);

        /**
         * @var Video $pendingVideo
         */
        foreach ($pendingVideos as $pendingVideo)
        {
            // retrieve and update video conversion status from storage server
            $videoResource = $videoHelper->getVideoInfo($pendingVideo->id);

            $conversionStatus = $videoResource->general_status->status_code;
            if ($conversionStatus === 'complete') {
                $pendingVideo->status = Video::UPLOAD_STATUS_CONVERTED;
                $pendingVideo->save();
            } else if ($videoResource->general_status->is_failed) {
                $pendingVideo->status = Video::UPLOAD_STATUS_FAILED;
                $pendingVideo->save();
            }
        }

        /*
        $failedVideos = Video::where('status', Video::UPLOAD_STATUS_FAILED);
        foreach ($failedVideos as $failedVideo)
        {
            retry conversion
        }
        */
    }
}
