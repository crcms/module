<?php

namespace CrCms\Module\Commands;

use Illuminate\Console\Command;

/**
 * Class ModuleStatusCommand
 *
 * @package CrCms\Module\Commands
 * @author simon
 */
class ModuleStatusCommand extends Command
{

    protected $signature = 'module:status {name} {status?}';

}