<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(BASEPATH.'database/DB_driver.php');
require_once(BASEPATH.'database/DB_query_builder.php');

/**
 * @property CI_DB_mysqli_driver $masterDb
 */
class CI_Qb
{
    private $aseEncryptKey = false;
    protected $database    = false;
    protected $masterDb    = false;
    protected $slaveDb     = false;
    protected $etcDb       = [];
    protected $qb;
    protected $queryType   = 'select';
    protected $table       = false;
    protected $subQryAlias = '';
    protected $params;
    protected $totalRows   = 0;
    protected $insertId    = false;
    protected $lastQury;
    public $total          = false;

    public function __construct($params = [])
    {
        if (empty($params)) {
            $cfg = load_class('Config', 'core');
            $cfg->load('qb', true);

            $params = $cfg->item('qb');
        }

        $this->params = $params;
        $this->qb     = new NunaQb($params);
    }

    public function platform()
    {
        return $this->qb->platform();
    }

    public function setDatabase($database)
    {
        if ($database === 'master') {
            $this->database = $this->getMasterDb();
        } elseif ($database === 'slave') {
            $this->database = $this->getSlaveDb();
        }elseif ($database === 'payment') {
            $this->database = $this->getMasterDb();
        } else {
            $this->database = $this->getEtcDb($database);
        }

        return $this;
    }

    public function getEtcDb($dbName)
    {
        // set etcDb
        if (isset($this->etcDb[$dbName]) === false) {
            $this->etcDb[$dbName] = getForbiz()->import('db.'.$dbName);
        }

        return $this->etcDb[$dbName];
    }

    public function betweenDate($col, $startDate, $endDate, $type = 'and')
    {
        $startDate = (strlen($startDate) > 10 ? $startDate : ($startDate.' 00:00:00'));
        $endDate   = (strlen($endDate) > 10 ? $endDate : ($endDate.' 23:59:59'));
        if ($type == 'or') {
            $this->orWhere("{$col} BETWEEN '{$startDate}' AND '{$endDate}'", null, false);
        } else {
            $this->where("{$col} BETWEEN '{$startDate}' AND '{$endDate}'", null, false);
        }
        return $this;
    }

    public function betweenBasic($col, $startDate, $endDate, $type = 'and')
    {
        if ($type == 'or') {
            $this->orWhere("{$col} BETWEEN '{$startDate}' AND '{$endDate}'", null, false);
        } else {
            $this->where("{$col} BETWEEN '{$startDate}' AND '{$endDate}'", null, false);
        }
        return $this;
    }

    public function orBetweenDate($col, $startDate, $endDate)
    {
        return $this->betweenDate($col, $startDate, $endDate, 'or');
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function setTotalRows($totalRows)
    {
        $this->totalRows = $totalRows;

        return $this;
    }

    public function transStart($test_mode = false)
    {
        return $this->getMasterDb()->trans_start($test_mode);
    }

    public function transComplete()
    {
        return $this->getMasterDb()->trans_complete();
    }

    public function transStrict($mode = true)
    {
        return $this->getMasterDb()->trans_strict($mode);
    }

    public function transStatus()
    {
        return $this->getMasterDb()->trans_status();
    }

    public function transOff()
    {
        return $this->getMasterDb()->trans_off();
    }

    public function transBegin($test_mode = false)
    {
        return $this->getMasterDb()->trans_begin($test_mode);
    }

    public function transRollback()
    {
        return $this->getMasterDb()->trans_rollback();
    }

    public function transCommit()
    {
        return $this->getMasterDb()->trans_commit();
    }

    public function chkEnctyptKey()
    {
        if (!defined('FBEC4B0E1CFB328CE5CBE1EDC4B68C34')) {
            $this->getSlaveDb();
        }

        if ($this->aseEncryptKey === false) {
            $this->aseEncryptKey = FBEC4B0E1CFB328CE5CBE1EDC4B68C34;
        }
    }

    public function encrypt(string $val)
    {
        $this->chkEnctyptKey();

        return sprintf("HEX(AES_ENCRYPT('%s','%s'))", addslashes($val), $this->aseEncryptKey);
    }

    public function decrypt(string $key)
    {
        $this->chkEnctyptKey();

        return sprintf("AES_DECRYPT(UNHEX(%s),'%s')", $key, $this->aseEncryptKey);
    }

    public function encryptWhere($key, $value)
    {
        $this->where($key, $this->encrypt($value), false);
        return $this;
    }

    public function encryptSet(string $key, $value)
    {
        $this->set($key, $this->encrypt($value), false);
        return $this;
    }

    public function decryptSelect(string $key, $alias = false)
    {
        if ($alias === false) {
            if (strpos($key, '.') !== false) {
                $data  = explode('.', $key);
                $alias = array_pop($data);
            } else {
                $alias = $key;
            }
        }

        $this->select(sprintf("%s as %s", $this->decrypt($key), $alias), false);

        return $this;
    }

    public function pagination($cur_page = null, $per_page = null, $link_num = 10, $method = 'post')
    {
        $qry = $method == 'get' ? $_GET : $_POST;

        $qry_str = [];
        foreach ($qry as $key => $val) {
            $qry_str[xss_clean($key)] = xss_clean($val);
        }

        $cur_page = $cur_page === null ? (isset($qry_str['cur_page']) ? intval($qry_str['cur_page']) : 1) : $cur_page;
        $per_page = $per_page === null ? (isset($qry_str['per_page']) ? intval($qry_str['per_page']) : 20) : $per_page;

        unset($qry_str['cur_page']);
        unset($qry_str['per_page']);

        $cur_page  = $cur_page < 1 ? 1 : $cur_page;
        $per_page  = $per_page <= 0 ? 10 : $per_page;
        $per_page  = $per_page > 1000 ? 1000 : $per_page;
        $mid_range = intval(floor($link_num / 2));

        if ($this->totalRows > 0) {
            $total_rows = $this->totalRows;

            $last_page = intval(ceil($total_rows / $per_page));
            $cur_page  = $cur_page > $last_page ? $last_page : $cur_page;

            $mid_range = $mid_range > $last_page ? $last_page : $mid_range;

            $page_list = array();

            $start = $cur_page - $mid_range;
            $end   = $cur_page + $mid_range;

            if ($start <= 0) {
                $end   += abs($start) + 1;
                $start = 1;
            }

            if ($end > $last_page) {
                $start -= $end - $last_page;
                $start = $start < 1 ? 1 : $start;
                $end   = $last_page;
            }

            $prev_jump = $start - ($mid_range + 1);
            $prev_jump = $prev_jump < 1 ? 1 : $prev_jump;
            $next_jump = $end + $mid_range + 1;
            $next_jump = $next_jump > $last_page ? $last_page : $next_jump;

            for ($i = $start; $i <= $end; $i++) {
                $page_list[] = $i;
            }

            $offset = ($cur_page - 1) * $per_page;
            $offset = $offset <= 0 ? null : $offset;

            return array(
                'first_page' => 1,
                'prev_jump' => intval($prev_jump),
                'prev_page' => intval(($cur_page - 1 < 1 ? 1 : $cur_page - 1)),
                'cur_page' => intval($cur_page),
                'next_page' => intval($cur_page + 1 > $last_page ? $last_page : $cur_page + 1),
                'next_jump' => intval($next_jump),
                'last_page' => intval($last_page),
                'page_list' => $page_list,
                'per_page' => intval($per_page),
                'qry_str' => !empty($qry_str) ? ($method == 'get' ? $methodhttp_build_query($qry_str) : $qry_str) : '',
                'offset' => intval($offset)
            );
        } else {
            return false;
        }
    }

    public function allowedFields($data, $allowedFields = [], $default = [])
    {
        if (!empty($allowedFields)) {
            $allowedData = [];

            foreach ($allowedFields as $fName) {
                if (array_key_exists($fName, $data)) {
                    $allowedData[$fName] = $data[$fName];
                } else {
                    if (array_key_exists($fName, $default)) {
                        $allowedData[$fName] = $default[$fName];
                    }
                }
            }

            return $allowedData;
        } else {
            return $data;
        }
    }

    public function startCache()
    {
        $this->qb->start_cache();
        return $this;
    }

    public function stopCache()
    {
        $this->qb->stop_cache();
        return $this;
    }

    public function flushCache()
    {
        $this->qb->flush_cache();
        return $this;
    }

    public function getInsertId()
    {
        return $this->insertId;
    }

    public function getCount($cntColum = false)
    {
        $cntStr = $cntColum ? "COUNT({$cntColum}) AS " : str_replace('SELECT', '', $this->qb->getCountString());
        return $this->select($cntStr.$this->qb->escape_identifiers('numrows'), false)
                ->exec()
                ->getRow()
            ->numrows;
    }

    public function getMasterDb()
    {
        // set masterDb
        if ($this->masterDb === false) {
            $this->masterDb = getForbiz()->import('db.master');
        }

        return $this->masterDb;
    }

    public function getSlaveDb()
    {
        // set slaveDb
        if ($this->slaveDb === false) {
            $this->slaveDb = getForbiz()->import('db.slave');
        }

        return $this->slaveDb;
    }

    public function getTableList($table){
        $rows = $this->exec("show tables like '{$table}%'")->getResultArray();
        $tables = [];
        if(!empty($rows)) {
            foreach ($rows as $row) {
                $tables[] = array_values($row)[0];
            }
        }
        return $tables;
    }

    /**
     * excute sql
     * @param string $sql
     * @return NunaResult | boolean
     */
    public function exec($sql = '')
    {
        $queryType = $this->queryType;

        if ($sql == '') {
            $sql = $this->toStr();
        } else {
            $queryType = strtolower(substr(ltrim($sql), 0, 6));
            switch ($queryType) {
                case 'insert':
                case 'update':
                case 'delete':
                case 'trunca':
                case 'show t':
                case 'create':
                case 'drop t':
                    break;
                default:
                    $queryType = $this->queryType;
                    break;
            }
        }

        if ($GLOBALS['CFG']->item('log_threshold') > 1) {
            $backLog = debug_backtrace(0)[0];
            log_message('debug', $_SERVER['REQUEST_URI'].'('.$backLog['file'].':'.$backLog['line'].') - '.$sql);
        }

        if ($this->database === false) {
            $this->database = ($queryType == 'select' ? $this->getSlaveDb() : $this->getMasterDb());
        }

        $result = $this->database->query($sql, false);

        if ($queryType == 'select' && is_object($result)) {
            $res = new NunaResult($result);
            $this->total = $res->num_rows();
        } else {
            if ($queryType == 'insert') {
                $this->insertId = $this->database->insert_id();
                $res = $this->insertId;
            }else if($queryType == 'show t'){
                $res = new NunaResult($result);
            } else {
                $res = true;
            }
        }

        $this->lastQury = $sql;
        $this->database = false;

        return $res;
    }

    public function queryBind($sql, $binds = FALSE)
    {
        return $this->qb->compile_binds($sql, $binds);
    }

    public function startSubQuery($alias = '')
    {
        $subQuery = new CI_Qb($this->params);

        $subQuery->subQryAlias = $alias ? $alias : '';
        $subQuery->subQuery    = $subQuery;

        return $subQuery;
    }

    public function endSubQuery()
    {
        $sql = '('.$this->subQuery->toStr().')'.($this->subQryAlias ? (' AS '.$this->subQryAlias) : '');
        unset($this->subQuery);

        return $sql;
    }

    /**
     * Select
     *
     * Generates the SELECT portion of the query
     *
     * @param    string
     * @param    mixed
     * @return    CI_Qb
     */
    public function select($select = '*', $escape = NULL)
    {
        $this->qb->select($select, $escape);

        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Select Max
     *
     * Generates a SELECT MAX(field) portion of a query
     *
     * @param    string    the field
     * @param    string    an alias
     * @return    CI_Qb
     */
    public function selectMax($select = '', $alias = '')
    {
        $this->qb->select_max($select, $alias);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Select Min
     *
     * Generates a SELECT MIN(field) portion of a query
     *
     * @param    string    the field
     * @param    string    an alias
     * @return    CI_Qb
     */
    public function selectMin($select = '', $alias = '')
    {
        $this->qb->select_min($select, $alias);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Select Average
     *
     * Generates a SELECT AVG(field) portion of a query
     *
     * @param    string    the field
     * @param    string    an alias
     * @return    CI_Qb
     */
    public function selectAvg($select = '', $alias = '')
    {
        $this->qb->select_avg($select, $alias);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Select Sum
     *
     * Generates a SELECT SUM(field) portion of a query
     *
     * @param    string    the field
     * @param    string    an alias
     * @return    CI_Qb
     */
    public function selectSum($select = '', $alias = '')
    {
        $this->qb->select_sum($select, $alias);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * DISTINCT
     *
     * Sets a flag which tells the query string compiler to add DISTINCT
     *
     * @param    bool $val
     * @return    CI_Qb
     */
    public function distinct($val = TRUE)
    {
        $this->qb->distinct($val);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * From
     *
     * Generates the FROM portion of the query
     *
     * @param    mixed $from can be a string or array
     * @return    CI_Qb
     */
    public function from($from)
    {
        if ($this->queryType !== 'select') {
            throw new Exception('Must call the "exec()" or "toStr()" method after calling '.$this->queryType);
        } else {
            $this->qb->from($from);

            return $this;
        }
    }
    // --------------------------------------------------------------------

    /**
     * JOIN
     *
     * Generates the JOIN portion of the query
     *
     * @param    string
     * @param    string    the join condition
     * @param    string    the type of join
     * @param    string    whether not to try to escape identifiers
     * @return    CI_Qb
     */
    public function join($table, $cond, $type = '', $escape = NULL)
    {
        $this->qb->join($table, $cond, $type, $escape);

        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * WHERE
     *
     * Generates the WHERE portion of the query.
     * Separates multiple calls with 'AND'.
     *
     * @param    mixed
     * @param    mixed
     * @param    bool
     * @return    CI_Qb
     */
    public function where($key, $value = NULL, $escape = NULL)
    {
        $this->qb->where($key, $value, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * OR WHERE
     *
     * Generates the WHERE portion of the query.
     * Separates multiple calls with 'OR'.
     *
     * @param    mixed
     * @param    mixed
     * @param    bool
     * @return    CI_Qb
     */
    public function orWhere($key, $value = NULL, $escape = NULL)
    {
        $this->qb->or_where($key, $value, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * WHERE IN
     *
     * Generates a WHERE field IN('item', 'item') SQL query,
     * joined with 'AND' if appropriate.
     *
     * @param    string $key The field to search
     * @param    array $values The values searched on
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function whereIn($key = NULL, $values = NULL, $escape = NULL)
    {
        $this->qb->where_in($key, $values, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * OR WHERE IN
     *
     * Generates a WHERE field IN('item', 'item') SQL query,
     * joined with 'OR' if appropriate.
     *
     * @param    string $key The field to search
     * @param    array $values The values searched on
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function orWhereIn($key = NULL, $values = NULL, $escape = NULL)
    {
        $this->qb->or_where_in($key, $values, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * WHERE NOT IN
     *
     * Generates a WHERE field NOT IN('item', 'item') SQL query,
     * joined with 'AND' if appropriate.
     *
     * @param    string $key The field to search
     * @param    array $values The values searched on
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function whereNotIn($key = NULL, $values = NULL, $escape = NULL)
    {
        $this->qb->where_not_in($key, $values, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * OR WHERE NOT IN
     *
     * Generates a WHERE field NOT IN('item', 'item') SQL query,
     * joined with 'OR' if appropriate.
     *
     * @param    string $key The field to search
     * @param    array $values The values searched on
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function orWhereNotIn($key = NULL, $values = NULL, $escape = NULL)
    {
        $this->qb->or_where_not_in($key    = NULL, $values = NULL, $escape = NULL);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * LIKE
     *
     * Generates a %LIKE% portion of the query.
     * Separates multiple calls with 'AND'.
     *
     * @param    mixed $field
     * @param    string $match
     * @param    string $side
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function like($field, $match = '', $side = 'both', $escape = NULL)
    {
        $this->qb->like($field, $match, $side, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * NOT LIKE
     *
     * Generates a NOT LIKE portion of the query.
     * Separates multiple calls with 'AND'.
     *
     * @param    mixed $field
     * @param    string $match
     * @param    string $side
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function notLike($field, $match = '', $side = 'both', $escape = NULL)
    {
        $this->qb->not_like($field, $match, $side, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * OR LIKE
     *
     * Generates a %LIKE% portion of the query.
     * Separates multiple calls with 'OR'.
     *
     * @param    mixed $field
     * @param    string $match
     * @param    string $side
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function orLike($field, $match = '', $side = 'both', $escape = NULL)
    {
        $this->qb->or_like($field, $match, $side, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * OR NOT LIKE
     *
     * Generates a NOT LIKE portion of the query.
     * Separates multiple calls with 'OR'.
     *
     * @param    mixed $field
     * @param    string $match
     * @param    string $side
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function orNotLike($field, $match = '', $side = 'both', $escape = NULL)
    {
        $this->qb->or_not_like($field, $match, $side, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Starts a query group.
     *
     * @param    string $not (Internal use only)
     * @param    string $type (Internal use only)
     * @return    CI_Qb
     */
    public function groupStart($not = '', $type = 'AND ')
    {
        $this->qb->group_start($not, $type);

        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Starts a query group, but ORs the group
     *
     * @return    CI_Qb
     */
    public function orGroupStart()
    {
        $this->qb->or_group_start();
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Starts a query group, but NOTs the group
     *
     * @return    CI_Qb
     */
    public function notGroupStart()
    {
        $this->qb->not_group_start();
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Starts a query group, but OR NOTs the group
     *
     * @return    CI_Qb
     */
    public function orNotGroupStart()
    {
        $this->qb->or_not_group_start();
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Ends a query group
     *
     * @return    CI_Qb
     */
    public function groupEnd()
    {
        $this->qb->group_end();

        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * GROUP BY
     *
     * @param    string $by
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function groupBy($by, $escape = NULL)
    {
        $this->qb->group_by($by, $escape);

        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * HAVING
     *
     * Separates multiple calls with 'AND'.
     *
     * @param    string $key
     * @param    string $value
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function having($key, $value = NULL, $escape = NULL)
    {
        $this->qb->having($key, $value, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * OR HAVING
     *
     * Separates multiple calls with 'OR'.
     *
     * @param    string $key
     * @param    string $value
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function orHaving($key, $value = NULL, $escape = NULL)
    {
        $this->qb->or_having($key, $value, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * ORDER BY
     *
     * @param    string $orderby
     * @param    string $direction ASC, DESC or RANDOM
     * @param    bool $escape
     * @return    CI_Qb
     */
    public function orderBy($orderby, $direction = '', $escape = NULL)
    {
        $this->qb->order_by($orderby, $direction, $escape);

        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * LIMIT
     *
     * @param    int $value LIMIT value
     * @param    int $offset OFFSET value
     * @return    CI_Qb
     */
    public function limit($value, $offset = 0)
    {
        $this->qb->limit($value, $offset);
        return $this;
    }

    /**
     * Excute last query string
     * @return string
     */
    public function lastQuery()
    {
        return $this->lastQury;
    }
    // --------------------------------------------------------------------

    /**
     * Sets the OFFSET value
     *
     * @param    int $offset OFFSET value
     * @return    CI_Qb
     */
    public function offset($offset)
    {
        $this->qb->offset($offset);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * The "set" function.
     *
     * Allows key/value pairs to be set for inserting or updating
     *
     * @param    mixed
     * @param    string
     * @param    bool
     * @return    CI_Qb
     */
    public function set($key, $value = '', $escape = NULL)
    {
        $this->qb->set($key, $value, $escape);
        return $this;
    }
    // --------------------------------------------------------------------

    /**
     * Insert
     *
     * Compiles an insert string and runs the query
     *
     * @param    string    the table to insert data into
     * @param    array    an associative array of insert values
     * @param    bool $escape Whether to escape values and identifiers
     * @return    CI_Qb
     */
    public function insert($table, $set = NULL, $escape = NULL)
    {
        if ($this->queryType !== 'select') {
            throw new Exception('Must call the "exec()" or "toStr()" method after calling '.$this->queryType);
        } else {
            $this->table     = $table ? $table : $this->table;
            $this->queryType = 'insert';

            if ($set !== NULL) {
                foreach ($set as $sKey => $sVal) {
                    $this->set($sKey, $sVal, $escape);
                }
            }

            return $this;
        }
    }
    // --------------------------------------------------------------------

    /**
     * UPDATE
     *
     * Compiles an update string and runs the query.
     *
     * @param    string $table
     * @param    array $set An associative array of update values
     * @param    mixed $where
     * @param    int $limit
     * @return    CI_Qb
     */
    public function update($table, $set = NULL, $where = NULL, $limit = NULL)
    {
        if ($this->queryType !== 'select') {
            throw new Exception('Must call the "exec()" or "toStr()" method after calling '.$this->queryType);
        } else {

            $this->table     = $table ? $table : $this->table;
            $this->queryType = 'update';

            if ($set !== NULL) {
                foreach ($set as $sKey => $sVal) {
                    $this->set($sKey, $sVal);
                }
            }

            if ($where !== NULL) {
                $this->where($where);
            }

            if (!empty($limit)) {
                $this->limit($limit, $offset);
            }

            return $this;
        }
    }
    // --------------------------------------------------------------------

    /**
     * Delete
     *
     * Compiles a delete string and runs the query
     *
     * @param    strint    the table(s) to delete from.
     * @param    mixed    the where clause
     * @param    mixed    the limit clause
     * @return    CI_Qb
     */
    public function delete($table, $where = '', $limit = NULL)
    {
        if ($this->queryType !== 'select') {
            throw new Exception('Must call the "exec()" or "toStr()" method after calling '.$this->queryType);
        } elseif (!is_string($table)) {
            throw new Exception('The table name is not a string.');
        } else {

            $this->table     = $table ? $table : $this->table;
            $this->queryType = 'delete';

            if ($where != '') {
                $this->where($where);
            }

            if (!empty($limit)) {
                $this->limit($limit);
            }

            return $this;
        }
    }
    // --------------------------------------------------------------------

    /**
     * toStr
     *
     * @return    string
     */
    public function toStr()
    {
        switch ($this->queryType) {
            case 'update':
                if ($this->qb->hasWhare()) {
                    $sql = $this->qb->get_compiled_update($this->table);
                } else {
                    throw new Exception('Update must call where() function!');
                }
                break;
            case 'insert':
                $sql = $this->qb->get_compiled_insert($this->table);
                break;
            case 'delete':
                if ($this->qb->hasWhare()) {
                    $sql = $this->qb->get_compiled_delete($this->table);
                } else {
                    throw new Exception('Delete must call where() function!');
                }
                break;
            default:
                $sql = $this->qb->get_compiled_select();
                break;
        }

        $this->queryType = 'select';

        return $sql;
    }
}

/**
 * Description of NunaQB
 *
 * @author hoksi
 */
class NunaQb extends CI_DB_query_builder
{
    public $stmt_id;
    public $curs_id;
    public $limit_used;
    public $dbversion;

    public function __construct($params)
    {
        parent::__construct($params);

        $this->driver($this->dbdriver);
    }

    public function driver($driver = 'mysqli')
    {
        switch ($driver) {
            case 'cubrid':
                $this->_random_keyword       = array('RANDOM()', 'RANDOM(%d)');
            case 'mysqli':
            case 'mysql':
                $this->_escape_char          = '`';
                break;
            case 'oci8':
                $this->_reserved_identifiers = array('*', 'rownum');
                $this->_random_keyword       = array('ASC', 'ASC');
                $this->_count_string         = 'SELECT COUNT(1) AS ';
                break;
            case 'odbc':
                $this->_escape_char          = '';
                $this->_like_escape_str      = " {escape '%s'} ";
                $this->_random_keyword       = array('RND()', 'RND(%d)');
                break;
            case 'postgre':
            case 'sqlite3':
            case 'sqlite':
                $this->_random_keyword       = array('RANDOM()', 'RANDOM()');
                break;
            case 'sqlsrv':
            case 'mssql':
                $this->_random_keyword       = array('NEWID()', 'RAND(%d)');
                $this->_quoted_identifier    = TRUE;
                break;
            case 'ibase':
                $this->_random_keyword       = array('RAND()', 'RAND()');
                break;
        }
    }

    public function getCountString()
    {
        return $this->_count_string;
    }

    protected function _limit($sql)
    {
        $db_limit_func = $this->dbdriver.'_limit';

        if (method_exists($this, $db_limit_func)) {
            return $this->{$db_limit_func}($sql);
        } else {
            return parent::_limit($sql);
        }
    }

    protected function oci8_limit($sql)
    {
        if (version_compare($this->version(), '12.1', '>=')) {
            // OFFSET-FETCH can be used only with the ORDER BY clause
            empty($this->qb_orderby) && $sql .= ' ORDER BY 1';

            return $sql.' OFFSET '.(int) $this->qb_offset.' ROWS FETCH NEXT '.$this->qb_limit.' ROWS ONLY';
        }

        $this->limit_used = TRUE;
        return 'SELECT * FROM (SELECT inner_query.*, rownum rnum FROM ('.$sql.') inner_query WHERE rownum < '.($this->qb_offset + $this->qb_limit + 1).')'
            .($this->qb_offset ? ' WHERE rnum >= '.($this->qb_offset + 1) : '');
    }

    protected function ibase_limit($sql)
    {
        // Limit clause depends on if Interbase or Firebird
        if (stripos($this->version(), 'firebird') !== FALSE) {
            $select = 'FIRST '.$this->qb_limit
                .($this->qb_offset ? ' SKIP '.$this->qb_offset : '');
        } else {
            $select = 'ROWS '
                .($this->qb_offset ? $this->qb_offset.' TO '.($this->qb_limit + $this->qb_offset) : $this->qb_limit);
        }

        return preg_replace('`SELECT`i', 'SELECT '.$select, $sql, 1);
    }

    protected function mssql_limit($sql)
    {
        $limit = $this->qb_offset + $this->qb_limit;

        // As of SQL Server 2005 (9.0.*) ROW_NUMBER() is supported,
        // however an ORDER BY clause is required for it to work
        if (version_compare($this->version(), '9', '>=') && $this->qb_offset && !empty($this->qb_orderby)) {
            $orderby = $this->_compile_order_by();

            // We have to strip the ORDER BY clause
            $sql = trim(substr($sql, 0, strrpos($sql, $orderby)));

            // Get the fields to select from our subquery, so that we can avoid CI_rownum appearing in the actual results
            if (count($this->qb_select) === 0 OR strpos(implode(',', $this->qb_select), '*') !== FALSE) {
                $select = '*'; // Inevitable
            } else {
                // Use only field names and their aliases, everything else is out of our scope.
                $select       = array();
                $field_regexp = ($this->_quoted_identifier) ? '("[^\"]+")' : '(\[[^\]]+\])';
                for ($i = 0, $c = count($this->qb_select); $i < $c; $i++) {
                    $select[] = preg_match('/(?:\s|\.)'.$field_regexp.'$/i', $this->qb_select[$i], $m) ? $m[1] : $this->qb_select[$i];
                }
                $select = implode(', ', $select);
            }

            return 'SELECT '.$select." FROM (\n\n"
                .preg_replace('/^(SELECT( DISTINCT)?)/i', '\\1 ROW_NUMBER() OVER('.trim($orderby).') AS '.$this->escape_identifiers('CI_rownum').', ',
                    $sql)
                ."\n\n) ".$this->escape_identifiers('CI_subquery')
                ."\nWHERE ".$this->escape_identifiers('CI_rownum').' BETWEEN '.($this->qb_offset + 1).' AND '.$limit;
        }

        return preg_replace('/(^\SELECT (DISTINCT)?)/i', '\\1 TOP '.$limit.' ', $sql);
    }

    protected function sqlsrv_limit($sql)
    {
        // As of SQL Server 2012 (11.0.*) OFFSET is supported
        if (version_compare($this->version(), '11', '>=')) {
            // SQL Server OFFSET-FETCH can be used only with the ORDER BY clause
            empty($this->qb_orderby) && $sql .= ' ORDER BY 1';

            return $sql.' OFFSET '.(int) $this->qb_offset.' ROWS FETCH NEXT '.$this->qb_limit.' ROWS ONLY';
        }

        $limit = $this->qb_offset + $this->qb_limit;

        // An ORDER BY clause is required for ROW_NUMBER() to work
        if ($this->qb_offset && !empty($this->qb_orderby)) {
            $orderby = $this->_compile_order_by();

            // We have to strip the ORDER BY clause
            $sql = trim(substr($sql, 0, strrpos($sql, $orderby)));

            // Get the fields to select from our subquery, so that we can avoid CI_rownum appearing in the actual results
            if (count($this->qb_select) === 0 OR strpos(implode(',', $this->qb_select), '*') !== FALSE) {
                $select = '*'; // Inevitable
            } else {
                // Use only field names and their aliases, everything else is out of our scope.
                $select       = array();
                $field_regexp = ($this->_quoted_identifier) ? '("[^\"]+")' : '(\[[^\]]+\])';
                for ($i = 0, $c = count($this->qb_select); $i < $c; $i++) {
                    $select[] = preg_match('/(?:\s|\.)'.$field_regexp.'$/i', $this->qb_select[$i], $m) ? $m[1] : $this->qb_select[$i];
                }
                $select = implode(', ', $select);
            }

            return 'SELECT '.$select." FROM (\n\n"
                .preg_replace('/^(SELECT( DISTINCT)?)/i', '\\1 ROW_NUMBER() OVER('.trim($orderby).') AS '.$this->escape_identifiers('CI_rownum').', ',
                    $sql)
                ."\n\n) ".$this->escape_identifiers('CI_subquery')
                ."\nWHERE ".$this->escape_identifiers('CI_rownum').' BETWEEN '.($this->qb_offset + 1).' AND '.$limit;
        }

        return preg_replace('/(^\SELECT (DISTINCT)?)/i', '\\1 TOP '.$limit.' ', $sql);
    }

    protected function postgre_limit($sql)
    {
        return $sql.' LIMIT '.$this->qb_limit.($this->qb_offset ? ' OFFSET '.$this->qb_offset : '');
    }

    public function version()
    {
        return $this->dbversion;
    }

    public function set_dbversion($version)
    {
        $this->dbversion = $version;

        return $this;
    }

    public function hasWhare()
    {
        return empty($this->qb_where) === false;
    }
}