<?php
/**
 *
 * AbstractNotORM.php
 *
 * Code Description
 *
 * @author     limin<lmin@vip.deyi.com>
 * @since      2015-11-17 19:53
 * @copyright  deyi.com
 *¡¡
 */

namespace MVC\notorm;


abstract class AbstractNotORM

{
    protected $connection, $driver, $structure, $cache;
    protected $notORM, $table, $primary, $rows, $referenced = array();

    protected $debug = false;
    protected $debugTimer;
    protected $freeze = false;
    protected $rowClass = 'NotORMRow';
    protected $jsonAsArray = false;

    protected function access($key, $delete = false) {
    }

} 