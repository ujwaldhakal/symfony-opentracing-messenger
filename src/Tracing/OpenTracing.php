<?php

declare(strict_types=1);

namespace Ujwaldhakal\OpentracingMessengerBundle\Tracing;

use Auxmoney\OpentracingBundle\Internal\Persistence;
use Auxmoney\OpentracingBundle\Internal\Utility;
use Auxmoney\OpentracingBundle\Service\Tracing;
use OpenTracing\Reference;
use OpenTracing\Span;

final class OpenTracing implements TracingInterface
{
    public function __construct(private Tracing $tracing,
                                private Utility $utility,
                                private Persistence $persistence)
    {
    }

    public function startSpan(string $spanName, array $options = []): void
    {
        $this->tracing->startActiveSpan($spanName, $options);
    }

    public function linkParentSpan(string $spanName, array $options = []): void
    {
        if (!empty($options)) {
            $context = $this->utility->extractSpanContext($options);
            $reference = new Reference(Reference::FOLLOWS_FROM, $context);
            $this->tracing->startActiveSpan($spanName, ['references' => $reference]);
        }
    }

    public function getTracingHeaders(): array
    {
        return $this->tracing->injectTracingHeadersIntoCarrier([]);
    }

    public function closeSpan(): void
    {
        $this->tracing->finishActiveSpan();
        $this->persistence->flush();
    }

    public function getActiveSpan(): ?Span
    {
        return $this->tracing->getActiveSpan();
    }

    public function logInActiveSpan(array $fields): void
    {
        $this->tracing->logInActiveSpan($fields);
    }
}
