<?php
namespace AnyDownloader\InstagramDownloader;

use AnyDownloader\DownloadManager\Exception\NothingToExtractException;
use AnyDownloader\DownloadManager\Exception\NotValidUrlException;
use AnyDownloader\DownloadManager\Handler\BaseHandler;
use AnyDownloader\DownloadManager\Model\Attribute\AuthorAttribute;
use AnyDownloader\DownloadManager\Model\Attribute\HashtagsAttribute;
use AnyDownloader\DownloadManager\Model\Attribute\IdAttribute;
use AnyDownloader\DownloadManager\Model\Attribute\TextAttribute;
use AnyDownloader\DownloadManager\Model\FetchedResource;
use AnyDownloader\DownloadManager\Model\ResourceItem;
use AnyDownloader\DownloadManager\Model\ResourceItem\ResourceItemFactory;
use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\InstagramDownloader\Model\InstagramFetchedResource;
use Goutte\Client;

final class InstagramHandler extends BaseHandler
{
    /**
     * @var string[]
     */
    protected $urlRegExPatterns = [
        '/(\/\/|www\.)instagram\.com\/p\/[a-zA-Z0-9]+/'
    ];

    /**
     * @var Client
     */
    private $client;

    /**
     * InstagramHandler constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param URL $url
     * @return FetchedResource
     * @throws NothingToExtractException
     * @throws NotValidUrlException
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

        $instagramResource->setImagePreview(
            ResourceItemFactory::fromURL(
                URL::fromString($media->display_url)
            )
        );

        /** Instagram carousel */
        if (isset($media->edge_sidecar_to_children) && is_array($media->edge_sidecar_to_children->edges)) {
            foreach($media->edge_sidecar_to_children->edges as $item) {
                $item = $item->node;
                $this->handleMedia($instagramResource, $item);
            }
        } else {
            $this->handleMedia($instagramResource, $media);
        }

        if ($media->owner) {
            try {
                $avatar = URL::fromString($media->owner->profile_pic_url);
            } catch (\Exception $exception) {
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
            $textAttr = new TextAttribute($media->edge_media_to_caption->edges[0]->node->text);
            $instagramResource->addAttribute($textAttr);
            $instagramResource->addAttribute(
                HashtagsAttribute::fromTextArray($textAttr->getValue())
            );
        }

        return $instagramResource;
    }

    /**
     * @param FetchedResource $instagramResource
     * @param $media
     * @throws NotValidUrlException
     */
    private function handleMedia(FetchedResource $instagramResource, $media)
    {
        if ($media->is_video == 1) {
            if ($video = ResourceItemFactory::fromURL(URL::fromString($media->video_url))) {
                $instagramResource->setVideoPreview($video);
                $instagramResource->addItem($video);
            }
            return;
        }

        if (!isset($media->display_resources)) {
            return;
        }

        // extract only high quality media items (usually, the latest array element)
        $resource = end($media->display_resources);
        $item = ResourceItemFactory::fromURL(URL::fromString($resource->src),
            $resource->config_width . 'x' . $resource->config_height
        );
        if ($item) {
            $instagramResource->addItem($item);
        }
    }

}