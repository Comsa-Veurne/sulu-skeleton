<?php


namespace App\Twig;


use App\Entity\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    private $em;
    private $request;

    public function __construct(
        EntityManagerInterface $em,
        RequestStack $requestStack
    )
    {
        $this->em = $em;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getFilters()
    {
        return [
            new TwigFilter('margin', [$this, 'formatMargin']),
            new TwigFilter('width', [$this, 'formatWidth']),
            new TwigFilter('size', [$this, 'formatSize']),
            new TwigFilter('columns', [$this, 'formatColumns']),
            new TwigFilter('youtubeId', [$this, 'getYoutubeId']),
        ];
    }

    public function getYoutubeId($url)
    {
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $params);
        return isset($params['v']) ? $params['v'] : false;
    }

    public function formatMargin($margin)
    {
        switch ($margin) {
            case 'small':
                return 'my-1';
            case 'large':
                return 'my-5';
            default:
                return 'my-3';
        }
    }

    public function formatWidth($size)
    {
        switch ($size) {
            case 'half':
                return 'col-md-6';
            default:
                return 'col-md-12';
        }
    }

    public function formatSize($size)
    {
        switch ($size) {
            case 'small':
                return 'sm';
            case 'large':
                return 'lg';
            default:
                return 'nm';
        }
    }

    public function formatColumns($columns)
    {
        switch ($columns) {
            case 2:
                return 'col-md-6';
            case 3:
                return 'col-md-4';
            case 4:
                return 'col-md-3';
            default:
                return 'col-md-12';
        }
    }

    public function getGlobals()
    {
        $data = [];

        //-- Fetch all settings
        $repository = $this->em->getRepository(Setting::class);
        $settings = $repository->findAll();

        foreach ($settings as $setting) {
            $setting->setLocale($this->request->getLocale());
            $data[$setting->getKey()] = $setting->getValue();
        }
        return $data;
    }
}
