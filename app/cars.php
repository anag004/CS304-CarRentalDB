<html>
    <head>
        <title>CPSC 304 Project</title>
    </head>

    <body>
        <!-- A drop down menu listing the car types -->
        <?php
            $db_conn = NULL;
            $success = True;

            // Connects to the database, returns a true/false value
            function connectToDB() {
                global $db_conn;

                $db_conn = OCILogon("ora_anag004", "a23835341", "dbhost.students.cs.ubc.ca:1522/stu");
                if ($db_conn) {
                    echo "Connected to DB...<br>";
                    return true;
                } else {
                    $e = OCI_Error(); // For OCILogon errors pass no handle
                    echo htmlentities($e['message']);
                    return false;
                }
            }

            // Executes a plain SQL command, returns the result
            function executePlainSQL($cmdstr) {
                global $db_conn, $success;

                $statement = OCIParse($db_conn, $cmdstr);

                if (!$statement) {
                    echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                    echo htmlentities($e['message']);
                    $success = False;
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
                    $success = False;
                }
                
                return $statement;
            }
            
            // // Prints the car types passed as a result variable
            // function printCarTypes($result) {
            //     echo "<br>Retrieved data from table vehicle_type:<br>";
            //     echo "<ul>";

            //     while ($row = OCI_Fetch_array($result, OCI_BOTH)) {
            //         echo "<li>" . $row["VTNAME"];
            //     }
                
            //     echo "</ul>";
            // }

            // Creates a drop-down menu with all the possible car types
            function createCarTypesDropdown($result) {
                echo "<select id='carList'>";

                while ($row = OCI_Fetch_array($result, OCI_BOTH)) {
                    echo "<option value = " . "'" . $row["VTNAME"] . "'>" . $row["VTNAME"] . "</option>";
                }

                echo "</select>";
            }

            connectToDB();
            $result = executePlainSQL("SELECT * FROM vehicle_type");
            // printCarTypes($result);
            createCarTypesDropdown($result);
        ?>
    </body>
</html>