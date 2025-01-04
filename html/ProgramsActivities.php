<?php
include("../connection/Connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs and Activities</title>
    <link rel="stylesheet" href="../css/ProgramsActivities.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../html/HomePage.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Programs and Activities</span>
        </div>
        <nav class="nav-links">
            <a href="../html/HomePage.php" class="nav-item">HOME</a>
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
                    "Governance" => "Create a supportive environment for youth that values sports and skill development.",
                    "General Administration" => " Empower the Sangguniang Kabataan Council to enhance leadership skills.."
                ];

                foreach ($categories as $category => $description) {
                    echo "
                    <div class='category-card'>
                        <h3>$category</h3>
                        <p>$description</p>
                    </div>
                    ";
                }
                ?>
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
                    echo "
                    <div class='category-card'>
                        <h3>$category</h3>
                        <p>$description</p>
                    </div>
                    ";
                }
                ?>
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

    console.log("Toggling programs. Type: ", type);  // Add console log to verify the function works

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
}


</script>


    
</body>
</html>
