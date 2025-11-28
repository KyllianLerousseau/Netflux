<?php
// api/src/Encoder/MultipartDecoder.php

namespace App\Encoder;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

final class MultipartDecoder implements DecoderInterface
{
    public const FORMAT = 'multipart';

    public function __construct(private readonly RequestStack $requestStack) {}

    

    public function decode(string $data, string $format, array $context = []): ?array
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return null;
        }

        $decoded = [];

        foreach ($request->request->all() as $key => $value) {
            if (is_array($value)) {
                $decoded[$key] = $value;
                continue;
            }

            if (in_array($key, ['duration'])) {
                $decoded[$key] = (int) $value;
                continue;
            }

            if (is_string($value)) {
                $trimmed = trim($value);
                if (str_starts_with($trimmed, '{') || str_starts_with($trimmed, '[')) {
                    try {
                        $decoded[$key] = json_decode($trimmed, true, flags: \JSON_THROW_ON_ERROR);
                    } catch (\JsonException $e) {
                        $decoded[$key] = $value;
                    }
                } else {
                    $decoded[$key] = $value;
                }
                continue;
            }

            $decoded[$key] = $value;
        }
        foreach ($request->files->all() as $key => $file) {
            if ($file instanceof UploadedFile) {
                $decoded[$key] = $file;
            }
        }

        return $decoded;
    }

    public function supportsDecoding(string $format): bool
    {
        return self::FORMAT === $format;
    }
}
