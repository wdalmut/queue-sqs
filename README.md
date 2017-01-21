# AWS SQS adapter

To use this package you need `Corley\Queue\Queue` and the AWS PHP SDK
[v2](http://docs.aws.amazon.com/aws-sdk-php/v2/api/class-Aws.Sqs.SqsClient.html) or
[v3](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Sqs.SqsClient.html)

[![Build Status](https://travis-ci.org/wdalmut/queue-sqs.svg?branch=master)](https://travis-ci.org/wdalmut/queue-sqs)

```sh
composer require corley/queue:~1
```

Remember to install your AWS SDK

## AWS V2


```sh
composer require aws/aws-sdk-php:~2
```

## AWS V3


```sh
composer require aws/aws-sdk-php:~3
```

## Use as adapter

Create the adapter

with v2

```php
use Corley\Queue\AWS\V2;

$adapter = new V2\SQS($client);
```

or v3

```php
use Corley\Queue\AWS\V3;

$adapter = new V3\SQS($client);
```

Set as usual

```php
use Corley\Queue\Queue;

$queue = new Queue("https://sqs.aws.amazon.com/125897125982/test", $adapter);
$queue->send(json_encode(["test" => "ok"]));

list($receipt, $message) = $queue->receive();
$message = json_decode($message, true);

$queue->delete($receipt);
```


