<?php
namespace AnyDownloader\InstagramDownloader\Model;

use AnyDownloader\DownloadManager\Model\FetchedResource;

final class InstagramFetchedResource extends FetchedResource
{
    /**
     * @return string
     */
    public function getExtSource(): string
    {
        return 'instagram';
    }
}

