<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 10/26/17
 * Time: 1:16 PM
 */

namespace USAEpay\Transaction;


class CreditCardPOS extends Type\CreditCard
{
    protected $magStripe;
    protected $cardPresent;
    protected $termType;
    protected $magSupport;
    protected $contactless;
    protected $dukpt;
    protected $signature;
    protected $reasonCode;

    /**
     * @return mixed
     */
    public function getMagStripe()
    {
        return $this->magStripe;
    }

    /**
     * @param mixed $magStripe
     */
    public function setMagStripe($magStripe)
    {
        $this->magStripe = $magStripe;
    }

    /**
     * @return mixed
     */
    public function getCardPresent()
    {
        return $this->cardPresent;
    }

    /**
     * @param mixed $cardPresent
     */
    public function setCardPresent($cardPresent)
    {
        $this->cardPresent = $cardPresent;
    }

    /**
     * @return mixed
     */
    public function getTermType()
    {
        return $this->termType;
    }

    /**
     * @param mixed $termType
     */
    public function setTermType($termType)
    {
        $this->termType = $termType;
    }

    /**
     * @return mixed
     */
    public function getMagSupport()
    {
        return $this->magSupport;
    }

    /**
     * @param mixed $magSupport
     */
    public function setMagSupport($magSupport)
    {
        $this->magSupport = $magSupport;
    }

    /**
     * @return mixed
     */
    public function getContactless()
    {
        return $this->contactless;
    }

    /**
     * @param mixed $contactless
     */
    public function setContactless($contactless)
    {
        $this->contactless = $contactless;
    }

    /**
     * @return mixed
     */
    public function getDukpt()
    {
        return $this->dukpt;
    }

    /**
     * @param mixed $dukpt
     */
    public function setDukpt($dukpt)
    {
        $this->dukpt = $dukpt;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getReasonCode()
    {
        return $this->reasonCode;
    }

    /**
     * @param mixed $reasonCode
     */
    public function setReasonCode($reasonCode)
    {
        $this->reasonCode = $reasonCode;
    }
}