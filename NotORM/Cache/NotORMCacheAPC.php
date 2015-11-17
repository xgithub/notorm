<?php
/**
 *
 * NotORMCacheAPC.php
 *
 * Code Description
 *
 * @author     limin<lmin@vip.deyi.com>
 * @since      2015-11-17 20:01
 * @copyright  deyi.com
 *¡¡
 */

namespace MVC\notorm\NotORM\Cache;

use MVC\notorm\NotORM\Cache\InterfaceNotORMCache;

class NotORMCacheAPC implements InterfaceNotORMCache
{
    function load($key) {
        $return = apc_fetch("NotORM.$key", $success);
        if (!$success) {
            return null;
        }
        return $return;
    }

    function save($key, $data) {
        apc_store("NotORM.$key", $data);
    }
} 