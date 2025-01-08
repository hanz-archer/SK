<?php
include("Connection.php");

// Array of all CBYDP tables
$tables = [
    'cbydp_pa_sie' => 'Social Inclusion and Equity',
    'cbydp_pa_pbs' => 'Peace Building and Security',
    'cbydp_pa_ac' => 'Active Citizenship',
    'cbydp_pa_ee' => 'Economic Empowerment',
    'cbydp_pa_sports' => 'Sports Development',
    'cbydp_pa_gap' => 'General Administration',
    'cbydp_pa_education' => 'Education',
    'cbydp_pa_health' => 'Health',
    'cbydp_pa_environment' => 'Environment',
    'cbydp_pa_agriculture' => 'Agriculture'
];

echo "<h2>Available Years in CBYDP Tables</h2>";

foreach ($tables as $table => $description) {
    $sql = "SELECT DISTINCT calendar_year FROM $table ORDER BY calendar_year DESC";
    
    try {
        $result = $conn->query($sql);
        
        echo "<h3>$description ($table)</h3>";
        
        if ($result && $result->num_rows > 0) {
            echo "<ul>";
            while($row = $result->fetch_assoc()) {
                echo "<li>Year: " . $row['calendar_year'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No years found in this table.</p>";
        }
    } catch (Exception $e) {
        echo "<p>Error checking table $table: " . $e->getMessage() . "</p>";
    }
}

$conn->close();
?> 