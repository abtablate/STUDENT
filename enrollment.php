<?php
include 'db.php';

// Default variables
$update = false;
$enrollment_id = "";
$enrollment_date = "";
$student_id = "";
$course_id = "";

// Save new enrollment
if (isset($_POST['save'])) {
    $stmt = $conn->prepare("INSERT INTO ENROLLMENT (ENROLLMENTID, ENROLLMENT_DATE, STUDENTID, COURSEID) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isii", $_POST['enrollment_id'], $_POST['enrollment_date'], $_POST['student_id'], $_POST['course_id']);
    $stmt->execute();
    header("Location: enrollment.php");
}

// Update enrollment
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE ENROLLMENT SET ENROLLMENT_DATE=?, STUDENTID=?, COURSEID=? WHERE ENROLLMENTID=?");
    $stmt->bind_param("siii", $_POST['enrollment_date'], $_POST['student_id'], $_POST['course_id'], $_POST['enrollment_id']);
    $stmt->execute();
    header("Location: enrollment.php");
}

// Delete enrollment
if (isset($_GET['delete'])) {
    $enrollment_id = $_GET['delete'];
    $conn->query("DELETE FROM ENROLLMENT WHERE ENROLLMENTID=$enrollment_id") or die($conn->error);
    header("Location: enrollment.php");
}

// Edit enrollment
if (isset($_GET['edit'])) {
    $enrollment_id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM ENROLLMENT WHERE ENROLLMENTID=$enrollment_id") or die($conn->error);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $enrollment_id = $row['ENROLLMENTID'];
        $enrollment_date = $row['ENROLLMENT_DATE'];
        $student_id = $row['STUDENTID'];
        $course_id = $row['COURSEID'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Enrollments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Enrollment Management</h1>
<nav>
    <a href="index.php">Home</a>
    <a href="student.php">Students</a>
    <a href="course.php">Courses</a>
    <a href="enrollment.php">Enrollments</a>
</nav>

<h2><?php echo $update ? "Update Enrollment" : "Add New Enrollment"; ?></h2>

<form method="post" action="enrollment.php">
    <input type="number" name="enrollment_id" placeholder="Enrollment ID" value="<?php echo $enrollment_id; ?>" required <?php if($update) echo "readonly"; ?>>
    <input type="date" name="enrollment_date" value="<?php echo $enrollment_date; ?>" required>
    <input type="number" name="student_id" placeholder="Student ID" value="<?php echo $student_id; ?>" required>
    <input type="number" name="course_id" placeholder="Course ID" value="<?php echo $course_id; ?>" required>

    <input type="submit" name="<?php echo $update ? "update" : "save"; ?>" value="<?php echo $update ? "Update" : "Save"; ?>">
</form>

<h2>Search Enrollment</h2>
<form method="get" action="enrollment.php" style="max-width: 500px; margin: 20px auto;">
    <input type="text" name="search" placeholder="Search by Student ID or Course ID" style="width: 80%; padding: 10px;">
    <input type="submit" value="Search" style="padding: 10px;">
    <a href="enrollment.php" style="margin-left: 10px; text-decoration: none;">Reset</a>
</form>

<h2>Enrollment List</h2>
<table>
    <tr>
        <th>Enrollment ID</th>
        <th>Date</th>
        <th>Student ID</th>
        <th>Course ID</th>
        <th>Actions</th>
    </tr>
    <?php
    if (isset($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);
        $result = $conn->query("SELECT * FROM ENROLLMENT WHERE STUDENTID LIKE '%$search%' OR COURSEID LIKE '%$search%'") or die($conn->error);
    } else {
        $result = $conn->query("SELECT * FROM ENROLLMENT") or die($conn->error);
    }
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['ENROLLMENTID']; ?></td>
        <td><?php echo $row['ENROLLMENT_DATE']; ?></td>
        <td><?php echo $row['STUDENTID']; ?></td>
        <td><?php echo $row['COURSEID']; ?></td>
        <td>
            <a href="enrollment.php?edit=<?php echo $row['ENROLLMENTID']; ?>">Edit</a> |
            <a href="enrollment.php?delete=<?php echo $row['ENROLLMENTID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
