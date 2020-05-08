<?php


namespace App\Configuration;

use Sulu\Bundle\FormBundle\Configuration\FormConfiguration;
use Sulu\Bundle\FormBundle\Configuration\FormConfigurationFactory as SuluFormConfigurationFactory;
use Sulu\Bundle\FormBundle\Configuration\FormConfigurationInterface;
use Sulu\Bundle\FormBundle\Configuration\MailConfiguration;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Media\CollectionStrategyInterface;
use Sulu\Bundle\PageBundle\Document\PageDocument;
use Sulu\Component\DocumentManager\DocumentManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FormConfigurationFactory extends SuluFormConfigurationFactory
{
    private $request;
    private $documentManager;

    public function __construct(CollectionStrategyInterface $collectionStrategy, string $mailAdminTemplate, string $mailWebsiteTemplate, string $mailAdminPlainTextTemplate, string $mailWebsitePlainTextTemplate, DocumentManagerInterface $documentManager, RequestStack $requestStack)
    {
        parent::__construct($collectionStrategy, $mailAdminTemplate, $mailWebsiteTemplate, $mailAdminPlainTextTemplate, $mailWebsitePlainTextTemplate);
        $this->request = $requestStack->getCurrentRequest();
        $this->documentManager = $documentManager;
    }

    public function buildByDynamic(Dynamic $dynamic): FormConfigurationInterface
    {
        /** @var FormConfiguration $config */
        $config = parent::buildByDynamic($dynamic);

        /** @var MailConfiguration $adminMailConfiguration */
        $adminMailConfiguration = $config->getAdminMailConfiguration();

        $pathToResource = $this->request->attributes->get('_route_params');
        $documentUuid = $pathToResource['structure']->getDocument()->getUuid();

        /** @var PageDocument $document */
        $document = $this->documentManager->find($documentUuid);

        $adminMailConfiguration->setSubject("{$adminMailConfiguration->getSubject()} - {$document->getTitle()}");
        $config->setAdminMailConfiguration($adminMailConfiguration);
        return $config;
    }
}
