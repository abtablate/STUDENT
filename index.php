<!DOCTYPE html>
<html>
<head>
    <title>Student Enrollment Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .buttons {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .button-link {
            display: block;
            width: 300px;
            height: 150px;
            background-color: #3498db;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            line-height: 150px;
            border-radius: 20px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .button-link:hover {
            background-color: #2980b9;
        }

        
    </style>
</head>
<body>

<header>
    Student Enrollment Management System
</header>

<div class="container">
    <div class="buttons">
        <a class="button-link" href="student.php">STUDENTS</a>
        <a class="button-link" href="course.php">COURSES</a>
        <a class="button-link" href="enrollment.php">ENROLLMENTS</a>
    </div>
</div>


</body>
</html>
