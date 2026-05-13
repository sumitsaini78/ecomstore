    <?php
session_start();
include("db.php");

$msg = "";

// 1. Update Settings Logic
if (isset($_POST['update_settings'])) {
    foreach ($_POST['set'] as $key => $value) {
        $key = mysqli_real_escape_string($conn, $key);
        $value = mysqli_real_escape_string($conn, $value);
        
        mysqli_query($conn, "UPDATE settings SET s_value = '$value' WHERE s_key = '$key'");
    }
    $msg = "<div class='alert alert-success'>Settings updated successfully!</div>";
}

// 2. Fetch all settings into an array
$settings_res = mysqli_query($conn, "SELECT * FROM settings");
$set = [];
while($row = mysqli_fetch_assoc($settings_res)) {
    $set[$row['s_key']] = $row['s_value'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Site Settings</title>
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fa-solid fa-gears text-secondary"></i> System Settings</h2>
                <a href="index.php" class="btn btn-secondary btn-sm">Dashboard</a>
            </div>

            <?= $msg; ?>

            <form action="" method="POST">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">General Settings</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Site Name</label>
                            <input type="text" name="set[site_name]" class="form-control" value="<?= $set['site_name'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Admin Email</label>
                            <input type="email" name="set[site_email]" class="form-control" value="<?= $set['site_email'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Theme Primary Color</label>
                            <input type="color" name="set[theme_color]" class="form-control form-control-color" value="<?= $set['theme_color'] ?? '#0dcaf0'; ?>">
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">SEO & Meta Tags</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Meta Title</label>
                            <input type="text" name="set[seo_title]" class="form-control" value="<?= $set['seo_title'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Meta Description</label>
                            <textarea name="set[seo_description]" class="form-control" rows="3"><?= $set['seo_description'] ?? ''; ?></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" name="update_settings" class="btn btn-primary w-100 shadow">Save All Changes</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>