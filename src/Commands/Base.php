<?php

namespace SilverStripe\VendorPluginHelper\Commands;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Legacy base command to expose resource assets.
 * @deprecated 1.0.0..2.0.0
 */
abstract class Base extends Command
{
    protected function configure()
    {
        parent::configure();

        $this->addArgument(
            'path',
            InputArgument::OPTIONAL,
            'Base path to project to link modules to',
            null
        );
        $this->addOption(
            'target',
            't',
            InputOption::VALUE_REQUIRED,
            'Top level folder to link resources to',
            'resources'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(
            '<comment>' .
            str_pad('', 80, '*') .
            "\nWARNING this command has been deprecated and may be removed in future releases.\n" .
            "Use `vendor-plugin-helper` vendor-expose` instead. \n" .
            str_pad('', 80, '*') .
            "</comment>\n"
        );


        $cmd = new VendorExposeCommand();
        $cmd->setHelperSet($this->getHelperSet());
        $arrayInput = new ArrayInput(
            [
            'method' => $this->getMethod(),
            '--path' => $this->getPath($input)
            ]
        );
        $cmd->run($arrayInput, $output);
    }

    /**
     * Return the method to use to expose the assets.
     *
     * @return string
     */
    abstract protected function getMethod();

    /**
     * Get absolute path to target folder to link
     *
     * @param InputInterface $input
     * @return string
     */
    protected function getPath(InputInterface $input)
    {
        $path = $input->getArgument('path') ?: getcwd();
        if (!is_dir($path)) {
            throw new InvalidArgumentException("invalid path argument \"{$path}\"");
        }
        return realpath($path);
    }
}
