<?php

namespace SilverStripe\VendorHelper;

use SilverStripe\VendorHelper\Commands\Copy;
use SilverStripe\VendorHelper\Commands\Link;
use Symfony\Component\Console;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;

class Application extends Console\Application
{
    protected function getDefaultCommands()
    {
        $commands = [
            new HelpCommand('help'),
            new ListCommand('list'),
            new Link(),
            new Copy(),
        ];
        return $commands;
    }
}
