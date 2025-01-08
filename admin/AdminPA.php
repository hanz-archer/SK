<?php
include("../connection/Connection.php");

// Add this new function to get available years for each category
function getAvailableYears($category, $type) {
    global $conn;
    
    // Create separate mappings for CBYDP and ABYIP
    $cbydpMapping = [
        'social_inclusion_and_equity' => 'social',
        'peace_building_and_security' => 'peace',
        'active_citizenship' => 'citizenship',
        'economic_empowerment' => 'economic',
        'sports_development' => 'sports',
        'general_administration' => 'general',
        'education' => 'education',
        'health' => 'health',
        'environment' => 'environment',
        'agriculture' => 'agriculture'
    ];

    $abyipMapping = [
        'social_inclusion_and_equity' => 'sie',
        'peace_building_and_security' => 'pbs',
        'active_citizenship' => 'ac',
        'economic_empowerment' => 'ee',
        'sports_development' => 'sports',
        'general_administration' => 'gap',
        'education' => 'education',
        'health' => 'health',
        'environment' => 'environment',
        'agriculture' => 'agriculture'
    ];
    
    // Debug log the incoming category
    error_log("Incoming category to getAvailableYears: " . $category);
    
    // Use appropriate mapping based on type
    if ($type === 'cbydp_pa') {
        $tableName = $cbydpMapping[$category] ?? $category;
    } else {
        $tableName = $abyipMapping[$category] ?? $category;
    }
    
    error_log("Mapped to table name: " . $tableName);
    
    // Different table name format for CBYDP and ABYIP
    if ($type === 'cbydp_pa') {
        $table = "cbydp_pa_{$tableName}";
    } else {
        $table = "abyip_{$tableName}";
    }
    
    $sql = "SELECT DISTINCT calendar_year FROM {$table} ORDER BY calendar_year DESC";
    
    try {
        error_log("=== Year Fetch Debug ===");
        error_log("Original Category: " . $category);
        error_log("Type: " . $type);
        error_log("Mapped Table Name: " . $tableName);
        error_log("Full Table Name: " . $table);
        error_log("SQL Query: " . $sql);
        
        $result = $conn->query($sql);
        $years = array();
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $years[] = $row['calendar_year'];
            }
            error_log("Found years: " . implode(", ", $years));
        } else {
            error_log("No rows found in table: " . $table);
        }
        return $years;
        
    } catch (mysqli_sql_exception $e) {
        error_log("Error querying table {$table}: " . $e->getMessage());
        return array();
    }
}

function generateYearOptions() {
    $currentYear = date('Y');
    $options = '';
    for($year = $currentYear; $year >= 2000; $year--) {
        $options .= "<option value='$year'>$year</option>";
    }
    return $options;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Programs and Activities</title>
    <link rel="stylesheet" href="../css/ProgramsActivities.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Programs and Activities</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <main>
    <section class="programs-container">
        <h1>Programs and Activities</h1>
        <div class="toggle-types">
            <button class="type-btn active" id="btnCBYDP" onclick="togglePrograms('CBYDP')">CBYDP</button>
            <button class="type-btn" id="btnABYIP" onclick="togglePrograms('ABYIP')">ABYIP</button>
        </div>

        <!-- CBYDP Section -->
        <div class="programs" id="CBYDP">
            <h2>Comprehensive Barangay Youth Development Plan</h2>
            <div class="categories">
                <?php
                $categories = [
                    "Education" => "Enable youth to engage in accessible, quality lifelong learning for global competitiveness.",
                    "Health" => "Engage youth in inclusive programs promoting health, nutrition, and psychosocial well-being.",
                    "Environment" => "Involve youth in eco-friendly programs for sustainable ecosystems and biodiversity.",
                    "Social Inclusion and Equity" => "Enable youth to thrive in a just society with equal opportunities for all.",
                    "Active Citizenship" => "Engage youth in sustainable community development and nation-building.",
                    "Economic Empowerment" => "Empower youth as employees or entrepreneurs in decent work, free from vulnerabilities.",
                    "Peace Building and Security" => "Promoting human security, public safety, and national peace.",
                    "Agriculture" => "Encourage youth in agricultural development through education and sustainable practices..",
                    "Sports Development" => "Foster an environment where sports enhance youth participation and skill development.",
                    "General Administration" => " Empower the Sangguniang Kabataan Council to enhance leadership skills.."
                ];

                foreach ($categories as $category => $description) {
                    // Convert category name to database-friendly format
                    $categorySlug = strtolower(str_replace(' ', '_', $category));
                    
                    // Debug log the category conversion
                    error_log("Converting category: " . $category . " to slug: " . $categorySlug);
                    
                    // Get years for both CBYDP and ABYIP
                    $cbydpYears = getAvailableYears($categorySlug, 'cbydp_pa');
                    $abyipYears = getAvailableYears($categorySlug, 'abyip');
                    
                    error_log("=== Category Card Debug ===");
                    error_log("Category: " . $category);
                    error_log("Category Slug: " . $categorySlug);
                    error_log("CBYDP Years: " . implode(", ", $cbydpYears));
                    error_log("ABYIP Years: " . implode(", ", $abyipYears));
                    
                    echo "
                    <div class='category-card' onclick='showYearSelector(\"$category\", this)'>
                        <h3>$category</h3>
                        <p>$description</p>
                        <div class='year-selector' style='display: none;' 
                             data-cbydp-years='" . htmlspecialchars(json_encode($cbydpYears)) . "'
                             data-abyip-years='" . htmlspecialchars(json_encode($abyipYears)) . "'
                             data-category-slug='" . htmlspecialchars($categorySlug) . "'>
                            <button class='close-selector' onclick='closeYearSelector(event, this)'>×</button>
                            <select class='year-dropdown' onchange='handleYearSelection(this, \"$category\")'>
                                <option value=''>Select Year</option>
                            </select>
                        </div>
                    </div>
                    ";
                }
                ?>
            </div>

            <div id="uploadMenu" class="upload-menu" style="display: none;">
                <a href="../post/CBYDP_Education.php">Post Education</a>
                <a href="../post/CBYDP_Health.php">Post Health</a>
                <a href="../post/CBYDP_Environment.php">Post Environment</a>
                <a href="../post/CBYDP_Social.php">Post Social Inclusion and Equity</a>
                <a href="../post/CBYDP_Citizenship.php">Post Active Citizenship</a>
                <a href="../post/CBYDP_Economic.php">Post Economic Empowerment</a>
                <a href="../post/CBYDP_Peace.php">Post Peace Building and Security</a>
                <a href="../post/CBYDP_Agriculture.php">Post Agriculture</a>
                <a href="../post/CBYDP_Sports.php">Post Sports Development</a>
                <a href="../post/CBYDP_Governance.php">Post Governance</a>
                <a href="../post/CBYDP_General.php">Post General Administration</a>
             </div>


             <div class="plus-button" onclick="toggleUploadMenu()">
                <img src="../images/plus_icon.png" alt="Plus Icon">
            </div>
        </div>

        <!-- ABYIP Section -->
        <div class="programs hidden" id="ABYIP">
            <h2>Annual Barangay Youth Investment Plan</h2>
            <div class="categories">
                <?php
                $categories = [
                    "Education" => "Enable youth to engage in accessible, quality lifelong learning for global competitiveness.",
                    "Health" => "Engage youth in inclusive programs promoting health, nutrition, and psychosocial well-being.",
                    "Environment" => "Involve youth in eco-friendly programs for sustainable ecosystems and biodiversity.",
                    "Social Inclusion and Equity" => "Enable youth to thrive in a just society with equal opportunities for all.",
                    "Active Citizenship" => "Engage youth in sustainable community development and nation-building.",
                    "Economic Empowerment" => "Empower youth as employees or entrepreneurs in decent work, free from vulnerabilities.",
                    "Peace Building and Security" => "Promoting human security, public safety, and national peace.",
                    "Agriculture" => "Encourage youth in agricultural development through education and sustainable practices..",
                    "Sports Development" => "Foster an environment where sports enhance youth participation and skill development.",
                    "General Administration" => " Empower the Sangguniang Kabataan Council to enhance leadership skills.."
                ];

                foreach ($categories as $category => $description) {
                    // Convert category name to database-friendly format
                    $categorySlug = strtolower(str_replace(' ', '_', $category));
                    
                    // Get years for ABYIP
                    $abyipYears = getAvailableYears($categorySlug, 'abyip');
                    
                    echo "
                    <div class='category-card' onclick='showYearSelector(\"$category\", this)'>
                        <h3>$category</h3>
                        <p>$description</p>
                        <div class='year-selector' style='display: none;' 
                             data-abyip-years='" . htmlspecialchars(json_encode($abyipYears)) . "'>
                            <button class='close-selector' onclick='closeYearSelector(event, this)'>×</button>
                            <select class='year-dropdown' onchange='handleYearSelection(this, \"$category\")'>
                                <option value=''>Select Year</option>
                            </select>
                        </div>
                    </div>
                    ";
                }
                ?>
            </div>

            <div id="uploadMenu2" class="upload-menu2" style="display: none;">
                <a href="../post/ABYIP_Education.php">Post Education</a>
                <a href="../post/ABYIP_Health.php">Post Health</a>
                <a href="../post/ABYIP_Environment.php">Post Environment</a>
                <a href="../post/ABYIP_SIE.php">Post Social Inclusion and Equity</a>
                <a href="../post/ABYIP_AC.php">Post Active Citizenship</a>
                <a href="../post/ABYIP_EE.php">Post Economic Empowerment</a>
                <a href="../post/ABYIP_PBS.php">Post Peace Building and Security</a>
                <a href="../post/ABYIP_Agriculture.php">Post Agriculture</a>
                <a href="../post/ABYIP_Sports.php">Post Sports Development</a>
                <a href="../post/ABYIP_GAP.php">Post General Administration</a>
            </div>

                        
            <div class="plus-button" onclick="toggleUploadMenu2()">
                <img src="../images/plus_icon.png" alt="Plus Icon">
            </div>

            </div>
        </div>
    </section>
</main>

<script>
function togglePrograms(type) {
    const cbydpSection = document.getElementById('CBYDP');
    const abyipSection = document.getElementById('ABYIP');
    const cbydpBtn = document.getElementById('btnCBYDP');
    const abyipBtn = document.getElementById('btnABYIP');

    console.log("Toggling programs. Type: ", type);  // Debug log

    if (type === 'CBYDP') {
        cbydpSection.classList.remove('hidden');
        abyipSection.classList.add('hidden');
        cbydpBtn.classList.add('active');
        abyipBtn.classList.remove('active');
    } else {
        cbydpSection.classList.add('hidden');
        abyipSection.classList.remove('hidden');
        cbydpBtn.classList.remove('active');
        abyipBtn.classList.add('active');
    }

    // Update all visible year selectors
    document.querySelectorAll('.year-selector:not([style*="display: none"])').forEach(selector => {
        updateYearOptions(selector, type);
    });
}



function toggleUploadMenu() {
    var menu = document.getElementById("uploadMenu");
    // Toggle the menu visibility
    if (menu.style.display === "none" || menu.style.display === "") {
        menu.style.display = "block"; // Show the menu
    } else {
        menu.style.display = "none"; // Hide the menu
    }
}

function toggleUploadMenu2() {
    var menu = document.getElementById("uploadMenu2");
    // Toggle the menu visibility
    if (menu.style.display === "none" || menu.style.display === "") {
        menu.style.display = "block"; // Show the menu
    } else {
        menu.style.display = "none"; // Hide the menu
    }
}

// Close the menu if clicked outside of it
window.onclick = function(event) {
    var menu = document.getElementById("uploadMenu");
    var menu2 = document.getElementById("uploadMenu2");
    var button = document.querySelector('.plus-button');
    
    // Check if elements exist before trying to use them
    if (menu && button && !button.contains(event.target) && !menu.contains(event.target)) {
        menu.style.display = "none";
    }

    if (menu2 && !event.target.closest('.plus-button') && !menu2.contains(event.target)) {
        menu2.style.display = "none";
    }
}

function generateYearOptions() {
    let currentYear = new Date().getFullYear();
    let options = '';
    for(let year = currentYear; year >= 2000; year--) {
        options += `<option value="${year}">${year}</option>`;
    }
    return options;
}

function showYearSelector(category, card) {
    // Hide all other year selectors first
    document.querySelectorAll('.year-selector').forEach(selector => {
        selector.style.display = 'none';
    });
    
    // Show the clicked card's year selector
    const selector = card.querySelector('.year-selector');
    
    // Determine which type is active (CBYDP or ABYIP)
    const isCBYDP = !document.getElementById('CBYDP').classList.contains('hidden');
    const type = isCBYDP ? 'cbydp_pa' : 'abyip';
    
    // Get the years from the appropriate dataset
    const years = isCBYDP 
        ? JSON.parse(selector.dataset.cbydpYears || '[]')
        : JSON.parse(selector.dataset.abyipYears || '[]');
    
    console.log('Category:', category);
    console.log('Type:', type);
    console.log('Years:', years);
    console.log('Dataset CBYDP:', selector.dataset.cbydpYears);
    console.log('Dataset ABYIP:', selector.dataset.abyipYears);
    
    // Clear existing options except the first one
    const dropdown = selector.querySelector('.year-dropdown');
    while (dropdown.options.length > 1) {
        dropdown.remove(1);
    }
    
    // Add the years as options
    years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        dropdown.appendChild(option);
    });
    
    // Show alert if no years available
    if (years.length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'No Data Available',
            text: `No ${isCBYDP ? 'CBYDP' : 'ABYIP'} records available for this category yet.`,
            confirmButtonColor: '#e48130'
        });
        return;
    }
    
    selector.style.display = 'block';
}

function handleYearSelection(selectElement, category) {
    const year = selectElement.value;
    if (!year) return;

    // Determine which section is currently active
    const isCBYDP = !document.getElementById('CBYDP').classList.contains('hidden');
    const type = isCBYDP ? 'cbydp' : 'abyip';
    
    // Create a mapping for PDF file names
    const pdfMapping = {
        'Social Inclusion and Equity': 'sie',
        'Peace Building and Security': 'pbs',
        'Active Citizenship': 'ac',
        'Economic Empowerment': 'ee',
        'Sports Development': 'sports',
        'General Administration': 'gap',
        'Education': 'education',
        'Health': 'health',
        'Environment': 'environment',
        'Agriculture': 'agriculture'
    };

    // Get the PDF slug for the category
    const pdfSlug = pdfMapping[category];
    if (!pdfSlug) {
        console.error('Unknown category:', category);
        return;
    }

    // Convert category to database-friendly format
    const dbCategory = category.toLowerCase().replace(/ /g, '_');

    // Fetch signatories first
    fetch(`../connection/get_signatories.php?type=${type}&category=${dbCategory}&year=${year}`)
        .then(response => response.json())
        .then(response => {
            if (response.status === 'error') {
                throw new Error(response.message);
            }

            const data = response.data;
            
            // Construct the PDF URL with fetched signatories
            const pdfUrl = `../connection/pdf_${type}_${pdfSlug}.php?` + 
                `year=${encodeURIComponent(year)}&` +
                `prepared_by_name=${encodeURIComponent(data.prepared_by_name)}&` +
                `prepared_by_position=${encodeURIComponent(data.prepared_by_position)}&` +
                `approved_by_name=${encodeURIComponent(data.approved_by_name)}&` +
                `approved_by_position=${encodeURIComponent(data.approved_by_position)}`;

            // Open PDF in new window
            window.open(pdfUrl, '_blank');
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Failed to fetch signatories',
                confirmButtonColor: '#3085d6'
            });
        });
}

// Add this JavaScript function to update dropdown options based on active type
function updateYearOptions(selector, type) {
    const yearDropdown = selector.querySelector('.year-dropdown');
    const years = type === 'CBYDP' 
        ? JSON.parse(selector.dataset.cbydpYears || '[]')
        : JSON.parse(selector.dataset.abyipYears || '[]');
    
    // Clear existing options except the first one
    while (yearDropdown.options.length > 1) {
        yearDropdown.remove(1);
    }
    
    // Add new options
    years.forEach(year => {
        const option = new Option(year, year);
        yearDropdown.add(option);
    });

    // If no years available, show alert and hide selector
    if (years.length === 0) {
        selector.style.display = 'none';
        Swal.fire({
            icon: 'info',
            title: 'No Data Available',
            text: `No ${type} records available for this category yet.`,
            confirmButtonColor: '#e48130'
        });
    }
}

// Close selector function
function closeYearSelector(event, button) {
    event.stopPropagation();
    const selector = button.parentElement;
    selector.style.display = 'none';
}

</script>

</body>
</html>
