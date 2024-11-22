<?php
session_start(); // Start the session for error handling

// If there's an error (e.g., invalid login), show the error message
if (isset($_GET['error'])) {
    $errorMessage = htmlspecialchars($_GET['error']);
} else {
    $errorMessage = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stationary Request System - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('kpj.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.2) 100%);
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 3;
        }

        .logo img {
            width: 200px;
            height: auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 2rem;
            z-index: 2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin: 0;
            letter-spacing: 1px;
        }

        .header .underline {
            width: 60px;
            height: 3px;
            background: #6086b0;
            margin: 10px auto;
            border-radius: 3px;
            position: relative;
            overflow: hidden;
        }

        .header .underline::after {
            content: '';
            position: absolute;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shine 2s infinite;
        }

        @keyframes shine {
            to {
                left: 100%;
            }
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 320px;
            z-index: 2;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .input-group {
            position: relative;
            margin: 0.8rem 0;
        }

        .input-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6086b0;
        }

        input {
            width: 100%;
            padding: 0.8rem 0.8rem 0.8rem 2.5rem;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
        }

        input:focus {
            outline: none;
            border-color: #6086b0;
            box-shadow: 0 0 0 3px rgba(96, 134, 176, 0.1);
        }

        button {
            margin-top: 1.5rem;
            padding: 1rem;
            background: linear-gradient(135deg, #6086b0 0%, #4a6d93 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            background: linear-gradient(135deg, #4a6d93 0%, #385270 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 109, 147, 0.2);
        }

        button:active {
            transform: translateY(0);
        }

        h2 {
            font-weight: 600;
            font-size: 1.5rem;
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .error {
            color: #dc3545;
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: rgba(220, 53, 69, 0.1);
            border-radius: 6px;
        }

        @keyframes popup {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="logo">
        <img src="/stationery/images/kpjlogo.jpg" alt="Company Logo">
    </div>
    <div class="header">
        <h1>STATIONARY REQUEST SYSTEM</h1>
        <div class="underline"></div>
    </div>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($errorMessage): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form action="login_process.php" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>