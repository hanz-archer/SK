<?php
require('../libs/fpdf/fpdf.php');
include("Connection.php");

class PDF extends FPDF {
    // Header
    function Header() {
        // Logos
        $this->Image('../images/SK.png', 20, 10, 25);
        $this->Image('../images/Sumaguan_Logo.png', 165, 10, 25);
        
        // Header text
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
        $this->Cell(0, 5, 'Province of Cebu', 0, 1, 'C');
        $this->Cell(0, 5, 'Municipality of ARGAO', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, 'BARANGAY SUMAGUAN', 0, 1, 'C');
        
        // SK Office
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 5, 'OFFICE OF THE SANGGUNIANG KABATAAN', 0, 1, 'C');
        
        // CBYDP Title
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 5, 'COMPREHENSIVE BARANGAY YOUTH DEVELOPMENT PLAN (CBYDP)', 0, 1, 'C');
        $this->Cell(0, 5, 'CY 2024-2026', 0, 1, 'C');
        
        // Center of Participation
        $this->Ln(5);
        $this->SetFont('Arial', '', 11);
        $this->Cell(45, 5, 'Center of Participation:', 0, 0);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 5, 'EDUCATION', 0, 1);
        
        // Agenda Statement
        $this->Ln(5);
        $this->SetFont('Arial', '', 11);
        $this->Cell(35, 5, 'Agenda Statement:', 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, 'For the youth to participate in accessible, developmental, quality, and relevant formal, non-formal and informal lifelong learning and training that prepares graduates to be globally competitive but responsive to national needs and to prepare them for the workplace and the emergence of new media and other technologies.');
        
        // Table Header
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(40, 10, 'YOUTH DEVELOPMENT CONCERN', 1, 0, 'C', true);
        $this->Cell(30, 10, 'OBJECTIVE', 1, 0, 'C', true);
        $this->Cell(30, 10, 'PERFORMANCE INDICATOR', 1, 0, 'C', true);
        $this->Cell(45, 10, 'TARGET', 1, 0, 'C', true);
        $this->Cell(25, 10, 'PPAs', 1, 0, 'C', true);
        $this->Cell(20, 10, 'BUDGET', 1, 1, 'C', true);
    }

    // Footer
    function Footer() {
        $this->SetY(-50);
        $this->SetFont('Arial', '', 10);
        
        // Prepared by
        $this->Cell(95, 5, 'Prepared by:', 0, 0);
        $this->Cell(95, 5, 'Approved by:', 0, 1);
        
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 10);
        
        // Get the data from session or POST
        if(isset($_GET['prepared_by_name']) && isset($_GET['approved_by_name'])) {
            $prepared_by_name = strtoupper($_GET['prepared_by_name']);
            $prepared_by_position = $_GET['prepared_by_position'];
            $approved_by_name = strtoupper($_GET['approved_by_name']);
            $approved_by_position = $_GET['approved_by_position'];
            
            $this->Cell(95, 5, $prepared_by_name, 0, 0, 'C');
            $this->Cell(95, 5, $approved_by_name, 0, 1, 'C');
            
            $this->SetFont('Arial', '', 10);
            $this->Cell(95, 5, $prepared_by_position, 0, 0, 'C');
            $this->Cell(95, 5, $approved_by_position, 0, 1, 'C');
        }
    }
}

// Create PDF object
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);

// Get the submitted data
if(isset($_GET['year'])) {
    $year = $_GET['year'];
    
    // Fetch data from database
    $sql = "SELECT * FROM cbydp_pa_education WHERE calendar_year = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while($row = $result->fetch_assoc()) {
        // Output data in table format
        $pdf->Cell(40, 10, $row['youth_development_concern'], 1, 0, 'L');
        $pdf->Cell(30, 10, $row['objective'], 1, 0, 'L');
        $pdf->Cell(30, 10, $row['performance_indicator'], 1, 0, 'L');
        
        // Combine targets in one cell
        $targets = "2024: " . $row['target_2024'] . "\n";
        $targets .= "2025: " . $row['target_2025'] . "\n";
        $targets .= "2026: " . $row['target_2026'];
        $pdf->MultiCell(45, 10, $targets, 1, 'L');
        
        $pdf->Cell(25, 10, $row['ppas'], 1, 0, 'L');
        $pdf->Cell(20, 10, '₱' . number_format($row['budget'], 2), 1, 1, 'R');
    }
    
    $stmt->close();
}

$pdf->Output('CBYDP_Education_Plan.pdf', 'I');
?>
