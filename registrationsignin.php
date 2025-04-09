<?php
    include("databaseconnection.php");

    if(isset($_POST['submit2'])){
        $enteredusername = $_POST['usernamee'];
        $enteredpassword = $_POST['passwordd'];
        
        $stmt = $conn->prepare("SELECT id, username, password FROM tableone WHERE username = ?");
        $stmt->bind_param("s", $enteredusername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($enteredpassword, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo '<script>
                alert("Logged in successfully!");
                </script>';
                exit;

            } else {
                echo "Invalid password.";
            }
        } else {
            echo "You havent created an account"; 
        }

        $stmt->close();
        $conn->close();
    } else {
        echo 'create account';
    }
    mysqli_close($conn);
?>