<?php

declare(strict_types=1);

namespace Ujwaldhakal\OpentracingMessengerBundle\EventSubscriber;

use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingStamp;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Ujwaldhakal\OpentracingMessengerBundle\Tracing\TracingInterface;

final class SendMessageToTransportSubscriber implements EventSubscriberInterface
{
    public function __construct(private TracingInterface $tracing){}
    
    public static function getSubscribedEvents() : array
    {
        return [
            SendMessageToTransportsEvent::class => [
                ['onMessageSentToTransport', 0],
            ],
        ];
    }

    public function onMessageSentToTransport(SendMessageToTransportsEvent $event)
    {
        $event->setEnvelope($event->getEnvelope()->with(new TracingStamp($this->tracing->getTracingHeaders())));
    }
}
