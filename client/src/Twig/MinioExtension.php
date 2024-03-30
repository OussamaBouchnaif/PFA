<?php


namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MinioExtension extends AbstractExtension
{
    private $endpointMinio;

    public function __construct(string $endpointMinio)
    {
        $this->endpointMinio = $endpointMinio;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('minio_url', [$this, 'getMinioUrl']),
        ];
    }

    public function getMinioUrl(string $imagePath)
    {
        return $this->endpointMinio . $imagePath;
    }
}