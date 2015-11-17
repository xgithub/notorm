<?php
/**
 *
 * InterfaceNotORMCache.php
 *
 * Code Description
 *
 * @author     limin<lmin@vip.deyi.com>
 * @since      2015-11-17 19:55
 * @copyright  deyi.com
 *¡¡
 */
namespace MVC\notorm\NotORM\Cache;

interface InterfaceNotORMCache
{
    /** Load stored data
     * @param string
     * @return mixed or null if not found
     */
    function load($key);

    /** Save data
     * @param string
     * @param mixed
     * @return null
     */
    function save($key, $data);

} 