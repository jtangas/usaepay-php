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
        $key = '_jLu4KI5kS2E6u4jl2x72dqG5pZkVUK3';
        $pin = '1234';
        $useSandBox = true;
        $testMode = false;
        if (!$useSandBox) {
            $client = Mockery::mock(Client::class);
            $client->shouldReceive('post')
                ->andReturn('');
        } else {
            $client = new Client();
        }

        $gateWay = new Gateway($key, $pin, $useSandBox, $testMode, $client);

        $validCCTrans = [
            'ip'            => '111.111.111.111',
            'amount'        => '100.00',
            'invoice'       => uniqid(),
            'description'   => 'Test Order',
            'card'          => '4111111111111111',
            'exp'           => '0120',
            'cardholder'    => 'Justin Tangas',
            'billstreet'    => '517 4th Ave',
            'billstreet2'   => 'suite 401',
            'zip'           => '92101',
            'cvv2'          => '111'
        ];

        $trans = $gateWay->createTransaction(Gateway::CREDIT_TRANS, $validCCTrans);

        $result = $trans->process();
        var_dump($result->getBody()->getContents());

        $this->assertInstanceOf(CreditCardEcom::class, $trans);

        $this->assertEquals("", $result);
    }
}