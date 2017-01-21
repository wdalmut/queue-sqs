<?php
namespace Corley\Queue\AWS\V3;

use Aws\Sqs\SqsClient;

class SQSTest extends \PHPUnit_Framework_TestCase
{
    private $adapter;

    public function setUp()
    {
        $client = new SqsClient(["region" => "eu-west-1", "version" => "latest"]);

        $this->adapter = new SQS($client);
    }

    public function testSendMessages()
    {
        $response = $this->adapter->send($_SERVER["QUEUE_NAME"], "test", []);
        $this->assertEquals(md5("test"), $response->get("MD5OfMessageBody"));
    }

    public function testSendAndReceiveMessages()
    {
        $this->adapter->send($_SERVER["QUEUE_NAME"], "test", []);
        list($receipt, $message) = $this->adapter->receive($_SERVER["QUEUE_NAME"], []);

        $this->assertNotNull($message);
        $this->assertNotNull($receipt);
        $this->assertNotFalse($receipt);
    }

    public function testSendAndReceiveAndDeleteMessages()
    {
        $this->adapter->send($_SERVER["QUEUE_NAME"], "test", []);
        list($receipt, $message) = $this->adapter->receive($_SERVER["QUEUE_NAME"], []);
        $this->adapter->delete($_SERVER["QUEUE_NAME"], $receipt, []);
    }
}

