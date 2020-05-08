<?php


namespace App\Form\ListBuilder;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\ListBuilder\DynamicListBuilder as SuluDynamicListBuilder;
use Sulu\Bundle\PageBundle\Document\PageDocument;
use Sulu\Component\DocumentManager\DocumentManagerInterface;
use Symfony\Component\Routing\RouterInterface;

class DynamicListBuilder extends SuluDynamicListBuilder
{
    /**
     * @var DocumentManagerInterface
     */
    private $documentManager;

    public function __construct(string $delimiter, RouterInterface $router, DocumentManagerInterface $documentManager)
    {
        parent::__construct($delimiter, $router);
        $this->documentManager = $documentManager;
    }

    public function build(Dynamic $dynamic, string $locale): array
    {
        $entries = parent::build($dynamic, $locale);
        $singleEntry = $entries[0];

        if ($dynamic->getType() === 'page') {
            $page = $this->documentManager->find($dynamic->getTypeId());
            if ($page instanceof PageDocument) {
                $singleEntry['page'] = $page->getTitle();
            }
        }

        return [$singleEntry];
    }
}
