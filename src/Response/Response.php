<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 10/26/17
 * Time: 3:59 PM
 */

namespace USAEpay\Response;


class Response
{
    protected $rawResult;
    protected $result;
    protected $resultCode;
    protected $authCode;
    protected $refNum;
    protected $batch;
    protected $avsResult;
    protected $avsResultCode;
    protected $avs;
    protected $cvv2Result;
    protected $cvv2ResultCode;
    protected $vpasResultCode;
    protected $isDuplicate;
    protected $convertedAmount;
    protected $convertedAmountCurrency;
    protected $conversionRate;
    protected $custNum;
    protected $authAmount;
    protected $balance;
    protected $cardLevelResult;
    protected $procRefNum;
    protected $cardRef;
    protected $acsUrl;
    protected $pareq;
    protected $ccTransId;
    protected $profilerScore;
    protected $profilerResponse;
    protected $profilerReason;
    protected $error;
    protected $errorCode;
    protected $blank;
    protected $transportError;

    /**
     * @return mixed
     */
    public function getRawResult()
    {
        return $this->rawResult;
    }

    /**
     * @param mixed $rawResult
     */
    public function setRawResult($rawResult)
    {
        $this->rawResult = $rawResult;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResultCode()
    {
        return $this->resultCode;
    }

    /**
     * @param mixed $resultCode
     */
    public function setResultCode($resultCode)
    {
        $this->resultCode = $resultCode;
    }

    /**
     * @return mixed
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * @param mixed $authCode
     */
    public function setAuthCode($authCode)
    {
        $this->authCode = $authCode;
    }

    /**
     * @return mixed
     */
    public function getRefNum()
    {
        return $this->refNum;
    }

    /**
     * @param mixed $refNum
     */
    public function setRefNum($refNum)
    {
        $this->refNum = $refNum;
    }

    /**
     * @return mixed
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param mixed $batch
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;
    }

    /**
     * @return mixed
     */
    public function getAvsResult()
    {
        return $this->avsResult;
    }

    /**
     * @param mixed $avsResult
     */
    public function setAvsResult($avsResult)
    {
        $this->avsResult = $avsResult;
    }

    /**
     * @return mixed
     */
    public function getAvsResultCode()
    {
        return $this->avsResultCode;
    }

    /**
     * @param mixed $avsResultCode
     */
    public function setAvsResultCode($avsResultCode)
    {
        $this->avsResultCode = $avsResultCode;
    }

    /**
     * @return mixed
     */
    public function getAvs()
    {
        return $this->avs;
    }

    /**
     * @param mixed $avs
     */
    public function setAvs($avs)
    {
        $this->avs = $avs;
    }

    /**
     * @return mixed
     */
    public function getCvv2Result()
    {
        return $this->cvv2Result;
    }

    /**
     * @param mixed $cvv2Result
     */
    public function setCvv2Result($cvv2Result)
    {
        $this->cvv2Result = $cvv2Result;
    }

    /**
     * @return mixed
     */
    public function getCvv2ResultCode()
    {
        return $this->cvv2ResultCode;
    }

    /**
     * @param mixed $cvv2ResultCode
     */
    public function setCvv2ResultCode($cvv2ResultCode)
    {
        $this->cvv2ResultCode = $cvv2ResultCode;
    }

    /**
     * @return mixed
     */
    public function getVpasResultCode()
    {
        return $this->vpasResultCode;
    }

    /**
     * @param mixed $vpasResultCode
     */
    public function setVpasResultCode($vpasResultCode)
    {
        $this->vpasResultCode = $vpasResultCode;
    }

    /**
     * @return mixed
     */
    public function getisDuplicate()
    {
        return $this->isDuplicate;
    }

    /**
     * @param mixed $isDuplicate
     */
    public function setIsDuplicate($isDuplicate)
    {
        $this->isDuplicate = $isDuplicate;
    }

    /**
     * @return mixed
     */
    public function getConvertedAmount()
    {
        return $this->convertedAmount;
    }

    /**
     * @param mixed $convertedAmount
     */
    public function setConvertedAmount($convertedAmount)
    {
        $this->convertedAmount = $convertedAmount;
    }

    /**
     * @return mixed
     */
    public function getConvertedAmountCurrency()
    {
        return $this->convertedAmountCurrency;
    }

    /**
     * @param mixed $convertedAmountCurrency
     */
    public function setConvertedAmountCurrency($convertedAmountCurrency)
    {
        $this->convertedAmountCurrency = $convertedAmountCurrency;
    }

    /**
     * @return mixed
     */
    public function getConversionRate()
    {
        return $this->conversionRate;
    }

    /**
     * @param mixed $conversionRate
     */
    public function setConversionRate($conversionRate)
    {
        $this->conversionRate = $conversionRate;
    }

    /**
     * @return mixed
     */
    public function getCustNum()
    {
        return $this->custNum;
    }

    /**
     * @param mixed $custNum
     */
    public function setCustNum($custNum)
    {
        $this->custNum = $custNum;
    }

    /**
     * @return mixed
     */
    public function getAuthAmount()
    {
        return $this->authAmount;
    }

    /**
     * @param mixed $authAmount
     */
    public function setAuthAmount($authAmount)
    {
        $this->authAmount = $authAmount;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return mixed
     */
    public function getCardLevelResult()
    {
        return $this->cardLevelResult;
    }

    /**
     * @param mixed $cardLevelResult
     */
    public function setCardLevelResult($cardLevelResult)
    {
        $this->cardLevelResult = $cardLevelResult;
    }

    /**
     * @return mixed
     */
    public function getProcRefNum()
    {
        return $this->procRefNum;
    }

    /**
     * @param mixed $procRefNum
     */
    public function setProcRefNum($procRefNum)
    {
        $this->procRefNum = $procRefNum;
    }

    /**
     * @return mixed
     */
    public function getCardRef()
    {
        return $this->cardRef;
    }

    /**
     * @param mixed $cardRef
     */
    public function setCardRef($cardRef)
    {
        $this->cardRef = $cardRef;
    }

    /**
     * @return mixed
     */
    public function getAcsUrl()
    {
        return $this->acsUrl;
    }

    /**
     * @param mixed $acsUrl
     */
    public function setAcsUrl($acsUrl)
    {
        $this->acsUrl = $acsUrl;
    }

    /**
     * @return mixed
     */
    public function getPareq()
    {
        return $this->pareq;
    }

    /**
     * @param mixed $pareq
     */
    public function setPareq($pareq)
    {
        $this->pareq = $pareq;
    }

    /**
     * @return mixed
     */
    public function getCcTransId()
    {
        return $this->ccTransId;
    }

    /**
     * @param mixed $ccTransId
     */
    public function setCcTransId($ccTransId)
    {
        $this->ccTransId = $ccTransId;
    }

    /**
     * @return mixed
     */
    public function getProfilerScore()
    {
        return $this->profilerScore;
    }

    /**
     * @param mixed $profilerScore
     */
    public function setProfilerScore($profilerScore)
    {
        $this->profilerScore = $profilerScore;
    }

    /**
     * @return mixed
     */
    public function getProfilerResponse()
    {
        return $this->profilerResponse;
    }

    /**
     * @param mixed $profilerResponse
     */
    public function setProfilerResponse($profilerResponse)
    {
        $this->profilerResponse = $profilerResponse;
    }

    /**
     * @return mixed
     */
    public function getProfilerReason()
    {
        return $this->profilerReason;
    }

    /**
     * @param mixed $profilerReason
     */
    public function setProfilerReason($profilerReason)
    {
        $this->profilerReason = $profilerReason;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param mixed $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return mixed
     */
    public function getBlank()
    {
        return $this->blank;
    }

    /**
     * @param mixed $blank
     */
    public function setBlank($blank)
    {
        $this->blank = $blank;
    }

    /**
     * @return mixed
     */
    public function getTransportError()
    {
        return $this->transportError;
    }

    /**
     * @param mixed $transportError
     */
    public function setTransportError($transportError)
    {
        $this->transportError = $transportError;
    }
}