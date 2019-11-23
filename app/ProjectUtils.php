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

        // Returns an SQL command for the appropriate vehicle
        public static function getVehicleQueryString($requestObject) {
            $result = "";
            $counter = 0; // Stores the number of values specified

            echo "VTNAME: " . $requestObject['VTNAME'];

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

                $date_format = "'YYYY-MM-DD:HH24:MI'";
                $from_date = "'" . $requestObject['FROM_DATE'] . ':' . $requestObject['FROM_TIME'] . "'";
                
                if (!$requestObject['TO_DATE']) {
                    echo "DID NOT FIND TO_DATE";
                    return false;
                }

                if (!$requestObject['TO_TIME']) {
                    echo "DID NOT FIND TO_TIME";
                    return false;
                }

                $to_date = "'" . $requestObject['TO_DATE'] . ':' . $requestObject['TO_TIME'] . "'";

                $result = $result . "NOT EXISTS ( SELECT  * FROM rentals r WHERE (" . "to_date(" . $from_date . ", "  . $date_format . "), to_date(" . $to_date . ", " . $date_format . ")) OVERLAPS (r.FROM_DATETIME, r.TO_DATETIME) AND r.vlicense = v.vlicense )";
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
    }
?>
