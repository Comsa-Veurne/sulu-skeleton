<?php


namespace App\Admin;


use App\Entity\Setting;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Component\Webspace\Manager\WebspaceManagerInterface;

class SettingAdmin extends Admin
{
    const LIST_KEY = 'settings';
    const LIST_VIEW = 'app.settings.list';
    const ADD_VIEW = 'app.settings.add';
    const EDIT_VIEW = 'app.settings.edit';
    const FORM_KEY = 'setting_details';

    private $viewBuilderFactory;
    private $webspaceManager;

    public function __construct(
        ViewBuilderFactoryInterface $viewBuilderFactory,
        WebspaceManagerInterface $webspaceManager
    )
    {
        $this->viewBuilderFactory = $viewBuilderFactory;
        $this->webspaceManager = $webspaceManager;
    }

    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        $settingsMenu = $navigationItemCollection->get('sulu_admin.settings');
        $navigationItem = new NavigationItem('app.setting.general');
        $navigationItem->setPosition(1);
        $navigationItem->setView(static::LIST_VIEW);
        $settingsMenu->addChild($navigationItem);
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $locales = $this->webspaceManager->getAllLocales();
        $listToolbarActions = [
            new ToolbarAction('sulu_admin.add'), new ToolbarAction('sulu_admin.delete')
        ];
        $viewCollection->add(
            $this->viewBuilderFactory->createListViewBuilder(self::LIST_VIEW, '/settings/:locale')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setListKey(self::LIST_KEY)
                ->addListAdapters(['table'])
                ->addLocales($locales)
                ->setDefaultLocale($locales[0])
                ->setAddView(static::ADD_VIEW)
                ->setEditView(static::EDIT_VIEW)
                ->addToolbarActions($listToolbarActions)
        );

        $viewCollection->add(
            $this->viewBuilderFactory->createResourceTabViewBuilder(static::ADD_VIEW, '/settings/:locale/add')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setBackView(static::LIST_VIEW)
                ->addLocales($locales)
        );
        $viewCollection->add(
            $this->viewBuilderFactory->createFormViewBuilder(static::ADD_VIEW . '.details', '/details')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setFormKey(static::FORM_KEY)
                ->setTabTitle('app.setting.add')
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
            $this->viewBuilderFactory->createResourceTabViewBuilder(static::EDIT_VIEW, '/settings/:locale/:id')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setBackView(static::LIST_VIEW)
                ->addLocales($locales)
        );
        $viewCollection->add(
            $this->viewBuilderFactory->createFormViewBuilder(static::EDIT_VIEW . '.details', '/details')
                ->setResourceKey(Setting::RESOURCE_KEY)
                ->setFormKey(self::FORM_KEY)
                ->setTabTitle('app.setting.edit')
                ->addToolbarActions($formToolbarActions)
                ->setParent(static::EDIT_VIEW)
        );
    }
}
