<?php

namespace App\Service;
use App\Repository\URLRepository;

class ShortUrlCodeGenerator
{
    private $urlRepository;
    private $shortUrlCodeGenerator;

    public function __construct(URLRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }
    private function generateShortUrlCode(int $length = 6): string
    {        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shortUrlCode = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = mt_rand(0, strlen($characters) - 1);
            $shortUrlCode .= $characters[$randomIndex];
        }
        
        return $shortUrlCode;
    }

    public function generateUniqueShortUrlCode(): string
    {
        $shortUrlCode = $this->generateShortUrlCode();

        // Check if the short URL already exists
        $existingUrl = $this->urlRepository->findOneBy(['shortUrlCode' => $shortUrlCode]);
        if ($existingUrl) {
            // Generate a new unique short URL recursively
            return $this->generateUniqueShortUrlCode();
        }

        return $shortUrlCode;
    }
}
