<?php

namespace App\Service;

use App\Entity\URL;
use App\Entity\Analytics;
use App\Repository\URLRepository;
use Symfony\Bundle\SecurityBundle\Security;

class UrlManager
{
    private $urlRepository;
    private $shortUrlCodeGenerator;
    private $security;

    public function __construct(URLRepository $urlRepository,ShortUrlCodeGenerator $shortUrlCodeGenerator, Security $security)
    {
        $this->urlRepository = $urlRepository;
        $this->shortUrlCodeGenerator = $shortUrlCodeGenerator;
        $this->security = $security;
    }

    public function createUrl(string $originalUrl, string $customAlias = null): URL
    {
        $url = new URL();
        $url->setOriginalUrl($originalUrl);
        $url->setUser($this->security->getUser());
        $shortUrlCode = $this->generateUniqueShortUrlCode();
        $url->setShortUrlCode($shortUrlCode);
        $url->setAnalytics(new Analytics());

        //Set alias
        if (!empty($customAlias)) {
            $url->setCustomAlias($customAlias);
        }

        $this->urlRepository->save($url, true);

        return $url;
    }

    private function generateUniqueShortUrlCode(): string
    {
        return $this->shortUrlCodeGenerator->generateUniqueShortUrlCode();
    }

    public function delete(URL $url) {
        $this->urlRepository->remove($url, true);
    }
}
