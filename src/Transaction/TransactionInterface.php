<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 10/26/17
 * Time: 1:22 PM
 */

namespace USAEpay\Transaction;


use USAEpay\Input\LineItem;

interface TransactionInterface
{
    /**
     * Send Transaction to teh USAePay Gateway and parse response
     *
     * @return boolean
     */
    public function process();

    /**
     * @param LineItem $item
     * @return mixed
     */
    public function addLine(LineItem $item);

    /**
     * Returns the subtotal cost for all line items
     * @return float
     */
    public function getLineTotal();

    /**
     * Removes all line items
     *
     * @return void
     */
    public function clearLines();

    /**
     * @deprecated
     */
    public function clearData();

    /**
     * Run a sale by referencing a previous sale (refnum must be set).
     * No Credit card or check data is required.
     *
     * @return boolean
     */
    public function processQuickSale();

    /**
     * Run a refund by referencing a previous sale (refnum must be set).
     * No Credit card or check data is required.
     *
     * @return boolean
     */
    public function processQuickCredit();

    /**
     * Checks Data for errors. (runs automatically during the Process
     * function.
     *
     * @return mixed
     */
    public function checkData();
}