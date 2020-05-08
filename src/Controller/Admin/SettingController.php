<?php


namespace App\Controller\Admin;


use App\Admin\SettingAdmin;
use App\Entity\Setting;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SettingController extends AbstractRestController implements ClassResourceInterface
{
    private $doctrineListBuilderFactory;
    /**
     * @var FieldDescriptorFactoryInterface
     */
    private $fieldDescriptorFactory;
    /**
     * @var RestHelperInterface
     */
    private $restHelper;
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        DoctrineListBuilderFactoryInterface $doctrineListBuilderFactory,
        FieldDescriptorFactoryInterface $fieldDescriptorFactory,
        RestHelperInterface $restHelper,
        EntityManagerInterface $em
    )
    {
        parent::__construct($viewHandler);
        $this->fieldDescriptorFactory = $fieldDescriptorFactory;
        $this->doctrineListBuilderFactory = $doctrineListBuilderFactory;
        $this->restHelper = $restHelper;
        $this->em = $em;
        $this->repository = $em->getRepository(Setting::class);
    }

    public function cgetAction(Request $request): Response
    {
        $listBuilder = $this->doctrineListBuilderFactory->create(Setting::class);
        $fieldDescriptors = $this->fieldDescriptorFactory->getFieldDescriptors(Setting::RESOURCE_KEY);
        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

        $list = $listBuilder->execute();

        $total = $listBuilder->count();
        $page = $listBuilder->getCurrentPage();
        $limit = $listBuilder->getLimit();

        $representation = new ListRepresentation(
            $list,
            SettingAdmin::LIST_KEY,
            $request->get('_route'),
            $request->query->all(),
            $page,
            $limit,
            $total
        );

        return $this->handleView($this->view($representation));
    }

    public function getAction(int $id, Request $request): Response
    {
        $entity = $this->repository->find($id);
        if (!$entity) {
            throw new NotFoundHttpException();
        }
        return $this->handleView($this->view($entity));
    }

    public function postAction(Request $request): Response
    {
        $entity = new Setting();
        $data = $request->request->all();
        $entity->setKey($data['key']);
        $entity->setLabel($data['label']);
        $entity->setValue($data['value']);
        $this->em->persist($entity);
        $this->em->flush();
        return $this->handleView($this->view($entity));
    }
}
