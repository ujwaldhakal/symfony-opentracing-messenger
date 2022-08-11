<?php

declare(strict_types=1);


namespace Ujwaldhakal\OpentracingMessengerBundle\Tests\Unit\Tracing;

use Auxmoney\OpentracingBundle\Internal\Persistence;
use Auxmoney\OpentracingBundle\Internal\Utility;
use Auxmoney\OpentracingBundle\Service\Tracing;
use OpenTracing\Mock\MockSpan;
use OpenTracing\NoopSpanContext;
use PHPUnit\Framework\TestCase;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\OpenTracing;

final class OpenTracingTest extends TestCase
{
    private Tracing $tracing;

    private Utility $utility;

    private Persistence $persistence;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->tracing = $this->getMockBuilder(Tracing::class)->getMock();
        $this->utility = $this->getMockBuilder(Utility::class)->getMock();
        $this->persistence = $this->getMockBuilder(Persistence::class)->getMock(); 
    }

    /**
     * @test
     */
    public function start_span(): void
    {
        $openTracing = new OpenTracing($this->tracing,$this->utility,$this->persistence);
        $this->tracing->expects(self::exactly(1))->method('startActiveSpan')->with(self::anything());
        $openTracing->startSpan("start");
    }

    /**
     * @test
     */
    public function link_parent_span_with_options(): void
    {
        $this->utility->method('extractSpanContext')->willReturn(new NoopSpanContext());
        $openTracing = new OpenTracing($this->tracing,$this->utility,$this->persistence);
        $this->utility->expects(self::exactly(1))->method('extractSpanContext');
        $this->tracing->expects(self::exactly(1))->method('startActiveSpan');
        $openTracing->linkParentSpan("parent span",['uber-trace-id' => '125125']);
    }

    /**
     * @test
     */
    public function get_tracing_headers(): void
    {
        $openTracing = new OpenTracing($this->tracing,$this->utility,$this->persistence);
        $this->tracing->expects(self::exactly(1))->method('injectTracingHeadersIntoCarrier');
        $openTracing->getTracingHeaders();
    }

    /**
     * @test
     */
    public function log_in_active_span(): void
    {
        $openTracing = new OpenTracing($this->tracing,$this->utility,$this->persistence);
        $this->tracing->expects(self::exactly(1))->method('logInActiveSpan');
        $openTracing->logInActiveSpan([]);
    }

    /**
     * @test
     */
    public function close_span(): void
    {
        $openTracing = new OpenTracing($this->tracing,$this->utility,$this->persistence);
        $this->tracing->expects(self::exactly(1))->method('finishActiveSpan');
        $this->persistence->expects(self::exactly(1))->method('flush');
        $openTracing->closeSpan();
    }
}