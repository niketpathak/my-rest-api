<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use App\Service\FileUploader;
use App\Entity\media;

final class MediaNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private FileUploader $fileUploader;
    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(FileUploader $fileUploader) {
        $this->fileUploader = $fileUploader;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool {
        return !isset($context[self::ALREADY_CALLED]) && $data instanceof media;
    }

    public function normalize($object, ?string $format = null, array $context = []) {
        $context[self::ALREADY_CALLED] = true;

        // update the filePath with the url
        $object->filePath = $this->fileUploader->getUrl($object->filePath);

        return $this->normalizer->normalize($object, $format, $context);
    }
}