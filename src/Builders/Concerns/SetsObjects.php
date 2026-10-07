<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

use Finvalda\Builders\ObjectLevel;
use Finvalda\Exceptions\ValidationException;

/**
 * Analytical objects on the operation header (sObjektas1..6).
 *
 * Used only by builders whose operation header has the sObjektas fields in the
 * spec (sales and purchase families).
 */
trait SetsObjects
{
    public function object1(string $code): static
    {
        return $this->objects([1 => $code]);
    }

    public function object2(string $code): static
    {
        return $this->objects([2 => $code]);
    }

    public function object3(string $code): static
    {
        return $this->objects([3 => $code]);
    }

    public function object4(string $code): static
    {
        return $this->objects([4 => $code]);
    }

    public function object5(string $code): static
    {
        return $this->objects([5 => $code]);
    }

    public function object6(string $code): static
    {
        return $this->objects([6 => $code]);
    }

    /**
     * Set several analytical objects at once, keyed by level.
     *
     * @param  array<int, string>  $objects  e.g. [1 => 'DEPT01', 4 => '1234567']
     *
     * @throws ValidationException  On a level outside 1-6.
     */
    public function objects(array $objects): static
    {
        foreach ($objects as $level => $code) {
            $this->header[ObjectLevel::key($level)] = $code;
        }

        return $this;
    }
}
