<?php

// for security and data pre-process purpose
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getIPAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$ip_address = getIPAddress();

$nameErr = $phoneErr = $emailErr = $subjectErr = $messageErr = "";
$name = $phone = $email = $subject = $message = "";



// Checking for request method
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = test_input($_POST["name"]);
    $phone = test_input($_POST["phone"]);
    $email = test_input($_POST["email"]);
    $subject = test_input($_POST["subject"]);
    $message = test_input($_POST["message"]);

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = $_POST["name"];
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone is required";
    } else {
        $phone = $_POST["phone"];

        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $phoneErr = "Enter a valid Phone no";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["subject"])) {
        $subjectErr = "Subject is required";
    } else {
        $subject = $_POST["subject"];
    }

    if (empty($_POST["message"])) {
        $messageErr = "Message is reqired";
    } else {
        $message = $_POST["message"];
    }

    if ($nameErr == "" && $emailErr == "" && $phoneErr == "" && $messageErr == "" && $subjectErr == "") {

        include_once './config/Database.php';
        include_once './models/Contact.php';
        include_once './mail.php';

        // Instantiate DB & connect
        $database = new Database();
        $db = $database->connect();

        $contact = new Contact($db);

        $ip = $ip_address;

        $contact->email = $email;
        $contact->name = $name;
        $contact->phone = $phone;
        $contact->subject = $subject;
        $contact->message = $message;
        $contact->ip_address = $ip;

        $result = $contact->check_duplicacy();
        $row = $result->rowCount();

        if ($row > 0) {
            echo "<p class='error message'>ERROR: Message already send...</p>";
        } else {
            if ($contact->create_form()) {
                echo "<p class='success message'>SUCESS: Successfully taken the response...</p>";

                $mail = new Mail();
                $mail->send_mail($name, $email, $subject, $message, $phone);
            } else {
                echo "<p class='error message'>ERROR: Something went wrong</p>";
            }
        }
        $name = $phone = $email = $subject = $message = "";
        $_POST["subject"] = $_POST["name"] = $_POST["phone"] = $_POST["email"] = $_POST["message"] = "";
        $_POST = array();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <table style="margin: auto; margin-top:10px">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <tr>
                <td><label for="name">Full Name:</label></td>
                <td><input type="text" name="name" id="name" value="<?php echo $name ?>"><br>
                    <span class="error"><?php echo $nameErr; ?></span>
                </td>
            </tr>
            <tr>
                <td><label for="phone">Phone no.:</label></td>
                <td><input type="number" name="phone" id="phone" value="<?php echo $phone ?>"><br>
                    <span class="error"><?php echo $phoneErr; ?></span>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" name="email" id="email" value="<?php echo $email ?>"><br>
                    <span class="error"><?php echo $emailErr; ?></span>
                </td>
            </tr>
            <tr>
                <td><label for="subject">Subject:</label></td>
                <td><input type="text" name="subject" id="subject" value="<?php echo $subject ?>"><br>
                    <span class="error"><?php echo $subjectErr; ?></span>
                </td>
            </tr>
            <tr>
                <td><label for="message">Message:</label></td>
                <td><textarea name="message" id="message" rows="10"><?php echo $message ?></textarea><br>
                    <span class="error"><?php echo $messageErr; ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Submit" />
                    <input type="reset" value="Reset" />
                </td>
            </tr>
        </form>
    </table>
</body>

</html>