<?php

declare(strict_types=1);

namespace Ujwaldhakal\OpentracingMessengerBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingInterface;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingStamp;

final class WorkerMessageHandledSubscriber implements EventSubscriberInterface
{
    public function __construct(private TracingInterface $tracing){}
    
    public static function getSubscribedEvents(): array
    {
        return [
            WorkerMessageHandledEvent::class => [
                ['onMessageHandled', 0],
            ],
        ];
    }

    public function onMessageHandled(WorkerMessageHandledEvent $event): void
    {
        if ($this->tracing->getActiveSpan()) {
            $this->tracing->closeSpan();
        }
    }
}
