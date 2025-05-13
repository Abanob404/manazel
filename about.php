<?php
// templates/pages/about.php

$page_title = 
'about_us'
; // For header.php to pick up

?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
            <h1><?php echo lang(
'about_us'
); ?></h1>
            <p class="lead">
                <?php echo lang(
'about_us_intro_placeholder_p1_en_ar'
); // Placeholder, add to lang files
                // Example: "Manazel Real Estate is a premier real estate company dedicated to helping you find your perfect property. With years of experience and a commitment to excellence, we strive to provide the best service to our clients."
                // Example AR: "منازل العقارية هي شركة عقارية رائدة مكرسة لمساعدتك في العثور على عقارك المثالي. مع سنوات من الخبرة والالتزام بالتميز، نسعى جاهدين لتقديم أفضل خدمة لعملائنا."
                ?>
            </p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3><?php echo lang(
'our_mission_en_ar'
); // Placeholder, add to lang files ?></h3>
            <p>
                <?php echo lang(
'our_mission_text_placeholder_en_ar'
); // Placeholder, add to lang files
                // Example: "Our mission is to simplify the property buying and selling process, making it transparent and stress-free for everyone involved. We leverage technology and market expertise to achieve the best outcomes."
                // Example AR: "مهمتنا هي تبسيط عملية شراء وبيع العقارات، وجعلها شفافة وخالية من الإجهاد لجميع المعنيين. نحن نستفيد من التكنولوجيا وخبرة السوق لتحقيق أفضل النتائج."
                ?>
            </p>
        </div>
        <div class="col-md-6">
            <h3><?php echo lang(
'our_vision_en_ar'
); // Placeholder, add to lang files ?></h3>
            <p>
                <?php echo lang(
'our_vision_text_placeholder_en_ar'
); // Placeholder, add to lang files
                // Example: "Our vision is to be the most trusted and respected real estate agency in the region, known for our integrity, professionalism, and client satisfaction."
                // Example AR: "رؤيتنا هي أن نكون وكالة العقارات الأكثر ثقة واحترامًا في المنطقة، معروفين بنزاهتنا واحترافنا ورضا عملائنا."
                ?>
            </p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center">
            <h3><?php echo lang(
'meet_our_team_en_ar'
); // Placeholder, add to lang files ?></h3>
            <p><em>(Team member profiles to be added here - this could be a dynamic section later)</em></p>
            <!-- Example structure for a team member -->
            <!-- 
            <div class="col-md-4 text-center mb-4">
                <img src="<?php echo base_url(
'assets/images/team_member_placeholder.jpg'
); ?>" class="img-fluid rounded-circle mb-2" alt="Team Member" style="width: 150px; height: 150px; object-fit: cover;">
                <h4>John Doe</h4>
                <p>CEO & Founder</p>
            </div> 
            -->
        </div>
    </div>

</div>

<?php
// Add new language keys to lang/en.php and lang/ar.php
/*
// lang/en.php additions:
    // About Us Page
    'about_us_intro_placeholder_p1_en_ar' => 'Manazel Real Estate is a premier real estate company dedicated to helping you find your perfect property. With years of experience and a commitment to excellence, we strive to provide the best service to our clients.',
    'our_mission_en_ar' => 'Our Mission',
    'our_mission_text_placeholder_en_ar' => 'Our mission is to simplify the property buying and selling process, making it transparent and stress-free for everyone involved. We leverage technology and market expertise to achieve the best outcomes.',
    'our_vision_en_ar' => 'Our Vision',
    'our_vision_text_placeholder_en_ar' => 'Our vision is to be the most trusted and respected real estate agency in the region, known for our integrity, professionalism, and client satisfaction.',
    'meet_our_team_en_ar' => 'Meet Our Team',

// lang/ar.php additions:
    // About Us Page
    'about_us_intro_placeholder_p1_en_ar' => 'منازل العقارية هي شركة عقارية رائدة مكرسة لمساعدتك في العثور على عقارك المثالي. مع سنوات من الخبرة والالتزام بالتميز، نسعى جاهدين لتقديم أفضل خدمة لعملائنا.',
    'our_mission_en_ar' => 'مهمتنا',
    'our_mission_text_placeholder_en_ar' => 'مهمتنا هي تبسيط عملية شراء وبيع العقارات، وجعلها شفافة وخالية من الإجهاد لجميع المعنيين. نحن نستفيد من التكنولوجيا وخبرة السوق لتحقيق أفضل النتائج.',
    'our_vision_en_ar' => 'رؤيتنا',
    'our_vision_text_placeholder_en_ar' => 'رؤيتنا هي أن نكون وكالة العقارات الأكثر ثقة واحترامًا في المنطقة، معروفين بنزاهتنا واحترافنا ورضا عملائنا.',
    'meet_our_team_en_ar' => 'تعرف على فريقنا',
*/
?>
