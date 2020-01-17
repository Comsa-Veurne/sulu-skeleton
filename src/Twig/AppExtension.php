<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('margin', [$this, 'formatMargin']),
            new TwigFilter('width', [$this, 'formatWidth']),
            new TwigFilter('size', [$this, 'formatSize']),
            new TwigFilter('columns', [$this, 'formatColumns']),
        ];
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
}
