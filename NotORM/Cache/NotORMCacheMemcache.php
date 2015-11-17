<?php
/**
 *
 * NotORMCacheMemcache.php
 *
 * Code Description
 *
 * @author     limin<lmin@vip.deyi.com>
 * @since      2015-11-17 20:00
 * @copyright  deyi.com
 *¡¡
 */
namespace MVC\notorm\NotORM\Cache;

use MVC\notorm\NotORM\Cache\InterfaceNotORMCache;

class NotORMCacheMemcache implements InterfaceNotORMCache
{
    private $memcache;

    function __construct(Memcache $memcache) {
        $this->memcache = $memcache;
    }

    function load($key) {
        $return = $this->memcache->get("NotORM.$key");
        if ($return === false) {
            return null;
        }
        return $return;
    }

    function save($key, $data) {
        $this->memcache->set("NotORM.$key", $data);
    }
} 