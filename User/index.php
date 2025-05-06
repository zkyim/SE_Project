<?php require_once '../_components/header.php'; ?>

<?php if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'User'): ?>
  <?php require_once '../_components/notauthorized.php'; ?>
<?php else: ?>
User
<?php endif; ?>

<?php require_once '../_components/footer.php'; ?>