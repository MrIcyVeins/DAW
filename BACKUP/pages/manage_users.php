<?php
session_start();
require_once "../database/db_connect.php";

// Check if the user is logged in and is an admin
if (!isset($_SESSION['email']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../pages/login.php");
    exit();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_selected'])) {
        // Bulk delete users, excluding the current admin and other admins
        if (!empty($_POST['selected_users'])) {
            $userIds = array_map('intval', $_POST['selected_users']);
            $filteredIds = array_filter($userIds, function ($id) use ($conn) {
                $query = "SELECT is_admin FROM users WHERE id = $id";
                $result = $conn->query($query);
                $user = $result->fetch_assoc();
                return $id != $_SESSION['user_id'] && (!$user['is_admin'] || $user['is_admin'] == 0);
            });

            if (!empty($filteredIds)) {
                $idList = implode(",", $filteredIds);
                $query = "DELETE FROM users WHERE id IN ($idList)";
                if (!$conn->query($query)) {
                    die("Delete Failed: " . $conn->error);
                }
                header("Location: manage_users.php");
                exit();
            }
        }
    } elseif (isset($_POST['delete_single'])) {
        // Delete a single user, excluding other admins
        $userId = intval($_POST['user_id']);
        $query = "SELECT is_admin FROM users WHERE id = $userId";
        $result = $conn->query($query);
        $user = $result->fetch_assoc();

        if ($userId != $_SESSION['user_id'] && (!$user['is_admin'] || $user['is_admin'] == 0)) {
            $query = "DELETE FROM users WHERE id = $userId";
            if (!$conn->query($query)) {
                die("Delete Failed: " . $conn->error);
            }
            header("Location: manage_users.php");
            exit();
        }
    } elseif (isset($_POST['edit_password'])) {
        // Edit a specific user's password, excluding other admins
        $userId = intval($_POST['user_id']);
        $query = "SELECT is_admin FROM users WHERE id = $userId";
        $result = $conn->query($query);
        $user = $result->fetch_assoc();

        if (!$user['is_admin'] || $user['is_admin'] == 0) {
            $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $query = "UPDATE users SET password_hash = '$newPassword' WHERE id = $userId";
            if (!$conn->query($query)) {
                die("Password Update Failed: " . $conn->error);
            }
            header("Location: manage_users.php");
            exit();
        }
    }
}

// Fetch all users
$users = [];
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = $conn->real_escape_string(trim($_GET['search']));
    $query = "SELECT * FROM users WHERE email LIKE '%$search%' OR id LIKE '%$search%'";
} else {
    $query = "SELECT * FROM users";
}

$result = $conn->query($query);

if (!$result) {
    die("Database Query Failed: " . $conn->error);
}

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Users</h2>

    <!-- Search Box -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by email or user ID..."
                   value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- User List -->
    <form method="POST" id="userForm">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><input type="checkbox" id="select_all"></th>
                <th>ID</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?php if ($user['id'] != $_SESSION['user_id'] && (!$user['is_admin'] || $user['is_admin'] == 0)): ?>
                            <input type="checkbox" name="selected_users[]"
                                   value="<?php echo $user['id']; ?>" class="user-checkbox">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                    <td>
                        <!-- Edit Password -->
                        <?php if (!$user['is_admin'] || $user['is_admin'] == 0): ?>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editPasswordModal<?php echo $user['id']; ?>">Edit Password
                            </button>
                        <?php endif; ?>

                        <!-- Delete User -->
                        <?php if ($user['id'] != $_SESSION['user_id'] && (!$user['is_admin'] || $user['is_admin'] == 0)): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="delete_single" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>

                <!-- Edit Password Modal -->
                <?php if (!$user['is_admin'] || $user['is_admin'] == 0): ?>
                    <div class="modal fade" id="editPasswordModal<?php echo $user['id']; ?>" tabindex="-1"
                         aria-labelledby="editPasswordModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"
                                        id="editPasswordModalLabel<?php echo $user['id']; ?>">Edit Password for User ID <?php echo $user['id']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" name="new_password" class="form-control" required>
                                        </div>
                                        <button type="submit" name="edit_password" class="btn btn-success">Save Changes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Bulk Delete Button -->
        <button type="submit" name="delete_selected" class="btn btn-danger d-none" id="bulkDeleteButton">Delete Selected</button>
    </form>
</div>

<script>
    // Handle "Select All" checkbox
    document.getElementById('select_all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        toggleBulkDeleteButton();
    });

    // Toggle bulk delete button visibility
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkDeleteButton);
    });

    function toggleBulkDeleteButton() {
        const selected = Array.from(checkboxes).some(checkbox => checkbox.checked);
        document.getElementById('bulkDeleteButton').classList.toggle('d-none', !selected);
    }
</script>

<?php include "../includes/footer.php"; ?>
