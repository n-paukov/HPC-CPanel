<?php
namespace App\Core\Libraries;

/**
 * Class FileCache
 * @package App\Core\Libraries
 */
class FileCache {
    /**
     * @param string $path
     * @param int $lifetime
     *
     * @return mixed|null
     */
    public static function getCachedData(string $path, int $lifetime) {
        $cachedFilePath = CACHE_DIR.DIRECTORY_SEPARATOR.$path;

        if (!file_exists($cachedFilePath))
            return null;

        if (time() - filemtime($cachedFilePath) >= $lifetime)
            return null;

        return unserialize(file_get_contents($cachedFilePath));
    }

    /**
     * @param string $path
     * @param $data
     */
    public static function setCachedData(string $path, $data) {
        $cachedFilePath = CACHE_DIR.DIRECTORY_SEPARATOR.$path;

        file_put_contents($cachedFilePath, serialize($data));
        chmod($cachedFilePath, 600);
    }

    /**
     * @param string $path
     */
    public static function resetCachedData(string $path) {
        $cachedFilePath = CACHE_DIR.DIRECTORY_SEPARATOR.$path;

        unlink($cachedFilePath);
    }
}