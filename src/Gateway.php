<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 10/26/17
 * Time: 12:12 PM
 */

namespace USAEpay;

use GuzzleHttp\Client;
use USAEpay\Transaction\AbstractTransaction;
use USAEpay\Transaction\Check;
use USAEpay\Transaction\CreditCardEcom;
use USAEpay\Transaction\CreditCardPOS;

class Gateway
{
    protected $key, $pin, $useSandBox, $testMode, $client;

    const CREDIT_TRANS  = 'credit';
    const CHECK_TRANS   = 'check';

    public function __construct($key, $pin, $useSandBox, $testMode, $client)
    {
        $this->client       = $client;
        $this->key          = $key;
        $this->pin          = $pin;
        $this->useSandBox   = $useSandBox;
        $this->testMode     = $testMode;
    }

    /**
     * @param string $type
     * @param array $properties
     * @return AbstractTransaction
     */
    public function createTransaction($type, $properties = [])
    {
        switch ($type) {
            case self::CHECK_TRANS:
                $class = Check::class;
                break;
            case self::CREDIT_TRANS:
                $class = CreditCardEcom::class;
                if (isset($properties['pos']) && $properties['pos']) {
                    $class = CreditCardPOS::class;
                }
                break;
            default:
                $class = CreditCardEcom::class;
                break;
        }

        return new $class(
            $this->key,
            $this->pin,
            $this->useSandBox,
            $this->testMode,
            $this->client,
            $properties
        );
    }
}