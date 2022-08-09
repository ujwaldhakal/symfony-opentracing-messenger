<?php

declare(strict_types=1);

namespace Ujwaldhakal\OpentracingMessengerBundle\EventSubscriber;

use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingStamp;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingInterface;

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
        /** @var Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingStamp $tracingHeaders */
        $tracingHeaders = $event->getEnvelope()->last(TracingStamp::class);
        if(!empty($tracingHeaders)) {
        $name = get_class($event->getEnvelope()->getMessage());
        $this->tracing->linkParentSpan($name, $tracingHeaders->getTracingHeaders());
        }
    }
}
