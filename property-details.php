<?php
// templates/pages/property-details.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . 
    '/../../includes/db.php
';
require_once __DIR__ . 
    '/../../includes/language.php
';
require_once __DIR__ . 
    '/../../src/auth.php
';
require_once __DIR__ . 
    '/../../src/property_interactions.php
';

$page_title = lang('property_details');

$property_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$current_user_id = get_current_user_id();

// --- Handle Rating Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'rate_property' && $property_id && is_logged_in()) {
    $rating_value = isset($_POST['rating_value']) ? (int)$_POST['rating_value'] : 0;
    $comment_en = isset($_POST['comment_en']) ? trim($_POST['comment_en']) : null;
    $comment_ar = isset($_POST['comment_ar']) ? trim($_POST['comment_ar']) : null; // Assuming you might add a field for AR comment later or handle it differently

    // For simplicity, if current lang is AR, use comment_ar, else comment_en
    $user_comment = (get_current_lang() === 'ar' && !empty($comment_ar)) ? $comment_ar : $comment_en;
    
    // Decide which comment field to save based on current language, or save both if available
    // This example saves both if provided, or one based on current language if only one comment box is used in the form
    // For a single comment box in the form, you might decide which DB field to populate based on current language

    $result = add_or_update_rating($current_user_id, $property_id, $rating_value, $comment_en, $comment_ar);
    $_SESSION['message'] = $result['message'];
    $_SESSION['message_type'] = $result['success'] ? 'success' : 'danger';
    header("Location: " . base_url("?page=property-details&id=" . $property_id));
    exit;
}

// --- Handle Follow/Unfollow Action ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $property_id && is_logged_in()) {
    if ($_POST['action'] == 'follow_property') {
        $result = follow_property($current_user_id, $property_id);
    } elseif ($_POST['action'] == 'unfollow_property') {
        $result = unfollow_property($current_user_id, $property_id);
    }
    if (isset($result)){
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = $result['success'] ? 'success' : 'danger';
        header("Location: " . base_url("?page=property-details&id=" . $property_id));
        exit;
    }
}


// Fetch actual property data from DB (Placeholder - to be replaced with actual DB query)
// For now, using the sample array, but we need to make this dynamic
$conn = get_db_connection();
$property = null;
if ($property_id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM properties WHERE id = :id AND is_active = 1");
        $stmt->bindParam(':id', $property_id, PDO::PARAM_INT);
        $stmt->execute();
        $property_db = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($property_db) {
            $property = $property_db;
            // Fetch gallery images (assuming a separate table or JSON field)
            // For simplicity, let's assume gallery_images_json stores a JSON array of paths
            $property['gallery_images'] = !empty($property['gallery_images_json']) ? json_decode($property['gallery_images_json'], true) : [];
            // Agent details might be in a related table or denormalized
            // For now, using placeholders if not in properties table
            $property['agent_name_en'] = $property['agent_name_en'] ?? 'N/A';
            $property['agent_name_ar'] = $property['agent_name_ar'] ?? 'غير متوفر';
            $property['agent_phone'] = $property['agent_phone'] ?? 'N/A';
            $property['agent_email'] = $property['agent_email'] ?? 'N/A';

        } else {
            // Property not found or not active
        }
    } catch (PDOException $e) {
        error_log("Error fetching property details: " . $e->getMessage());
        // Handle error appropriately
    }
}

if (!$property) {
    // Handle property not found - redirect to 404 or listings page
    $page_title = lang('error_404_message');
    include_once __DIR__ . '/../layouts/header.php';
    echo "<div class='container text-center py-5'><h2>" . lang('error_404_message') . "</h2><p>Property not found.</p><a href='" . base_url('?page=listings') . "'>" . lang('listings') . "</a></div>";
    include_once __DIR__ . '/../layouts/footer.php';
    exit;
}

$current_lang = get_current_lang();
$title = $current_lang === 'ar' ? ($property['title_ar'] ?? $property['title_en']) : ($property['title_en'] ?? $property['title_ar']);
$location = $current_lang === 'ar' ? ($property['location_ar'] ?? $property['location_en']) : ($property['location_en'] ?? $property['location_ar']);
$type = $current_lang === 'ar' ? ($property['type_ar'] ?? $property['type_en']) : ($property['type_en'] ?? $property['type_ar']);
$status = $current_lang === 'ar' ? ($property['status_ar'] ?? $property['status_en']) : ($property['status_en'] ?? $property['status_ar']);
$description = $current_lang === 'ar' ? ($property['description_ar'] ?? $property['description_en']) : ($property['description_en'] ?? $property['description_ar']);
$agent_name = $current_lang === 'ar' ? ($property['agent_name_ar'] ?? $property['agent_name_en']) : ($property['agent_name_en'] ?? $property['agent_name_ar']);

$user_rating = null;
$is_following = false;
if (is_logged_in() && $current_user_id) {
    $user_rating = get_user_rating_for_property($current_user_id, $property_id);
    $is_following = is_following_property($current_user_id, $property_id);
}
$average_rating = get_average_rating($property_id);

include_once __DIR__ . '/../layouts/header.php';

// Display session messages
if (isset($_SESSION['message'])) {
    echo '<div class="container mt-3"><div class="alert alert-' . ($_SESSION['message_type'] ?? 'info') . ' alert-dismissible fade show" role="alert">';
    echo $_SESSION['message'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div></div>';
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

?>

<div class="container property-details-page py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-3"><?php echo htmlspecialchars($title); ?></h1>
            <p class="text-muted mb-4"><i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars($location); ?></p>

            <!-- Image Gallery Carousel -->
            <?php if (!empty($property['main_image_path']) || !empty($property['gallery_images'])): ?>
            <div id="propertyImageCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php 
                    $total_images = 0;
                    if (!empty($property['main_image_path'])) $total_images++;
                    if (!empty($property['gallery_images'])) $total_images += count($property['gallery_images']);
                    
                    $slide_index = 0;
                    if (!empty($property['main_image_path'])): ?>
                        <button type="button" data-bs-target="#propertyImageCarousel" data-bs-slide-to="<?php echo $slide_index; ?>" class="active" aria-current="true" aria-label="Slide <?php echo $slide_index + 1; ?>"></button>
                    <?php 
                        $slide_index++;
                    endif;
                    if (!empty($property['gallery_images'])):
                        foreach ($property['gallery_images'] as $key => $img):
                    ?>
                        <button type="button" data-bs-target="#propertyImageCarousel" data-bs-slide-to="<?php echo $slide_index; ?>" <?php if ($slide_index == 0 && empty($property['main_image_path'])) echo 'class="active" aria-current="true"'; ?> aria-label="Slide <?php echo $slide_index + 1; ?>"></button>
                    <?php 
                        $slide_index++;
                        endforeach;
                    endif; ?>
                </div>
                <div class="carousel-inner rounded">
                    <?php 
                    $is_first_slide = true;
                    if (!empty($property['main_image_path'])): ?>
                    <div class="carousel-item <?php if ($is_first_slide) { echo 'active'; $is_first_slide = false; } ?>">
                        <img src="<?php echo base_url(htmlspecialchars($property['main_image_path'])); ?>" class="d-block w-100 property-main-image" alt="<?php echo htmlspecialchars($title); ?>">
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($property['gallery_images'])): foreach ($property['gallery_images'] as $gallery_image): ?>
                    <div class="carousel-item <?php if ($is_first_slide) { echo 'active'; $is_first_slide = false; } ?>">
                        <img src="<?php echo base_url(htmlspecialchars($gallery_image)); ?>" class="d-block w-100 property-gallery-image" alt="<?php echo htmlspecialchars($title); ?> Gallery Image">
                    </div>
                    <?php endforeach; endif; ?>
                </div>
                <?php if ($total_images > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#propertyImageCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"><?php echo lang('previous_en_ar'); ?></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#propertyImageCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"><?php echo lang('next_en_ar'); ?></span>
                </button>
                <?php endif; ?>
            </div>
            <?php elseif (!empty($property['main_image_path'])): ?>
                <img src="<?php echo base_url(htmlspecialchars($property['main_image_path'])); ?>" class="img-fluid rounded mb-4 property-main-image" alt="<?php echo htmlspecialchars($title); ?>">
            <?php else: ?>
                <img src="<?php echo base_url('assets/images/placeholder_property_default.jpg'); ?>" class="img-fluid rounded mb-4 property-main-image" alt="<?php echo htmlspecialchars($title); ?>">
            <?php endif; ?>

            <!-- Property Features -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?php echo lang('property_features_en_ar'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2"><i class="fas fa-dollar-sign fa-fw me-2"></i><strong><?php echo lang('price'); ?>:</strong> <?php echo htmlspecialchars(number_format($property['price'], 2)); ?> <?php echo htmlspecialchars($property['currency'] ?? 'USD'); ?></div>
                        <div class="col-md-4 mb-2"><i class="fas fa-bed fa-fw me-2"></i><strong><?php echo lang('bedrooms'); ?>:</strong> <?php echo htmlspecialchars($property['bedrooms']); ?></div>
                        <div class="col-md-4 mb-2"><i class="fas fa-bath fa-fw me-2"></i><strong><?php echo lang('bathrooms'); ?>:</strong> <?php echo htmlspecialchars($property['bathrooms']); ?></div>
                        <div class="col-md-4 mb-2"><i class="fas fa-ruler-combined fa-fw me-2"></i><strong><?php echo lang('area_sqm'); ?>:</strong> <?php echo htmlspecialchars($property['area_sqm']); ?></div>
                        <div class="col-md-4 mb-2"><i class="fas fa-home fa-fw me-2"></i><strong><?php echo lang('type'); ?>:</strong> <?php echo htmlspecialchars($type); ?></div>
                        <div class="col-md-4 mb-2"><i class="fas fa-info-circle fa-fw me-2"></i><strong><?php echo lang('status'); ?>:</strong> <?php echo htmlspecialchars($status); ?></div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?php echo lang('description'); ?></h4>
                </div>
                <div class="card-body">
                    <p><?php echo nl2br(htmlspecialchars($description)); ?></p>
                </div>
            </div>

            <!-- User Interactions: Rating & Following -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?php echo lang('user_interactions_en_ar'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3 border-end">
                            <h5><?php echo lang('rate_property'); ?></h5>
                            <?php if ($average_rating !== null): ?>
                                <p><?php echo lang('average_rating_en_ar'); // Add to lang files ?>: <?php echo number_format($average_rating, 1); ?> <i class="fas fa-star text-warning"></i></p>
                            <?php endif; ?>
                            <?php if (is_logged_in()): ?>
                                <form method="POST" action="<?php echo base_url('?page=property-details&id=' . $property_id); ?>">
                                    <input type="hidden" name="action" value="rate_property">
                                    <div class="mb-2">
                                        <label for="rating_value" class="form-label"><?php echo lang('your_rating_en_ar'); ?> (1-5 <?php echo lang('stars_en_ar'); ?>):</label>
                                        <select name="rating_value" id="rating_value" class="form-select form-select-sm" required>
                                            <option value="" <?php if (!$user_rating) echo 'selected'; ?>>-- <?php echo lang('select_rating_en_ar'); // Add to lang files ?> --</option>
                                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                            <option value="<?php echo $i; ?>" <?php if ($user_rating && $user_rating['rating_value'] == $i) echo 'selected'; ?>><?php echo $i; ?> <?php echo lang('stars_en_ar'); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="comment_<?php echo $current_lang; ?>" class="form-label"><?php echo lang('comment_en_ar'); ?></label>
                                        <textarea name="comment_<?php echo $current_lang; ?>" id="comment_<?php echo $current_lang; ?>" class="form-control form-control-sm" rows="2"><?php if ($user_rating) echo htmlspecialchars($current_lang === 'ar' ? ($user_rating['comment_ar'] ?? '') : ($user_rating['comment_en'] ?? '')); ?></textarea>
                                        <?php if ($current_lang === 'en'): ?>
                                            <input type="hidden" name="comment_ar" value="<?php if ($user_rating && isset($user_rating['comment_ar'])) echo htmlspecialchars($user_rating['comment_ar']); ?>">
                                        <?php else: ?>
                                            <input type="hidden" name="comment_en" value="<?php if ($user_rating && isset($user_rating['comment_en'])) echo htmlspecialchars($user_rating['comment_en']); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm"><?php echo lang('submit_rating_en_ar'); ?></button>
                                </form>
                    
(Content truncated due to size limit. Use line ranges to read in chunks)