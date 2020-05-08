<?php


namespace App\Admin;


use App\Entity\Setting;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;

class SettingAdmin extends Admin
{
    const LIST_KEY = 'settings';
    const LIST_VIEW = 'app.settings.list';
    const ADD_VIEW = 'app.settings.add';
    const EDIT_VIEW = 'app.settings.edit';
    const FORM_KEY = 'setting_details';

    private $viewBuilderFactory;

    public function __construct(ViewBuilderFactoryInterface $viewBuilderFactory)
    {
        $this->viewBuilderFactory = $viewBuilderFactory;
    }

    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        $navigationItem = new NavigationItem('app.settings');
        $navigationItem->setIcon('fa-cog');
        $navigationItem->setPosition(10);
        $navigationItem->setView(static::LIST_VIEW);

        $navigationItemCollection->add($navigationItem);
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $listToolbarActions = [
            new ToolbarAction('sulu_admin.add'), new ToolbarAction('sulu_admin.delete')
        ];
        $viewCollection->add(
            $this->viewBuilderFactory->createListViewBuilder(self::LIST_VIEW, '/settings')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setListKey(self::LIST_KEY)
                ->addListAdapters(['table'])
                ->setAddView(static::ADD_VIEW)
                ->setEditView(static::EDIT_VIEW)
                ->addToolbarActions($listToolbarActions)
        );

        $viewCollection->add(
            $this->viewBuilderFactory->createResourceTabViewBuilder(static::ADD_VIEW, '/settings/add')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setBackView(static::LIST_VIEW)
        );
        $viewCollection->add(
            $this->viewBuilderFactory->createFormViewBuilder(static::ADD_VIEW . '.details', '/details')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setFormKey(static::FORM_KEY)
                ->setTabTitle('app.settings')
                ->setEditView(static::EDIT_VIEW)
                ->addToolbarActions([
                    new ToolbarAction('sulu_admin.save')
                ])
                ->setParent(static::ADD_VIEW)
        );

        $formToolbarActions = [
            new ToolbarAction('sulu_admin.save'),
            new ToolbarAction('sulu_admin.delete')
        ];
        $viewCollection->add(
            $this->viewBuilderFactory->createResourceTabViewBuilder(static::EDIT_VIEW, '/settings/:id')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setBackView(static::LIST_VIEW)
        );
        $viewCollection->add(
            $this->viewBuilderFactory->createFormViewBuilder(static::EDIT_VIEW . '.details', '/details')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setFormKey(self::FORM_KEY)
                ->addToolbarActions($formToolbarActions)
                ->setParent(static::EDIT_VIEW)
        );
    }
}
