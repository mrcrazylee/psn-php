<?php

namespace PlayStation\Http;

use GuzzleHttp\Psr7\StreamDecoratorTrait;
use JsonSerializable;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

class JsonStream implements StreamInterface, JsonSerializable
{
    use StreamDecoratorTrait;

    public function jsonSerialize()
    {
        $contents = (string) $this->getContents();
      
        if ($contents === '') {
            return null;
        }

        $decoded = json_decode($contents, false);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'Error trying to decode response: ' .
                json_last_error_msg()
            );
        }

        return $decoded;
    }
}