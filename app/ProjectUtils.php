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

        public static function getResultInTable($result, $arr) {
            // echo "DISPLAY CALLED <br>";
            $counter = 0;
            $arr_len = count($arr);
        
            $out= "<table class='table table-sm table-hover'>";

            $out.= "<thead class='thead-light'><tr>";
            $out.= "<th >" . "SNO" . "</th>";
            for($i = 0; $i < $arr_len; $i++) {
                $out.= "<th>" . $arr[$i] . "</th>";
            }
            $out.= "</tr></thead><tbody>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                $counter++;
                $out.= "<tr>";
                $out.= "<td>" . $counter . "</td>";
                for($i = 0; $i < $arr_len; $i++) {
                    $out.= "<td>" . $row[$arr[$i]] . "</td>";
                }
                $out.= "</tr>";
            }

            $out.= "</tbody></table>";
            return array($counter,$out);
        }

        // Makes a reservation with the supplied information
        public static function makeReservation($requestObject, $db_conn) {
            $fromDate = ProjectUtils::constructDate($requestObject['FROM_DATE'], $requestObject['FROM_TIME']);
            $toDate = ProjectUtils::constructDate($requestObject['TO_DATE'], $requestObject['TO_TIME']);
            
            $insertDetails = "'" . $requestObject['VTNAME'] . "'" . ", " . $requestObject['DLICENSE'] . ", " . $fromDate . ", " . $toDate . ", '" . $requestObject['LOCATION'] . "'";
            $confNo = hash('ripemd160', $insertDetails);
            
            $result = $db_conn->executePlainSQL("INSERT INTO reservations VALUES (" . "'" . $confNo . "'" . ", " . $insertDetails . ")");
            $db_conn->commit();

            return $confNo;
        }

        // Checks if a reservation exists with the given data
        public static function getReservation($confNo, $db_conn, $infoString) {
            $result = $db_conn->executePlainSQL("SELECT " . $infoString . " FROM reservations WHERE conf_no = " . "'" . $confNo . "'");

            if (($row = oci_fetch_array($result)) != false) {
                return $row;
            } else {
                return false;
            }
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

                $result = $result . "NOT EXISTS ( SELECT  * FROM rentals rent, reservations resv WHERE (" . $from_date . ", " . $to_date . ") OVERLAPS (resv.FROM_DATETIME, resv.TO_DATETIME) AND rent.vlicense = v.vlicense AND resv.conf_no = rent.conf_no )";
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
        public static function getErrorBox($text,$color="red"){
            if($color =="red"){
                return '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>ERROR: </strong>'.$text.'</div>';
            }
            if($color == "blue"){
                return '<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>INFO: </strong>'.$text.'</div>';
            }
        }

    }
?>
