<?php
/**
 * Created by PhpStorm.
 * User: mrnim
 * Date: 5/10/2018
 * Time: 3:00 PM
 */

namespace App\RealWorld\Video;


use App\Article;
use App\Jobs\ProcessVideo;
use App\RealWorld\Video\Storage\StorageInterface;
use App\Video;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VideoHelper implements VideoHelperInterface
{
    const TEMP_VIDEOS_PATH = 'tempVideos';

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * VideoHelper constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function scheduleVideoUpload(Article $article, UploadedFile $video)
    {
        // move video to temp folder
        $videoFilePath = $video->store(self::TEMP_VIDEOS_PATH);

        // queue upload to the main storage
        ProcessVideo::dispatch($article, $videoFilePath);
    }

    public function uploadToStorage(Article $article, $tempFilePath)
    {
        try {
            // read the file from temp folder
            $filePath = Storage::disk('local')->path($tempFilePath);
            $file = new \Illuminate\Http\File($filePath, true);

            // upload to storage
            $uploadOptions = [
                'file_name' => $file->getBasename('.'.$file->getExtension()),
                'title' => $article->slug
            ];
            /**
             * @var Video $video
             */
            $video = $this->storage->upload($file, $uploadOptions);

            // remove previously uploaded video from storage
            if ($article->video()->exists()) {
                $this->storage->delete($article->video->id);
            }

            // fill database with info returned from storage
            $article->video()->save($video);

            // remove temporary file
            Storage::disk('local')->delete($tempFilePath);

        } catch (FileNotFoundException $e) {
            // log
        }
    }

    public function getVideoInfo(Video $video)
    {
        $this->storage->get($video->id);
    }

    public function deleteVideo(Video $video)
    {
        $this->storage->delete($video->id);
    }
}