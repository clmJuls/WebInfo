<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <title>CourseRecord</title>
</head>
<body>
    <ul class="navigation-bar">
        <li><a href="Student_record.php">StudentRecord</a></li>
        <li><a href="Course_Record.php">Course</a></li>
        <li><a href="Instructor_Record.php">Instructor</a></li>
        <li><a href="Enrollment_Record.php">Enrollment</a></li>
    </ul>
    <div class="status">
        <?php // Check if the query was successful
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "studentrecord";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Status:  Connection failed: " . $conn->connect_error);
        }
        echo "Server Status: Connected successfully";
        ?>
    </div>


  <!-- Course Records  -->


    <div class="card-style">
        <h1>Add Course</h1>
        <table style="width:40%">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <tr><td><label for="fname">Course Name:</label></td>
                <td><input type="text" name="coursename" id="coursename" value=""></td></tr>
                <tr><td><label for="fname">Credits:</label></td> 
                <td><input type="text" name="coursecredits" id="coursecredits" value=""></td></tr>
                <tr><td></td><td><input type="submit" value="Add Course" name="addcourse"></td></tr>
            </form>
        </table>
    </div>


    <div class="card-style">
        <h1>Course Records</h1>
        <?php 

        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addcourse']))
        {
            try{
                $coursename = $_POST['coursename'];
                $coursecredit = (int)$_POST['coursecredits'];
                $coursesql = "INSERT INTO course (CourseName,Credits) 
                                        VALUES(
                                        '$coursename',
                                        '$coursecredit')";
                //$studentrecord = $conn->exec($studentsql);
                //echo  gettype($studenfname);	

                if (mysqli_query($conn, $coursesql)) {
                    echo "New record created successfully";
                } else {
                    echo "<br>Error: " . $studentsql . "<br>" . mysqli_error($conn);
                }
            }catch(PDOException $e) {
                echo $studentrecord . "<br>" . $e->getMessage();
            }
            
            
        }?>
            <table style="width:100%">
                <tr>
                    <th>CourseID</th>
                    <th>CourseName</th>
                    <th>Credits</th>
                    <th>Options</th>
                </tr>
                <?php
                // Example query
                $sql = "SELECT * FROM course";
                $result = $conn->query($sql);

                // Check if the query was successful
                if ($result) {
                    // Process the results
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["CourseID"] . "</td>"
                        . "<td>" . $row["CourseName"]. "</td>"
                        . "<td>" . $row["Credits"]. "</td>"
                        . "<td><form method=".'POST'.">" 
                        . "<input type=".'hidden'." value=". '_method' ." name= " . "DELETE"  ."/>" 
                        . "<button type=".'submit'." value=". $row["CourseID"] ." name= " . 'deleteButton' .">Delete</button>" 
                        . "</form></td></tr>";
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }?>
            </table>
        
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteButton'])) {
                        $idToDelete = $_POST['deleteButton'];;

                        $sql = "DELETE FROM course WHERE CourseID=$idToDelete";

                        if ($conn->query($sql) === TRUE) {
                            echo "Record deleted successfully";
                        } else {
                            echo "Error deleting record: " . $conn->error;
                        }
                        // echo "Delete operation triggered.";
                }
            ?>
        </div>

        <div class="card-style">
        <?php 
        $selecteditsql = "SELECT CourseID, CourseName, Credits  FROM course";
        $result = $conn->query($selecteditsql);
        ?>
        <h1>Edit Records</h1>
        <form method="POST">
            <label for="course_id">Select Course</label>
            <select name="course_id" id="course_id">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['CourseID'] . '">' . $row['CourseName'] ." "." (". $row['Credits'].") " . '</option>';
                    }
                }
                ?>
            </select>
            <input type="submit" value="Show Student Info">
        </form>
        <?php
    // Check if the form has been submitted and a student ID is selected
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
        $selected_id = $_POST['course_id'];

        // Fetch student details based on the selected ID
        $editsql = "SELECT * FROM course WHERE CourseID = $selected_id";
        $result = $conn->query($editsql);

        if ($result->num_rows > 0) {
            $editstudent = $result->fetch_assoc();
            // Display input fields with fetched student information
            ?>
            <table style="width:40%">
            <form method="POST" action="Course_Record.php">
            <input type="hidden" name="ecourse_id" value="<?php echo $editstudent['CourseID']; ?>">
            <tr><td>Course Name:</td>
             <td><input type="text" name="efirstname" value="<?php echo $editstudent['CourseName']; ?>"></td></tr>
             <tr><td>Last Name:</td>
             <td><input type="text" name="elastname" value="<?php echo $editstudent['Credits']; ?>"></td></tr>
             <tr><td></td><td><input type="submit" value="Update"></td></tr>
            </form>
            </table>
            <?php
        } else {
            echo "No Course found with this ID.";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ecourse_id'])) {
        $ucourse_id = $_POST['ecourse_id'];
        $ucoursename = $_POST['efirstname'];
        $ucredits = $_POST['elastname'];

    
        $eupdatesql = "UPDATE course SET CourseName='$ucoursename', Credits='$ucredits' WHERE CourseID='$ucourse_id'";
    
        if ($conn->query($eupdatesql) === TRUE) {
            echo "Course information updated successfully";
        } else {
            echo "Error updating Course information: " . $conn->error;
        }
    }

    ?>
    </div>
    <!-- Student Record -->

    <div class="card-style">
    <h1>Add Student Record</h1>
    <table style="width:40%">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <tr><td><label for="fname">First name:</label></td>
            <td><input type="text" name="studentFname" id="studentFname" value=""></td></tr>
            <tr><td><label for="fname">Last name:</label></td>
            <td><input type="text" name="studentLname" id="studentLname" value=""></td></tr>
            <tr><td><label for="fname">Date of Birth</label></td>
            <td><input type="text" name="studentDOB" id="studentDOB" value=""></td></tr>
            <tr><td><label for="fname">Email:</label></td>
            <td><input type="text" name="studentEmail" id="studentEmail" value=""></td></tr>
            <tr><td><label for="fname">Phone:</label></td>
            <td><input type="text" name="studentPhone" id="studentPhone" value=""></td></tr>   
            <tr><td></td><td><input type="submit" value="submit" name="addstudent"></td></tr>
        </form>
    </table>
    </div>
    <?php 

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addstudent']))
    {
        try{
            $studenfname = $_POST['studentFname'];
            $studentlname = $_POST['studentLname'];
            $studentDOB = $_POST['studentDOB'];
            $studentemail = $_POST['studentEmail'];
            $studentphone = (int)$_POST['studentPhone'];
            $studentsql = "INSERT INTO student (FirstName,LastName,DateOfBirth,Email,Phone) 
                                    VALUES(
                                    '$studenfname',
                                    '$studentlname',
                                    '$studentDOB',
                                    '$studentemail',
                                    $studentphone)";
            //$studentrecord = $conn->exec($studentsql);
            //echo  gettype($studenfname);	

            if (mysqli_query($conn, $studentsql)) {
                echo "New record created successfully";
            } else {
                echo "<br>Error: " . $studentsql . "<br>" . mysqli_error($conn);
            }
        }catch(PDOException $e) {
            echo $studentrecord . "<br>" . $e->getMessage();
        }
        
        
    }?>

    <div class="card-style">
        <h1>Students Records</h1>
        <table style="width:100%">
        <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Options</th>
        </tr>
        <?php
        // Example query
        $sql = "SELECT * FROM student";
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result) {
            // Process the results
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["StudentID"] . "</td>"
                . "<td>" . $row["FirstName"]. "</td>"
                . "<td>" . $row["LastName"]. "</td>"
                . "<td>" . $row["DateOfBirth"]. "</td>"
                . "<td>" . $row["Email"]. "</td>"
                . "<td>" . $row["Phone"]. "</td>"
                . "<td><form method=".'POST'.">" 
                . "<input type=".'hidden'." value=". '_method' ." name= " . "DELETE"  ."/>" 
                . "<button type=".'submit'." value=". $row["StudentID"] ." name= " . 'deleteButton' .">Delete</button>" 
                . "</form></td></tr>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }?>
        </table>
    </div>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteButton'])) {
                $idToDelete = $_POST['deleteButton'];;

                $sql = "DELETE FROM student WHERE StudentID=$idToDelete";

                if ($conn->query($sql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }

                $sqlen = "DELETE FROM enrollment WHERE StudentID=$idToDelete";

                if ($conn->query($sqlen) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
                // echo "Delete operation triggered.";
        }
    ?>

    <div class="card-style">
        <?php 
        $selecteditsql = "SELECT StudentID, FirstName, LastName, Email  FROM student";
        $result = $conn->query($selecteditsql);
        ?>
        <h1>Edit Records</h1>
        <form method="POST">
            <label for="student_id">Select Student</label>
            <select name="student_id" id="student_id">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['StudentID'] . '">' . $row['FirstName'] ." ". $row['LastName']."  (". $row['Email'].") " . '</option>';
                    }
                }
                ?>
            </select>
            <input type="submit" value="Show Student Info">
        </form>
        <?php
    // Check if the form has been submitted and a student ID is selected
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
        $selected_id = $_POST['student_id'];

        // Fetch student details based on the selected ID
        $editsql = "SELECT * FROM student WHERE StudentID = $selected_id";
        $result = $conn->query($editsql);

        if ($result->num_rows > 0) {
            $editstudent = $result->fetch_assoc();
            // Display input fields with fetched student information
            ?>
            <table style="width:40%">
            <form method="POST" action="Student_Record.php">
            <input type="hidden" name="estudent_id" value="<?php echo $editstudent['StudentID']; ?>">
            <tr><td>First Name:</td>
             <td><input type="text" name="efirstname" value="<?php echo $editstudent['FirstName']; ?>"></td></tr>
             <tr><td>Last Name:</td>
             <td><input type="text" name="elastname" value="<?php echo $editstudent['LastName']; ?>"></td></tr>
             <tr><td> Date of Birth:</td>
             <td><input type="text" name="edateofbirth" value="<?php echo $editstudent['DateOfBirth']; ?>"></td></tr>
             <tr><td>Email:</td>
             <td><input type="text" name="eemail" value="<?php echo $editstudent['Email']; ?>"></td></tr>
             <tr><td>Phone: </td>
             <td><input type="text" name="ephone" value="<?php echo $editstudent['Phone']; ?>"></td></tr>
             <tr><td></td><td><input type="submit" value="Update"></td></tr>
            </form>
            </table>
            <?php
        } else {
            echo "No student found with this ID.";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['estudent_id'])) {
        $student_id = $_POST['estudent_id'];
        $firstname = $_POST['efirstname'];
        $lastname = $_POST['elastname'];
        $dateofbirth = $_POST['edateofbirth'];
        $email = $_POST['eemail'];
        $phone = $_POST['ephone'];
    
        $eupdatesql = "UPDATE student SET FirstName='$firstname', LastName='$lastname', DateOfBirth='$dateofbirth', Email='$email', Phone='$phone' WHERE StudentID='$student_id'";
    
        if ($conn->query($eupdatesql) === TRUE) {
            echo "Student information updated successfully";
        } else {
            echo "Error updating student information: " . $conn->error;
        }
    }

    ?>
    </div>

    <!-- ENROLL  -->


    <div class="card-style">
        <h1>Enroll</h1>
        <table style="width:40%">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <tr><td><label for="fname">Select Student:</label></td>
                <td>
                <select id="student" name="student">
                <?php
                    echo "<br><hr>";
                    // Example query
                    $sql = "SELECT * FROM student";
                    $result = $conn->query($sql);

                    // Check if the query was successful
                    if ($result) {
                        // Process the results
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=" . $row["StudentID"] . ">".$row["FirstName"]."</option>";
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }?>
                </select>
                </td></tr>
                <tr><td><label for="fname">Select Course:</label></td>
                <td>
                <select id="course" name="course">
                <?php
                    echo "<br><hr>";
                    // Example query
                    $sql = "SELECT * FROM course";
                    $result = $conn->query($sql);

                    // Check if the query was successful
                    if ($result) {
                        // Process the results
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=" . $row["CourseID"] . ">".$row["CourseName"]."</option>";
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }?>
                </select>
                </td></tr>
                <tr><td><label for="fname">Enrollment Date:</label></td>
                <td><input type="date" id="datepicker" name="selectedDate"></td></tr>
                <tr><td><label for="fname">Grade:</label></td>
                <td><input type="number" id="integerInput" name="grade" required></td></tr>      
                <tr><td></td><td><input type="submit" value="submit" name="addenroll"></td></tr>
            </form>
        </table>
    
    
    <?php 

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addenroll']))
    {
        try{
            $student = $_POST['student'];
            $course = $_POST['course'];
            $enrolldate = $_POST['selectedDate'];
            $grade = (int)$_POST['grade'];
            $studentsql = "INSERT INTO enrollment (StudentID,CourseID,EnrollmentDate,Grade) 
                                    VALUES(
                                    '$student',
                                    '$course',
                                    '$enrolldate',
                                    '$grade')";
            //$studentrecord = $conn->exec($studentsql);
            //echo  gettype($studenfname);	

            if (mysqli_query($conn, $studentsql)) {
                echo "New record created successfully";
            } else {
                echo "<br>Error: " . $studentsql . "<br>" . mysqli_error($conn);
            }
        }catch(PDOException $e) {
            echo $studentrecord . "<br>" . $e->getMessage();
        }
        
        
    }?>
    </div>

    <div class="card-style">
        <h1>Enrollment Records</h1>
        <table style="width:100%">
        <tr>
            <th>Enrollment ID</th>
            <th>Student ID</th>
            <th>Course ID</th>
            <th>Enrollment Date</th>
            <th>Grade</th>
            <th>Options</th>
        </tr>
        <?php
        $sql = "SELECT * FROM enrollment";
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result) {
            // Process the results
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["EnrollmentID"] . "</td>"
                . "<td>" . $row["StudentID"]. "</td>"
                . "<td>" . $row["CourseID"]. "</td>"
                . "<td>" . $row["EnrollmentDate"]. "</td>"
                . "<td>" . $row["Grade"]. "</td>"
                . "<td><form method=".'POST'.">" 
                . "<input type=".'hidden'." value=". '_method' ." name= " . "DELETE"  ."/>" 
                . "<button type=".'submit'." value=". $row["EnrollmentID"] ." name= " . 'deleteButton' .">Delete</button>" 
                . "</form></td></tr>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }?>
        </table>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteButton'])) {
                $idToDelete = $_POST['deleteButton'];;

                $eenrollsql = "DELETE FROM enrollment WHERE EnrollmentID=$idToDelete";

                if ($conn->query($eenrollsql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
        }
    ?>
    </div>
    <div class="card-style">
        <?php 
        $selecteditsql = "SELECT EnrollmentID, StudentID, EnrollmentDate, Grade FROM enrollment";
        $result = $conn->query($selecteditsql);
        ?>
        <h1>Edit Records</h1>
        <form method="POST">
            <label for="enrolls_id">Select Student</label>
            <select name="enrolls_id" id="enrolls_id">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['EnrollmentID'] . '">' ."Student:". $row['StudentID'] ." Date:". $row['EnrollmentDate']."  (Grade:". $row['Grade'].") " . '</option>';
                    }
                }
                ?>
            </select>
            <input type="submit" value="Show Student Info">
        </form>
        <?php
    // Check if the form has been submitted and a student ID is selected
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enrolls_id'])) {
        $selected_id = $_POST['enrolls_id'];

        // Fetch student details based on the selected ID
        $enrolleditsql = "SELECT * FROM enrollment WHERE EnrollmentID = $selected_id";
        $result = $conn->query($enrolleditsql);

        if ($result->num_rows > 0) {
            $editstudent = $result->fetch_assoc();
            // Display input fields with fetched student information
            ?>
            <table style="width:40%">
            <form method="POST" action="Enrollment_Record.php">
            <input type="hidden" name="eenrollment_id" value="<?php echo $editstudent['EnrollmentID']; ?>">
            <tr><td>Enrollment Date:</td>
             <td><input type="date" name="enrolldates" value="<?php echo $editstudent['EnrollmentDate']; ?>"></td></tr>
             <tr><td>Grade:</td>
             <td><input type="text" name="enrollgrade" value="<?php echo $editstudent['Grade']; ?>"></td></tr>
             <tr><td></td><td><input type="submit" value="Update"></td></tr>
            </form>
            </table>
            <?php
        } else {
            echo "No student found with this ID.";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eenrollment_id'])) {
        $enrollmentids = $_POST['eenrollment_id'];
        $enrollsdates = $_POST['enrolldates'];
        $grades = $_POST['enrollgrade'];
    
        $eupdatesql = "UPDATE enrollment SET EnrollmentDate='$enrollsdates', Grade='$grades' WHERE EnrollmentID='$enrollmentids'";
    
        if ($conn->query($eupdatesql) === TRUE) {
            echo "Enrollment information updated successfully";
        } else {
            echo "Error updating Enrollment information: " . $conn->error;
        }
    }

    ?>
    </div>

    
    <!-- Instructor Records -->


    <div class="card-style">
        <h1>Add Instructor Record</h1>
        <table style="width:40%">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <tr><td><label for="fname">First name:</label></td>
                <td><input type="text" name="insfname" id="insfname" value=""></td></tr>
                <tr><td><label for="fname">Last name:</label></td>
                <td><input type="text" name="inslname" id="inslname" value=""></td></tr>
                <tr><td><label for="fname">Email:</label></td>
                <td><input type="text" name="insemail" id="insemail" value=""></td></tr>
                <tr><td><label for="fname">Phone:</label></td>
                <td><input type="text" name="insphone" id="insphone" value=""></td></tr> 
                <tr><td></td><td><input type="submit" value="submit" name="addinstructor"></td></tr>
            </form>
        </table>
    </div>
    <?php 

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addinstructor']))
    {
        try{
            $studenfname = $_POST['insfname'];
            $studentlname = $_POST['inslname'];
            $studentemail = $_POST['insemail'];
            $studentphone = (int)$_POST['insphone'];
            $instrucsql = "INSERT INTO instructor (FirstName,LastName,Email,Phone) 
                                    VALUES(
                                    '$studenfname',
                                    '$studentlname',
                                    '$studentemail',
                                    $studentphone)";
            //$studentrecord = $conn->exec($studentsql);
            //echo  gettype($studenfname);	

            if (mysqli_query($conn, $instrucsql)) {
                echo "New record created successfully";
            } else {
                echo "<br>Error: " . $instrucsql . "<br>" . mysqli_error($conn);
            }
        }catch(PDOException $e) {
            echo $studentrecord . "<br>" . $e->getMessage();
        }
        
        
    }?>
    
    <div class="card-style">
        <h1>Instructor Records</h1>
        <table style="width:100%">
        <tr>
            <th>Instructor ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Options</th>
        </tr>
        <?php
        $sql = "SELECT * FROM instructor";
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result) {
            // Process the results
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["InstructorID"] . "</td>"
                . "<td>" . $row["FirstName"]. "</td>"
                . "<td>" . $row["LastName"]. "</td>"
                . "<td>" . $row["Email"]. "</td>"
                . "<td>" . $row["Phone"]. "</td>"
                . "<td><form method=".'POST'.">" 
                . "<input type=".'hidden'." value=". '_method' ." name= " . "DELETE"  ."/>" 
                . "<button type=".'submit'." value=". $row["InstructorID"] ." name= " . 'deleteButton' .">Delete</button>" 
                . "</form></td></tr>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }?>
        </table>
    </div>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteButton'])) {
                $idToDelete = $_POST['deleteButton'];;

                $delinssql = "DELETE FROM instructor WHERE InstructorID=$idToDelete";

                if ($conn->query($delinssql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
        }
    ?>
    <div class="card-style">
        <?php 
            $selecteditsql = "SELECT InstructorID, FirstName, LastName, Email  FROM instructor";
            $result = $conn->query($selecteditsql);
            ?>
            <h1>Edit Records</h1>
            <form method="POST">
                <label for="instr_id">Select Instructor</label>
                <select name="instr_id" id="instr_id">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['InstructorID'] . '">' . $row['FirstName'] ." ". $row['LastName']."  (". $row['Email'].") " . '</option>';
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="Show Instructor Info">
            </form>
            <?php
        // Check if the form has been submitted and a student ID is selected
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['instr_id'])) {
            $selected_id = $_POST['instr_id'];

            // Fetch student details based on the selected ID
            $editsql = "SELECT * FROM instructor WHERE InstructorID = $selected_id";
            $result = $conn->query($editsql);

            if ($result->num_rows > 0) {
                $editstudent = $result->fetch_assoc();
                // Display input fields with fetched student information
                ?>
                <table style="width:40%">
                <form method="POST" action="Instructor_Record.php">
                <input type="hidden" name="instrs_id" value="<?php echo $editstudent['InstructorID']; ?>">
                <tr><td>First Name:</td>
                <td><input type="text" name="ifirstname" value="<?php echo $editstudent['FirstName']; ?>"></td></tr>
                <tr><td>Last Name:</td>
                <td><input type="text" name="ilastname" value="<?php echo $editstudent['LastName']; ?>"></td></tr>
                <tr><td>Email:</td>
                <td><input type="text" name="iemail" value="<?php echo $editstudent['Email']; ?>"></td></tr>
                <tr><td>Phone: </td>
                <td><input type="text" name="iphone" value="<?php echo $editstudent['Phone']; ?>"></td></tr>
                <tr><td></td><td><input type="submit" value="Update"></td></tr>
                </form>
                </table>
                <?php
            } else {
                echo "No student found with this ID.";
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['instrs_id'])) {
            $instr_ids = $_POST['instrs_id'];
            $ifirstnames = $_POST['ifirstname'];
            $ilastnames = $_POST['ilastname'];
            $iemails = $_POST['iemail'];
            $iphones = $_POST['iphone'];
        
            $eupdatesql = "UPDATE instructor SET FirstName='$ifirstnames', LastName='$ilastnames', Email='$iemails', Phone='$iphones' WHERE InstructorID='$instr_ids'";
        
            if ($conn->query($eupdatesql) === TRUE) {
                echo "Instructor information updated successfully";
            } else {
                echo "Error updating Instructor information: " . $conn->error;
            }
        }

        ?>
    </div>
</body>
</html>