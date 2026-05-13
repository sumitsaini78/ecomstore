<?php
session_start();
include("db.php");

// 1. Status Update Logic
if (isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE id = $order_id");
    header("Location: orders.php?msg=updated");
    exit;
}

// 2. Fetch Orders with Customer Names
$orders = mysqli_query($conn, "SELECT orders.*, users.name FROM orders JOIN users ON orders.user_id = users.id ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Manage Orders</title>
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Customer Orders</h5>
            <a href="index.php" class="btn btn-outline-light btn-sm">Dashboard</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-center">Details</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($orders)): ?>
                    <tr>
                        <td class="align-middle">#<?= $row['id']; ?></td>
                        <td class="align-middle"><?= $row['name']; ?></td>
                        <td class="align-middle fw-bold text-success">₹<?= number_format($row['total_amount'], 2); ?></td>
                        <td class="align-middle"><?= date('d-m-Y', strtotime($row['order_date'])); ?></td>
                        <td class="align-middle">
                            <?php 
                                $s = $row['status'] ?? 'Pending';
                                $badge = ($s == 'Completed') ? 'bg-success' : (($s == 'Cancelled') ? 'bg-danger' : 'bg-warning text-dark');
                            ?>
                            <span class="badge <?= $badge; ?>"><?= $s; ?></span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary" onclick="viewItems(<?= $row['id']; ?>)">
                                <i class="fa-solid fa-eye"></i> View Items
                            </button>
                        </td>
                        <td class="text-center">
                            <form action="" method="POST" class="d-inline-flex gap-1">
                                <input type="hidden" name="order_id" value="<?= $row['id']; ?>">
                                <select name="status" class="form-select form-select-sm" style="width: 110px;">
                                    <option value="Pending" <?= ($s=='Pending')?'selected':''; ?>>Pending</option>
                                    <option value="Completed" <?= ($s=='Completed')?'selected':''; ?>>Completed</option>
                                    <option value="Cancelled" <?= ($s=='Cancelled')?'selected':''; ?>>Cancelled</option>
                                </select>
                                <button type="submit" name="update_status" class="btn btn-sm btn-dark">Ok</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="itemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Items in Order #<span id="order_id_title"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="order_items_body">
                </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function viewItems(orderId) {
    $('#order_id_title').text(orderId);
    $('#itemModal').modal('show');
    
    // AJAX call to get items
    $.ajax({
        url: 'fetch_order_items.php',
        method: 'POST',
        data: {order_id: orderId},
        success: function(response) {
            $('#order_items_body').html(response);
        }
    });
}
</script>
</body>
</html>