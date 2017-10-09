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
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $namePrefix;

    /**
     * @var
     */
    protected $namespace;

    /**
     * MakeModule constructor.
     * @param Config $config
     */
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

        if (!$this->exists()) {

        $this->makeStructure();

        $this->makeComposer();

        $this->makeServiceProvider();

        $this->makeConfig();
        }
    }

    /**
     * @return bool
     */
    protected function exists()
    {
        if (file_exists($this->directorStructure('composer.json'))) {
            throw new \RuntimeException('The module already exists');
        }

        return false;
    }

    /**
     * @param string $name
     */
    protected function formatName(string $name)
    {
        $names = explode('/', $name);
        $this->namePrefix = count($names) === 1 ? 'project' : strtolower(Str::camel($this->namePrefix));
        $this->name = strtolower(Str::camel($names[0]));
        $this->namespace = Str::camel($names[0]);
    }

    /**
     *
     */
    protected function makeStructure()
    {
        Helper::createFile($this->directorStructure('src/Http/Controllers/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Http/Middleware/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Http/Requests/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Http/Resources/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Models/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Console/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Jobs/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Listeners/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Repositories/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Repositories/Magic/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Services/.gitkeep'), '');
        Helper::createFile($this->directorStructure('src/Events/.gitkeep'), '');
        Helper::createFile($this->directorStructure('resources/.gitkeep'), '');
        Helper::createFile($this->directorStructure('resources/lang/.gitkeep'), '');
        Helper::createFile($this->directorStructure('resources/views/.gitkeep'), '');
        Helper::createFile($this->directorStructure('resources/assets/.gitkeep'), '');
        Helper::createFile($this->directorStructure('tests/.gitkeep'), '');
        Helper::createFile($this->directorStructure('database/migrations/.gitkeep'), '');
        Helper::createFile($this->directorStructure('database/seeds/.gitkeep'), '');
        Helper::createFile($this->directorStructure('database/factories/.gitkeep'), '');
        Helper::createDir($this->directorStructure('config'));
        Helper::createDir($this->directorStructure('src/Providers'));
    }

    /**
     *
     * "laravel": {
     * "dont-discover": [
     * "Modules\\\\Providers\\\\{$this->namespace}\\\\ServiceProvider"
     * ]
     * },
     *
     */
    /**
     *
     */
    protected function makeComposer()
    {
        $namespace = studly_case($this->namespace);
        $composer = <<<EOT
{
    "name": "{$this->namePrefix}/{$this->name}",
    "description": "",
    "autoload": {
        "psr-4": {
            "Modules\\\\{$namespace}\\\\": "src/"
        }
    },
    "extra": {
        "status" : 1
    }
}
EOT;
        Helper::createFile($this->directorStructure('composer.json'), $composer);
    }

    /**
     * @param string $path
     * @return string
     */
    protected function directorStructure(string $path)
    {
        return $this->config->get('module.base_path') . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @return void
     */
    protected function makeServiceProvider()
    {
        $namespace = studly_case($this->namespace);

        $provider = <<<EOT
<?php

namespace Modules\\{$namespace}\\Providers;

use Illuminate\Support\ServiceProvider;

class {$namespace}ServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected \$defer = false;

    /**
     * @var string
     */
    protected \$namespaceName = '{$this->namespace}';

    /**
     * @var string
     */
    protected \$packagePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

    /**
     * @return void
     */
    public function boot()
    {
        \$this->loadMigrationsFrom(\$this->packagePath.'database/migrations');
        \$this->loadTranslationsFrom(\$this->packagePath.'resources/lang', \$this->namespaceName);
        \$this->loadViewsFrom(\$this->packagePath.'resources/views', \$this->namespaceName);
        \$this->registerRoute();
    }

    /**
     * @return void
     */
    public function register()
    {
        \$this->mergeConfigFrom(
            \$this->packagePath.'config/\$this->namespaceName.php', \$this->namespaceName
        );
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return [
        ];
    }
    
    /**
     * @return void
     */
    protected function registerRoute()
    {
        \$routePath = \$this->packagePath.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR;

        foreach (str_replace(\$routePath,'',glob(\$routePath)) as \$route) {
            \$this->loadRoutesFrom(\$routePath."/{\$route}.php");
        }
    }
}
EOT;
        Helper::createFile($this->directorStructure('src/Providers/' . $namespace . 'ServiceProvider.php'), $provider);
    }

    protected function makeConfig()
    {
        $config = <<<EOT
<?php

return [
    
];
EOT;
        Helper::createFile($this->directorStructure('config/' . $this->namespace . '.php'), $config);
    }
}