<?php
/** NotORM - simple reading data from the database
* @link http://www.notorm.com/
* @author Jakub Vrana, http://www.vrana.cz/
* @copyright 2010 Jakub Vrana
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
namespace MVC\notorm;

use MVC\notorm\AbstractNotORM;
use MVC\notorm\NotORM\InterfaceNotORMStructure;
use MVC\notorm\NotORM\NotORMStructureDiscovery;
use MVC\notorm\NotORM\NotORMStructureConvention;

use MVC\notorm\NotORM\Cache\NotORMCacheSession;
use MVC\notorm\NotORM\Cache\NotORMCacheMemcache;
use MVC\notorm\NotORM\Cache\NotORMCacheInclude;
use MVC\notorm\NotORM\Cache\NotORMCacheFile;
use MVC\notorm\NotORM\Cache\NotORMCacheDatabase;
use MVC\notorm\NotORM\Cache\NotORMCacheAPC;

use MVC\notorm\NotORM\NotORMLiteral;
use MVC\notorm\NotORM\NotORMRow;
use MVC\notorm\NotORM\NotORMResult;
use MVC\notorm\NotORM\NotORMMultiResult;


if (!interface_exists('JsonSerializable')) {
	interface JsonSerializable {
		function jsonSerialize();
	}
}

/*include_once dirname(__FILE__) . "/NotORM/Structure.php";
include_once dirname(__FILE__) . "/NotORM/Cache.php";
include_once dirname(__FILE__) . "/NotORM/Literal.php";
include_once dirname(__FILE__) . "/NotORM/Result.php";
include_once dirname(__FILE__) . "/NotORM/MultiResult.php";
include_once dirname(__FILE__) . "/NotORM/Row.php";

*/



/** Database representation
* @property-write mixed $debug = false Enable debugging queries, true for error_log($query), callback($query, $parameters) otherwise
* @property-write bool $freeze = false Disable persistence
* @property-write string $rowClass = 'NotORMRow' Class used for created objects
* @property-write bool $jsonAsArray = false Use array instead of object in Result JSON serialization
* @property-write string $transaction Assign 'BEGIN', 'COMMIT' or 'ROLLBACK' to start or stop transaction
*/
class NotORM extends AbstractNotORM {
	
	/** Create database representation
	* @param PDO
	* @param NotORM_Structure or null for new NotORM_Structure_Convention
	* @param NotORM_Cache or null for no cache
	*/
	function __construct(\PDO $connection, IterfaceNotORMStructure $structure = null, InterfaceNotORMCache $cache = null) {
		$this->connection = $connection;
		$this->driver = $connection->getAttribute(\PDO::ATTR_DRIVER_NAME);
		if (!isset($structure)) {
			$structure = new NotORMStructureConvention();
		}
		$this->structure = $structure;

		$this->cache = $cache;
	}
	
	/** Get table data to use as $db->table[1]
	* @param string
	* @return NotORMResult
	*/
	function __get($table) {
		return new NotORMResult($this->structure->getReferencingTable($table, ''), $this, true);
	}
	
	/** Set write-only properties
	* @return null
	*/
	function __set($name, $value) {
		if ($name == "debug" || $name == "debugTimer" || $name == "freeze" || $name == "rowClass" || $name == "jsonAsArray") {
			$this->$name = $value;
		}
		if ($name == "transaction") {
			switch (strtoupper($value)) {
				case "BEGIN": return $this->connection->beginTransaction();
				case "COMMIT": return $this->connection->commit();
				case "ROLLBACK": return $this->connection->rollback();
			}
		}
	}
	
	/** Get table data
	* @param string
	* @param array (["condition"[, array("value")]]) passed to NotORMResult::where()
	* @return NotORMResult
	*/
	function __call($table, array $where) {
		$return = new NotORMResult($this->structure->getReferencingTable($table, ''), $this);
		if ($where) {
			call_user_func_array(array($return, 'where'), $where);
		}
		return $return;
	}
	
}
