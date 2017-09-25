<?php

namespace SilverStripe\VendorHelper\Commands;

use SilverStripe\VendorPlugin\Methods\CopyMethod;
use SilverStripe\VendorPlugin\Methods\ExposeMethod;

class Copy extends Base
{
    public function __construct()
    {
        parent::__construct('copy');
        $this->setDescription('Copy all vendor web-visible assets to the given target');
    }

    /**
     * Activate components using the give method
     *
     * @return ExposeMethod
     */
    protected function getMethod()
    {
        return new CopyMethod();
    }
}
