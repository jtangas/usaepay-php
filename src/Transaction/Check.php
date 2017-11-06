<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 10/26/17
 * Time: 1:17 PM
 */

namespace USAEpay\Transaction;


class Check extends AbstractTransaction
{
    private $account;
    private $routing;
    private $ssn;
    private $dlNum;
    private $dlState;
    private $checkNum;
    protected $accountType;
    protected $checkFormat;
    private $checkImageFront;
    private $checkImageBack;
    protected $auxonus;
    protected $epcCode;
    protected $micr;

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getRouting()
    {
        return $this->routing;
    }

    /**
     * @param mixed $routing
     */
    public function setRouting($routing)
    {
        $this->routing = $routing;
    }

    /**
     * @return mixed
     */
    public function getSsn()
    {
        return $this->ssn;
    }

    /**
     * @param mixed $ssn
     */
    public function setSsn($ssn)
    {
        $this->ssn = $ssn;
    }

    /**
     * @return mixed
     */
    public function getDlNum()
    {
        return $this->dlNum;
    }

    /**
     * @param mixed $dlNum
     */
    public function setDlNum($dlNum)
    {
        $this->dlNum = $dlNum;
    }

    /**
     * @return mixed
     */
    public function getDlState()
    {
        return $this->dlState;
    }

    /**
     * @param mixed $dlState
     */
    public function setDlState($dlState)
    {
        $this->dlState = $dlState;
    }

    /**
     * @return mixed
     */
    public function getCheckNum()
    {
        return $this->checkNum;
    }

    /**
     * @param mixed $checkNum
     */
    public function setCheckNum($checkNum)
    {
        $this->checkNum = $checkNum;
    }

    /**
     * @return mixed
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * @param mixed $accountType
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    }

    /**
     * @return mixed
     */
    public function getCheckFormat()
    {
        return $this->checkFormat;
    }

    /**
     * @param mixed $checkFormat
     */
    public function setCheckFormat($checkFormat)
    {
        $this->checkFormat = $checkFormat;
    }

    /**
     * @return mixed
     */
    public function getCheckImageFront()
    {
        return $this->checkImageFront;
    }

    /**
     * @param mixed $checkImageFront
     */
    public function setCheckImageFront($checkImageFront)
    {
        $this->checkImageFront = $checkImageFront;
    }

    /**
     * @return mixed
     */
    public function getCheckImageBack()
    {
        return $this->checkImageBack;
    }

    /**
     * @param mixed $checkImageBack
     */
    public function setCheckImageBack($checkImageBack)
    {
        $this->checkImageBack = $checkImageBack;
    }

    /**
     * @return mixed
     */
    public function getAuxonus()
    {
        return $this->auxonus;
    }

    /**
     * @param mixed $auxonus
     */
    public function setAuxonus($auxonus)
    {
        $this->auxonus = $auxonus;
    }

    /**
     * @return mixed
     */
    public function getEpcCode()
    {
        return $this->epcCode;
    }

    /**
     * @param mixed $epcCode
     */
    public function setEpcCode($epcCode)
    {
        $this->epcCode = $epcCode;
    }

    /**
     * @return mixed
     */
    public function getMicr()
    {
        return $this->micr;
    }

    /**
     * @param mixed $micr
     */
    public function setMicr($micr)
    {
        $this->micr = $micr;
    }

    /**
     * Tests PHP Installation. If errors are detected, suggested solutions will be displayed.
     *
     * @return mixed
     */
    public function test()
    {
        // TODO: Implement test() method.
    }
}