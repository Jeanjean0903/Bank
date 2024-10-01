<?php
session_start();
require 'db_connection.php';

if (isset($_POST['login'])) {
    $account_number = $_POST['account_number'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE account_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $account_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: account.php");
    } else {
        echo "Numéro de compte ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion à votre compte</title>
</head>
<body>
    <h2>Connexion</h2>
    <form method="post">
        <label for="account_number">Numéro de compte :</label>
        <input type="text" name="account_number" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit" name="login">Se connecter</button>
    </form>
</body>
</html>
