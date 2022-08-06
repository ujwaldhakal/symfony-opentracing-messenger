<?php

declare(strict_types=1);

namespace Ujwaldhakal\Messenger\Tracing;

use OpenTracing\Span;

interface TracingInterface
{
    public function startSpan(string $spanName, array $options = []): void;

    public function linkParentSpan(string $spanName, array $options = []): void;

    public function getTracingHeaders(): array;

    public function closeSpan(): void;

    public function getActiveSpan(): ?Span;

    public function logInActiveSpan(array $fields): void;
}
