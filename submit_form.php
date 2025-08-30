<?php
// submit_form.php - Demo Booking Form Handler

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
    $firstName = sanitize_input($_POST["firstName"]);
    $companyName = sanitize_input($_POST["companyName"]);
    $email = sanitize_input($_POST["email"]);
    $phone = sanitize_input($_POST["phone"]);
    $product = sanitize_input($_POST["product"]);
    $message = sanitize_input($_POST["message"]);
    
    // Basic validation
    $errors = array();
    
    if (empty($firstName)) {
        $errors[] = "First Name is required";
    }
    
    if (empty($companyName)) {
        $errors[] = "Company Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone Number is required";
    }
    
    if (empty($product)) {
        $errors[] = "Product of Interest is required";
    }
    
    if (empty($message)) {
        $errors[] = "Additional Requirements is required";
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        // Get current timestamp
        $timestamp = date("Y-m-d H:i:s");
        
        // Email configuration
        $to_email = "kyronhealthcare@gmail.com";
        $fullName = $firstName . " - " . $companyName;
        $subject = "New Demo Request - " . $fullName;
        
        // Create email content
        $email_body = "New Demo Request Received\n\n";
        $email_body .= "Submission Time: " . $timestamp . "\n";
        $email_body .= "Name: " . $firstName . "\n";
        $email_body .= "Company: " . $companyName . "\n";
        $email_body .= "Email: " . $email . "\n";
        $email_body .= "Phone: " . $phone . "\n";
        $email_body .= "Product of Interest: " . $product . "\n";
        $email_body .= "Additional Requirements:\n" . $message . "\n\n";
        $email_body .= "Please contact the customer within 24 hours to schedule the demo.\n";
        
        // Email headers
        $headers = "From: noreply@kyronhealthcare.com\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Send email
        $email_sent = mail($to_email, $subject, $email_body, $headers);
        
        // Also send confirmation email to customer
        $customer_subject = "Demo Request Confirmation - Kyron Healthcare";
        $customer_body = "Dear " . $firstName . ",\n\n";
        $customer_body .= "Thank you for your interest in Kyron Healthcare!\n\n";
        $customer_body .= "We have received your demo request for: " . $product . "\n\n";
        $customer_body .= "Our team will contact you within 24 hours to schedule your demonstration.\n\n";
        $customer_body .= "Request Details:\n";
        $customer_body .= "Name: " . $firstName . "\n";
        $customer_body .= "Company: " . $companyName . "\n";
        $customer_body .= "Email: " . $email . "\n";
        $customer_body .= "Phone: " . $phone . "\n";
        $customer_body .= "Product: " . $product . "\n";
        $customer_body .= "Requirements: " . $message . "\n\n";
        $customer_body .= "Best regards,\n";
        $customer_body .= "Kyron Healthcare Team\n";
        $customer_body .= "Phone: +91-11-41629088\n";
        $customer_body .= "Mobile: +91-9315942627\n";
        $customer_body .= "Email: kyronhealthcare@gmail.com";
        
        $customer_headers = "From: kyronhealthcare@gmail.com\r\n";
        $customer_headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $customer_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        $customer_email_sent = mail($email, $customer_subject, $customer_body, $customer_headers);
        
        // Display success message and form data
        ?>
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Demo Request Submitted - Kyron Healthcare</title>
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
                    <h4 class="mb-3">Demo Request Submitted Successfully!</h4>
                    <p class="mb-4">Thank you for your interest. We’ll get back to you soon.</p>
                    <a href="index.html" class="btn btn-primary btn-block">Return to Home</a>
                </div>
            </div>
        </body>
        </html>
        <?php
        $log_entry = "\n--- Demo Request ---\n";
        $log_entry .= "Timestamp: " . $timestamp . "\n";
        $log_entry .= "Name: " . $firstName . " " . $lastName . "\n";
        $log_entry .= "Email: " . $email . "\n";
        $log_entry .= "Phone: " . $phone . "\n";
        $log_entry .= "Product of Interest: " . $product . "\n";
        $log_entry .= "Additional Requirements: " . $message . "\n";
        $log_entry .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
        $log_entry .= "User Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
        $log_entry .= "-------------------\n";
        
        // Uncomment the line below to enable logging to a file
        // file_put_contents('demo_requests.log', $log_entry, FILE_APPEND | LOCK_EX);
        
        // TODO: Here you can add additional functionality such as:
        // 1. Save to database
        // 2. Send email notification to admin
        // 3. Send confirmation email to user
        // 4. Integrate with CRM system
        
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
    // If form wasn't submitted via POST, redirect to the form page
    header("Location: bookademo.html");
    exit();
}
?>
