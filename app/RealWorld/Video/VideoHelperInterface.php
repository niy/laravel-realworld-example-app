<?php
/**
 * Created by PhpStorm.
 * User: mrnim
 * Date: 5/10/2018
 * Time: 10:19 PM
 */

namespace App\RealWorld\Video;


use App\Article;
use App\RealWorld\Video\Storage\StorageInterface;
use App\Video;
use Illuminate\Http\UploadedFile;

interface VideoHelperInterface
{
    /**
     * VideoHelperInterface constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage);

    /**
     * @param Article $article
     * @param UploadedFile $video
     */
    public function scheduleVideoUpload(Article $article, UploadedFile $video);

    /**
     * @param Article $article
     * @param $tempFilePath
     */
    public function uploadToStorage(Article $article, $tempFilePath);

    /**
     * @param Video $video
     */
    public function getVideoInfo(Video $video);

    /**
     * @param Video $video
     */
    public function deleteVideo(Video $video);
}