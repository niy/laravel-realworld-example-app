<?php
/**
 * Created by PhpStorm.
 * User: mrnim
 * Date: 5/10/2018
 * Time: 10:47 AM
 */

namespace App\RealWorld\Video\Storage;


use App\ArvanCloud\VideoApiClient;
use App\ArvanCloud\VideoApiClientInterface;
use App\Video;
use Illuminate\Http\File;

class ArvanCloudStorage implements StorageInterface
{
    const DEFAULT_OPTIONS = [
        'channel' => '5b02bf49-c5db-4579-8db3-c1f1f55626af',
        'title' => '',
        'url' => '',
        'file_name' => '',
        'tag' => '',
        'video_ss' => '00:00:00',
        'encode' => 0,
        'convert_speed' => 'ultrafast',
        'convert_file' => [
            [
                'resolution' => '256x144',
                'video_bitrate' => '64000',
                'audio_bitrate' => '96000',
                'output_type' => 'hls'
            ],
            [
                'resolution' => '854x480',
                'video_bitrate' => '300000',
                'audio_bitrate' => '128000',
                'output_type' => 'hls'
            ]
        ]
    ];
    /**
     * @var VideoApiClientInterface $client
     */
    private $client;

    /**
     * ArvanCloudStorage constructor.
     */
    public function __construct()
    {
        $this->client = new VideoApiClient();
    }

    /**
     * @inheritdoc
     */
    public function upload(File $file, $options = array())
    {
        // upload base file
        $baseFile = $this->client->insertVideoFile($file);

        // convert to desired formats

        $options = array_replace_recursive(
            self::DEFAULT_OPTIONS,
            $options
        );

        $videoResource = $this->client->insertVideo(
            $baseFile->id,
            $options
        );

        // return Video object with filled data
        $video = new Video([
            'id' => $videoResource->id,
            'url' => $videoResource->sources[0]->file,
            'thumbnail_url' => $videoResource->thumbnail->large
        ]);
        return $video;
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        return $this->client->getOneVideoById($id);
    }

    /**
     * @inheritdoc
     */
    public function delete($id)
    {
        return $this->client->delete($id);
    }
}