<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 11/6/17
 * Time: 12:01 PM
 */

namespace USAEpay\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use USAEpay\Gateway;
use USAEpay\Transaction\CreditCardEcom;
use Mockery;

class GatewayTest extends TestCase
{
    public function testCreateTransaction()
    {
        $key = 'abc123';
        $pin = '1234';
        $useSandBox = false;
        $testMode = false;
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->andReturn('');

        $gateWay = new Gateway($key, $pin, $useSandBox, $testMode, $client);

        $validCCTrans = [
            'ip' => '111.111.111.111',
            'amount' => '100.00',
            'invoice' => uniqid(),
            'description' => 'Test Order'
        ];

        $trans = $gateWay->createTransaction(Gateway::CREDIT_TRANS, $validCCTrans);

        $result = $trans->process();

        $this->assertInstanceOf(CreditCardEcom::class, $trans);

        $this->assertEquals("", $result);
    }
}