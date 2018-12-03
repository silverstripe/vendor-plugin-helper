<?php

namespace SilverStripe\VendorPluginHelper\Commands;


/**
 * Expose resource with the link method
 * @deprecated 1.0.0..2.0.0
 */
class Link extends Base
{
    public function __construct()
    {
        parent::__construct('link');
        $this->setDescription(
            'This method as been deprecated. Use vendor-expose instead. ' .
            'Symlink all vendor web-visible assets to the given target.'
        );
    }

    protected function getMethod()
    {
        return 'symlink';
    }
}
