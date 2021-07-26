# InstagramDownloader
Get video & image sources from Instagram

Install via Composer
```
composer require any-downloader/instagram-downloader
```

You have two options of how to use this package

1. Use it standalone

```php
<?php
use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\InstagramDownloader\InstagramHandler;
use Goutte\Client;

include_once 'vendor/autoload.php';

$instagramPostUrl = URL::fromString('https://www.instagram.com/p/CPymPNfBvnM/');
$instagramHandler = new InstagramHandler(new Client());
$result = $instagramHandler->fetchResource($instagramPostUrl);

print_r($result->toArray());

/**
Array
(
    [source_url] => https://www.instagram.com/p/CQmlIsWDdKh/
    [preview_image] => Array
        (
            [type] => image
            [format] => jpg
            [quality] =>
            [url] => https://instagram.fbkk5-3.fna.fbcdn.net/v/t51.2885-15/e35/208793833_197236692346254_2941739638331277075_n.jpg?tp=1&_nc_ht=instagram.fbkk5-3.fna.fbcdn.net&_nc_cat=1&_nc_ohc=hqGl8coYoC8AX8_TAe9&edm=AABBvjUBAAAA&ccb=7-4&oh=f926bd2039a4d20f8ae3c6d737012193&oe=60DE0C89&_nc_sid=83d603
            [mime_type] => image/jpg
        )

    [preview_video] => Array
        (
            [type] => video
            [format] => mp4
            [quality] =>
            [url] => https://instagram.fbkk5-4.fna.fbcdn.net/v/t50.2886-16/208293603_963789457782658_1292489345229422396_n.mp4?_nc_ht=instagram.fbkk5-4.fna.fbcdn.net&_nc_cat=110&_nc_ohc=2HRPftxAQe4AX_GHIqf&edm=AABBvjUBAAAA&ccb=7-4&oe=60DDFA2A&oh=1f8c2a5cdd0aa5e228dc8fa9fd3ae7ff&_nc_sid=83d603
            [mime_type] => video/mp4
        )

    [attributes] => Array
        (
            [author] => Array
                (
                    [id] => 184692323
                    [avatar_url] => https://instagram.fbkk5-3.fna.fbcdn.net/v/t51.2885-19/s150x150/194921896_794059374581630_4576885874575036174_n.jpg?tp=1&_nc_ht=instagram.fbkk5-3.fna.fbcdn.net&_nc_ohc=_DZ3X5MWU60AX8b0Ss2&edm=AABBvjUBAAAA&ccb=7-4&oh=1c701acfbf691866bca1a075a0d019db&oe=60E201DA&_nc_sid=83d603
                    [full_name] => Lady Gaga
                    [nickname] => ladygaga
                )

            [id] => 2604932759571780257
            [text] => ☀️#bekind even if it’s to yourself
        )

    [items] => Array
        (
            [video] => Array
                (
                    [0] => Array
                        (
                            [type] => video
                            [format] => mp4
                            [quality] =>
                            [url] => https://instagram.fbkk5-4.fna.fbcdn.net/v/t50.2886-16/208293603_963789457782658_1292489345229422396_n.mp4?_nc_ht=instagram.fbkk5-4.fna.fbcdn.net&_nc_cat=110&_nc_ohc=2HRPftxAQe4AX_GHIqf&edm=AABBvjUBAAAA&ccb=7-4&oe=60DDFA2A&oh=1f8c2a5cdd0aa5e228dc8fa9fd3ae7ff&_nc_sid=83d603
                            [mime_type] => video/mp4
                        )

                )

        )

)

**/
```

2. Use it with DownloadManager. 
Useful in case if your application is willing to download files from different sources (i.e. has more than one download handler)

```php
<?php
use AnyDownloader\DownloadManager\DownloadManager;
use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\InstagramDownloader\InstagramHandler;
use Goutte\Client;

include_once 'vendor/autoload.php';

$instagramPostUrl = URL::fromString('https://www.instagram.com/p/CPymPNfBvnM/');

$downloadManager = new DownloadManager();
$downloadManager->addHandler(new InstagramHandler(new Client()));

$result = $downloadManager->fetchResource($instagramPostUrl);

print_r($result->toArray());
```

[iwannacode.net](https://iwannacode.net)
