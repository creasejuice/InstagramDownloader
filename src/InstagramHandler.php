<?php
namespace AnyDownloader\InstagramDownloader;

use AnyDownloader\DownloadManager\Exception\NothingToExtractException;
use AnyDownloader\DownloadManager\Handler\BaseHandler;
use AnyDownloader\DownloadManager\Model\Attribute\AuthorAttribute;
use AnyDownloader\DownloadManager\Model\Attribute\IdAttribute;
use AnyDownloader\DownloadManager\Model\Attribute\TextAttribute;
use AnyDownloader\DownloadManager\Model\FetchedResource;
use AnyDownloader\DownloadManager\Model\ResourceItem\Image\JPGResourceItem;
use AnyDownloader\DownloadManager\Model\ResourceItem\Video\MP4ResourceItem;
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

        if (stripos($crawler->html(), 'window._sharedData = ') === false) {
            throw new NothingToExtractException();
        }

        $instagramResource = new InstagramFetchedResource($url);

        $sharedData = explode('window._sharedData = ', $crawler->html());
        $sharedData = explode("</script>", $sharedData[1]);
        $sharedData = json_decode(rtrim($sharedData[0], ';'));
        $media = $sharedData->entry_data->PostPage[0]->graphql->shortcode_media;

        $instagramResource->setImagePreview(JPGResourceItem::fromURL(URL::fromString($media->display_url)));

        if ($media->is_video == 1) {
            $video = MP4ResourceItem::fromURL(URL::fromString($media->video_url));
            $instagramResource->setVideoPreview($video);
            $instagramResource->addItem($video);
        } else {
            foreach($media->display_resources as $resource) {
                $instagramResource->addItem(
                    JPGResourceItem::fromURL(
                        URL::fromString($resource->src),
                        $resource->config_width . 'x' . $resource->config_height
                    )
                );
            }
        }

        if ($media->owner) {
            try {
                $avatar = URL::fromString($media->owner->profile_pic_url);
            } catch(\Exception $exception) {
                $avatar = null;
            }
            $instagramResource->addAttribute(
                new AuthorAttribute(
                    $media->owner->id,
                    $media->owner->username,
                    $media->owner->full_name,
                    $avatar
                )
            );
        }

        $instagramResource->addAttribute(new IdAttribute($media->id));
        if ($media->edge_media_to_caption && count($media->edge_media_to_caption->edges)) {
            $instagramResource->addAttribute(
                new TextAttribute($media->edge_media_to_caption->edges[0]->node->text)
            );
        }

        return $instagramResource;
    }

}