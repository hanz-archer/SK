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
        
        // Table Header with exact formatting for portrait
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(255, 255, 255);

        // Define column widths for portrait (adjusted to fit page)
        $col_widths = array(40, 30, 35, 45, 25, 25);
        
        // First row of headers
        $this->Cell($col_widths[0], 10, 'YOUTH DEVELOPMENT CONCERN', 1, 0, 'C');
        $this->Cell($col_widths[1], 10, 'OBJECTIVE', 1, 0, 'C');
        $this->Cell($col_widths[2], 10, 'PERFORMANCE INDICATOR', 1, 0, 'C');
        
        // TARGET header spanning 3 columns
        $this->Cell($col_widths[3], 5, 'TARGET', 1, 0, 'C');
        
        $this->Cell($col_widths[4], 10, 'PPAs', 1, 0, 'C');
        $this->Cell($col_widths[5], 10, 'BUDGET', 1, 1, 'C');

        // Second row for TARGET years
        $this->Cell($col_widths[0], 5, '', 0, 0);
        $this->Cell($col_widths[1], 5, '', 0, 0);
        $this->Cell($col_widths[2], 5, '', 0, 0);
        
        // TARGET subheaders
        $year_width = $col_widths[3] / 3;
        $this->Cell($year_width, 5, '2024', 1, 0, 'C');
        $this->Cell($year_width, 5, '2025', 1, 0, 'C');
        $this->Cell($year_width, 5, '2026', 1, 0, 'C');
        
        $this->Cell($col_widths[4], 5, '', 0, 0);
        $this->Cell($col_widths[5], 5, '', 0, 1);
    }

    // Add a MultiCell with auto-height function
    function MultiCellAutoHeight($w, $txt, $border=1, $align='L') {
        // Calculate height needed for the text
        $cw = $this->GetStringWidth($txt);
        $h = 5; // minimum height
        
        if($cw > $w) {
            $words = explode(' ', $txt);
            $line = '';
            $lines = 1;
            
            foreach($words as $word) {
                $testLine = $line . ' ' . $word;
                if($this->GetStringWidth($testLine) > $w) {
                    $lines++;
                    $line = $word;
                } else {
                    $line = $testLine;
                }
            }
            $h = max($h, $lines * 5);
        }
        
        $this->MultiCell($w, $h/2, $txt, $border, $align);
        return $h;
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
$pdf = new PDF('P', 'mm', 'A4'); // Changed to Portrait
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
    
    // Define column widths (same as header)
    $col_widths = array(40, 30, 35, 45, 25, 25);
    
    while($row = $result->fetch_assoc()) {
        $startY = $pdf->GetY();
        $startX = $pdf->GetX();
        
        // Store current position
        $x = $startX;
        
        // Calculate maximum height needed for this row
        $heights = array();
        
        // Get heights for each cell
        $pdf->SetX($x);
        $heights[] = $pdf->MultiCellAutoHeight($col_widths[0], $row['youth_development_concern']);
        
        $pdf->SetXY($x + $col_widths[0], $startY);
        $heights[] = $pdf->MultiCellAutoHeight($col_widths[1], $row['objective']);
        
        $pdf->SetXY($x + $col_widths[0] + $col_widths[1], $startY);
        $heights[] = $pdf->MultiCellAutoHeight($col_widths[2], $row['performance_indicator']);
        
        // TARGET cells
        $year_width = $col_widths[3] / 3;
        $currentX = $x + $col_widths[0] + $col_widths[1] + $col_widths[2];
        
        // Use the maximum height for consistent row height
        $maxHeight = max($heights);
        
        // Reset position and draw cells with consistent height
        $pdf->SetXY($x, $startY);
        
        // Draw all cells with the maximum height
        $pdf->MultiCell($col_widths[0], $maxHeight, $row['youth_development_concern'], 1, 'L');
        $pdf->SetXY($x + $col_widths[0], $startY);
        $pdf->MultiCell($col_widths[1], $maxHeight, $row['objective'], 1, 'L');
        $pdf->SetXY($x + $col_widths[0] + $col_widths[1], $startY);
        $pdf->MultiCell($col_widths[2], $maxHeight, $row['performance_indicator'], 1, 'L');
        
        // TARGET cells with consistent height
        $pdf->SetXY($currentX, $startY);
        $pdf->Cell($year_width, $maxHeight, $row['target_2024'] . ' students', 1, 0, 'C');
        $pdf->Cell($year_width, $maxHeight, $row['target_2025'] . ' students', 1, 0, 'C');
        $pdf->Cell($year_width, $maxHeight, $row['target_2026'] . ' students', 1, 0, 'C');
        
        // PPAs and Budget
        $currentX = $x + array_sum(array_slice($col_widths, 0, 4));
        $pdf->SetXY($currentX, $startY);
        $pdf->MultiCell($col_widths[4], $maxHeight, $row['ppas'], 1, 'L');
        
        $pdf->SetXY($currentX + $col_widths[4], $startY);
        $pdf->MultiCell($col_widths[5], $maxHeight, '₱' . number_format($row['budget'], 2) . "\nEvery year", 1, 'R');
        
        // Move to next row
        $pdf->Ln(2);
    }
    
    $stmt->close();
}

$pdf->Output('CBYDP_Education_Plan.pdf', 'I');
?>
