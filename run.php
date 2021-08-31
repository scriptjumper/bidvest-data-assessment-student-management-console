<?php
    require_once('classes/students.php');

    $students = new Students();
    if (isset($argv[1])) {
        $action = $students->get_value($argv[1]);
    } else {
        exit;
    }

    switch ($action) {
        case 'add':
            // Getting inputs from CLI and constructing JSON object
            $inputId = $students->get_input("Enter id");
            $inputName = $students->get_input("Enter name");
            $inputSurname = $students->get_input("Enter Surname");
            $inputAge = $students->get_input("Enter age");
            $inputCurriculum = $students->get_input("Enter Curriculum");

            // Opening student file
            $dir = $students->studentDir . substr($inputId, 0, 2);
            $file = $inputId . $students->fileExt;

            // Checking if all the fields was filled in
            if ($inputId === '' || $inputName === '' || $inputSurname === '' || $inputAge === '' || $inputCurriculum === '') {
                print_r("All student details are mandatory!");
                exit;
            } else if(strlen($inputId) !== 7) {// Checking if the id entered consists of 7 digits
                print_r("Student ids must consist of 7 digits!");
                exit;
            } else if(file_exists($dir . '/' . $file)) {// Checking if the id entered is unique
                print_r("Student id already exists!");
                exit;
            }

            $studentJSON = json_encode(
                array(
                    'id' => (int)$inputId,
                    'name' => $inputName,
                    'surname' => $inputSurname,
                    'age' => (int)$inputAge,
                    'curriculum' => $inputCurriculum,
                )
            );

            // If folder does not exist create it.
            if(is_dir($dir) === false)
            {
                mkdir($dir);
            }

            $students->write_to_file($dir . '/' . $file, $studentJSON);
            
            break;
        case 'search':
            $searchTerm = $students->get_input("Enter Search criteria");
            $allData = $students->get_students_data();

            if ($searchTerm === '') {
                $students->build_table($allData);
            } else {
                // get filter type eg name=test or curriculum=math
                $filter = strtolower($searchTerm);

                switch ($filter) {
                    case strpos($filter, 'id=') !== false:
                        $studentData = $students->filter_students($allData, 'id', $students->get_value($filter, 'int'));
                        break;

                    case strpos($filter, 'name=') !== false:
                        $studentData = $students->filter_students($allData, 'name', $students->get_value($filter));
                        break;

                    case strpos($filter, 'surname=') !== false:
                        $studentData = $students->filter_students($allData, 'surname', $students->get_value($filter));
                        break;

                    case strpos($filter, 'age=') !== false:
                        $studentData = $students->filter_students($allData, 'age', $students->get_value($filter, 'int'));
                        break;
                        
                    case strpos($filter, 'curriculum=') !== false:
                        $studentData = $students->filter_students($allData, 'curriculum', $students->get_value($filter));
                        break;
                        
                    default:
                        break;
                }

                $students->build_table($studentData);
            }

            break;
        case 'edit':
            // Firstly checking if the student id exists
            if (isset($argv[2])) {
                $studentId = $students->get_value($argv[2]);
            } else {
                $studentId = '';
                print_r("No student ID has been set!");
                exit;
            }

            print_r("Leave field blank to keep previous value\n");

            // Opening student file
            $path = $students->studentDir . substr($studentId, 0, 2) . '/';
            $file_to_read = $studentId . $students->fileExt;

            $json = file_get_contents($path . $file_to_read);
            
            // Decode the JSON file
            $json_data = json_decode($json, true);
            
            // Getting edited values of student data
            $_name = $students->get_input("Enter name [" . $json_data['name'] . "]");
            $_surname = $students->get_input("Enter surname [" . $json_data['surname'] . "]");
            $_age = $students->get_input("Enter age [" . $json_data['age'] . "]");
            $_curriculum = $students->get_input("Enter curriculum [" . $json_data['curriculum'] . "]");
            
            $editedJSON = json_encode(
                array(
                    'id' => $json_data['id'],
                    'name' => $_name !== '' ? $_name : $json_data['name'],
                    'surname' => $_surname !== '' ? $_surname : $json_data['surname'],
                    'age' => $_age !== '' ? (int)$_age : $json_data['age'],
                    'curriculum' => $_curriculum !== '' ? $_curriculum : $json_data['curriculum'],
                )
            );

            $students->write_to_file($path . $file_to_read, $editedJSON);
            
            break;
        case 'delete':
            // Firstly checking if the student id exists
            if (isset($argv[2])) {
                $studentId = $students->get_value($argv[2]);
            } else {
                $studentId = '';
                print_r("No student ID has been set!");
                exit;
            }

            // Create the folder and file paths
            $path = $students->studentDir . substr($studentId, 0, 2) . '/';
            $filename = $studentId . $students->fileExt;;

            // Remove the JSON file
            if (unlink($path . $filename)) {
                print_r("Student deleted successfully");
            } else {
                print_r("There was a error deleting the file " . $filename);
            }

            break;
        default:
            print_r("Unknown operation, exiting console.");
            break;
    }
?>