<?php
include('db.php');

$success = false;
$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize inputs
    $fullname = trim($_POST['fullname'] ?? '');
    $studentid = trim($_POST['studentid'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $college = trim($_POST['college'] ?? '');
    $guardian_name = trim($_POST['guardian_name'] ?? '');
    $guardian_phone = trim($_POST['guardian_phone'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $semester = intval($_POST['semester'] ?? 0);
    $address = trim($_POST['address'] ?? '');

    // basic server-side validation
    if ($fullname === '' || $studentid === '' || $email === '' || $dob === '' || $gender === '' || $college === '' || $department === '' || $course === '' || $semester < 1) {
        $errorMsg = "Please fill required fields.";
    } else {
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO registrations (fullname, studentid, email, dob, gender, college, guardian_name, guardian_phone, department, course, semester, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssssssssis", $fullname, $studentid, $email, $dob, $gender, $college, $guardian_name, $guardian_phone, $department, $course, $semester, $address);
            if ($stmt->execute()) {
                $success = true;
            } else {
                $errorMsg = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errorMsg = "Database prepare failed: " . $conn->error;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Registration Result</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .result-wrap{text-align:center;padding:18px}
    .success-box{background:#e9fcec;color:#0b7b3a;border:1px solid #c5f0d0;padding:14px;border-radius:10px;margin-bottom:12px}
    .error-box{background:#ffecec;color:#b00020;border:1px solid #f5c6c6;padding:14px;border-radius:10px;margin-bottom:12px}
    .data-list{margin-top:12px;text-align:left}
    .data-list p{padding:6px 0;border-bottom:1px dashed #f1f1f1}
  </style>
</head>
<body>
  <div class="container">
    <?php if ($success): ?>
      <div class="result-wrap">
        <h1>✅ Registration Successful</h1>
        <div class="success-box">Your response has been successfully recorded in the database.</div>

        <div class="data-list">
          <p><strong>Name:</strong> <?= htmlspecialchars($fullname) ?></p>
          <p><strong>Student ID:</strong> <?= htmlspecialchars($studentid) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
          <p><strong>DOB:</strong> <?= htmlspecialchars($dob) ?></p>
          <p><strong>Gender:</strong> <?= htmlspecialchars($gender) ?></p>
          <p><strong>College:</strong> <?= htmlspecialchars($college) ?></p>
          <p><strong>Guardian:</strong> <?= htmlspecialchars($guardian_name ?: '-') ?></p>
          <p><strong>Guardian Phone:</strong> <?= htmlspecialchars($guardian_phone ?: '-') ?></p>
          <p><strong>Department:</strong> <?= htmlspecialchars($department) ?></p>
          <p><strong>Course:</strong> <?= htmlspecialchars($course) ?></p>
          <p><strong>Semester:</strong> <?= htmlspecialchars($semester) ?></p>
          <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($address)) ?></p>
        </div>

        <div style="margin-top:16px">
          <a class="btn" href="index.html">Register another</a>
          <a class="btn" href="view_records.php" style="background:#333;margin-left:8px">View All</a>
        </div>
      </div>
    <?php else: ?>
      <div class="result-wrap">
        <h1>❌ Submission Failed</h1>
        <div class="error-box"><?= htmlspecialchars($errorMsg ?: "Unknown error") ?></div>
        <a class="btn" href="index.html">Back to form</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>