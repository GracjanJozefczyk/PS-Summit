<?php

declare(strict_types=1);

namespace App\Creator;

use ApiPlatform\Validator\Exception\ValidationException;
use App\Entity\Brand\BrandImageInterface;
use App\Entity\Brand\BrandInterface;
use App\Repository\BrandRepositoryInterface;
use Sylius\Bundle\ApiBundle\Creator\ImageCreatorInterface;
use Sylius\Bundle\ApiBundle\Exception\NoFileUploadedException;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class BrandImageCreator implements ImageCreatorInterface
{
    public function __construct(
        private FactoryInterface $brandImageFactory,
        private BrandRepositoryInterface $brandRepository,
        private ImageUploaderInterface $imageUploader,
        private ValidatorInterface $validator,
    ) {
    }

    public function create(string $ownerIdentifier, ?\SplFileInfo $file, ?string $type = null, array $context = []): ImageInterface
    {
        if (null === $file) {
            throw new NoFileUploadedException();
        }

        $owner = $this->brandRepository->findOneBy(['code' => $ownerIdentifier]);
        if (!$owner instanceof BrandInterface) {
            throw new NotFoundHttpException('Brand not found.');
        }

        /** @var BrandImageInterface $brandImage */
        $brandImage = $this->brandImageFactory->createNew();
        $brandImage->setFile($file);
        $brandImage->setType($type);

        $violations = $this->validator->validate($brandImage, groups: ['sylius']);
        if (0 < $violations->count()) {
            throw new ValidationException($violations);
        }

        $owner->addImage($brandImage);

        $this->imageUploader->upload($brandImage);

        return $brandImage;
    }
}
