<!-- A drop down menu listing the car types -->
<?php
    class  ProjectUtils{

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
    }
?>
