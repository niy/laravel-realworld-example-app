<?php
/**
 * Created by PhpStorm.
 * User: mrnim
 * Date: 5/5/2018
 * Time: 4:48 PM
 */

namespace App\ArvanCloud;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\File;

class VideoApiClient implements VideoApiClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * VideoApiClient constructor.
     */
    public function __construct()
    {
        $this->client = ArvanCloudClient::create();
    }

    /**
     * @inheritdoc
     */
    public function insertVideoFile(File $file)
    {
        $apiEndpointUrl = self::VIDEO_BASE_URL . 'files/video';

        try {
            $response = $this->client->request('POST', $apiEndpointUrl, [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => file_get_contents($file->getRealPath()),
                        'filename' => $file->getFilename()
                    ]
                ]
            ]);
            $responseData = json_decode($response->getBody()->getContents())->data;
            return $responseData;
        } catch (GuzzleException $e) {
            // log failure
            // @TODO: replace dd with logger
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function insertVideo($fileId, $options)
    {
        $apiEndpointUrl = self::VIDEO_BASE_URL . 'videos';

        try {
            $options['file_id'] = $fileId;

            $response = $this->client->request('POST', $apiEndpointUrl, [
                'form_params' => $options
            ]);
            $responseData = json_decode($response->getBody()->getContents())->data;
            return $responseData;
        } catch (GuzzleException $e) {
            // log failure
            // @TODO: replace dd with logger
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function getOneVideoById($id)
    {
        $apiEndpointUrl = self::VIDEO_BASE_URL . 'videos/' . $id;

        try {
            $response = $this->client->request('GET', $apiEndpointUrl);
            $responseData = json_decode($response->getBody()->getContents())->data;
            return $responseData;
        } catch (GuzzleException $e) {
            // log failure
            // @TODO: replace dd with logger
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function delete($id)
    {
        $apiEndpointUrl = self::VIDEO_BASE_URL . 'videos/' . $id;

        try {
            $this->client->request('DELETE', $apiEndpointUrl);
            return true;
        } catch (GuzzleException $e) {
            // log failure
            // @TODO: replace dd with logger
            dd($e->getMessage());
            return false;
        }
    }
}