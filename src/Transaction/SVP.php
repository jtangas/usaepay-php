<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 10/26/17
 * Time: 1:18 PM
 */

namespace USAEpay\Transaction;


class SVP extends AbstractTransaction
{
    protected $svpBank;
    protected $svpReturnUrl;
    protected $svpCancelUrl;

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