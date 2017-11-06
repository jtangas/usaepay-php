<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 10/26/17
 * Time: 1:33 PM
 */

namespace USAEpay\Input;


class LineItem
{
    protected $sku;
    protected $name;
    protected $description;
    protected $cost;
    protected $qty;
    protected $taxable;
    protected $refNum;
    protected $um;
    protected $taxRate;
    protected $taxAmount;
    protected $taxClass;
    protected $commodityCode;
    protected $discountRate;
    protected $discountAmount;

    public function __construct($properties=[])
    {
        if ($properties) {
            foreach ($properties as $property=>$value) {
                if (property_exists($this, $property)) {
                    $this->{$property} = $value;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param mixed $qty
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    /**
     * @return mixed
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param mixed $taxable
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
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
    public function getUm()
    {
        return $this->um;
    }

    /**
     * @param mixed $um
     */
    public function setUm($um)
    {
        $this->um = $um;
    }

    /**
     * @return mixed
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param mixed $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
    }

    /**
     * @return mixed
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * @param mixed $taxAmount
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;
    }

    /**
     * @return mixed
     */
    public function getTaxClass()
    {
        return $this->taxClass;
    }

    /**
     * @param mixed $taxClass
     */
    public function setTaxClass($taxClass)
    {
        $this->taxClass = $taxClass;
    }

    /**
     * @return mixed
     */
    public function getCommodityCode()
    {
        return $this->commodityCode;
    }

    /**
     * @param mixed $commodityCode
     */
    public function setCommodityCode($commodityCode)
    {
        $this->commodityCode = $commodityCode;
    }

    /**
     * @return mixed
     */
    public function getDiscountRate()
    {
        return $this->discountRate;
    }

    /**
     * @param mixed $discountRate
     */
    public function setDiscountRate($discountRate)
    {
        $this->discountRate = $discountRate;
    }

    /**
     * @return mixed
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * @param mixed $discountAmount
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
    }
}