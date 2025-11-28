<?php
// api/src/Serializer/MediaObjectNormalizer.php

namespace App\Serializer;

use App\Entity\Movie;
use Vich\UploaderBundle\Storage\StorageInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MediaObjectNormalizer implements NormalizerInterface
{

  private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

  public function __construct(
    #[Autowire(service: 'api_platform.jsonld.normalizer.item')]
    private readonly NormalizerInterface $normalizer,
    private readonly StorageInterface $storage
  ) {}

  /**
   * @param Movie $object
   */

  public function normalize($object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
  {
    $context[self::ALREADY_CALLED] = true;

    $data = $this->normalizer->normalize($object, $format, $context);
    $data['image'] = $this->storage->resolveUri($object, 'image');
    
    return $data;
  }

  public function supportsNormalization($data, ?string $format = null, array $context = []): bool
  {

    if (isset($context[self::ALREADY_CALLED])) {
      return false;
    }

    return $data instanceof Movie;
  }

  public function getSupportedTypes(?string $format): array
  {
    return [
      Movie::class => true,
    ];
  }
}
