<?php
include 'db.php';

// Default variables
$update = false;
$course_id = "";
$course_code = "";
$course_description = "";
$units = "";

// Save new course
if (isset($_POST['save'])) {
    $stmt = $conn->prepare("INSERT INTO COURSE (COURSEID, COURSE_CODE, COURSE_DESCRIPTION, UNITS) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $_POST['course_id'], $_POST['course_code'], $_POST['course_description'], $_POST['units']);
    $stmt->execute();
    header("Location: course.php");
}

// Update course
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE COURSE SET COURSE_CODE=?, COURSE_DESCRIPTION=?, UNITS=? WHERE COURSEID=?");
    $stmt->bind_param("ssii", $_POST['course_code'], $_POST['course_description'], $_POST['units'], $_POST['course_id']);
    $stmt->execute();
    header("Location: course.php");
}

// Delete course
if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];
    $conn->query("DELETE FROM COURSE WHERE COURSEID=$course_id") or die($conn->error);
    header("Location: course.php");
}

// Edit course
if (isset($_GET['edit'])) {
    $course_id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM COURSE WHERE COURSEID=$course_id") or die($conn->error);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $course_id = $row['COURSEID'];
        $course_code = $row['COURSE_CODE'];
        $course_description = $row['COURSE_DESCRIPTION'];
        $units = $row['UNITS'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Course Management</h1>
<nav>
    <a href="index.php">Home</a>
    <a href="student.php">Students</a>
    <a href="course.php">Courses</a>
    <a href="enrollment.php">Enrollments</a>
</nav>

<h2><?php echo $update ? "Update Course" : "Add New Course"; ?></h2>

<form method="post" action="course.php">
    <input type="number" name="course_id" placeholder="Course ID" value="<?php echo $course_id; ?>" required <?php if($update) echo "readonly"; ?>>
    <input type="text" name="course_code" placeholder="Course Code" value="<?php echo $course_code; ?>" required>
    <input type="text" name="course_description" placeholder="Course Description" value="<?php echo $course_description; ?>">
    <input type="number" name="units" placeholder="Units" value="<?php echo $units; ?>" required>

    <input type="submit" name="<?php echo $update ? "update" : "save"; ?>" value="<?php echo $update ? "Update" : "Save"; ?>">
</form>

<h2>Search Course</h2>
<form method="get" action="course.php" style="max-width: 500px; margin: 20px auto;">
    <input type="text" name="search" placeholder="Search by Code or Description" style="width: 80%; padding: 10px;">
    <input type="submit" value="Search" style="padding: 10px;">
    <a href="course.php" style="margin-left: 10px; text-decoration: none;">Reset</a>
</form>

<h2>Course List</h2>
<table>
    <tr>
        <th>Course ID</th>
        <th>Code</th>
        <th>Description</th>
        <th>Units</th>
        <th>Actions</th>
    </tr>
    <?php
    if (isset($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);
        $result = $conn->query("SELECT * FROM COURSE WHERE COURSE_CODE LIKE '%$search%' OR COURSE_DESCRIPTION LIKE '%$search%'") or die($conn->error);
    } else {
        $result = $conn->query("SELECT * FROM COURSE") or die($conn->error);
    }
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['COURSEID']; ?></td>
        <td><?php echo $row['COURSE_CODE']; ?></td>
        <td><?php echo $row['COURSE_DESCRIPTION']; ?></td>
        <td><?php echo $row['UNITS']; ?></td>
        <td>
            <a href="course.php?edit=<?php echo $row['COURSEID']; ?>">Edit</a> |
            <a href="course.php?delete=<?php echo $row['COURSEID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
