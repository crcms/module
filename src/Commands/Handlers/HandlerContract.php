<?php

namespace CrCms\Module\Commands\Handlers;

/**
 * Interface HandlerContract
 *
 * @package CrCms\Module\Commands\Handlers
 * @author simon
 */
interface HandlerContract
{
    /**
     * @param array $arguments
     * @return void
     */
    public function handle(array $arguments);
}