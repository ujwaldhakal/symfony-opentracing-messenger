<?php

declare(strict_types=1);

namespace Ujwaldhakal\Messenger\EventSubscriber;

use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Ujwaldhakal\Messenger\Tracing\TracingStamp;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Ujwaldhakal\Messenger\Tracing\TracingInterface;

final class WorkerMessageReceivedSubscriber implements EventSubscriberInterface
{
    public function __construct(private TracingInterface $tracing){}
    
    public static function getSubscribedEvents() : array
    {
        return [
            WorkerMessageReceivedEvent::class => [
                ['onMessageReceived', 0],
            ],
        ];
    }

    public function onMessageReceived(WorkerMessageReceivedEvent $event)
    {
        /** @var Ujwaldhakal\Messenger\Tracing\TracingStamp $tracingHeaders */
        $tracingHeaders = $event->getEnvelope()->last(TracingStamp::class);
        $name = get_class($event->getEnvelope()->getMessage());
        $this->tracing->linkParentSpan($name, $tracingHeaders->getTracingHeaders());
    }
}
