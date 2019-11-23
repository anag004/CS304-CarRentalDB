<?php

class Database {
    private $db_conn;
    public $success;

    function connect() {
        $this->db_conn = OCILogon("ora_anag004", "a23835341", "dbhost.students.cs.ubc.ca:1522/stu");
        if ($this->db_conn) {
            // echo "Connected to DB...<br>";
            return true;
        } else {
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    // Executes a plain SQL command, returns the result
    function executePlainSQL($cmdstr) {
        $statement = OCIParse($this->db_conn, $cmdstr);

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($this->db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $this->success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        
        // ========= CODE TO DEBUG RETRIEVED DATA ==========
        // OCI_fetch_all($statement, $res);
        // echo "<pre>\n";
        // var_dump($res);
        // echo "</pre>\n";
        // =================================================

        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $this->success = False;
        }
        
        return $statement;
    }

    function __destruct() {
        OCI_close($this->db_conn);
    }

    function commit() {
        echo "DATA COMMITTED<br>";
        OCICommit($this->db_conn);
    }
 }

?>