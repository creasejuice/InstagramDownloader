<?php
namespace AnyDownloader\RedGifsDownloader\Tests;

use AnyDownloader\DownloadManager\Model\URL;
use AnyDownloader\InstagramDownloader\InstagramHandler;
use Goutte\Client;
use PHPUnit\Framework\TestCase;

class InstagramHandlerTest extends TestCase
{
    /** @test */
    public function handler_validates_given_url()
    {
        $handler = new InstagramHandler(new Client());
        $url = URL::fromString('https://www.instagram.com/p/CPymPNfBvnM/');
        $this->assertTrue($handler->isValidUrl($url));
    }

    /** @test */
    public function handler_validates_given_url_without_www()
    {
        $handler = new InstagramHandler(new Client());
        $url = URL::fromString('https://instagram.com/p/CPymPNfBvnM/');
        $this->assertTrue($handler->isValidUrl($url));
    }

    /** @test */
    public function handler_can_not_validates_given_url()
    {
        $handler = new InstagramHandler(new Client());
        $url = URL::fromString('https://pornhub.com/watch/demandingpapayawhipaardwolf');
        $this->assertFalse($handler->isValidUrl($url));
    }
}