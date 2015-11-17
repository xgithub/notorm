<?php
/**
 *
 * NotORMCacheSession.php
 *
 * Code Description
 *
 * @author     limin<lmin@vip.deyi.com>
 * @since      2015-11-17 19:56
 * @copyright  deyi.com
 *¡¡
 */
namespace MVC\notorm\NotORM\Cache;

use MVC\notorm\NotORM\Cache\InterfaceNotORMCache;

class NotORMCacheSession implements InterfaceNotORMCache
{
    function load($key) {
        if (!isset($_SESSION["NotORM"][$key])) {
            return null;
        }
        return $_SESSION["NotORM"][$key];
    }

    function save($key, $data) {
        $_SESSION["NotORM"][$key] = $data;
    }
} 