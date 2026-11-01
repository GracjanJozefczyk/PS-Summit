<?php

declare(strict_types=1);

namespace App\TwigComponent\Shop;

use App\Repository\BrandRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\TwigHooks\Twig\Component\HookableComponentTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

final class BrandListComponent
{
    use HookableComponentTrait;

    public function __construct(
        private readonly BrandRepositoryInterface $brandRepository,
        private readonly ChannelContextInterface $channelContext,
    ) {
    }

    #[ExposeInTemplate('brands')]
    public function brands(): array
    {
        return $this->brandRepository->findEnabledByChannel($this->channelContext->getChannel());
    }
}
