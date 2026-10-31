<?php

declare(strict_types=1);

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'sylius.menu.admin.main')]
final class AdminMenuListener
{
    public function __invoke(MenuBuilderEvent $event): void
    {
        $catalog = $event->getMenu()->getChild('catalog');
        if (null === $catalog) {
            return;
        }

        $catalog
            ->addChild('brands', ['route' => 'app_admin_brand_index', 'extras' => ['routes' => [
                ['route' => 'app_admin_brand_create'],
                ['route' => 'app_admin_brand_update'],
            ]]])
            ->setLabel('app.menu.admin.main.catalog.brands')
            ->setLabelAttribute('icon', 'tabler:building-store')
        ;
    }
}
