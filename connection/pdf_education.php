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

    function WrapCell($width, $height, $text)
    {
        $x = $this->GetX();
        $y = $this->GetY();
        $this->MultiCell($width, $height, $text, 1, 'L');
        $this->SetXY($x + $width, $y);
    }
}


$pdf = new PDF($year);
$pdf->AddPage('L', array(420, 297)); // A4 landscape size


$pdf->SetFont('Arial', 'B', 10);
$header = [
    'REFERENCE CODE',
    'PPAs',
    'DESCRIPTION',
    'EXPECTED RESULT',
    'PERFORMANCE INDICATOR',
    'PERIOD OF IMPLEMENTATION',
    'BUDGET',
    'PERSON RESPONSIBLE'
];


$w = [
    30, 
    30, 
    50,
    50, 
    40, 
    30, 
    90, 
    50  
];


foreach ($header as $i => $col) {
    $pdf->Cell($w[$i], 10, $col, 1, 0, 'C');
}
$pdf->Ln();


$pdf->Cell(30, 10, '', 0); 
$pdf->Cell(30, 10, '', 0); 
$pdf->Cell(50, 10, '', 0); 
$pdf->Cell(50, 10, '', 0); 
$pdf->Cell(40, 10, '', 0); 
$pdf->Cell(30, 10, 'BUDGET', 1, 0, 'C'); 
$pdf->Cell(30, 10, '', 0); 
$pdf->Cell(30, 10, '', 0); 
$pdf->Ln();

$pdf->Cell(30, 10, '', 0); 
$pdf->Cell(30, 10, '', 0);
$pdf->Cell(50, 10, '', 0); 
$pdf->Cell(50, 10, '', 0); 
$pdf->Cell(40, 10, '', 0);
$pdf->Cell(30, 10, 'MOOE', 1, 0, 'C');
$pdf->Cell(30, 10, 'CO', 1, 0, 'C'); 
$pdf->Cell(30, 10, 'TOTAL', 1, 1, 'C'); 


$pdf->SetFont('Arial', '', 10);


foreach ($data_entries as $data) {
    $description = "GIVING OF EDUCATIONAL SUPPLIES AND ASSISTANCE"; 

    $pdf->Cell($w[0], 10, $data['reference_code'], 1); 
    $pdf->Cell($w[1], 10, $data['ppas'], 1); 
    $pdf->Cell($w[2], 10, $description, 1);
    $pdf->Cell($w[3], 10, $data['expected_result'], 1); 
    $pdf->Cell($w[4], 10, $data['performance_indicator'], 1); 
    $pdf->Cell($w[5], 10, $data['period_of_implementation'], 1);
    
    $pdf->Cell(30, 10, '₱' . number_format($data['mooe'], 2), 1, 0, 'C'); 
    $pdf->Cell(30, 10, '₱' . number_format($data['co'], 2), 1, 0, 'C');
    $pdf->Cell(30, 10, '₱' . number_format($data['total'], 2), 1, 1, 'C'); 

    $pdf->Cell($w[7], 10, $data['person_responsible'], 1); 
}

$pdf->Output('I', 'Education_' . $year . '_' . $month . '.pdf');
?>