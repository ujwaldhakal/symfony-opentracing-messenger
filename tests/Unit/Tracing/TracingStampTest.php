<?php

declare(strict_types=1);


namespace Ujwaldhakal\OpentracingMessengerBundle\Tests\Unit\Tracing;

use PHPUnit\Framework\TestCase;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingStamp;

final class TracingStampTest extends TestCase
{
    /**
     * @test
     */
    public function get_headers(): void
    {
        $payload = ['trace-id' => '123'];
        $tracingStamp = new TracingStamp($payload);

        self::assertSame($payload,$tracingStamp->getTracingHeaders());
    }
}