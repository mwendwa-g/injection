<?php
    include("databaseconnection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username)) {
            echo "Username is empty";
        } elseif (empty($email)) {
            echo "Email is empty";
        } elseif (empty($password)) {
            echo "Password is empty";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Use prepared statements!
            $stmt = $conn->prepare("INSERT INTO tableone (email, username, password) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sss", $email, $username, $hash);
                
                try {
                    $stmt->execute();
                    echo '<script>
                alert("Account created successfully!");
                </script>';
                exit;
                } catch (mysqli_sql_exception $e) {
                    echo '<script>alert("That username or email is already taken."); window.history.back();</script>';
                }

                $stmt->close();
            } else {
                echo "Error preparing statement: " . mysqli_error($conn);
            }
        }
    }

    mysqli_close($conn);
?>
