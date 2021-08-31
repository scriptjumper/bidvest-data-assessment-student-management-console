<?php 
    class Students {
        public $studentDir = 'students/';
        public $fileExt = '.json';

        /**
         * Getting the value after the equal sign
         * Returns the value as a string by default 
         * unless you specify int
         */
        function get_value($str, $type = 'string'){
            $arg = substr($str, strpos($str, "=") + 1);

            if($type === 'int') {
                $value = (int)$arg;
            } else {
                $value = $arg;
            }

            return $value;
        }
        
        /**
         * Getting input entered in the CLI
         * Returns a string
         */
        function get_input($txt) {
            echo "$txt: ";
            $input = fopen ("php://stdin", "r");
            $inputStr = trim(fgets($input));
            fclose($input);

            return $inputStr;
        }

        /**
         * Creating and updating the data in the JSON file
         * then closes the file
         */
        function write_to_file($path, $json) {
            $file = fopen($path, "w");

            // write JSON data to file and close file
            fwrite($file, $json);
            return fclose($file);
        }

        /**
         * Fetches the JSON data in all the sub-folders
         * Returns a JSON array 
         */
        function get_students_data() {
            $folders = scandir($this->studentDir);
            $folders = array_diff(scandir($this->studentDir), array('.', '..'));

            $studentsJSON = [];

            foreach ($folders as $folder) {
                $folderPath = $this->studentDir . "$folder/";

                $files = scandir($folderPath);
                $files = array_diff(scandir($folderPath), array('.', '..'));

                foreach ($files as $file) {
                    $filePath = $folderPath . $file;

                    $json = file_get_contents($filePath);
                    $json_data = json_decode($json, true);

                    array_push($studentsJSON, $json_data);
                }
            }

            return $studentsJSON;
        }

        /**
         * Filtering JSON data by the property and value
         * Returning a JSON array
         */
        function filter_students($data, $filterBy, $filterTerm) {
            $studentData = [];

            foreach($data as $key => $value){
                if($value[$filterBy] === $filterTerm) {
                    array_push($studentData, $data[$key]);
                }
            }

            return $studentData;
        }

        /**
         * Formatting and building a table to display in the console
         */
        function build_table($data) {
            $mask = "| %-10.30s | %-30.30s | %-30.30s | %-30.30s | %-30.30s |\n";
            $table_border = "+------------------------------------------------------------------------------------------------------------------------------------------------+\n";
            printf($table_border);
            printf($mask, 'id', 'Name', 'Surname', 'Age', 'Curriculum');
            printf($table_border);
            
            foreach ($data as $value) {
                printf($mask, $value['id'], $value['name'], $value['surname'], $value['age'], $value['curriculum']);
                printf($table_border);
            }

            return;
        }
    }
?>