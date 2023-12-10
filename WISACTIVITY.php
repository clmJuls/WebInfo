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
</body>
</html>