<?php

namespace SilverStripe\VendorPluginHelper\Commands;

/**
 * Expose resource with the copy method
 * @deprecated 1.0.0..2.0.0
 */
class Copy extends Base
{
    public function __construct()
    {
        parent::__construct('copy');
        $this->setDescription(
            'This method as been deprecated. Use vendor-expose instead. ' .
            'Copy all vendor web-visible assets to the given target.');
    }

    /**
     * Activate components using the give method
     */
    protected function getMethod()
    {
        return 'copy';
    }
}
