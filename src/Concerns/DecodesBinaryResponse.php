<?php

declare(strict_types=1);

namespace Finvalda\Concerns;

use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Responses\Response;

/**
 * Decodes base64-wrapped binary payloads returned by Pure REST endpoints
 * such as MakeInvoice, MakeReport, GetAutoReport, and GetPrekesImage.
 */
trait DecodesBinaryResponse
{
    /**
     * Decode the base64 file payload from a Pure REST binary response.
     *
     * @throws FinvaldaException
     */
    protected function decodeBinaryResponse(Response $response, string $context): string
    {
        if ($response->failed()) {
            throw new FinvaldaException("{$context} failed: " . ($response->error ?: 'Unknown error'));
        }

        $base64 = $this->extractFileContents($response, $context);
        $stripped = preg_replace('/\s+/', '', $base64) ?? '';
        $binary = base64_decode($stripped, true);

        if ($binary === false || $binary === '') {
            throw new FinvaldaException("{$context} did not contain valid base64 file contents");
        }

        return $binary;
    }

    /**
     * @throws FinvaldaException
     */
    private function extractFileContents(Response $response, string $context): string
    {
        $data = $response->data;
        $value = $data['fileContents']
            ?? $data['FileContents']
            ?? $data['file_contents']
            ?? (count($data) === 1 ? reset($data) : null);

        if (! is_string($value) || $value === '') {
            throw new FinvaldaException("{$context} did not contain fileContents");
        }

        return $value;
    }
}
