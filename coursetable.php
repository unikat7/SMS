<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Course Management</title>
</head>
<body>
<?php
include 'connection.php';

if (isset($_POST['update_course'])) {
    $old_code = $_POST['old_code'];
    $course_name = $_POST['course_name'];
    $credit_hours = $_POST['credit_hours'];
    $semester = $_POST['semester'];
    $update_sql = "UPDATE course SET name='$course_name', hours='$credit_hours', semester='$semester' WHERE code='$old_code'";
    mysqli_query($connection, $update_sql);
}

if (isset($_POST['delete_course'])) {
    $code = $_POST['code_course'];
    $check_teacher_sql = "SELECT * FROM course_teacher WHERE course_code = '$code'";
    $check_result = mysqli_query($connection, $check_teacher_sql);
    if (mysqli_num_rows($check_result) == 0) {
        $delete_sql = "DELETE FROM course WHERE code='$code'";
        mysqli_query($connection, $delete_sql);
    }
}
?>
<div class="container mt-4">
    <h2>Course Management</h2>
    <div class="table-responsive">
        <table class="table table-bordered" id="courseTable">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Code</th>
                    <th>Credit Hours</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM course";
                $data = mysqli_query($connection, $sql);
                if (mysqli_num_rows($data) > 0) {
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['code']}</td>
                                <td>{$row['hours']}</td>
                                <td>{$row['semester']}</td>
                                <td>
                                    <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#updateModal' 
                                        data-code='{$row['code']}' 
                                        data-name='{$row['name']}' 
                                        data-hours='{$row['hours']}' 
                                        data-semester='{$row['semester']}'>Update</button>
                                    <form method='POST' action='' style='display:inline;'>
                                        <input type='hidden' name='code_course' value='{$row['code']}'>
                                        <button type='submit' name='delete_course' class='btn btn-danger'>Delete</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center;'>No courses found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <input type="hidden" name="old_code" id="modal_old_code">
                    <div class="mb-3">
                        <label for="modal_course_name" class="form-label">Course Name</label>
                        <input type="text" id="modal_course_name" name="course_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal_credit_hours" class="form-label">Credit Hours</label>
                        <input type="number" id="modal_credit_hours" name="credit_hours" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal_semester" class="form-label">Semester</label>
                        <input type="text" id="modal_semester" name="semester" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update_course" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('modal_old_code').value = button.getAttribute('data-code');
        document.getElementById('modal_course_name').value = button.getAttribute('data-name');
        document.getElementById('modal_credit_hours').value = button.getAttribute('data-hours');
        document.getElementById('modal_semester').value = button.getAttribute('data-semester');
    });

    window.addEventListener('load', function () {
        const table = document.getElementById('courseTable');
        const tableHeight = table.offsetHeight;
        const windowHeight = window.innerHeight;

        if (tableHeight > windowHeight) {
            addPagination();
        }

        function addPagination() {
            const rows = table.querySelectorAll('tbody tr');
            const rowsPerPage = 5;
            let currentPage = 1;
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            const paginationDiv = document.createElement('div');
            paginationDiv.classList.add('d-flex', 'justify-content-center', 'mt-3');
            const pagination = document.createElement('ul');
            pagination.classList.add('pagination');

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.classList.add('page-item');
                const a = document.createElement('a');
                a.classList.add('page-link');
                a.innerText = i;
                a.href = '#';
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = i;
                    updateTable();
                });
                li.appendChild(a);
                pagination.appendChild(li);
            }

            paginationDiv.appendChild(pagination);
            document.querySelector('.container').appendChild(paginationDiv);

            function updateTable() {
                rows.forEach((row, index) => {
                    row.style.display =
                        index >= (currentPage - 1) * rowsPerPage &&
                        index < currentPage * rowsPerPage
                            ? ''
                            : 'none';
                });
            }

            updateTable();
        }
    });
</script>
</body>
</html>
