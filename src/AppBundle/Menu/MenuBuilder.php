<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

/**
 * Class MenuBuilder
 * @package AppBundle\Menu
 */
class MenuBuilder
{
    /**
     * @param FactoryInterface $factory
     * @param array $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->addChild('Home', ['route' => 'homepage']);
        $menu->addChild('Admin', [
            'route' => 'page_slug',
            'routeParameters' => [
                'path' => '/admin'
            ]
        ]);
        // ... add more children

        return $menu;
    }
}
