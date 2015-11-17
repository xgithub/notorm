<?php
/**
 *
 * NotORMCacheFile.php
 *
 * Code Description
 *
 * @author     limin<lmin@vip.deyi.com>
 * @since      2015-11-17 19:57
 * @copyright  deyi.com
 *¡¡
 */
namespace MVC\notorm\NotORM\Cache;

use MVC\notorm\NotORM\Cache\InterfaceNotORMCache;

class NotORMCacheFile implements InterfaceNotORMCache
{
    private $filename, $data = [];

    function __construct($filename)
    {
        $this->filename = $filename;
        $this->data = unserialize(@file_get_contents($filename)); // @ - file may not exist
    }

    function load($key)
    {
        if (!isset($this->data[$key])) {
            return null;
        }
        return $this->data[$key];
    }

    function save($key, $data)
    {
        if (!isset($this->data[$key]) || $this->data[$key] !== $data) {
            $this->data[$key] = $data;
            file_put_contents($this->filename, serialize($this->data), LOCK_EX);
        }
    }

} 