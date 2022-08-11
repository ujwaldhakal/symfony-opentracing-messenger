<?php

declare(strict_types=1);


namespace Ujwaldhakal\OpentracingMessengerBundle\Tests\Unit\EventListener;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Ujwaldhakal\OpentracingMessengerBundle\EventSubscriber\WorkerMessageHandledSubscriber;
use Ujwaldhakal\OpentracingMessengerBundle\EventSubscriber\WorkerMessageReceivedSubscriber;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingInterface;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingStamp;

final class WorkerMessageReceivedSubscriberTest extends TestCase
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
        self::assertArrayHasKey(WorkerMessageReceivedEvent::class, WorkerMessageReceivedSubscriber::getSubscribedEvents());
    }

    /**
     * @test
     */
    public function on_message_received_with_headers(): void
    {
        $this->tracing->expects(self::once())->method('linkParentSpan');
        $subscriber = new WorkerMessageReceivedSubscriber($this->tracing);
        $envelope = (new Envelope(self::returnArgument(1)))->with(new TracingStamp(['trace-id' => '123']));
        $event = new WorkerMessageReceivedEvent($envelope,'test');
        $subscriber->onMessageReceived($event);
    }

    /**
     * @test
     */
    public function on_message_received_without_headers(): void
    {
        $this->tracing->expects(self::exactly(0))->method('linkParentSpan');
        $subscriber = new WorkerMessageReceivedSubscriber($this->tracing);
        $envelope = (new Envelope(self::returnArgument(1)));
        $event = new WorkerMessageReceivedEvent($envelope,'test');
        $subscriber->onMessageReceived($event);
    }
}