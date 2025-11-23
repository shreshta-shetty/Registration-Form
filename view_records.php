<?php
include('db.php');

$sql = "SELECT * FROM registrations ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>All Registrations</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .table-wrap{overflow:auto;margin-top:10px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid #eee;text-align:left}
    th{background:#ffefdc}
    .top-actions{display:flex;justify-content:space-between;align-items:center}
    .small{font-size:13px;color:#666}
  </style>
</head>
<body>
  <div class="container">
    <div class="top-actions">
      <h2>Registered Students</h2>
      <div>
        <a class="btn" href="index.html">New Registration</a>
      </div>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Student ID</th>
            <th>Email</th>
            <th>College</th>
            <th>Department</th>
            <th>Course</th>
            <th>Semester</th>
            <th>Registered At</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): $i=1; ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= htmlspecialchars($row['studentid']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['college']) ?></td>
                <td><?= htmlspecialchars($row['department']) ?></td>
                <td><?= htmlspecialchars($row['course']) ?></td>
                <td><?= htmlspecialchars($row['semester']) ?></td>
                <td class="small"><?= htmlspecialchars($row['created_at']) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="9">No records found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>
<?php $conn->close(); ?>