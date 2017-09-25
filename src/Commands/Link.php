<?php

namespace SilverStripe\VendorHelper\Commands;

use SilverStripe\VendorPlugin\Methods\ExposeMethod;
use SilverStripe\VendorPlugin\Methods\SymlinkMethod;

class Link extends Base
{
    public function __construct()
    {
        parent::__construct('link');
        $this->setDescription('Symlink all vendor web-visible assets to the given target');
    }

    /**
     * Activate components using the give method
     *
     * @return ExposeMethod
     */
    protected function getMethod()
    {
        return new SymlinkMethod();
    }
}
