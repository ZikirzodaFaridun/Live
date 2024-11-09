<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Registration System (No MySQL)</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f9; }
        .container { width: 300px; padding: 20px; background: #fff; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border-radius: 8px; }
        input { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .message { color: red; font-size: 0.9em; }
    </style>
</head>
<body>

<div class="container">
    <h2>Register</h2>
    
    <?php
    $file = 'users.txt';
    $message = '';

    // Registration logic
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (empty($username) || empty($password)) {
            $message = "Username and password are required!";
        } else {
            // Check if user already exists
            $users = file($file, FILE_IGNORE_NEW_LINES);
            $userExists = false;

            foreach ($users as $user) {
                list($existingUsername) = explode(',', $user);
                if ($existingUsername == $username) {
                    $userExists = true;
                    break;
                }
            }

            if ($userExists) {
                $message = "Username is already taken!";
            } else {
                // Save new user
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                file_put_contents($file, "$username,$hashedPassword\n", FILE_APPEND);
                $message = "Registration successful!";
            }
        }
    }
    ?>

    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        
        <button type="submit">Register</button>
    </form>

    <?php if (!empty($message)) { ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php } ?>
</div>

</body>
</html>
