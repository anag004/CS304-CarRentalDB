<!-- A drop down menu listing the car types -->
<?php
    class  ProjectUtils {
        // Creates a drop-down menu with all the possible types -- including a Anything type
        public static function getDropdownString($result, $name, $class="") {
            $output="";
            
            $output .= "<select name='" . $name . "' class='".$class."'>";
            $output .=  "<option value = '" . "all" . "'>" . "all" . "</option>";

            while ($row = OCI_Fetch_array($result, OCI_BOTH)) {
                $output .=  "<option value = '" . $row[$name] . "'>" . "$row[$name]" . "</option>";
            }
            $output .=  "</select>";
            return $output;
        }

        public static function constructDate($date, $time) {
            $date_string = "'" . $date . ':' . $time . "'";
            $date_format = "'YYYY-MM-DD:HH24:MI'";
            return "to_date(" . $date_string . ", "  . $date_format . ")";
        }

        public static function printResultInTable($result, $arr) {
            // echo "DISPLAY CALLED <br>";
            $counter = 0;
            $arr_len = count($arr);
        
            echo "<table border = '1'>";

            echo "<tr>";
            echo "<th>" . "SNO" . "</th>";
            for($i = 0; $i < $arr_len; $i++) {
                echo "<th>" . $arr[$i] . "</th>";
            }
            echo "</tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                $counter++;
                echo "<tr>";
                echo "<td>" . $counter . "</td>";
                for($i = 0; $i < $arr_len; $i++) {
                    echo "<td>" . $row[$arr[$i]] . "</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
            return $counter;
        }

        // Returns an SQL command for the appropriate vehicle
        public static function getVehicleQueryString($requestObject) {
            $result = "";
            $counter = 0; // Stores the number of values specified

            // Check for VTNAME
            if ($requestObject['VTNAME'] != 'all' && $requestObject['VTNAME'] != '') {
                if ($counter == 0) {
                    $result = $result . " WHERE ";
                    $counter++;
                } else if ($counter >= 1) {
                    // If there is already something there, add AND
                    $result = $result . " AND ";
                    $counter++;
                } else {
                    $counter++;
                }
                $result = $result . "v.VTNAME = '" . $requestObject['VTNAME'] . "'";
            }

            // DATE = YYYY-MM-DD
            // TIME = HH:MM
            if ($requestObject['FROM_DATE']) {
                if ($counter == 0) {
                    $result = $result . " WHERE ";
                    $counter++;
                } else if ($counter >= 1) {
                    // If there is already something there, add AND
                    $result = $result . " AND ";
                    $counter++;
                } else {
                    $counter++;
                }

                if (!$requestObject['FROM_TIME']) {
                    echo "DID NOT FIND FROM_TIME";
                    return false;
                }

                // $date_format = "'YYYY-MM-DD:HH24:MI'";
                $from_date = ProjectUtils::constructDate($requestObject['FROM_DATE'], $requestObject['FROM_TIME']);
                
                if (!$requestObject['TO_DATE']) {
                    echo "DID NOT FIND TO_DATE";
                    return false;
                }

                if (!$requestObject['TO_TIME']) {
                    echo "DID NOT FIND TO_TIME";
                    return false;
                }

                $to_date = ProjectUtils::constructDate($requestObject['TO_DATE'], $requestObject['TO_TIME']);

                $result = $result . "NOT EXISTS ( SELECT  * FROM rentals r WHERE (" . $from_date . ", " . $to_date . ") OVERLAPS (r.FROM_DATETIME, r.TO_DATETIME) AND r.vlicense = v.vlicense )";
            } else if ($requestObject['FROM_TIME'] || $requestObject['TO_DATE'] || $requestObject['TO_TIME']) {
                return false;
            } 

            if ($requestObject['LOCATION'] != 'all' && $requestObject['LOCATION'] != '') {
                if ($counter == 0) {
                    $result = $result . " WHERE ";
                    $counter++;
                } else if ($counter >= 1) {
                    // If there is already something there, add AND
                    $result = $result . " AND ";
                    $counter++;
                } else {
                    $counter++;
                }
                $result = $result . "v.LOCATION = '" . $requestObject['LOCATION'] . "'"; 
            }

            // echo $result;
            return $result;
        }
        public static function getErrorBox($text){
            return '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>ERROR: </strong>'.$text.'</div>';
        }

    }
?>
