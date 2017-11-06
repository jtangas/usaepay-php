<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 10/26/17
 * Time: 2:50 PM
 */

namespace USAEpay\Transaction\Type;


use USAEpay\Transaction\AbstractTransaction;

class CreditCard extends AbstractTransaction
{
    private $card;
    private $exp;
    private $cardHolder;
    private $street;
    private $zip;
    private $cvv2;

    protected $cardAuth;
    protected $pares;
    protected $xid;
    protected $cavv;
    protected $eci;

    protected $saveCard;

    /**
     * @return mixed
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param mixed $card
     */
    public function setCard($card)
    {
        $this->card = $card;
    }

    /**
     * @return mixed
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * @param mixed $exp
     */
    public function setExp($exp)
    {
        $this->exp = $exp;
    }

    /**
     * @return mixed
     */
    public function getCardHolder()
    {
        return $this->cardHolder;
    }

    /**
     * @param mixed $cardHolder
     */
    public function setCardHolder($cardHolder)
    {
        $this->cardHolder = $cardHolder;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getCvv2()
    {
        return $this->cvv2;
    }

    /**
     * @param mixed $cvv2
     */
    public function setCvv2($cvv2)
    {
        $this->cvv2 = $cvv2;
    }

    /**
     * @return mixed
     */
    public function getCardAuth()
    {
        return $this->cardAuth;
    }

    /**
     * @param mixed $cardAuth
     */
    public function setCardAuth($cardAuth)
    {
        $this->cardAuth = $cardAuth;
    }

    /**
     * @return mixed
     */
    public function getPares()
    {
        return $this->pares;
    }

    /**
     * @param mixed $pares
     */
    public function setPares($pares)
    {
        $this->pares = $pares;
    }

    /**
     * @return mixed
     */
    public function getXid()
    {
        return $this->xid;
    }

    /**
     * @param mixed $xid
     */
    public function setXid($xid)
    {
        $this->xid = $xid;
    }

    /**
     * @return mixed
     */
    public function getCavv()
    {
        return $this->cavv;
    }

    /**
     * @param mixed $cavv
     */
    public function setCavv($cavv)
    {
        $this->cavv = $cavv;
    }

    /**
     * @return mixed
     */
    public function getEci()
    {
        return $this->eci;
    }

    /**
     * @param mixed $eci
     */
    public function setEci($eci)
    {
        $this->eci = $eci;
    }
}