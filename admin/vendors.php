<?php
session_start();
include("db.php");

// 1. Add Vendor Logic
if (isset($_POST['add_vendor'])) {
    $name = mysqli_real_escape_string($conn, $_POST['v_name']);
    $email = mysqli_real_escape_string($conn, $_POST['v_email']);
    $phone = mysqli_real_escape_string($conn, $_POST['v_phone']);
    $store = mysqli_real_escape_string($conn, $_POST['v_store']);

    $insert = "INSERT INTO vendors (v_name, v_email, v_phone, v_store) VALUES ('$name', '$email', '$phone', '$store')";
    mysqli_query($conn, $insert);
    header("Location: vendors.php?msg=added");
    exit;
}

// 2. Update Vendor Logic (NEW)
if (isset($_POST['update_vendor'])) {
    $id = (int)$_POST['v_id'];
    $name = mysqli_real_escape_string($conn, $_POST['v_name']);
    $email = mysqli_real_escape_string($conn, $_POST['v_email']);
    $phone = mysqli_real_escape_string($conn, $_POST['v_phone']);
    $store = mysqli_real_escape_string($conn, $_POST['v_store']);

    $update = "UPDATE vendors SET v_name='$name', v_email='$email', v_phone='$phone', v_store='$store' WHERE v_id=$id";
    mysqli_query($conn, $update);
    header("Location: vendors.php?msg=updated");
    exit;
}

// 3. Delete Vendor Logic
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM vendors WHERE v_id = $id");
    header("Location: vendors.php?msg=deleted");
    exit;
}

$vendors = mysqli_query($conn, "SELECT * FROM vendors ORDER BY v_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Manage Vendors - Admin</title>
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white fw-bold">Add New Vendor</div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-2">
                            <label class="small fw-bold">Vendor Name</label>
                            <input type="text" name="v_name" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="small fw-bold">Email</label>
                            <input type="email" name="v_email" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="small fw-bold">Phone</label>
                            <input type="text" name="v_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">Store Name</label>
                            <input type="text" name="v_store" class="form-control">
                        </div>
                        <button type="submit" name="add_vendor" class="btn btn-info w-100 text-white">Save Vendor</button>
                    </form>
                </div>
            </div>
            <a href="index.php" class="btn btn-secondary btn-sm w-100">Back to Dashboard</a>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Registered Vendors</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Store</th>
                                <th>Contact</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($vendors)): ?>
                            <tr>
                                <td><?= $row['v_name']; ?></td>
                                <td><span class="badge bg-secondary"><?= $row['v_store']; ?></span></td>
                                <td><?= $row['v_email']; ?><br><small><?= $row['v_phone']; ?></small></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary editBtn" 
                                        data-id="<?= $row['v_id']; ?>"
                                        data-name="<?= $row['v_name']; ?>"
                                        data-email="<?= $row['v_email']; ?>"
                                        data-phone="<?= $row['v_phone']; ?>"
                                        data-store="<?= $row['v_store']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <a href="vendors.php?delete=<?= $row['v_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this vendor?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Vendor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input type="hidden" name="v_id" id="edit_v_id">
            <div class="mb-2">
                <label class="small fw-bold">Vendor Name</label>
                <input type="text" name="v_name" id="edit_v_name" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Email</label>
                <input type="email" name="v_email" id="edit_v_email" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Phone</label>
                <input type="text" name="v_phone" id="edit_v_phone" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Store Name</label>
                <input type="text" name="v_store" id="edit_v_store" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="update_vendor" class="btn btn-primary">Update Vendor</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('.editBtn').on('click', function() {
        // Data attributes se values nikal kar modal ke fields mein bharna
        $('#edit_v_id').val($(this).data('id'));
        $('#edit_v_name').val($(this).data('name'));
        $('#edit_v_email').val($(this).data('email'));
        $('#edit_v_phone').val($(this).data('phone'));
        $('#edit_v_store').val($(this).data('store'));
    });
});
</script>

</body>
</html>