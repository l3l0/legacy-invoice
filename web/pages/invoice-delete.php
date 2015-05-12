<?php

if (!isset($_GET['invoice_id'])) {
    die('Page not found');
}

$connection->beginTransaction();

$stmt = $connection->prepare('DELETE FROM invoice_items WHERE invoice_id = :id');
$success = $stmt->execute(['id' => $_GET['invoice_id']]);

$stmt = $connection->prepare('DELETE FROM invoices WHERE user_id = :user_id AND id = :id');
$stmt->execute(['user_id' => $_SESSION['loggedInUser']['id'], 'id' => $_GET['invoice_id']]);

$success = $connection->commit();

if ($success) {
    header('Location: /index.php?page=invoices&successMessage="Invoice deleted"');
    exit;
}


header('Location: /index.php?page=invoices&errorMessage="Invoice cannot be deleted"');
exit;
