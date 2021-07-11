<?php
namespace AnyDownloader\InstagramDownloader\Test;

use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\InstagramDownloader\Model\InstagramFetchedResource;
use AnyDownloader\InstagramDownloader\InstagramHandler;
use AnyDownloader\InstagramDownloader\Test\Mock\HttpClientMock;
use Goutte\Client;
use PHPUnit\Framework\TestCase;

class InstagramHandlerParserTest extends TestCase
{
    /** @test */
    public function handler_parses_page_correctly_and_returns_resource_model()
    {
        $url = URL::fromString('https://www.instagram.com/p/CQmlIsWDdKh/');

        $handler = new InstagramHandler(new Client(new HttpClientMock()));

        $res = $handler->fetchResource($url);

        $this->assertInstanceOf(InstagramFetchedResource::class, $res);

        $this->assertEquals([
            'source_url' => 'https://www.instagram.com/p/CQmlIsWDdKh/',
            'preview_image' => [
                'type' => 'image',
                'format' => 'jpg',
                'title' => '',
                'url' => 'https://instagram.fbkk5-3.fna.fbcdn.net/v/t51.2885-15/e35/208793833_197236692346254_2941739638331277075_n.jpg?tp=1&_nc_ht=instagram.fbkk5-3.fna.fbcdn.net&_nc_cat=1&_nc_ohc=DkHIM1i2cXwAX-teCO2&edm=AABBvjUBAAAA&ccb=7-4&oh=d8e6fc9575dc4e541a3570b37b1a7e6e&oe=60DAC0C9&_nc_sid=83d603',
                'mime_type' => 'image/jpg'
            ],
            'preview_video' => [
                'type' => 'video',
                'format' => 'mp4',
                'title' => '',
                'url' => 'https://instagram.fbkk5-4.fna.fbcdn.net/v/t50.2886-16/208293603_963789457782658_1292489345229422396_n.mp4?_nc_ht=instagram.fbkk5-4.fna.fbcdn.net&_nc_cat=110&_nc_ohc=2HRPftxAQe4AX_GHIqf&edm=AABBvjUBAAAA&ccb=7-4&oe=60DAAE6A&oh=c7d8d001fa9d09f4f29e8d6e54e31011&_nc_sid=83d603',
                'mime_type' => 'video/mp4'
            ],
            'attributes' => [
                'author' => [
                    'id' => '184692323',
                    'avatar_url' => 'https://instagram.fbkk5-3.fna.fbcdn.net/v/t51.2885-19/s150x150/194921896_794059374581630_4576885874575036174_n.jpg?tp=1&_nc_ht=instagram.fbkk5-3.fna.fbcdn.net&_nc_ohc=_DZ3X5MWU60AX8b0Ss2&edm=AABBvjUBAAAA&ccb=7-4&oh=4a03e2179ac8bf748e7430e9ee37e664&oe=60E0079A&_nc_sid=83d603',
                    'full_name' => 'Lady Gaga',
                    'nickname' => 'ladygaga',
                    'avatar' => [
                        'type' => 'image',
                        'format' => 'jpg',
                        'title' => '',
                        'url' => 'https://instagram.fbkk5-3.fna.fbcdn.net/v/t51.2885-19/s150x150/194921896_794059374581630_4576885874575036174_n.jpg?tp=1&_nc_ht=instagram.fbkk5-3.fna.fbcdn.net&_nc_ohc=_DZ3X5MWU60AX8b0Ss2&edm=AABBvjUBAAAA&ccb=7-4&oh=4a03e2179ac8bf748e7430e9ee37e664&oe=60E0079A&_nc_sid=83d603',
                        'mime_type' => 'image/jpg'
                    ]
                ],
                'id' => '2604932759571780257',
                'text' => '☀️#bekind even if it’s to yourself'
            ],
            'items' => [
                'video' => [[
                        'type' => 'video',
                        'format' => 'mp4',
                        'title' => '',
                        'url' => 'https://instagram.fbkk5-4.fna.fbcdn.net/v/t50.2886-16/208293603_963789457782658_1292489345229422396_n.mp4?_nc_ht=instagram.fbkk5-4.fna.fbcdn.net&_nc_cat=110&_nc_ohc=2HRPftxAQe4AX_GHIqf&edm=AABBvjUBAAAA&ccb=7-4&oe=60DAAE6A&oh=c7d8d001fa9d09f4f29e8d6e54e31011&_nc_sid=83d603',
                        'mime_type' => 'video/mp4'
                    ]
                ]
            ]
        ], $res->toArray());
    }
}