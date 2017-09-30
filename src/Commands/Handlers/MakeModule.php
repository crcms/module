<?php

namespace CrCms\Module\Commands\Handlers;

use CrCms\Module\Helper;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Str;

/**
 * Class MakeModule
 *
 * @package CrCms\Module\Commands\Creator
 * @author simon
 */
class MakeModule implements HandlerContract
{
    protected $config;

    protected $name;
    protected $namePrefix;
    protected $namespace;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param array $arguments
     * @return void
     */
    public function handle(array $arguments)
    {
        $this->formatName($arguments['name']);

        $this->makeStructure();
    }

    protected function formatName(string $name)
    {
        $names = explode('/',$name);
        $this->namePrefix = count($names) === 1 ? 'project' : strtolower(Str::camel($this->namePrefix));
        $this->name = strtolower(Str::camel($names[0]));
        $this->namespace = Str::camel($names[0]);
    }

    protected function makeStructure()
    {
        Helper::createFile($this->directorStructure('src/Http/Controllers/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Http/Middleware/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Http/Requests/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Http/Resources/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Providers/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Models/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Console/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Jobs/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Listeners/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Repositories/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Repositories/Magic/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Services/.gitkeep'),'');
        Helper::createFile($this->directorStructure('src/Events/.gitkeep'),'');
        Helper::createFile($this->directorStructure('resource/.gitkeep'),'');
        Helper::createFile($this->directorStructure('tests/.gitkeep'),'');
        Helper::createDir($this->directorStructure('config'));
        Helper::createDir($this->directorStructure('src/Providers'));
    }

    protected function makeComposer()
    {
        $composer = <<<EOT
        {
            "name": "{$this->namePrefix}/{$this->name}",
            "description": "",
            "autoload": {
                "psr-4": {
                    "Modules\\{$this->namespace}\\": "src/"
                }
            },
            "extra": {
                "laravel": {
                    "dont-discover": [
                        "Modules\\Providers\\{$this->namespace}\\ServiceProvider"
                    ]
                },
                "status" : 1
            }
        }
EOT;
        Helper::createFile($this->directorStructure('composer.json'),$composer);
    }

    /**
     * @param string $path
     * @return string
     */
    protected function directorStructure(string $path)
    {
        return $this->config->get('module.base_path') . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . $path;
    }
}