<?php
require('../libs/fpdf/fpdf.php');
include("Connection.php");

class PDF extends FPDF {
    function __construct() {
        // Adjust margins to fit all columns
        parent::__construct('P', 'mm', 'A4');
        $this->SetMargins(10, 10, 10); // Left, Top, Right margins
    }

    // Calculate wrapped cell height
    function GetMultiCellHeight($w, $txt) {
        $height = 5;
        $startX = $this->GetX();
        $startY = $this->GetY();
        $this->MultiCell($w, 5, $txt);
        $endY = $this->GetY();
        $this->SetXY($startX, $startY);
        return $endY - $startY;
    }

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
        
        // Adjusted column widths to fit within page width (190mm with margins)
        $col_widths = array(40, 30, 35, 39, 35, 30);
        
        // First row headers
        $this->Cell($col_widths[0], 10, 'YOUTH DEVELOPMENT CONCERN', 1, 0, 'C');
        $this->Cell($col_widths[1], 10, 'OBJECTIVE', 1, 0, 'C');
        $this->Cell($col_widths[2], 10, 'PERFORMANCE INDICATOR', 1, 0, 'C');
        $this->Cell($col_widths[3], 5, 'TARGET', 'TLR', 0, 'C');
        $this->Cell($col_widths[4], 10, 'PPAs', 1, 0, 'C');
        $this->Cell($col_widths[5], 10, 'BUDGET', 1, 1, 'C');

        // TARGET years
        $year_width = $col_widths[3] / 3;
        $current_x = $this->GetX() + $col_widths[0] + $col_widths[1] + $col_widths[2];
        $current_y = $this->GetY() - 5;
        
        $this->SetXY($current_x, $current_y);
        $this->Cell($year_width, 5, '2024', 1, 0, 'C');
        $this->Cell($year_width, 5, '2025', 1, 0, 'C');
        $this->Cell($year_width, 5, '2026', 1, 1, 'C');
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

// Create PDF object with adjusted margins
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);

if(isset($_GET['year'])) {
    $year = $_GET['year'];
    
    $sql = "SELECT * FROM cbydp_pa_education WHERE calendar_year = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Use same adjusted column widths
    $col_widths = array(40, 30, 35, 39, 35, 30);
    
    while($row = $result->fetch_assoc()) {
        $start_x = $pdf->GetX();
        $start_y = $pdf->GetY();
        
        // Format and wrap text with stricter width limits
        $txt_concern = wordwrap($row['youth_development_concern'], 20, "\n", true);
        $txt_objective = wordwrap($row['objective'], 15, "\n", true);
        $txt_indicator = wordwrap($row['performance_indicator'], 15, "\n", true);
        $txt_ppas = wordwrap($row['ppas'], 20, "\n", true);
        
        // Format target cells with word wrap
        $target_2024 = wordwrap($row['target_2024'] . ' students', 8, "\n", true);
        $target_2025 = wordwrap($row['target_2025'] . ' students', 8, "\n", true);
        $target_2026 = wordwrap($row['target_2026'] . ' students', 8, "\n", true);
        
        // Calculate heights
        $line_height = 5;
        $heights = array();
        $heights[] = count(explode("\n", $txt_concern)) * $line_height;
        $heights[] = count(explode("\n", $txt_objective)) * $line_height;
        $heights[] = count(explode("\n", $txt_indicator)) * $line_height;
        $heights[] = count(explode("\n", $txt_ppas)) * $line_height;
        $heights[] = count(explode("\n", $target_2024)) * $line_height;
        $heights[] = count(explode("\n", $target_2025)) * $line_height;
        $heights[] = count(explode("\n", $target_2026)) * $line_height;
        $heights[] = 10; // Minimum height
        
        $max_height = max($heights);
        
        // Check for page break
        if ($start_y + $max_height > 250) {
            $pdf->AddPage();
            $start_y = $pdf->GetY();
        }
        
        // Reset X position
        $current_x = $start_x;
        
        // Youth Development Concern
        $pdf->SetXY($current_x, $start_y);
        $pdf->MultiCell($col_widths[0], $max_height, $txt_concern, 1, 'L');
        $current_x += $col_widths[0];
        
        // Objective
        $pdf->SetXY($current_x, $start_y);
        $pdf->MultiCell($col_widths[1], $max_height, $txt_objective, 1, 'L');
        $current_x += $col_widths[1];
        
        // Performance Indicator
        $pdf->SetXY($current_x, $start_y);
        $pdf->MultiCell($col_widths[2], $max_height, $txt_indicator, 1, 'L');
        $current_x += $col_widths[2];
        
        // TARGET cells with word wrap
        $year_width = $col_widths[3] / 3;
        $pdf->SetXY($current_x, $start_y);
        $pdf->MultiCell($year_width, $max_height/2, $target_2024, 1, 'C');
        $pdf->SetXY($current_x + $year_width, $start_y);
        $pdf->MultiCell($year_width, $max_height/2, $target_2025, 1, 'C');
        $pdf->SetXY($current_x + (2 * $year_width), $start_y);
        $pdf->MultiCell($year_width, $max_height/2, $target_2026, 1, 'C');
        $current_x += $col_widths[3];
        
        // PPAs
        $pdf->SetXY($current_x, $start_y);
        $pdf->MultiCell($col_widths[4], $max_height, $txt_ppas, 1, 'L');
        $current_x += $col_widths[4];
        
        // Budget (ensure it's visible)
        $pdf->SetXY($current_x, $start_y);
        $budget_amount = '₱' . number_format($row['budget'], 2);
        // Split budget text into two lines with proper spacing
        $pdf->MultiCell($col_widths[5], $max_height/2, $budget_amount . "\n\nEvery year", 1, 'R');
        
        // Move to next row with proper spacing
        $pdf->SetY($start_y + $max_height);
    }
    
    $stmt->close();
}

$pdf->Output('CBYDP_Education_Plan.pdf', 'I');
?>
