## Symfony Opentracing Messenger

This bundle helps you to setup opentracing on the [Symfony Messenger](https://symfony.com/doc/current/messenger.html) out of the box without any configs. 
This is just an addon for the [OpentracingBundleCore](https://github.com/auxmoney/OpentracingBundle-core).

If you are using Messenger for async messages no matter how many async messages you have inside message, it will trace them by modifying your messages before it gets processed. The way it modifies them is by using leveraging the [Symfony Messenger Events](https://symfony.com/doc/current/messenger.html#messenger-events).

## Installation
- Run `composer require  ujwaldhakal/symfony-opentracing-messenger`
- Import bundle on your `bundles.php` with 
```
  Auxmoney\OpentracingBundle\OpentracingBundle::class => ['all' => true],
  Ujwaldhakal\OpentracingMessengerBundle\MessengerBundle::class => ['all' => true]
```

- Follow the configuration from [https://github.com/auxmoney/OpentracingBundle-core](https://github.com/auxmoney/OpentracingBundle-core)


For more info visit:

https://github.com/auxmoney/OpentracingBundle-core