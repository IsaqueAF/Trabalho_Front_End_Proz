<?php

function registerUser(mysqli $conn, string $name, string $email, string $password): int {
    $stmt = $conn->prepare("INSERT INTO users VALUES (DEFAULT, ?, ?, ?, DEFAULT)");

    $passwordHash = trim(password_hash($password, PASSWORD_DEFAULT));
    $name = trim($name);
    $email = trim($email);
    $stmt->bind_param("sss", $name, $email, $passwordHash);

    if (!$stmt->execute()) {
        return -1;
    }

    return $conn->insert_id;
}

function loginUser (mysqli $conn, string $email, string $password): int {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    if (!$stmt->execute()) {
        return -1;
    }

    $userResult = $stmt->get_result();
    $user = $userResult->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        return $user["id"];
    } else {
        return 0;
    }
}

function getUser (mysqli $conn, int $userid): array {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("s", $userid);

    if (!$stmt->execute()) {
        return -1;
    }

    $userResult = $stmt->get_result();
    $user = $userResult->fetch_assoc();
    return $user;
}

function DeleteUser (mysqli $conn,  int $userID): int {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("s", $userID);

    if (!$stmt->execute()) {
        return -1;
    }

    return 1;
}

?>