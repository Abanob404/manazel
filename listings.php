<?php
// templates/pages/listings.php

$page_title = 
'listings'
; // For header.php to pick up

// Placeholder for fetching properties from database (will be added in a later phase)
$properties = [
    [
        'id' => 1,
        'title_en' => 'Luxury Villa with Sea View',
        'title_ar' => 'فيلا فاخرة بإطلالة على البحر',
        'image' => 'assets/images/placeholder_property_1.jpg', // Placeholder image
        'price' => '1,200,000 USD',
        'bedrooms' => 4,
        'bathrooms' => 5,
        'area' => '450 sqm',
        'location_en' => 'Coastal City, Region X',
        'location_ar' => 'المدينة الساحلية, منطقة X',
        'type_en' => 'Villa',
        'type_ar' => 'فيلا',
        'status_en' => 'For Sale',
        'status_ar' => 'للبيع',
        'short_desc_en' => 'A stunning luxury villa offering breathtaking sea views, spacious interiors, and top-class amenities. Perfect for families or as an investment.',
        'short_desc_ar' => 'فيلا فاخرة مذهلة توفر إطلالات خلابة على البحر وتصميمات داخلية واسعة ووسائل راحة من الدرجة الأولى. مثالية للعائلات أو كاستثمار.'
    ],
    [
        'id' => 2,
        'title_en' => 'Modern Apartment in Downtown',
        'title_ar' => 'شقة عصرية في وسط المدينة',
        'image' => 'assets/images/placeholder_property_2.jpg', // Placeholder image
        'price' => '650,000 USD',
        'bedrooms' => 2,
        'bathrooms' => 2,
        'area' => '120 sqm',
        'location_en' => 'City Center, Region Y',
        'location_ar' => 'وسط المدينة, منطقة Y',
        'type_en' => 'Apartment',
        'type_ar' => 'شقة',
        'status_en' => 'For Sale',
        'status_ar' => 'للبيع',
        'short_desc_en' => 'Chic and modern apartment located in the heart of the city, close to all amenities, with a sleek design and high-end finishes.',
        'short_desc_ar' => 'شقة أنيقة وعصرية تقع في قلب المدينة، قريبة من جميع وسائل الراحة، بتصميم أنيق وتشطيبات راقية.'
    ],
    [
        'id' => 3,
        'title_en' => 'Cozy Suburban House with Garden',
        'title_ar' => 'منزل مريح في الضواحي مع حديقة',
        'image' => 'assets/images/placeholder_property_3.jpg', // Placeholder image
        'price' => '450,000 USD',
        'bedrooms' => 3,
        'bathrooms' => 2,
        'area' => '200 sqm',
        'location_en' => 'Green Suburbs, Region Z',
        'location_ar' => 'الضواحي الخضراء, منطقة Z',
        'type_en' => 'House',
        'type_ar' => 'منزل',
        'status_en' => 'For Rent',
        'status_ar' => 'للإيجار',
        'short_desc_en' => 'A charming and cozy suburban house featuring a beautiful garden, perfect for a family looking for a peaceful environment.',
        'short_desc_ar' => 'منزل ساحر ومريح في الضواحي يتميز بحديقة جميلة، مثالي لعائلة تبحث عن بيئة هادئة.'
    ],
];

?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1><?php echo lang(
'listings'
); ?></h1>
            <p class="lead"><?php echo lang(
'listings_intro_placeholder_en_ar'
); // Placeholder, add to lang files ?></p>
        </div>
    </div>

    <!-- Placeholder for Search/Filter Bar - to be implemented later -->
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="<?php echo lang(
'search_keyword_placeholder_en_ar'
); // Placeholder ?>">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select">
                                <option selected><?php echo lang(
'all_types_en_ar'
); // Placeholder ?></option>
                                <option value="villa"><?php echo lang(
'villa_en_ar'
); // Placeholder ?></option>
                                <option value="apartment"><?php echo lang(
'apartment_en_ar'
); // Placeholder ?></option>
                                <option value="house"><?php echo lang(
'house_en_ar'
); // Placeholder ?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select">
                                <option selected><?php echo lang(
'any_status_en_ar'
); // Placeholder ?></option>
                                <option value="for_sale"><?php echo lang(
'for_sale_en_ar'
); // Placeholder ?></option>
                                <option value="for_rent"><?php echo lang(
'for_rent_en_ar'
); // Placeholder ?></option>
                            </select>
                        </div>
                        <div class="col-md-3">
                             <input type="text" class="form-control" placeholder="<?php echo lang(
'location_placeholder_en_ar'
); // Placeholder ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><?php echo lang(
'search'
); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($properties as $property): ?>
            <div class="col">
                <div class="card h-100 property-card">
                    <img src="<?php echo base_url($property[
'image'
]); ?>" class="card-img-top" alt="<?php echo htmlspecialchars(get_current_lang() === 
'ar'
 ? $property[
'title_ar'
] : $property[
'title_en'
]); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars(get_current_lang() === 
'ar'
 ? $property[
'title_ar'
] : $property[
'title_en'
]); ?></h5>
                        <p class="card-text text-muted"><small><i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars(get_current_lang() === 
'ar'
 ? $property[
'location_ar'
] : $property[
'location_en'
]); ?></small></p>
                        <p class="card-text price-tag"><?php echo htmlspecialchars($property[
'price'
]); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars(get_current_lang() === 
'ar'
 ? $property[
'short_desc_ar'
] : $property[
'short_desc_en'
]); ?></p>
                        <div class="property-features d-flex justify-content-around text-center my-3">
                            <span><i class="fas fa-bed me-1"></i> <?php echo $property[
'bedrooms'
]; ?> <?php echo lang(
'bedrooms'
); ?></span>
                            <span><i class="fas fa-bath me-1"></i> <?php echo $property[
'bathrooms'
]; ?> <?php echo lang(
'bathrooms'
); ?></span>
                            <span><i class="fas fa-ruler-combined me-1"></i> <?php echo $property[
'area'
]; ?></span>
                        </div>
                        <a href="<?php echo base_url(
'?page=property-details&id='
 . $property[
'id'
]); ?>" class="btn btn-primary w-100"><?php echo lang(
'view_details'
); ?></a>
                    </div>
                    <div class="card-footer text-muted">
                        <small><?php echo lang(
'type'
); ?>: <?php echo htmlspecialchars(get_current_lang() === 
'ar'
 ? $property[
'type_ar'
] : $property[
'type_en'
]); ?> | <?php echo lang(
'status'
); ?>: <?php echo htmlspecialchars(get_current_lang() === 
'ar'
 ? $property[
'status_ar'
] : $property[
'status_en'
]); ?></small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Placeholder for Pagination - to be implemented later -->
    <nav aria-label="Page navigation example" class="mt-5 d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true"><?php echo lang(
'previous_en_ar'
); // Placeholder ?></a></li>
            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#"><?php echo lang(
'next_en_ar'
); // Placeholder ?></a></li>
        </ul>
    </nav>

</div>

<?php
// Add new language keys to lang/en.php and lang/ar.php
/*
// lang/en.php additions:
    // Listings Page
    'listings_intro_placeholder_en_ar' => 'Explore our wide range of properties. Use the filters below to find the one that suits your needs.',
    'search_keyword_placeholder_en_ar' => 'Keyword (e.g. villa, sea view)',
    'all_types_en_ar' => 'All Types',
    'villa_en_ar' => 'Villa',
    'apartment_en_ar' => 'Apartment',
    'house_en_ar' => 'House',
    'any_status_en_ar' => 'Any Status',
    'for_sale_en_ar' => 'For Sale',
    'for_rent_en_ar' => 'For Rent',
    'location_placeholder_en_ar' => 'Location (e.g. City, Region)',
    'previous_en_ar' => 'Previous',
    'next_en_ar' => 'Next',

// lang/ar.php additions:
    // Listings Page
    'listings_intro_placeholder_en_ar' => 'اكتشف مجموعتنا الواسعة من العقارات. استخدم الفلاتر أدناه للعثور على ما يناسب احتياجاتك.',
    'search_keyword_placeholder_en_ar' => 'كلمة مفتاحية (مثال: فيلا، إطلالة بحرية)',
    'all_types_en_ar' => 'جميع الأنواع',
    'villa_en_ar' => 'فيلا',
    'apartment_en_ar' => 'شقة',
    'house_en_ar' => 'منزل',
    'any_status_en_ar' => 'أي حالة',
    'for_sale_en_ar' => 'للبيع',
    'for_rent_en_ar' => 'للإيجار',
    'location_placeholder_en_ar' => 'الموقع (مثال: المدينة، المنطقة)',
    'previous_en_ar' => 'السابق',
    'next_en_ar' => 'التالي',
*/
?>
<style>
.property-card {
    transition: transform .2s ease-out, box-shadow .2s ease-out;
}
.property-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0,0,0,.12);
}
.price-tag {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--bs-primary);
}
</style>
