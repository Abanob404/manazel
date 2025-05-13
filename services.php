<?php
// templates/pages/services.php

$page_title = 
'services'
; // For header.php to pick up

?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-10 offset-md-1 text-center">
            <h1><?php echo lang(
'our_services_title'
); ?></h1>
            <p class="lead">
                <?php echo lang(
'services_intro_placeholder_en_ar'
); // Placeholder, add to lang files
                // Example: "At Manazel Real Estate, we offer a comprehensive suite of services to meet all your property needs. Our experienced team is dedicated to providing exceptional support and guidance throughout your real estate journey."
                // Example AR: "في منازل العقارية، نقدم مجموعة شاملة من الخدمات لتلبية جميع احتياجاتك العقارية. فريقنا المتمرس مكرس لتقديم دعم وإرشاد استثنائيين طوال رحلتك العقارية."
                ?>
            </p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-home fa-3x mb-3 text-primary"></i> <!-- Placeholder icon -->
                    <h4 class="card-title"><?php echo lang(
'service_sales_leasing_en_ar'
); // Placeholder ?></h4>
                    <p class="card-text">
                        <?php echo lang(
'service_sales_leasing_desc_en_ar'
); // Placeholder
                        // Example: "Whether you are looking to buy, sell, or lease a property, our expert agents are here to guide you through every step, ensuring a smooth and successful transaction."
                        // Example AR: "سواء كنت تتطلع لشراء أو بيع أو تأجير عقار، فإن وكلائنا الخبراء هنا لإرشادك في كل خطوة، مما يضمن معاملة سلسة وناجحة."
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-building fa-3x mb-3 text-primary"></i> <!-- Placeholder icon -->
                    <h4 class="card-title"><?php echo lang(
'service_property_management_en_ar'
); // Placeholder ?></h4>
                    <p class="card-text">
                        <?php echo lang(
'service_property_management_desc_en_ar'
); // Placeholder
                        // Example: "We offer comprehensive property management services, taking care of everything from tenant screening and rent collection to maintenance and financial reporting."
                        // Example AR: "نقدم خدمات إدارة عقارات شاملة، معتنين بكل شيء بدءًا من فحص المستأجرين وتحصيل الإيجارات إلى الصيانة والتقارير المالية."
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-3x mb-3 text-primary"></i> <!-- Placeholder icon -->
                    <h4 class="card-title"><?php echo lang(
'service_investment_consultancy_en_ar'
); // Placeholder ?></h4>
                    <p class="card-text">
                        <?php echo lang(
'service_investment_consultancy_desc_en_ar'
); // Placeholder
                        // Example: "Our investment consultancy services provide expert advice and market insights to help you make informed decisions and maximize your returns in the real estate market."
                        // Example AR: "تقدم خدماتنا الاستشارية الاستثمارية نصائح الخبراء ورؤى السوق لمساعدتك في اتخاذ قرارات مستنيرة وتعظيم عوائدك في سوق العقارات."
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
         <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-search-dollar fa-3x mb-3 text-primary"></i> <!-- Placeholder icon -->
                    <h4 class="card-title"><?php echo lang(
'service_valuation_en_ar'
); // Placeholder ?></h4>
                    <p class="card-text">
                        <?php echo lang(
'service_valuation_desc_en_ar'
); // Placeholder
                        // Example: "Accurate property valuation is crucial. Our certified valuers provide detailed and reliable valuation reports for various purposes."
                        // Example AR: "تقييم العقارات بدقة أمر بالغ الأهمية. يقدم مقيمونا المعتمدون تقارير تقييم مفصلة وموثوقة لأغراض متنوعة."
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-file-signature fa-3x mb-3 text-primary"></i> <!-- Placeholder icon -->
                    <h4 class="card-title"><?php echo lang(
'service_legal_assistance_en_ar'
); // Placeholder ?></h4>
                    <p class="card-text">
                        <?php echo lang(
'service_legal_assistance_desc_en_ar'
); // Placeholder
                        // Example: "Navigating the legal aspects of real estate can be complex. We offer legal assistance to ensure all your transactions are compliant and secure."
                        // Example AR: "قد يكون التنقل في الجوانب القانونية للعقارات معقدًا. نقدم المساعدة القانونية لضمان أن جميع معاملاتك متوافقة وآمنة."
                        ?>
                    </p>
                </div>
            </div>
        </div>
         <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-tools fa-3x mb-3 text-primary"></i> <!-- Placeholder icon -->
                    <h4 class="card-title"><?php echo lang(
'service_maintenance_en_ar'
); // Placeholder ?></h4>
                    <p class="card-text">
                        <?php echo lang(
'service_maintenance_desc_en_ar'
); // Placeholder
                        // Example: "We provide reliable and timely maintenance services to keep your property in top condition, ensuring tenant satisfaction and preserving its value."
                        // Example AR: "نقدم خدمات صيانة موثوقة وفي الوقت المناسب للحفاظ على عقارك في أفضل حالة، مما يضمن رضا المستأجرين ويحافظ على قيمته."
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
// Add new language keys to lang/en.php and lang/ar.php
/*
// lang/en.php additions:
    // Services Page
    'services_intro_placeholder_en_ar' => 'At Manazel Real Estate, we offer a comprehensive suite of services to meet all your property needs. Our experienced team is dedicated to providing exceptional support and guidance throughout your real estate journey.',
    'service_sales_leasing_en_ar' => 'Sales & Leasing',
    'service_sales_leasing_desc_en_ar' => 'Whether you are looking to buy, sell, or lease a property, our expert agents are here to guide you through every step, ensuring a smooth and successful transaction.',
    'service_property_management_en_ar' => 'Property Management',
    'service_property_management_desc_en_ar' => 'We offer comprehensive property management services, taking care of everything from tenant screening and rent collection to maintenance and financial reporting.',
    'service_investment_consultancy_en_ar' => 'Investment Consultancy',
    'service_investment_consultancy_desc_en_ar' => 'Our investment consultancy services provide expert advice and market insights to help you make informed decisions and maximize your returns in the real estate market.',
    'service_valuation_en_ar' => 'Property Valuation',
    'service_valuation_desc_en_ar' => 'Accurate property valuation is crucial. Our certified valuers provide detailed and reliable valuation reports for various purposes.',
    'service_legal_assistance_en_ar' => 'Legal Assistance',
    'service_legal_assistance_desc_en_ar' => 'Navigating the legal aspects of real estate can be complex. We offer legal assistance to ensure all your transactions are compliant and secure.',
    'service_maintenance_en_ar' => 'Maintenance Services',
    'service_maintenance_desc_en_ar' => 'We provide reliable and timely maintenance services to keep your property in top condition, ensuring tenant satisfaction and preserving its value.',

// lang/ar.php additions:
    // Services Page
    'services_intro_placeholder_en_ar' => 'في منازل العقارية، نقدم مجموعة شاملة من الخدمات لتلبية جميع احتياجاتك العقارية. فريقنا المتمرس مكرس لتقديم دعم وإرشاد استثنائيين طوال رحلتك العقارية.',
    'service_sales_leasing_en_ar' => 'البيع والتأجير',
    'service_sales_leasing_desc_en_ar' => 'سواء كنت تتطلع لشراء أو بيع أو تأجير عقار، فإن وكلائنا الخبراء هنا لإرشادك في كل خطوة، مما يضمن معاملة سلسة وناجحة.',
    'service_property_management_en_ar' => 'إدارة العقارات',
    'service_property_management_desc_en_ar' => 'نقدم خدمات إدارة عقارات شاملة، معتنين بكل شيء بدءًا من فحص المستأجرين وتحصيل الإيجارات إلى الصيانة والتقارير المالية.',
    'service_investment_consultancy_en_ar' => 'الاستشارات الاستثمارية',
    'service_investment_consultancy_desc_en_ar' => 'تقدم خدماتنا الاستشارية الاستثمارية نصائح الخبراء ورؤى السوق لمساعدتك في اتخاذ قرارات مستنيرة وتعظيم عوائدك في سوق العقارات.',
    'service_valuation_en_ar' => 'تقييم العقارات',
    'service_valuation_desc_en_ar' => 'تقييم العقارات بدقة أمر بالغ الأهمية. يقدم مقيمونا المعتمدون تقارير تقييم مفصلة وموثوقة لأغراض متنوعة.',
    'service_legal_assistance_en_ar' => 'المساعدة القانونية',
    'service_legal_assistance_desc_en_ar' => 'قد يكون التنقل في الجوانب القانونية للعقارات معقدًا. نقدم المساعدة القانونية لضمان أن جميع معاملاتك متوافقة وآمنة.',
    'service_maintenance_en_ar' => 'خدمات الصيانة',
    'service_maintenance_desc_en_ar' => 'نقدم خدمات صيانة موثوقة وفي الوقت المناسب للحفاظ على عقارك في أفضل حالة، مما يضمن رضا المستأجرين ويحافظ على قيمته.',
*/
?>
