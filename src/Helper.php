<?php

namespace CrCms\Module;

/**
 * Class Helper
 *
 * @package CrCms\Module
 * @author simon
 */
final class Helper
{
    /**
     * @param string $path
     * @param int $mode
     * @return bool
     */
    public static function createDir(string $path,int $mode = 0755): bool
    {
        if (is_dir($path) || @mkdir($path, $mode)) {
            return true;
        }
        if (!@static::createDir(dirname($path), $mode)) {
            return false;
        }

        return mkdir($path, $mode);
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function removeDir(string $path): bool
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        if (is_dir($path)) {
            $dirs = scandir($path);
            foreach ($dirs as $dir) {
                if ($dir === '.' || $dir === '..') continue;
                $filePath = $path . DIRECTORY_SEPARATOR . $dir;
                is_dir($filePath) ? static::removeDir($filePath) : @unlink($filePath);
            }
        } else {
            return @unlink($path);
        }

        chmod($path, 0777);

        return @rmdir($path);
    }

    /**
     * @param string $path
     * @param string $content
     * @return bool
     */
    public static function createFile(string $path,string $content): bool
    {
        $basePath = dirname($path);
        if (!is_dir($path)) {
            static::createDir($path);
        }
        return (bool)file_put_contents($path,$content);
    }

}