<?php

namespace SprykerFeature\Zed\Payone\Business\Api\Response\Container;
use SprykerFeature\Zed\Payone\Business\Api\Response\Container\AbstractResponseContainer;


class CreditCardCheckResponseContainer extends AbstractResponseContainer
{

    /**
     * @var string
     */
    protected $pseudocardpan;
    /**
     * @var string
     */
    protected $truncatedcardpan;


    /**
     * @param string $truncatedcardpan
     */
    public function setTruncatedcardpan($truncatedcardpan)
    {
        $this->truncatedcardpan = $truncatedcardpan;
    }

    /**
     * @return string
     */
    public function getTruncatedcardpan()
    {
        return $this->truncatedcardpan;
    }

    /**
     * @param string $pseudocardpan
     */
    public function setPseudocardpan($pseudocardpan)
    {
        $this->pseudocardpan = $pseudocardpan;
    }

    /**
     * @return string
     */
    public function getPseudocardpan()
    {
        return $this->pseudocardpan;
    }

}