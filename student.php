<?php
include 'db.php';

// Default variables
$update = false;
$student_id = "";
$first_name = "";
$last_name = "";
$middle_initial = "";
$email = "";
$student_type = "";
$year_of_study = "";

// Save new student
if (isset($_POST['save'])) {
    $stmt = $conn->prepare("INSERT INTO STUDENT (STUDENTID, FIRSTNAME, LASTNAME, MIDDLEINITIAL, EMAIL, STUDENTTYPE, YEARofSTUDY) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $_POST['student_id'], $_POST['first_name'], $_POST['last_name'], $_POST['middle_initial'], $_POST['email'], $_POST['student_type'], $_POST['year']);
    $stmt->execute();
    header("Location: student.php");
}

// Update student
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE STUDENT SET FIRSTNAME=?, LASTNAME=?, MIDDLEINITIAL=?, EMAIL=?, STUDENTTYPE=?, YEARofSTUDY=? WHERE STUDENTID=?");
    $stmt->bind_param("ssssssi", $_POST['first_name'], $_POST['last_name'], $_POST['middle_initial'], $_POST['email'], $_POST['student_type'], $_POST['year'], $_POST['student_id']);
    $stmt->execute();
    header("Location: student.php");
}

// Delete student
if (isset($_GET['delete'])) {
    $student_id = $_GET['delete'];
    $conn->query("DELETE FROM STUDENT WHERE STUDENTID=$student_id") or die($conn->error);
    header("Location: student.php");
}

// Edit student (load data into form)
if (isset($_GET['edit'])) {
    $student_id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM STUDENT WHERE STUDENTID=$student_id") or die($conn->error);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $student_id = $row['STUDENTID'];
        $first_name = $row['FIRSTNAME'];
        $last_name = $row['LASTNAME'];
        $middle_initial = $row['MIDDLEINITIAL'];
        $email = $row['EMAIL'];
        $student_type = $row['STUDENTTYPE'];
        $year_of_study = $row['YEARofSTUDY'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Student Management</h1>
<nav>
    <a href="index.php">Home</a>
    <a href="student.php">Students</a>
    <a href="course.php">Courses</a>
    <a href="enrollment.php">Enrollments</a>
</nav>

<h2><?php echo $update ? "Update Student" : "Add New Student"; ?></h2>

<form method="post" action="student.php">
    <input type="number" name="student_id" placeholder="Student ID" value="<?php echo $student_id; ?>" required <?php if($update) echo "readonly"; ?>>
    <input type="text" name="first_name" placeholder="First Name" value="<?php echo $first_name; ?>" required>
    <input type="text" name="last_name" placeholder="Last Name" value="<?php echo $last_name; ?>" required>
    <input type="text" name="middle_initial" placeholder="Middle Initial" value="<?php echo $middle_initial; ?>">
    <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
    <select name="student_type">
        <option value="Regular" <?php if ($student_type == "Regular") echo "selected"; ?>>Regular</option>
        <option value="Irregular" <?php if ($student_type == "Irregular") echo "selected"; ?>>Irregular</option>
    </select>
    <input type="text" name="year" placeholder="Year of Study" value="<?php echo $year_of_study; ?>" required>

    <input type="submit" name="<?php echo $update ? "update" : "save"; ?>" value="<?php echo $update ? "Update" : "Save"; ?>">
</form>

<h2>Search Student</h2>
<form method="get" action="student.php" style="max-width: 500px; margin: 20px auto;">
    <input type="text" name="search" placeholder="Search by First Name or Last Name" style="width: 80%; padding: 10px;">
    <input type="submit" value="Search" style="padding: 10px;">
    <a href="student.php" style="margin-left: 10px; text-decoration: none;">Reset</a>
</form>

<h2>Student List</h2>
<table>
    <tr>
        <th>Student ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Type</th>
        <th>Year</th>
        <th>Actions</th>
    </tr>
    <?php
    if (isset($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);
        $result = $conn->query("SELECT * FROM STUDENT WHERE FIRSTNAME LIKE '%$search%' OR LASTNAME LIKE '%$search%'") or die($conn->error);
    } else {
        $result = $conn->query("SELECT * FROM STUDENT") or die($conn->error);
    }
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['STUDENTID']; ?></td>
        <td><?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME']; ?></td>
        <td><?php echo $row['EMAIL']; ?></td>
        <td><?php echo $row['STUDENTTYPE']; ?></td>
        <td><?php echo $row['YEARofSTUDY']; ?></td>
        <td>
            <a href="student.php?edit=<?php echo $row['STUDENTID']; ?>">Edit</a> |
            <a href="student.php?delete=<?php echo $row['STUDENTID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
