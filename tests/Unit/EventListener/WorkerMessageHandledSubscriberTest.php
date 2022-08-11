<?php

declare(strict_types=1);


namespace Ujwaldhakal\OpentracingMessengerBundle\Tests\Unit\EventListener;

use OpenTracing\NoopSpan;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Ujwaldhakal\OpentracingMessengerBundle\EventSubscriber\SendMessageToTransportSubscriber;
use Ujwaldhakal\OpentracingMessengerBundle\EventSubscriber\WorkerMessageHandledSubscriber;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingInterface;

final class WorkerMessageHandledSubscriberTest extends TestCase
{
    private TracingInterface $tracing;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tracing = $this->createStub(TracingInterface::class);

    }

    /**
     * @test
     */
    public function get_subscribed_events(): void
    {
        self::assertArrayHasKey(WorkerMessageHandledEvent::class, WorkerMessageHandledSubscriber::getSubscribedEvents());
    }

    /**
     * @test
     */
    public function on_message_handled_on_active_span(): void
    {
        $subscriber = new WorkerMessageHandledSubscriber($this->tracing);
        $event = new WorkerMessageHandledEvent(new Envelope(self::returnArgument(1)),'test');
        $this->tracing->method('getActiveSpan')->willReturn(new NoopSpan());
        $this->tracing->expects(self::once())->method('closeSpan');
        $subscriber->onMessageHandled($event);
    }

    /**
     * @test
     */
    public function on_message_handled_without_active_span(): void
    {
        $subscriber = new WorkerMessageHandledSubscriber($this->tracing);
        $event = new WorkerMessageHandledEvent(new Envelope(self::returnArgument(1)),'test');
        $this->tracing->expects(self::exactly(0))->method('closeSpan');
        $subscriber->onMessageHandled($event);
    }
}