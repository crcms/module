<?php

namespace CrCms\Module\Commands;

use CrCms\Module\Commands\Handlers\MakeModule;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;

/**
 * Class ModuleCommand
 *
 * @package CrCms\Module\Commands
 * @author simon
 */
class ModuleMakeCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'module:make {name}';

    /**
     * @var string
     */
    protected $description = 'make a module';

    /**
     * @var MakeModule
     */
    protected $handler;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * ModuleMakeCommand constructor.
     * @param MakeModule $makeModule
     * @param Composer $composer
     */
    public function __construct(MakeModule $makeModule,Composer $composer)
    {
        parent::__construct();
        $this->handler = $makeModule;
        $this->composer = $composer;
    }

    /**
     *
     */
    public function handle()
    {
        $this->validatorArguments($this->arguments());

        try {
            $this->handler->handle(['name' => $this->argument('name')]);
            $this->info('The module was created successfully');
            $this->composer->dumpAutoloads();
            $this->info('Generating optimized autoload files');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * @param array $arguments
     */
    protected function validatorArguments(array $arguments)
    {
        if (empty($arguments['name'])) {
            $this->error('The module name is not empty');
        }
        if (preg_match('/^[a-zA-Z][a-zA-Z]*$/',$arguments['name']) === 0) {
            $this->error('The module name format error');
        }
    }
}