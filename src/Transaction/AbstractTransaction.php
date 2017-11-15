<?php
/**
 * Created by PhpStorm.
 * User: justintangas
 * Date: 10/26/17
 * Time: 2:29 PM
 */

namespace USAEpay\Transaction;


use GuzzleHttp\Client;
use USAEpay\Input\LineItem;
use USAEpay\Response\Response;

abstract class AbstractTransaction implements TransactionInterface
{

    # region Constants
    const ERROR_REF_NUM_REQUIRED = 'Reference Number is Required';
    const USAEPAY_VERSION = "1.7.1";
    const DEFAULT_GATEWAY = 'https://www.usaepay.com/gate';
    const SANDBOX_GATEWAY = 'https://sandbox.usaepay.com/gate';

    /** commands */
    const CMD_SALE              = 'cc:sale';
    const CMD_VOID              = 'void';
    const CMD_CREDIT            = 'credit';
    const CMD_PRE_AUTH          = 'preauth';
    const CMD_POST_AUTH         = 'postauth';
    const CMD_REFUND            = 'refund';
    const CMD_CAPTURE           = 'capture';
    const CMD_CREDIT_VOID       = 'creditvoid';
    const CMD_QUICK_SALE        = 'quicksale';
    const CMD_QUICK_CREDIT      = 'quickcredit';
    const CMD_REFUND_ADJUST     = 'refund:adjust';
    const CMD_VOID_RELEASE      = 'void:release';
    const CMD_SVP               = 'svp';
    const CMD_CASH              = 'cash';
    const CMD_CASH_REFUND       = 'cash:refund';
    const CMD_CASH_SALE         = 'cash:sale';
    const CMD_EXTERNAL_CHECK    = 'external:check:sale';
    const CMD_EXTERNAL_CC       = 'external:cc:sale';
    const CMD_EXTERNAL_GIFT     = 'external:gift:sale';
    const CMD_CHECK             = 'check';
    const CMD_CHECK_SALE        = 'check:sale';
    const CMD_CHECK_CREDIT      = 'check:credit';
    const CMD_CHECKCREDIT       = 'checkcredit';
    const CMD_CHECK_REFUND      = 'check:refund';
    const CMD_CHECK_VOID        = 'check:void';
    const CMD_REVERSE_ACH       = 'reversach';
    const CMD_CC_CAPTURE        = 'cc:capture';
    const CMD_CC_REFUND         = 'cc:refund';
    const CMD_CC_SAVE           = 'cc:save';

    /** classFields for checks */
    const RECURRING             = 'isrecurring';
    const NON_TAXABLE           = 'nontaxable';
    const CHECKIMG_FRONT        = 'checkimagefront';
    const CHECKIMG_BACK         = 'checkimageback';
    const BILL_SRC_KEY          = 'billsourcekey';
    const CARD_PRESENT          = 'cardpresent';
    const ALLOW_PARTIAL_AUTH    = 'allowpartialauth';
    const SAVE_CARD             = 'savecard';

    /** auth expiration conditions */
    const AUTH_EXP_COND_IGNORE  = 'ignore';
    const AUTH_EXP_COND_ERROR   = 'error';
    const AUTH_EXP_COND_REAUTH  = 'reauth';

    /** recurring schedules */
    const SCHEDULE_DAILY        = 'daily';
    const SCHEDULE_WEEKLY       = 'weekly';
    const SCHEDULE_BIWEEKLY     = 'biweekly';
    const SCHEDULE_MONTHLY      = 'monthly';
    const SCHEDULE_BIMONTHLY    = 'bimonthly';
    const SCHEDULE_QUARTERLY    = 'quarterly';
    const SCHEDULE_ANNUALLY     = 'annually';
    const SCHEDULE_DISABLED     = 'disabled';

    /** error messages */
    const ERROR_SVP_BANK        = 'Bank ID is Required';
    const ERROR_SVP_RETURN_URL  = 'Return URL is Required';
    const ERROR_SVP_CANCEL_URL  = 'Cancel URL is Required';
    const ERROR_CHECK_ACCOUNT   = 'Account Number is Required';
    const ERROR_CHECK_ROUTING   = 'Routing Number is Required';
    const ERROR_CC_EMPTY        = 'Credit Card Number is Required';
    const ERROR_CC_EXP          = 'Expiration Date is Required';
    const ERROR_INVALID_DATA    = 10129;

    /** unformatted api fields */
    const CUSTOMFIELD           = 'UMcustom%i';
    const LINE_SKU              = 'UMline%isku';
    const LINE_NAME             = 'UMline%iname';
    const LINE_DESC             = 'UMline%idescription';
    const LINE_COST             = 'UMline%icost';
    const LINE_TAXABLE          = 'UMline%itaxable';
    const LINE_QTY              = 'UMline%iqty';
    const LINE_REFNUM           = 'UMline%iprodRefNum';
    const LINE_UM               = 'UMline%ium';
    const LINE_TAXRATE          = 'UMline%itaxrate';
    const LINE_TAXAMT           = 'UMline%itaxamt';
    const LINE_TAXCLASS         = 'UMline%itaxclass';
    const LINE_CMDTY_CODE       = 'UMline%icommoditycode';
    const LINE_DISCOUNT_RATE    = 'UMline%idiscountrate';
    const LINE_DISCOUNT_AMT     = 'UMline%idiscountamt';
    const CHECK_IMG_ENCODING    = 'UMcheckimageencoding';
    const HASH                  = 'UMhash';
    const TIMEOUT               = 'UMtimeout';

    /** hash formats */
    const SHA1_HASH             = 's/%d/%s/n';
    const MD5_HASH              = 'm/%d/%s/n';

    # endregion

    private $key;
    private $pin;

    /**
     * @var LineItem[]|array
     */
    protected $lineItems = [];

    protected $amount;
    protected $invoice;
    protected $poNum;
    protected $tax;
    protected $nonTaxable;
    protected $digitalGoods;
    protected $duty;
    protected $shipFromZip;
    protected $tip;
    protected $shipping;
    protected $discount;
    protected $subTotal;
    protected $currency;
    protected $allowPartialAuth;

    # region OptionalItems
    protected $origAuthoCode;
    protected $command = self::CMD_SALE;
    protected $orderId;
    protected $custId;
    protected $description;
    protected $custEmail;
    protected $custReceipt;
    protected $custReceiptName;
    protected $ignoreDuplicate;
    protected $ip;
    protected $geoLocation;
    protected $testMode = false;
    protected $useSandBox = false;
    protected $timeout;
    protected $gatewayUrl;
    protected $proxyUrl;
    protected $ignoreSSLCertErrors;
    protected $caBundle;
    protected $transport;
    protected $clerk;
    protected $terminal;
    protected $restaurantTable;
    protected $ticketedEvent;
    protected $ifAuthExpired;
    protected $authExpireDays;
    protected $inventoryLocation;

    protected $addCustomer;
    protected $recurring;
    protected $schedule = self::SCHEDULE_DISABLED;
    protected $numLeft;
    protected $start;
    protected $end;
    protected $billAmount;
    protected $billTax;
    protected $billSourceKey;

    protected $isRecurring;
    # endregion

    # region BillingFields;
    protected $billFirstName;
    protected $billLastName;
    protected $billCompany;
    protected $billStreet;
    protected $billStreet2;
    protected $billCity;
    protected $billState;
    protected $billZip;
    protected $billCountry;
    protected $billPhone;
    protected $email;
    protected $fax;
    protected $website;
    # endregion

    # region ShippingFields
    protected $delivery;
    protected $shipFirstName;
    protected $shipLastName;
    protected $shipCompany;
    protected $shipStreet;
    protected $shipStreet2;
    protected $shipCity;
    protected $shipState;
    protected $shipZip;
    protected $shipCountry;
    protected $shipPhone;
    # endregion

    # region CustomFields
    protected $customFields = [];
    # endregion

    /**
     * @var Client
     */
    protected $client;

    protected $comments;
    protected $software;
    protected $session;
    protected $refNum;
    protected $response;
    protected $fieldMappings = [
        "UMkey"                 => 'key',
        "UMcommand"             => 'command',
        "UMauthCode"            => 'origauthcode',
        "UMcard"                => 'card',
        "UMexpir"               => 'exp',
        "UMamount"              => 'amount',
        "UMinvoice"             => 'invoice',
        "UMorderid"             => 'orderid',
        "UMponum"               => 'ponum',
        "UMtax"                 => 'tax',
        "UMnontaxable"          => 'nontaxable',
        "UMtip"                 => 'tip',
        "UMshipping"            => 'shipping',
        "UMdiscount"            => 'discount',
        "UMsubtotal"            => 'subtotal',
        "UMcurrency"            => 'currency',
        "UMname"                => 'cardholder',
        "UMstreet"              => 'street',
        "UMzip"                 => 'zip',
        "UMdescription"         => 'description',
        "UMcomments"            => 'comments',
        "UMcvv2"                => 'cvv2',
        "UMip"                  => 'ip',
        "UMtestmode"            => 'testmode',
        "UMcustemail"           => 'custemail',
        "UMcustreceipt"         => 'custreceipt',
        "UMrouting"             => 'routing',
        "UMaccount"             => 'account',
        "UMssn"                 => 'ssn',
        "UMdlstate"             => 'dlstate',
        "UMdlnum"               => 'dlnum',
        "UMchecknum"            => 'checknum',
        "UMaccounttype"         => 'accounttype',
        "UMcheckformat"         => 'checkformat',
        "UMcheckimagefront"     => 'checkimage_front',
        "UMcheckimageback"      => 'checkimage_back',
        "UMaddcustomer"         => 'addcustomer',
        "UMrecurring"           => 'recurring',
        "UMbillamount"          => 'billamount',
        "UMbilltax"             => 'billtax',
        "UMschedule"            => 'schedule',
        "UMnumleft"             => 'numleft',
        "UMstart"               => 'start',
        "UMexpire"              => 'end',
        "UMbillsourcekey"       => 'billsourcekey',
        "UMbillfname"           => 'billfname',
        "UMbilllname"           => 'billlname',
        "UMbillcompany"         => 'billcompany',
        "UMbillstreet"          => 'billstreet',
        "UMbillstreet2"         => 'billstreet2',
        "UMbillcity"            => 'billcity',
        "UMbillstate"           => 'billstate',
        "UMbillzip"             => 'billzip',
        "UMbillcountry"         => 'billcountry',
        "UMbillphone"           => 'billphone',
        "UMemail"               => 'email',
        "UMfax"                 => 'fax',
        "UMwebsite"             => 'website',
        "UMshipfname"           => 'shipfname',
        "UMshiplname"           => 'shiplname',
        "UMshipcompany"         => 'shipcompany',
        "UMshipstreet"          => 'shipstreet',
        "UMshipstreet2"         => 'shipstreet2',
        "UMshipcity"            => 'shipcity',
        "UMshipstate"           => 'shipstate',
        "UMshipzip"             => 'shipzip',
        "UMshipcountry"         => 'shipcountry',
        "UMshipphone"           => 'shipphone',
        "UMcardauth"            => 'cardauth',
        "UMpares"               => 'pares',
        "UMxid"                 => 'xid',
        "UMcavv"                => 'cavv',
        "UMeci"                 => 'eci',
        "UMcustid"              => 'custid',
        "UMcardpresent"         => 'cardpresent',
        "UMmagstripe"           => 'magstripe',
        "UMdukpt"               => 'dukpt',
        "UMtermtype"            => 'termtype',
        "UMreasonCode"          => 'reasoncode',
        "UMmagsupport"          => 'magsupport',
        "UMcontactless"         => 'contactless',
        "UMsignature"           => 'signature',
        "UMsoftware"            => 'software',
        "UMignoreDuplicate"     => 'ignoreduplicate',
        "UMrefNum"              => 'refnum',
        'UMauxonus'             => 'auxonus',
        'UMepcCode'             => 'epccode',
        'UMcustreceiptname'     => 'custreceiptname',
        'UMallowPartialAuth'    => 'allowpartialauth',
        'UMdigitalGoods'        => 'digitalgoods',
        'UMmicr'                => 'micr',
        'UMsession'             => 'session',
        'UMisRecurring'         => 'isrecurring',
        'UMclerk'               => 'clerk',
        'UMtranterm'            => 'terminal',
        'UMresttable'           => 'restaurant_table',
        'UMticketedEvent'       => 'ticketedevent',
        'UMifAuthExpired'       => 'ifauthexpired',
        'UMauthExpireDays'      => 'authexpiredays',
        'UMinventorylocation'   => 'inventorylocation',
        'UMduty'                => 'duty',
        'UMshipfromzip'         => 'shipfromzip',
        'UMsaveCard'            => 'savecard',
        'UMlocation'            => 'geolocation',
    ];

    public function __construct(
        $key,
        $pin,
        $useSandBox = false,
        $testMode = false,
        Client $client,
        $properties = []
    )
    {
        $this->key = $key;
        $this->pin = $pin;
        $this->useSandBox = $useSandBox;
        $this->testMode = $testMode;
        $this->client = $client;

        $propList = get_class_vars(get_class($this));
        $carry = [];
        $propList = array_reduce(array_keys($propList), function($carry, $item) {
            $carry[str_replace("_", "", strtolower($item))] = $item;
            return $carry;
        }, $carry);



        foreach ($properties as $property => $value) {
            $normProp = str_replace("_", "", strtolower($property));
            if (array_key_exists($normProp, $propList)) {
                $this->{"set" . ucfirst($propList[$normProp])}($value);
            }
        }
    }

    public function process()
    {
        $sanityCheck = $this->checkData();
        if ($sanityCheck) {
            $this->response = new Response();
            $this->response->setResult("Error");
            $this->response->setResultCode("E");
            $this->response->setError($sanityCheck);
            $this->response->setErrorCode(self::ERROR_INVALID_DATA);
        }

        foreach ($this->fieldMappings as $apiField => $classField) {
            if (!property_exists($this, $classField)) {
                continue;
            }

            $normalized = str_replace("_", "", strtolower($classField));

            switch ($normalized) {
                case self::RECURRING:
                case self::NON_TAXABLE:
                    $data[$apiField] = ($this->{$classField}) ? "Y" : "N";
                    break;
                case self::CHECKIMG_FRONT:
                case self::CHECKIMG_BACK:
                    $data[$apiField] = base64_encode($this->{$classField});
                    $data[self::CHECK_IMG_ENCODING] = 'base64';
                    break;
                case self::BILL_SRC_KEY:
                    $data[$apiField] = ($this->{$classField}) ? "yes" : "no";
                    break;
                case self::CARD_PRESENT:
                    $data[$apiField] = ($this->{$classField}) ? "1" : "0";
                    break;
                case self::ALLOW_PARTIAL_AUTH:
                    $data[$apiField] = ($this->{$classField}) ? "Yes" : "No";
                    break;
                case self::SAVE_CARD:
                    $data[$apiField] = ($this->{$classField}) ? "y": "n";
                    break;
                default:
                    $data[$apiField] = $this->{$classField};
                    break;
            }
        }

        $customFields = array_slice($this->customFields, 0, 20);
        foreach ($customFields as $index => $value) {
            $data[self::CUSTOMFIELD . ($index+1)] = $value;
        }

        foreach ($this->lineItems as $i => $line) {
            $data[sprintf(self::LINE_SKU, $i)]              = $line->getSku();
            $data[sprintf(self::LINE_NAME, $i)]             = $line->getName();
            $data[sprintf(self::LINE_DESC, $i)]             = $line->getDescription();
            $data[sprintf(self::LINE_COST, $i)]             = $line->getCost();
            $data[sprintf(self::LINE_TAXABLE, $i)]          = $line->getTaxable();
            $data[sprintf(self::LINE_QTY, $i)]              = $line->getQty();
            if ($line->getRefNum()) {
                $data[sprintf(self::LINE_REFNUM, $i)]       = $line->getRefNum();
            }
            $data[sprintf(self::LINE_UM, $i)]               = $line->getUm();
            $data[sprintf(self::LINE_TAXRATE, $i)]          = $line->getTaxRate();
            $data[sprintf(self::LINE_TAXAMT, $i)]           = $line->getTaxAmount();
            $data[sprintf(self::LINE_TAXCLASS, $i)]         = $line->getTaxClass();
            $data[sprintf(self::LINE_CMDTY_CODE, $i)]       = $line->getCommodityCode();
            $data[sprintf(self::LINE_DISCOUNT_RATE, $i)]    = $line->getDiscountRate();
            $data[sprintf(self::LINE_DISCOUNT_AMT, $i)]     = $line->getDiscountAmount();
        }

        if (trim($this->getPin())) {
            $seed = microtime(true) . rand();
            $preHash = [
                $this->command,
                trim($this->pin),
                $this->amount,
                $this->invoice,
                $seed,
            ];

            $hashType = (function_exists('sha1')) ? self::SHA1_HASH : self::MD5_HASH;

            $hash = sprintf($hashType, $seed, sha1(implode(":", $preHash)));
            $data[self::HASH] = $hash;
        }

        if ($this->timeout) {
            $data[self::TIMEOUT] = intval($this->timeout);
        }

        $url = ($this->gatewayUrl) ? $this->gatewayUrl : self::DEFAULT_GATEWAY;
        if ($this->useSandBox) {
            $url = self::SANDBOX_GATEWAY;
        }

        var_dump($data);
        var_dump($url);

        /** @TODO do guzzle stuff here */
        $result = $this->client->post($url);

        var_dump($result->getBody()->getContents());die();

        return $result;
    }

    public function addLine(LineItem $item)
    {
        $this->lineItems[] = $item;
    }

    public function getLineTotal()
    {
        $total = 0;
        foreach ($this->lineItems as $item) {
            $total += (intval($item->getCost()*100) * intval($item->getQty()));
        }
        return number_format($total/100, 2, '.', '');
    }

    public function clearLines()
    {
        $this->lineItems = [];
    }

    public function clearData()
    {

    }

    public function processQuickSale()
    {
        // TODO: Implement processQuickSale() method.
    }

    public function processQuickCredit()
    {
        // TODO: Implement processQuickCredit() method.
    }

    public function checkData()
    {
        $errors = [];

        if (!$this->key) {
            $errors[] = "Source Key is Required";
        }

        switch (strtolower($this->command)) {
            case self::CMD_CC_CAPTURE:
            case self::CMD_CC_REFUND:
            case self::CMD_REFUND:
            case self::CMD_CHECK_REFUND:
            case self::CMD_CAPTURE:
            case self::CMD_CREDIT_VOID:
            case self::CMD_QUICK_SALE:
            case self::CMD_QUICK_CREDIT:
            case self::CMD_REFUND_ADJUST:
            case self::CMD_VOID_RELEASE:
            case self::CMD_CHECK_VOID:
            case self::CMD_VOID:
                if (!$this->refNum) {
                    $errors[] = self::ERROR_REF_NUM_REQUIRED;
                }
                break;
            case self::CMD_SVP:
                if (!$this->svpBank) {
                    $errors[] = self::ERROR_SVP_BANK;
                }

                if (!$this->svpReturnUrl) {
                    $errors[] = self::ERROR_SVP_RETURN_URL;
                }

                if (!$this->svpCancelUrl) {
                    $errors[] = self::ERROR_SVP_CANCEL_URL;
                }
                break;
            case self::CMD_CHECK_SALE:
            case self::CMD_CHECK_CREDIT:
            case self::CMD_CHECK:
            case self::CMD_CHECKCREDIT:
            case self::CMD_REVERSE_ACH:
                if (!$this->account) {
                    $errors[] = self::ERROR_CHECK_ACCOUNT;
                }

                if (!$this->routing) {
                    $errors[] = self::ERROR_CHECK_ROUTING;
                }
                break;
            case self::CMD_SALE:
                if (!property_exists($this, 'magStripe')) {continue;}
                if (!$this->magStripe && !preg_match('~^enc://~', $this->card)) {
                    if (!$this->card) {
                        $errors[] = self::ERROR_CC_EMPTY;
                    }

                    if (!$this->exp) {
                        $errors[] = self::ERROR_CC_EXP;
                    }
                }
                break;
        }

        if (!$errors) {
            return false;
        }

        return $errors;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @param mixed $pin
     */
    public function setPin($pin)
    {
        $this->pin = $pin;
    }

    /**
     * @return array
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * @param array $lineItems
     */
    public function setLineItems($lineItems)
    {
        $this->lineItems = $lineItems;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @param mixed $invoice
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * @return mixed
     */
    public function getPoNum()
    {
        return $this->poNum;
    }

    /**
     * @param mixed $poNum
     */
    public function setPoNum($poNum)
    {
        $this->poNum = $poNum;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param mixed $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return mixed
     */
    public function getNonTaxable()
    {
        return $this->nonTaxable;
    }

    /**
     * @param mixed $nonTaxable
     */
    public function setNonTaxable($nonTaxable)
    {
        $this->nonTaxable = $nonTaxable;
    }

    /**
     * @return mixed
     */
    public function getDigitalGoods()
    {
        return $this->digitalGoods;
    }

    /**
     * @param mixed $digitalGoods
     */
    public function setDigitalGoods($digitalGoods)
    {
        $this->digitalGoods = $digitalGoods;
    }

    /**
     * @return mixed
     */
    public function getDuty()
    {
        return $this->duty;
    }

    /**
     * @param mixed $duty
     */
    public function setDuty($duty)
    {
        $this->duty = $duty;
    }

    /**
     * @return mixed
     */
    public function getShipFromZip()
    {
        return $this->shipFromZip;
    }

    /**
     * @param mixed $shipFromZip
     */
    public function setShipFromZip($shipFromZip)
    {
        $this->shipFromZip = $shipFromZip;
    }

    /**
     * @return mixed
     */
    public function getTip()
    {
        return $this->tip;
    }

    /**
     * @param mixed $tip
     */
    public function setTip($tip)
    {
        $this->tip = $tip;
    }

    /**
     * @return mixed
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param mixed $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * @param mixed $subTotal
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getAllowPartialAuth()
    {
        return $this->allowPartialAuth;
    }

    /**
     * @param mixed $allowPartialAuth
     */
    public function setAllowPartialAuth($allowPartialAuth)
    {
        $this->allowPartialAuth = $allowPartialAuth;
    }

    /**
     * @return mixed
     */
    public function getOrigAuthoCode()
    {
        return $this->origAuthoCode;
    }

    /**
     * @param mixed $origAuthoCode
     */
    public function setOrigAuthoCode($origAuthoCode)
    {
        $this->origAuthoCode = $origAuthoCode;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed
     */
    public function getCustId()
    {
        return $this->custId;
    }

    /**
     * @param mixed $custId
     */
    public function setCustId($custId)
    {
        $this->custId = $custId;
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
    public function getCustEmail()
    {
        return $this->custEmail;
    }

    /**
     * @param mixed $custEmail
     */
    public function setCustEmail($custEmail)
    {
        $this->custEmail = $custEmail;
    }

    /**
     * @return mixed
     */
    public function getCustReceipt()
    {
        return $this->custReceipt;
    }

    /**
     * @param mixed $custReceipt
     */
    public function setCustReceipt($custReceipt)
    {
        $this->custReceipt = $custReceipt;
    }

    /**
     * @return mixed
     */
    public function getCustReceiptName()
    {
        return $this->custReceiptName;
    }

    /**
     * @param mixed $custReceiptName
     */
    public function setCustReceiptName($custReceiptName)
    {
        $this->custReceiptName = $custReceiptName;
    }

    /**
     * @return mixed
     */
    public function getIgnoreDuplicate()
    {
        return $this->ignoreDuplicate;
    }

    /**
     * @param mixed $ignoreDuplicate
     */
    public function setIgnoreDuplicate($ignoreDuplicate)
    {
        $this->ignoreDuplicate = $ignoreDuplicate;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getGeoLocation()
    {
        return $this->geoLocation;
    }

    /**
     * @param mixed $geoLocation
     */
    public function setGeoLocation($geoLocation)
    {
        $this->geoLocation = $geoLocation;
    }

    /**
     * @return bool
     */
    public function isTestMode()
    {
        return $this->testMode;
    }

    /**
     * @param bool $testMode
     */
    public function setTestMode($testMode)
    {
        $this->testMode = $testMode;
    }

    /**
     * @return bool
     */
    public function isUseSandBox()
    {
        return $this->useSandBox;
    }

    /**
     * @param bool $useSandBox
     */
    public function setUseSandBox($useSandBox)
    {
        $this->useSandBox = $useSandBox;
    }

    /**
     * @return mixed
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return mixed
     */
    public function getGatewayUrl()
    {
        return $this->gatewayUrl;
    }

    /**
     * @param mixed $gatewayUrl
     */
    public function setGatewayUrl($gatewayUrl)
    {
        $this->gatewayUrl = $gatewayUrl;
    }

    /**
     * @return mixed
     */
    public function getProxyUrl()
    {
        return $this->proxyUrl;
    }

    /**
     * @param mixed $proxyUrl
     */
    public function setProxyUrl($proxyUrl)
    {
        $this->proxyUrl = $proxyUrl;
    }

    /**
     * @return mixed
     */
    public function getIgnoreSSLCertErrors()
    {
        return $this->ignoreSSLCertErrors;
    }

    /**
     * @param mixed $ignoreSSLCertErrors
     */
    public function setIgnoreSSLCertErrors($ignoreSSLCertErrors)
    {
        $this->ignoreSSLCertErrors = $ignoreSSLCertErrors;
    }

    /**
     * @return mixed
     */
    public function getCaBundle()
    {
        return $this->caBundle;
    }

    /**
     * @param mixed $caBundle
     */
    public function setCaBundle($caBundle)
    {
        $this->caBundle = $caBundle;
    }

    /**
     * @return mixed
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param mixed $transport
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
    }

    /**
     * @return mixed
     */
    public function getClerk()
    {
        return $this->clerk;
    }

    /**
     * @param mixed $clerk
     */
    public function setClerk($clerk)
    {
        $this->clerk = $clerk;
    }

    /**
     * @return mixed
     */
    public function getTerminal()
    {
        return $this->terminal;
    }

    /**
     * @param mixed $terminal
     */
    public function setTerminal($terminal)
    {
        $this->terminal = $terminal;
    }

    /**
     * @return mixed
     */
    public function getRestaurantTable()
    {
        return $this->restaurantTable;
    }

    /**
     * @param mixed $restaurantTable
     */
    public function setRestaurantTable($restaurantTable)
    {
        $this->restaurantTable = $restaurantTable;
    }

    /**
     * @return mixed
     */
    public function getTicketedEvent()
    {
        return $this->ticketedEvent;
    }

    /**
     * @param mixed $ticketedEvent
     */
    public function setTicketedEvent($ticketedEvent)
    {
        $this->ticketedEvent = $ticketedEvent;
    }

    /**
     * @return mixed
     */
    public function getIfAuthExpired()
    {
        return $this->ifAuthExpired;
    }

    /**
     * @param mixed $ifAuthExpired
     */
    public function setIfAuthExpired($ifAuthExpired)
    {
        $this->ifAuthExpired = $ifAuthExpired;
    }

    /**
     * @return mixed
     */
    public function getAuthExpireDays()
    {
        return $this->authExpireDays;
    }

    /**
     * @param mixed $authExpireDays
     */
    public function setAuthExpireDays($authExpireDays)
    {
        $this->authExpireDays = $authExpireDays;
    }

    /**
     * @return mixed
     */
    public function getInventoryLocation()
    {
        return $this->inventoryLocation;
    }

    /**
     * @param mixed $inventoryLocation
     */
    public function setInventoryLocation($inventoryLocation)
    {
        $this->inventoryLocation = $inventoryLocation;
    }

    /**
     * @return mixed
     */
    public function getAddCustomer()
    {
        return $this->addCustomer;
    }

    /**
     * @param mixed $addCustomer
     */
    public function setAddCustomer($addCustomer)
    {
        $this->addCustomer = $addCustomer;
    }

    /**
     * @return mixed
     */
    public function getRecurring()
    {
        return $this->recurring;
    }

    /**
     * @param mixed $recurring
     */
    public function setRecurring($recurring)
    {
        $this->recurring = $recurring;
    }

    /**
     * @return string
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @param string $schedule
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @return mixed
     */
    public function getNumLeft()
    {
        return $this->numLeft;
    }

    /**
     * @param mixed $numLeft
     */
    public function setNumLeft($numLeft)
    {
        $this->numLeft = $numLeft;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getBillAmount()
    {
        return $this->billAmount;
    }

    /**
     * @param mixed $billAmount
     */
    public function setBillAmount($billAmount)
    {
        $this->billAmount = $billAmount;
    }

    /**
     * @return mixed
     */
    public function getBillTax()
    {
        return $this->billTax;
    }

    /**
     * @param mixed $billTax
     */
    public function setBillTax($billTax)
    {
        $this->billTax = $billTax;
    }

    /**
     * @return mixed
     */
    public function getBillSourceKey()
    {
        return $this->billSourceKey;
    }

    /**
     * @param mixed $billSourceKey
     */
    public function setBillSourceKey($billSourceKey)
    {
        $this->billSourceKey = $billSourceKey;
    }

    /**
     * @return mixed
     */
    public function getisRecurring()
    {
        return $this->isRecurring;
    }

    /**
     * @param mixed $isRecurring
     */
    public function setIsRecurring($isRecurring)
    {
        $this->isRecurring = $isRecurring;
    }

    /**
     * @return mixed
     */
    public function getBillFirstName()
    {
        return $this->billFirstName;
    }

    /**
     * @param mixed $billFirstName
     */
    public function setBillFirstName($billFirstName)
    {
        $this->billFirstName = $billFirstName;
    }

    /**
     * @return mixed
     */
    public function getBillLastName()
    {
        return $this->billLastName;
    }

    /**
     * @param mixed $billLastName
     */
    public function setBillLastName($billLastName)
    {
        $this->billLastName = $billLastName;
    }

    /**
     * @return mixed
     */
    public function getBillCompany()
    {
        return $this->billCompany;
    }

    /**
     * @param mixed $billCompany
     */
    public function setBillCompany($billCompany)
    {
        $this->billCompany = $billCompany;
    }

    /**
     * @return mixed
     */
    public function getBillStreet()
    {
        return $this->billStreet;
    }

    /**
     * @param mixed $billStreet
     */
    public function setBillStreet($billStreet)
    {
        $this->billStreet = $billStreet;
    }

    /**
     * @return mixed
     */
    public function getBillStreet2()
    {
        return $this->billStreet2;
    }

    /**
     * @param mixed $billStreet2
     */
    public function setBillStreet2($billStreet2)
    {
        $this->billStreet2 = $billStreet2;
    }

    /**
     * @return mixed
     */
    public function getBillCity()
    {
        return $this->billCity;
    }

    /**
     * @param mixed $billCity
     */
    public function setBillCity($billCity)
    {
        $this->billCity = $billCity;
    }

    /**
     * @return mixed
     */
    public function getBillState()
    {
        return $this->billState;
    }

    /**
     * @param mixed $billState
     */
    public function setBillState($billState)
    {
        $this->billState = $billState;
    }

    /**
     * @return mixed
     */
    public function getBillZip()
    {
        return $this->billZip;
    }

    /**
     * @param mixed $billZip
     */
    public function setBillZip($billZip)
    {
        $this->billZip = $billZip;
    }

    /**
     * @return mixed
     */
    public function getBillCountry()
    {
        return $this->billCountry;
    }

    /**
     * @param mixed $billCountry
     */
    public function setBillCountry($billCountry)
    {
        $this->billCountry = $billCountry;
    }

    /**
     * @return mixed
     */
    public function getBillPhone()
    {
        return $this->billPhone;
    }

    /**
     * @param mixed $billPhone
     */
    public function setBillPhone($billPhone)
    {
        $this->billPhone = $billPhone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * @param mixed $delivery
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;
    }

    /**
     * @return mixed
     */
    public function getShipFirstName()
    {
        return $this->shipFirstName;
    }

    /**
     * @param mixed $shipFirstName
     */
    public function setShipFirstName($shipFirstName)
    {
        $this->shipFirstName = $shipFirstName;
    }

    /**
     * @return mixed
     */
    public function getShipLastName()
    {
        return $this->shipLastName;
    }

    /**
     * @param mixed $shipLastName
     */
    public function setShipLastName($shipLastName)
    {
        $this->shipLastName = $shipLastName;
    }

    /**
     * @return mixed
     */
    public function getShipCompany()
    {
        return $this->shipCompany;
    }

    /**
     * @param mixed $shipCompany
     */
    public function setShipCompany($shipCompany)
    {
        $this->shipCompany = $shipCompany;
    }

    /**
     * @return mixed
     */
    public function getShipStreet()
    {
        return $this->shipStreet;
    }

    /**
     * @param mixed $shipStreet
     */
    public function setShipStreet($shipStreet)
    {
        $this->shipStreet = $shipStreet;
    }

    /**
     * @return mixed
     */
    public function getShipStreet2()
    {
        return $this->shipStreet2;
    }

    /**
     * @param mixed $shipStreet2
     */
    public function setShipStreet2($shipStreet2)
    {
        $this->shipStreet2 = $shipStreet2;
    }

    /**
     * @return mixed
     */
    public function getShipCity()
    {
        return $this->shipCity;
    }

    /**
     * @param mixed $shipCity
     */
    public function setShipCity($shipCity)
    {
        $this->shipCity = $shipCity;
    }

    /**
     * @return mixed
     */
    public function getShipState()
    {
        return $this->shipState;
    }

    /**
     * @param mixed $shipState
     */
    public function setShipState($shipState)
    {
        $this->shipState = $shipState;
    }

    /**
     * @return mixed
     */
    public function getShipZip()
    {
        return $this->shipZip;
    }

    /**
     * @param mixed $shipZip
     */
    public function setShipZip($shipZip)
    {
        $this->shipZip = $shipZip;
    }

    /**
     * @return mixed
     */
    public function getShipCountry()
    {
        return $this->shipCountry;
    }

    /**
     * @param mixed $shipCountry
     */
    public function setShipCountry($shipCountry)
    {
        $this->shipCountry = $shipCountry;
    }

    /**
     * @return mixed
     */
    public function getShipPhone()
    {
        return $this->shipPhone;
    }

    /**
     * @param mixed $shipPhone
     */
    public function setShipPhone($shipPhone)
    {
        $this->shipPhone = $shipPhone;
    }

    /**
     * @return mixed
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @param mixed $customFields
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getSoftware()
    {
        return $this->software;
    }

    /**
     * @param mixed $software
     */
    public function setSoftware($software)
    {
        $this->software = $software;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }
}