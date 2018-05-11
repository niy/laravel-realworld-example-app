<?php
/**
 * Created by PhpStorm.
 * User: mrnim
 * Date: 5/11/2018
 * Time: 11:54 AM
 */

namespace App\ArvanCloud;


use Illuminate\Http\File;

interface VideoApiClientInterface
{
    const VIDEO_BASE_URL = 'video/1.0/';

    /**
     * @param File $file
     * @return \stdClass|bool
     */
    public function insertVideoFile(File $file);

    /**
     * @param string $fileId
     * @param array $options
     * @return \stdClass|bool
     */
    public function insertVideo($fileId, $options);

    /**
     * @param $id
     * @return \stdClass|bool
     */
    public function getOneVideoById($id);

    /**
     * @param $id
     * @return bool
     */
    public function delete($id);
}