<?php

namespace SilverStripe\VendorPluginHelper\Commands;

use InvalidArgumentException;
use SilverStripe\VendorPlugin\Methods\ExposeMethod;
use SilverStripe\VendorPlugin\Util;
use SilverStripe\VendorPlugin\VendorModule;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Base extends Command
{
    const DEFAULT_TARGET = 'resources';

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
            self::DEFAULT_TARGET
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get destination
        $path = $this->getPath($input);
        $target = $input->getOption('target');
        if (empty($target)) {
            throw new InvalidArgumentException("Missing target directory");
        }

        // Load all modules
        $method = $this->getMethod();
        $modules = $this->getAllModules($path);
        $count = count($modules);
        $output->writeln("Setting up paths for {$count} modules");
        foreach ($modules as $module) {
            $name = $module->getName();
            $folders = $module->getExposedFolders();

            // Log details (similar to plugin output format)
            $output->writeln("Exposing web directories for module <info>{$name}</info>:");
            foreach ($folders as $folder) {
                $output->writeln("  - <info>$folder</info>");
            }

            // Do actual work!
            $module->exposePaths($method);
        }
        $output->writeln("Success!");
    }

    /**
     * Activate components using the give method
     *
     * @return ExposeMethod
     */
    abstract protected function getMethod();

    /**
     * Find all modules
     *
     * @param string $basePath Base path
     * @return VendorModule[]
     */
    protected function getAllModules($basePath)
    {
        $modules = [];
        $search = Util::joinPaths($basePath, 'vendor', '*', '*');
        foreach (glob($search, GLOB_ONLYDIR) as $modulePath) {
            // Filter by non-composer folders
            $composerPath = Util::joinPaths($modulePath, 'composer.json');
            if (!file_exists($composerPath)) {
                continue;
            }

            // Build module
            $name = basename($modulePath);
            $vendor = basename(dirname($modulePath));
            $module = new VendorModule($basePath, "{$vendor}/{$name}");

            // Check if this module has folders to expose
            if ($module->getExposedFolders()) {
                $modules[] = $module;
            }
        }
        return $modules;
    }

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
