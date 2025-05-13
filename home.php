<?php
// templates/pages/home.php

$page_title = 
'home'
; // For header.php to pick up

// Example: Fetch some featured properties (this will be dynamic later)
$featured_properties = [
    [
'id'
=> 1, 
'title_en'
=> 
'Luxury Villa with Sea View'
, 
'title_ar'
=> 
'فيلا فاخرة بإطلالة على البحر'
, 
'image'
=> 
'assets/images/placeholder_property1.jpg'
, 
'price'
=> 
'1,200,000'
, 
'currency'
=> 
'USD'
],
    [
'id'
=> 2, 
'title_en'
=> 
'Modern Downtown Apartment'
, 
'title_ar'
=> 
'شقة عصرية في وسط المدينة'
, 
'image'
=> 
'assets/images/placeholder_property2.jpg'
, 
'price'
=> 
'750,000'
, 
'currency'
=> 
'USD'
],
    [
'id'
=> 3, 
'title_en'
=> 
'Cozy Suburban House'
, 
'title_ar'
=> 
'منزل مريح في الضواحي'
, 
'image'
=> 
'assets/images/placeholder_property3.jpg'
, 
'price'
=> 
'450,000'
, 
'currency'
=> 
'USD'
],
];

?>

<div class="hero-section text-center py-5 bg-light">
    <h1><?php echo lang(
'welcome_message'
); ?></h1>
    <p class="lead"><?php echo lang(
'site_name'
); ?> - <?php echo ($current_lang == 
'ar'
) ? SITE_NAME_AR : SITE_NAME_EN; ?></p>
    <form class="row g-3 justify-content-center pt-3">
        <div class="col-auto">
            <input type="text" class="form-control" placeholder="<?php echo lang(
'search'
); ?>...">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><?php echo lang(
'search'
); ?></button>
        </div>
    </form>
</div>

<section class="featured-properties py-5">
    <div class="container">
        <h2 class="text-center mb-4"><?php echo lang(
'featured_properties'
); ?></h2>
        <div class="row">
            <?php foreach ($featured_properties as $property): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo base_url($property[
'image'
]); ?>" class="card-img-top" alt="<?php echo ($current_lang == 
'ar'
) ? $property[
'title_ar'
] : $property[
'title_en'
]; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo ($current_lang == 
'ar'
) ? $property[
'title_ar'
] : $property[
'title_en'
]; ?></h5>
                        <p class="card-text"><?php echo lang(
'price'
); ?>: <?php echo $property[
'price'
]; ?> <?php echo $property[
'currency'
]; ?></p>
                        <a href="<?php echo base_url(
'?page=property_details&id='
 . $property[
'id'
]); ?>" class="btn btn-primary"><?php echo lang(
'view_details'
); ?></a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="our-services py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4"><?php echo lang(
'our_services_title'
); ?></h2>
        <div class="row text-center">
            <div class="col-md-4">
                <h4><?php echo lang(
'listings'
); ?></h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="col-md-4">
                <h4><?php echo lang(
'consultation'
); // Add 'consultation' to lang files ?></h4>
                <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="col-md-4">
                <h4><?php echo lang(
'management'
); // Add 'management' to lang files ?></h4>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
            </div>
        </div>
    </div>
</section>

<section class="testimonials py-5">
    <div class="container">
        <h2 class="text-center mb-4"><?php echo lang(
'testimonials_title'
); ?></h2>
        <!-- Testimonial items will go here -->
        <p class="text-center"><em>(Testimonials section to be implemented)</em></p>
    </div>
</section>

