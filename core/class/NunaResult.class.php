<?php
/**
 * Description of ForbizResult
 *
 * @author hoksi
 */
class NunaResult extends CI_DB_mysqli_result
{

    public function __construct($result)
    {
        if (get_class($result) == 'CI_DB_mysqli_result') {
            $drv = (object) ['conn_id' => $result->conn_id, 'result_id' => $result->result_id];
        } elseif (get_class($result) == 'mysqli_result') {
            $drv = (object) ['conn_id' => '', 'result_id' => $result];
        }
        
        parent::__construct($drv);
    }

    /**
     * Retrieve the results of the query. Typically an array of
     * individual data rows, which can be either an 'array', an
     * 'object', or a custom class name.
     * @param string $type
     * @return mixed
     */
    public function getResult($type = 'object'): array
    {
        return $this->result($type);
    }

    /**
     * Returns the results as an array of arrays.
     *
     * If no results, an empty array is returned.
     *
     * @return array
     */
    public function getResultArray(): array
    {
        return $this->result_array();
    }

    /**
     * Wrapper object to return a row as either an array, an object, or
     * a custom class.
     *
     * If row doesn't exist, returns null.
     *
     * @param int    $n    The index of the results to return
     * @param string $type The type of result object. 'array', 'object' or class name.
     *
     * @return mixed
     */
    public function getRow($n = 0, $type = 'object')
    {
        return $this->row($n, $type);
    }

    /**
     * Returns a single row from the results as an array.
     *
     * If row doesn't exist, returns null.
     *
     * @param int $n
     *
     * @return mixed
     */
    public function getRowArray($n = 0)
    {
        return $this->row_array($n);
    }

    /**
     * Returns an unbuffered row and move the pointer to the next row.
     *
     * @param string $type
     *
     * @return mixed
     */
    public function getUnbufferedRow($type = 'object')
    {
        return $this->unbuffered_row($type);
    }

    /**
     * Frees the current result.
     *
     * @return mixed
     */
    public function freeResult()
    {
        $this->free_result();
    }
}