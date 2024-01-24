<?php require "functions.php" ?>
<?php 
   if(isset($_POST['register'])){
      $response = register($_POST['email'], $_POST['username'], $_POST['password'], $_POST['confirm-password']);
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px; /* Adjust the width as needed */
    }

    h2 {
      text-align: center;
      color: #333;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 5px;
      color: #555;
    }

    input {
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .btn-container {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
    }

    .btn {
      padding: 10px 20px;
      font-size: 16px;
      text-align: center;
      text-decoration: none;
      color: #fff;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-register {
      background-color: #3498db;
    }

    .btn-signup {
      background-color: #2ecc71;
    }

    .btn:hover {
      background-color: #555;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Register or Sign Up</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
      <label for="userEmail">Email:</label>
      <input type="email" id="userEmail" name="userEmail">

      <label for="userPassword">Password:</label>
      <input type="password" id="userPassword" name="userPassword">

      <label for="confirmPassword">Retype Password:</label>
      <input type="password" id="confirmPassword" name="confirmPassword">

      <div class="btn-container">
        <button type="submit" class="btn btn-register">Register</button>
        <button type="button" class="btn btn-signup" onclick="validateForm()">Sign Up</button>
      </div>
    </form>
  </div>
  <script>
    function validateForm() {
      // Get form elements
      var userEmail = document.getElementById('userEmail').value;
      var userPassword = document.getElementById('userPassword').value;
      var confirmPassword = document.getElementById('confirmPassword').value;

      // Simple email validation (you can use a more complex validation)
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(userEmail)) {
        alert('Invalid email format');
        return false;
      }

      // Password length validation (you can add more criteria)
      if (userPassword.length < 6) {
        alert('Password must be at least 6 characters long');
        return false;
      }

      // Password match validation
      if (userPassword !== confirmPassword) {
        alert('Passwords do not match');
        return false;
      }

      // If all validations pass, you can submit the form
      // You can also perform additional actions or use AJAX to send data to the server
      return true;
    }
  </script>

</body>
</html>

<?php
// Database connection details
$servername = "localhost";
$username = ""; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "userdetails";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user data from the form
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    // Simple validation (you may want to improve this)
    if (empty($userEmail) || empty($userPassword)) {
        echo "Email and password are required";
    } else {
        // Hash the password before storing it in the database (for security)
        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

        // Insert data into the database
        $sql = "INSERT INTO userinformation (emailid, password) VALUES ('$userEmail', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "User registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
