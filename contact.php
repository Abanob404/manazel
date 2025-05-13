<?php
// templates/pages/contact.php

$page_title = 
'contact_us'
; // For header.php to pick up

// Placeholder for form submission handling (will be added in a later phase)
$form_message = 
''
;
$form_error = false;

if ($_SERVER[
'REQUEST_METHOD'
] === 
'POST'
) {
    // Basic validation (more robust validation to be added later)
    $name = trim($_POST[
'name'
] ?? 
''
);
    $email = trim($_POST[
'email'
] ?? 
''
);
    $subject = trim($_POST[
'subject'
] ?? 
''
);
    $message_body = trim($_POST[
'message'
] ?? 
''
);

    if (empty($name) || empty($email) || empty($subject) || empty($message_body)) {
        $form_message = lang(
'fill_required_fields'
);
        $form_error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_message = lang(
'invalid_email_format'
); // Add 'invalid_email_format' to lang files
        $form_error = true;
    } else {
        // Placeholder: Simulate sending email
        // In a real application, you would use mail() function or a library like PHPMailer
        // mail("admin@example.com", "Contact Form: " . $subject, $message_body, "From: " . $email);
        $form_message = lang(
'message_sent_successfully'
); // Add 'message_sent_successfully' to lang files
        $form_error = false;
        // Clear form fields after successful submission (optional)
        $_POST = []; 
    }
}

?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
            <h1><?php echo lang(
'contact_form_title'
); ?></h1>
            <p class="lead"><?php echo lang(
'contact_intro_placeholder_en_ar'
); // Placeholder, add to lang files ?></p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-7">
            <h3 class="mb-3"><?php echo lang(
'send_us_a_message_en_ar'
); // Placeholder, add to lang files ?></h3>
            <?php if ($form_message): ?>
                <div class="alert <?php echo $form_error ? 
'alert-danger'
 : 
'alert-success'
; ?>">
                    <?php echo $form_message; ?>
                </div>
            <?php endif; ?>
            <form action="<?php echo base_url(
'?page=contact'
); ?>" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label"><?php echo lang(
'your_name'
); ?></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_POST[
'name'
] ?? 
''
); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><?php echo lang(
'your_email'
); ?></label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_POST[
'email'
] ?? 
''
); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label"><?php echo lang(
'subject'
); ?></label>
                    <input type="text" class="form-control" id="subject" name="subject" value="<?php echo htmlspecialchars($_POST[
'subject'
] ?? 
''
); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label"><?php echo lang(
'message'
); ?></label>
                    <textarea class="form-control" id="message" name="message" rows="5" required><?php echo htmlspecialchars($_POST[
'message'
] ?? 
''
); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo lang(
'send_message'
); ?></button>
            </form>
        </div>
        <div class="col-md-5">
            <h3 class="mb-3"><?php echo lang(
'contact_info'
); ?></h3>
            <p>
                <strong><?php echo lang(
'address'
); ?>:</strong><br>
                <?php echo lang(
'contact_address_placeholder_en_ar'
); // Placeholder, add to lang files ?>
            </p>
            <p>
                <strong><?php echo lang(
'phone_number'
); ?>:</strong><br>
                <?php echo lang(
'contact_phone_placeholder_en_ar'
); // Placeholder, add to lang files ?>
            </p>
            <p>
                <strong><?php echo lang(
'email_address'
); ?>:</strong><br>
                <?php echo lang(
'contact_email_placeholder_en_ar'
); // Placeholder, add to lang files ?>
            </p>
            <p>
                <strong><?php echo lang(
'working_hours_en_ar'
); // Placeholder, add to lang files ?>:</strong><br>
                <?php echo lang(
'contact_hours_placeholder_en_ar'
); // Placeholder, add to lang files ?>
            </p>
            <!-- You can add a Google Maps embed here if needed -->
        </div>
    </div>
</div>

<?php
// Add new language keys to lang/en.php and lang/ar.php
/*
// lang/en.php additions:
    // Contact Page
    'contact_intro_placeholder_en_ar' => 'We would love to hear from you! Whether you have a question about our services, properties, or anything else, our team is ready to answer all your inquiries.',
    'send_us_a_message_en_ar' => 'Send Us a Message',
    'contact_address_placeholder_en_ar' => '123 Real Estate St, Property City, PC 45678',
    'contact_phone_placeholder_en_ar' => '+1 234 567 8900',
    'contact_email_placeholder_en_ar' => 'info@manazel.me',
    'working_hours_en_ar' => 'Working Hours',
    'contact_hours_placeholder_en_ar' => 'Mon - Fri: 9:00 AM - 6:00 PM<br>Sat: 10:00 AM - 4:00 PM<br>Sun: Closed',
    'message_sent_successfully' => 'Your message has been sent successfully! We will get back to you shortly.',
    'invalid_email_format' => 'Invalid email format. Please enter a valid email address.',

// lang/ar.php additions:
    // Contact Page
    'contact_intro_placeholder_en_ar' => 'نود أن نسمع منك! سواء كان لديك سؤال حول خدماتنا أو عقاراتنا أو أي شيء آخر، فريقنا مستعد للإجابة على جميع استفساراتك.',
    'send_us_a_message_en_ar' => 'أرسل لنا رسالة',
    'contact_address_placeholder_en_ar' => '123 شارع العقارات، مدينة العقار، الرمز البريدي 45678',
    'contact_phone_placeholder_en_ar' => '+1 234 567 8900',
    'contact_email_placeholder_en_ar' => 'info@manazel.me',
    'working_hours_en_ar' => 'ساعات العمل',
    'contact_hours_placeholder_en_ar' => 'الاثنين - الجمعة: 9:00 صباحًا - 6:00 مساءً<br>السبت: 10:00 صباحًا - 4:00 مساءً<br>الأحد: مغلق',
    'message_sent_successfully' => 'تم إرسال رسالتك بنجاح! سوف نرد عليك قريبا.',
    'invalid_email_format' => 'صيغة البريد الإلكتروني غير صالحة. يرجى إدخال عنوان بريد إلكتروني صالح.',
*/
?>
