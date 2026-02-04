<?php
/**
 * Base Model Class
 */
abstract class Model {
    protected $db;

    public function __construct() {
        // Get the PDO instance from the Database Singleton
        $this->db = Database::getInstance();
    }

    /**
     * Force child classes to define the table name
     */
    abstract protected function getTableName();
}
