# InstagramDownloader
Get video & image sources from Instagram

Install via Composer
```
composer require any-downloader/instagram-downloader
```

You have two options of how to use this package

1. Use it standalone

```
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
/**
Array
(
    [source_url] => https://www.instagram.com/p/CPymPNfBvnM/
    [preview_image] => Array
        (
            [type] => image
            [format] => jpg
            [quality] =>
            [url] => https://instagram.fbkk5-5.fna.fbcdn.net/v/t51.2885-15/e35/s1080x1080/196905492_308586814084192_8841447818317806237_n.jpg?tp=1&_nc_ht=instagram.fbkk5-5.fna.fbcdn.net&_nc_cat=104&_nc_ohc=EcBDKzknHxsAX8C-SaS&edm=AABBvjUBAAAA&ccb=7-4&oh=9bfcbd02f5902da916579c3870c0c509&oe=60E07906&_nc_sid=83d603
            [mime_type] => image/jpg
        )

    [preview_video] =>
    [attributes] => Array
        (
            [author] => Array
                (
                    [id] => 13028111539
                    [avatar_url] => https://instagram.fbkk5-3.fna.fbcdn.net/v/t51.2885-19/s150x150/66856406_428564481080089_1662075382033022976_n.jpg?tp=1&_nc_ht=instagram.fbkk5-3.fna.fbcdn.net&_nc_ohc=1fgXiTDZgw8AX_90LXg&edm=AABBvjUBAAAA&ccb=7-4&oh=90326fbc674a8fd52008b97beab5ed57&oe=60E0A6ED&_nc_sid=83d603
                    [full_name] =>
                    [nickname] => elonmusk
                )

            [id] => 2590300906730224076
            [text] => 🎭
        )

    [items] => Array
        (
            [0] => Array
                (
                    [type] => image
                    [format] => jpg
                    [quality] => 640x640
                    [url] => https://instagram.fbkk5-5.fna.fbcdn.net/v/t51.2885-15/sh0.08/e35/s640x640/196905492_308586814084192_8841447818317806237_n.jpg?tp=1&_nc_ht=instagram.fbkk5-5.fna.fbcdn.net&_nc_cat=104&_nc_ohc=EcBDKzknHxsAX8C-SaS&edm=AABBvjUBAAAA&ccb=7-4&oh=e7715c9bfbdbe077396ba7c4a9bea9de&oe=60DF09C2&_nc_sid=83d603
                    [mime_type] => image/jpg
                )

            [1] => Array
                (
                    [type] => image
                    [format] => jpg
                    [quality] => 750x750
                    [url] => https://instagram.fbkk5-5.fna.fbcdn.net/v/t51.2885-15/sh0.08/e35/s750x750/196905492_308586814084192_8841447818317806237_n.jpg?tp=1&_nc_ht=instagram.fbkk5-5.fna.fbcdn.net&_nc_cat=104&_nc_ohc=EcBDKzknHxsAX8C-SaS&edm=AABBvjUBAAAA&ccb=7-4&oh=f5d76f82f03d35f0cab43933747b3955&oe=60E03306&_nc_sid=83d603
                    [mime_type] => image/jpg
                )

            [2] => Array
                (
                    [type] => image
                    [format] => jpg
                    [quality] => 1080x1080
                    [url] => https://instagram.fbkk5-5.fna.fbcdn.net/v/t51.2885-15/e35/s1080x1080/196905492_308586814084192_8841447818317806237_n.jpg?tp=1&_nc_ht=instagram.fbkk5-5.fna.fbcdn.net&_nc_cat=104&_nc_ohc=EcBDKzknHxsAX8C-SaS&edm=AABBvjUBAAAA&ccb=7-4&oh=9bfcbd02f5902da916579c3870c0c509&oe=60E07906&_nc_sid=83d603
                    [mime_type] => image/jpg
                )

        )

)

**/
```

2. Use it with DownloadManager. 
Useful in case if your application is willing to download files from different sources (i.e. has more than one download handler)

```
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
