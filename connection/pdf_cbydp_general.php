<?php
require('../libs/fpdf/fpdf.php');
include('Connection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

class PDF extends FPDF {
    // Add MultiCell with height calculation
    function MultiCellHeight($w, $h, $txt, $border=0, $align='J') {
        // Calculate height of text
        $lines = $this->NbLines($w, $txt);
        return $lines * $h;
    }

    function NbLines($w, $txt) {
        // Compute number of lines a MultiCell will take
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb) {
            $c = $s[$i];
            if($c=="\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax) {
                if($sep==-1) {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    // Add new function for table cells with consistent height
    function MultiCellTable($w, $h, $txt, $border=1, $align='L') {
        // Store current position
        $x = $this->GetX();
        $y = $this->GetY();
        
        // Output the cell
        $this->MultiCell($w, $h/max(1, substr_count($txt, "\n")+1), $txt, $border, $align);
        
        // Reset position to right of cell
        $this->SetXY($x + $w, $y);
    }

    // Rest of your Header and Footer functions remain the same
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
        $this->Cell(0, 5, 'GENERAL ADMINISTRATION', 0, 1);
        
        // Agenda Statement
        $this->Ln(5);
        $this->SetFont('Arial', '', 11);
        $this->Cell(35, 5, 'Agenda Statement:', 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, 'For the youth to participate in accessible, developmental, quality, and relevant formal, non-formal and informal lifelong learning and training that prepares graduates to be globally competitive but responsive to national needs and to prepare them for the workplace and the emergence of new media and other technologies.');
        
        // Table Header
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 6);
        
        // Adjusted column widths to fit within page width (190mm with margins)
        $col_widths = array(40, 25, 30, 45, 30, 20);
        
        // First row headers with text wrapping
        $this->Cell($col_widths[0], 10, "YOUTH\nDEVELOPMENT\nCONCERN", 1, 0, 'C');
        $this->Cell($col_widths[1], 10, "OBJECTIVE", 1, 0, 'C');
        $this->Cell($col_widths[2], 10, "PERFORMANCE\nINDICATOR", 1, 0, 'C');
        $this->Cell($col_widths[3], 5, "TARGET", 'TLR', 0, 'C');
        $this->Cell($col_widths[4], 10, "PPAs", 1, 0, 'C');
        $this->Cell($col_widths[5], 10, "BUDGET", 1, 1, 'C');

        // TARGET years (increased individual year width)
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

// Validate required parameters
$year = isset($_GET['year']) ? intval($_GET['year']) : null;
$prepared_by_name = isset($_GET['prepared_by_name']) ? htmlspecialchars($_GET['prepared_by_name']) : null;
$prepared_by_position = isset($_GET['prepared_by_position']) ? htmlspecialchars($_GET['prepared_by_position']) : null;
$approved_by_name = isset($_GET['approved_by_name']) ? htmlspecialchars($_GET['approved_by_name']) : null;
$approved_by_position = isset($_GET['approved_by_position']) ? htmlspecialchars($_GET['approved_by_position']) : null;

// Check for missing required parameters
if (!$year) {
    die('Year parameter is required');
}

if(isset($_GET['year'])) {
    $year = $_GET['year'];
    
    $sql = "SELECT * FROM cbydp_pa_general WHERE calendar_year = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        die("No data found for year $year");
    }
    
    // Use same adjusted column widths
    $col_widths = array(40, 25, 30, 45, 30, 20);
    
    while($row = $result->fetch_assoc()) {
        $start_y = $pdf->GetY();
        
        // Calculate heights needed for each cell content
        $heights = array();
        $line_height = 5;
        
        // Format and wrap text
        $txt_concern = wordwrap($row['youth_development_concern'], 15, "\n", true);
        $txt_objective = wordwrap($row['objective'], 12, "\n", true);
        $txt_indicator = wordwrap($row['performance_indicator'], 12, "\n", true);
        $txt_ppas = wordwrap($row['ppas'], 15, "\n", true);
        $target_2024 = $row['target_2024'];
        $target_2025 = $row['target_2025'];
        $target_2026 = $row['target_2026'];
        
        // Calculate heights for each cell
        $heights = array();
        $line_height = 5;
        
        // Calculate the number of lines for each cell
        $concern_lines = substr_count($txt_concern, "\n") + 1;
        $objective_lines = substr_count($txt_objective, "\n") + 1;
        $indicator_lines = substr_count($txt_indicator, "\n") + 1;
        $ppas_lines = substr_count($txt_ppas, "\n") + 1;
        
        // Get the maximum number of lines
        $max_lines = max($concern_lines, $objective_lines, $indicator_lines, $ppas_lines, 2); // minimum 2 lines
        
        // Set the height for all cells based on the maximum lines
        $max_height = $max_lines * $line_height;
        
        // Check if we need a new page
        if($pdf->GetY() + $max_height > $pdf->GetPageHeight() - 60) {
            $pdf->AddPage();
            $start_y = $pdf->GetY();
        }
        
        // Output cells with consistent height
        $current_x = $pdf->GetX();
        $year_width = $col_widths[3] / 3;
        
        $pdf->SetXY($current_x, $start_y);
        $pdf->MultiCellTable($col_widths[0], $max_height, $txt_concern);
        
        $pdf->SetXY($current_x + $col_widths[0], $start_y);
        $pdf->MultiCellTable($col_widths[1], $max_height, $txt_objective);
        
        $pdf->SetXY($current_x + $col_widths[0] + $col_widths[1], $start_y);
        $pdf->MultiCellTable($col_widths[2], $max_height, $txt_indicator);
        
        // Target years
        $target_x = $current_x + $col_widths[0] + $col_widths[1] + $col_widths[2];
        $pdf->SetXY($target_x, $start_y);
        $pdf->MultiCellTable($year_width, $max_height, $target_2024);
        $pdf->SetXY($target_x + $year_width, $start_y);
        $pdf->MultiCellTable($year_width, $max_height, $target_2025);
        $pdf->SetXY($target_x + (2 * $year_width), $start_y);
        $pdf->MultiCellTable($year_width, $max_height, $target_2026);
        
        $pdf->SetXY($target_x + $col_widths[3], $start_y);
        $pdf->MultiCellTable($col_widths[4], $max_height, $txt_ppas);
        
        $pdf->SetFont('Arial', '', 8); // Set font to Arial
        $peso = 'P'; // Simple P for peso
        $pdf->MultiCellTable($col_widths[5], $max_height, $peso . ' ' . number_format($row['budget'], 2) . "\nEvery year");
        
        // Move to next row
        $pdf->SetY($start_y + $max_height);
    }
    
    $stmt->close();
}

$pdf->Output('CBYDP_General_Plan.pdf', 'I');
?>

