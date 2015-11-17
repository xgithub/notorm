<?php
/**
 *
 * NotORMCacheInclude.php
 *
 * Code Description
 *
 * @author     limin<lmin@vip.deyi.com>
 * @since      2015-11-17 19:58
 * @copyright  deyi.com
 *¡¡
 */
namespace MVC\notorm\NotORM\Cache;

use MVC\notorm\NotORM\Cache\InterfaceNotORMCache;

class NotORMCacheInclude implements InterfaceNotORMCache
{
    private $filename, $data = [];

    function __construct($filename)
    {
        $this->filename = $filename;
        $this->data = @include realpath($filename); // @ - file may not exist, realpath() to not include from include_path //! silently falls with syntax error and fails with unreadable file
        if (!is_array($this->data)) { // empty file returns 1
            $this->data = [];
        }
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
            file_put_contents($this->filename, '<?php return ' . var_export($this->data, true) . ';', LOCK_EX);
        }
    }
} 