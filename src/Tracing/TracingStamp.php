<?php

declare(strict_types=1);

namespace Ujwaldhakal\Messenger\Tracing;

use Symfony\Component\Messenger\Stamp\StampInterface;

final class TracingStamp implements StampInterface
{
    public function __construct(private array $tracingHeaders)
    {
    }

    public function getTracingHeaders(): array
    {
        return $this->tracingHeaders;
    }
}
