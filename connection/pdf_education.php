<?php
require('../libs/fpdf/fpdf.php');
include("../connection/Connection.php");

if (!isset($_GET['table']) || !isset($_GET['year']) || !isset($_GET['month'])) {
    echo "Missing parameters.";
    exit;
}

$table = preg_replace('/[^a-zA-Z_]/', '', $_GET['table']);
$year = intval($_GET['year']);
$month = preg_replace('/[^a-zA-Z]/', '', $_GET['month']);

if (empty($table) || $year <= 0 || empty($month)) {
    echo "Invalid parameters.";
    exit;
}

$allowed_tables = ['pa_education'];
if (!in_array($table, $allowed_tables)) {
    echo "Invalid table specified.";
    exit;
}

$query = "SELECT * FROM $table WHERE calendar_year = ? AND period_of_implementation = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $year, $month);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No data found for the specified year and month.";
    exit;
}

$data_entries = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

// Define column widths with wider Period of Implementation column
$w = [25, 40, 60, 60, 40, 45, 90, 50]; // Changed performance indicator from 50 to 40
$fixed_height = 20; // Fixed height for all rows

class PDF extends FPDF
{
    protected $headerYear;

    function __construct($year)
    {
        parent::__construct();
        $this->headerYear = $year;
    }

    function Header()
    {
        $this->SetFont('Arial', '', 11);
        $this->Image('../images/SK.png', 120, 10, 40);
        $this->SetXY(200, 10);
        $this->Image('../images/Sumaguan_Logo.png', 260, 13, 35);

        $this->Ln(8);
        $this->Cell(0, 10, 'Republic of the Philippines', 0, 1, 'C');
        $this->Ln(-5);
        $this->Cell(0, 10, 'Province of Cebu', 0, 1, 'C');
        $this->Ln(-5);
        $this->Cell(0, 10, 'Municipality of ARGAO', 0, 1, 'C');
        $this->Ln(-5);
        $this->SetX(189);
        $this->Cell(0, 10, 'Barangay', 0, 0, 'L');
        $this->SetX(207);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 10, 'SUMAGUAN', 0, 1, 'L');

        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 10, 'OFFICE OF THE SANGGUNIANG KABATAAN', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 10, 'ANNUAL BARANGAY YOUTH INVESTMENT PLAN (ABYIP)', 0, 1, 'C');
        $this->SetFont('Arial', '', 11);
        $this->Ln(-5);
        $this->SetX(0);
        $this->Cell(0, 10, 'CALENDAR YEAR: ', 0, 0, 'C');
        $this->SetX(45);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 10, $this->headerYear, 0, 1, 'C');
        $this->SetFont('Arial', '', 11);

        $this->SetX(169);
        $this->Cell(0, 10, 'CENTER OF PARTICIPATION: ', 0, 0, 'L');
        $this->SetFont('Arial', 'B', 11);
        $this->SetX(65);
        $this->Cell(0, 10, 'EDUCATION', 0, 1, 'C');
    }

    // Modified MultiCellTable function with fixed height
    function MultiCellTable($w, $h, $txt, $border=1, $align='L', $fill=false)
    {
        $x = $this->GetX();
        $y = $this->GetY();

        // Draw cell border
        $this->Cell($w, $h, '', $border, 0, $align, $fill);

        // Calculate text padding to center vertically
        $lines = $this->NbLines($w, $txt);
        $dy = ($h - ($lines * 5)) / 2; // 5 is the standard line height
        
        // Print text with padding
        $this->SetXY($x, $y + $dy);
        $this->MultiCell($w, 5, $txt, 0, $align, $fill);

        // Return to right side of cell
        $this->SetXY($x + $w, $y);
    }

    // Helper function to count number of lines
    function NbLines($w, $txt)
    {
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
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
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
            if($l>$wmax)
            {
                if($sep==-1)
                {
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
}

$pdf = new PDF($year);
$pdf->AddPage('L', array(420, 297)); // A3 landscape size

// First row of headers
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($w[0], 10, 'REFERENCE', 'LTR', 0, 'C');
$pdf->Cell($w[1], 20, 'PPAs', 1, 0, 'C');
$pdf->Cell($w[2], 20, 'DESCRIPTION', 1, 0, 'C');
$pdf->Cell($w[3], 20, 'EXPECTED RESULT', 1, 0, 'C');
$pdf->Cell($w[4], 20, 'PERFORMANCE INDICATOR', 1, 0, 'C');
$pdf->Cell($w[5], 10, 'PERIOD OF', 'LTR', 0, 'C');
$pdf->Cell(90, 10, 'BUDGET', 1, 0, 'C');
$pdf->Cell($w[7], 20, 'PERSON RESPONSIBLE', 1, 1, 'C');

// Second row for split headers
$pdf->SetXY($pdf->GetX(), $pdf->GetY() - 10);
$pdf->Cell($w[0], 10, 'CODE', 'LBR', 0, 'C');
$pdf->SetXY($pdf->GetX() + $w[1] + $w[2] + $w[3] + $w[4], $pdf->GetY());
$pdf->Cell($w[5], 10, 'IMPLEMENTATION', 'LBR', 0, 'C');

// Budget subheaders
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->Cell(30, 10, 'MOOE', 1, 0, 'C');
$pdf->Cell(30, 10, 'CO', 1, 0, 'C');
$pdf->Cell(30, 10, 'TOTAL', 1, 1, 'C');

// Reset position for data rows
$pdf->SetY($y + 10);

// Data rows with fixed height
$pdf->SetFont('Arial', '', 10);
foreach ($data_entries as $data) {
    // Reference Code
    $pdf->Cell($w[0], $fixed_height, $data['reference_code'], 1, 0, 'C');
    
    // PPAs
    $pdf->MultiCellTable($w[1], $fixed_height, $data['ppas'], 1, 'L');
    
    // Description
    $pdf->MultiCellTable($w[2], $fixed_height, $data['description'], 1, 'L');
    
    // Expected Result
    $pdf->MultiCellTable($w[3], $fixed_height, $data['expected_result'], 1, 'L');
    
    // Performance Indicator
    $pdf->MultiCellTable($w[4], $fixed_height, $data['performance_indicator'], 1, 'L');
    
    // Period of Implementation (wider column)
    $pdf->Cell($w[5], $fixed_height, $data['period_of_implementation'], 1, 0, 'C');
    
    // Budget columns
    $pdf->Cell(30, $fixed_height, '₱' . number_format($data['mooe'], 2), 1, 0, 'R');
    $pdf->Cell(30, $fixed_height, '₱' . number_format($data['co'], 2), 1, 0, 'R');
    $pdf->Cell(30, $fixed_height, '₱' . number_format($data['total'], 2), 1, 0, 'R');
    
    // Person Responsible
    $pdf->MultiCellTable($w[7], $fixed_height, $data['person_responsible'], 1, 'L');
    
    $pdf->Ln($fixed_height);
}

$pdf->Output('I', 'Education_' . $year . '_' . $month . '.pdf');
?>