<?php

declare(strict_types=1);

namespace Ujwaldhakal\Messenger\EventSubscriber;

use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Ujwaldhakal\Messenger\Tracing\TracingStamp;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Ujwaldhakal\Messenger\Tracing\TracingInterface;

final class WorkerMessageHandledSubscriber implements EventSubscriberInterface
{
    public function __construct(private TracingInterface $tracing){}
    
    public static function getSubscribedEvents() : array
    {
        return [
            WorkerMessageHandledEvent::class => [
                ['onMessageHandled', 0],
            ],
        ];
    }

    public function onMessageHandled(WorkerMessageHandledEvent $event)
    {
        if ($this->tracing->getActiveSpan()) {
            $this->tracing->closeSpan();
        }
    }
}
