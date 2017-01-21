<?php
namespace Corley\Queue\AWS\V2;

use Corley\Queue\QueueInterface;

class SQS implements QueueInterface
{
    private $sqsClient;

    public function __construct(\Aws\Sqs\SqsClient $sqsClient)
    {
        $this->sqsClient = $sqsClient;
    }
    public function send($queueName, $message, array $options)
    {
        $response = $this->sqsClient->sendMessage(array_replace_recursive([
            "QueueUrl" => $queueName,
            "MessageBody" => $message,
        ], $options));

        return $response;
    }

    public function receive($queueName, array $options)
    {
        $response = $this->sqsClient->receiveMessage(array_replace_recursive([
            "QueueUrl" => $queueName,
            "MaxNumberOfMessages" => 1,
        ], $options));
        return [$response["Messages"][0]["ReceiptHandle"], $response["Messages"][0]["Body"], $response];
    }

    public function delete($queueName, $receipt, array $options)
    {
        $response = $this->sqsClient->deleteMessage(array_replace_recursive([
            "QueueUrl" => $queueName,
            "ReceiptHandle" => $receipt,
        ], $options));

        return $response;
    }
}
