<?php

namespace CrCms\Module\Commands;

use CrCms\Module\Commands\Handlers\MakeModule;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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

    protected $description = 'make a module';

    protected $handler;

    public function __construct(MakeModule $makeModule)
    {
        parent::__construct();
        $this->handler = $makeModule;
    }

    public function handle()
    {
        $this->validatorArguments($this->arguments());

        //$name = Str::camel($this->argument('name'));

        $this->handler->handle(['name' => $this->argument('name')]);
    }

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