<?php

namespace SilverStripe\VendorPluginHelper\Commands;

use InvalidArgumentException;
use SilverStripe\VendorPlugin\Console\VendorExposeCommand as PluginVendorExposeCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Wrapper around the original VendorExposeCommand so we can add a path option.
 */
class VendorExposeCommand extends PluginVendorExposeCommand
{
    public function configure()
    {
        parent::configure();

        $this->addOption(
            'path',
            '',
            InputOption::VALUE_OPTIONAL,
            'Base path to project to link modules to.',
            getcwd()
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Change directory to the composer project.
        $path = $this->getPath($input);
        chdir($path);

        return parent::execute($input, $output);
    }

    /**
     * Get absolute path to target folder to link
     *
     * @param InputInterface $input
     * @return string
     */
    protected function getPath(InputInterface $input)
    {
        $path = $input->getOption('path') ?: getcwd();
        if (!is_dir($path)) {
            throw new InvalidArgumentException("invalid path argument \"{$path}\"");
        }
        return realpath($path);
    }
}
