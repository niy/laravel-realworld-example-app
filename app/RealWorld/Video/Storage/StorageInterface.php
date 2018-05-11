<?php
/**
 * Created by PhpStorm.
 * User: mrnim
 * Date: 5/10/2018
 * Time: 10:44 AM
 */

namespace App\RealWorld\Video\Storage;


use App\Video;
use Illuminate\Http\File;

interface StorageInterface
{
    /**
     * Uploads a file to the storage
     *
     * @param File $file
     *
     * @param array $options
     * @return Video Created video information
     */
    public function upload(File $file, $options = array());

    /**
     * Gets an uploaded file's information
     *
     * @param string $fileId
     *
     * @return array Uploaded File info (such as id, url, name, etc.)
     */
    public function get($fileId);

    /**
     * Deletes an uploaded file from storage
     *
     * @param string $fileId
     *
     * @return bool True on success and False on failure
     */
    public function delete($fileId);
}