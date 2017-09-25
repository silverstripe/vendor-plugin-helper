<?php

namespace SilverStripe\VendorPluginHelper;

use SilverStripe\VendorPluginHelper\Commands\Copy;
use SilverStripe\VendorPluginHelper\Commands\Link;
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
