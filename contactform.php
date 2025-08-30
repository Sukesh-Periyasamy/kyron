<?php
// contactform.php - Contact Form Handler

// Force HTTPS for form submissions
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $secure_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $secure_url, true, 301);
    exit();
}

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Check if the form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    // Capture and sanitize form data
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $subject = sanitize_input($_POST["subject"]);
    $message = sanitize_input($_POST["message"]);
    
    // Basic validation
    $errors = array();
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        // Get current timestamp
        $timestamp = date("Y-m-d H:i:s");
        
        // Email configuration
        $to_email = "kyronhealthcare@gmail.com";
        $email_subject = "Contact Form: " . $subject;
        
        // Create email content
        $email_body = "New Contact Form Submission\n\n";
        $email_body .= "Submission Time: " . $timestamp . "\n";
        $email_body .= "Name: " . $name . "\n";
        $email_body .= "Email: " . $email . "\n";
        $email_body .= "Subject: " . $subject . "\n\n";
        $email_body .= "Message:\n" . $message . "\n\n";
        $email_body .= "Please respond to the customer as soon as possible.\n";
        
        // Email headers
        $headers = "From: noreply@kyronhealthcare.com\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Send email
        $email_sent = mail($to_email, $email_subject, $email_body, $headers);
        
        // Also send confirmation email to customer
        $customer_subject = "Thank you for contacting Kyron Healthcare";
        $customer_body = "Dear " . $name . ",\n\n";
        $customer_body .= "Thank you for contacting Kyron Healthcare!\n\n";
        $customer_body .= "We have received your message and will respond within 24 hours.\n\n";
        $customer_body .= "Your Message Details:\n";
        $customer_body .= "Subject: " . $subject . "\n";
        $customer_body .= "Message: " . $message . "\n\n";
        $customer_body .= "Best regards,\n";
        $customer_body .= "Kyron Healthcare Team\n";
        $customer_body .= "Phone: +91-11-41629088\n";
        $customer_body .= "Mobile: +91-9315942627\n";
        $customer_body .= "Email: kyronhealthcare@gmail.com";
        
        $customer_headers = "From: kyronhealthcare@gmail.com\r\n";
        $customer_headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $customer_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        $customer_email_sent = mail($email, $customer_subject, $customer_body, $customer_headers);
        
        // Display success message
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Message Sent - Kyron Healthcare</title>
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
            <link href="css/style.css" rel="stylesheet">
            <style>
                .centered-success {
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            </style>
        </head>
        <body>
            <div class="centered-success">
                <div class="card shadow-lg p-4 text-center" style="max-width: 400px; width: 100%;">
                    <div class="mb-3">
                        <span class="fa fa-check-circle text-success" style="font-size: 2.5rem;"></span>
                    </div>
                    <h4 class="mb-3">Message Sent Successfully!</h4>
                    <p class="mb-4">Thank you for contacting us. We'll get back to you soon.</p>
                    <a href="contact.html" class="btn btn-outline-secondary btn-sm mb-2">Send Another Message</a>
                    <a href="index.html" class="btn btn-primary btn-block">Return to Home</a>
                </div>
            </div>
        </body>
        </html>
        <?php
        
    } else {
        // Display errors
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Form Error - Kyron Healthcare</title>
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
            <link href="css/style.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card shadow-lg">
                            <div class="card-header bg-danger text-white text-center">
                                <h3 class="mb-0"><i class="fa fa-exclamation-triangle"></i> Form Submission Error</h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-danger">
                                    <h5>Please correct the following errors:</h5>
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li><?php echo $error; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                
                                <div class="text-center">
                                    <a href="javascript:history.back()" class="btn btn-primary">
                                        <i class="fa fa-arrow-left"></i> Go Back and Fix Errors
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
    
} else {
    // If form wasn't submitted via POST, redirect to the contact page
    header("Location: contact.html");
    exit();
}
?>