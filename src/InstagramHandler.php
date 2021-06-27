<?php
namespace AnyDownloader\InstagramDownloader;

use AnyDownloader\DownloadManager\Exception\NothingToExtractException;
use AnyDownloader\DownloadManager\Handler\BaseHandler;
use AnyDownloader\DownloadManager\Model\FetchedResource;
use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\InstagramDownloader\Model\InstagramFetchedResource;
use Goutte\Client;

final class InstagramHandler extends BaseHandler
{
    /**
     * @var string[]
     */
    protected $urlRegExPatterns = [
        '/(\/\/|www\.)instagram\.com\/p\/[a-zA-Z0-9]+/s'
    ];

    /**
     * @var Client
     */
    private $client;

    /**
     * RedGifsHandler constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param URL $url
     * @return InstagramFetchedResource
     * @throws NothingToExtractException
     */
    public function fetchResource(URL $url): FetchedResource
    {
        $crawler = $this->client->request('GET', $url->getValue());
        try {

        } catch (\Exception $exception) {
            throw new NothingToExtractException();
        }

        $resource = new InstagramFetchedResource($url);

        return $resource;
    }

}