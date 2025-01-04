<?php
require('../libs/fpdf/fpdf.php');
include("../connection/Connection.php");
header('Content-Type: text/html; charset=utf-8');
mysqli_set_charset($conn, "utf8mb4");

if (isset($_GET['meeting_id'])) {
    $meeting_id = intval($_GET['meeting_id']);
    

    $query = "SELECT * FROM meetings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $meeting_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pdf = new FPDF();
        
        $pdf->SetMargins(25.4, 25.4, 25.4);
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 10); 
        $pdf->SetDisplayMode('real'); 

        $attendees_query = "SELECT * FROM meeting_attendees WHERE meeting_id = ?";
        $attendees_stmt = $conn->prepare($attendees_query);
        $attendees_stmt->bind_param("i", $meeting_id);
        $attendees_stmt->execute();
        $attendees_result = $attendees_stmt->get_result();

        $attendees = ['present' => [], 'also_present' => [], 'absent' => []];
        while ($attendee = $attendees_result->fetch_assoc()) {
            $attendees[$attendee['attendance_status']][] = $attendee;
        }

        $pdf->Image('../images/Sumaguan_Logo.png', 30, 10, 40); 
        $pdf->Image('../images/SK_Logo.png', 150, 10, 40);      


        $pdf->SetY(15); 
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 8, 'Republic of the Philippines', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Province of Cebu', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Municipality of Argao', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Barangay Sumaguan', 0, 1, 'C');
        $pdf->Ln(10);


        $pdf->SetFont('Times', 'B', 12);
        $pdf->MultiCell(0, 10, 'MINUTES OF THE REGULAR SESSION OF THE SANGGUNIANG KABATAAN OF SUMAGUAN ARGAO CEBU HELD ON ' . 
            date("jS F Y, l", strtotime($row['date_of_meeting'])) . ' AT THE BARANGAY SESSION HALL', 0, 'C');
        $pdf->Ln(10);

        // Present section
        $attendees_query = "SELECT name, position FROM meeting_attendees WHERE meeting_id = ? AND attendance_status = 'present'";
        $attendees_stmt = $conn->prepare($attendees_query);
        $attendees_stmt->bind_param("i", $meeting_id);
        $attendees_stmt->execute();
        $attendees_result = $attendees_stmt->get_result();

        $pdf->SetFont('Times', 'B', 12); 
        $pdf->Cell(30, 10, 'Present:', 0, 1);
        $pdf->SetFont('Times', '', 12); 

        while ($attendee = $attendees_result->fetch_assoc()) {
            $pdf->SetX(40);
            $pdf->Cell(60, 8, 'Hon. ' . $attendee['name'], 0, 0);  
            $pdf->Cell(50, 8, '.......................', 0, 0);  
            $pdf->Cell(0, 8, $attendee['position'], 0, 1); 
        }
        $pdf->Ln(5);

        // Also Present section
        $also_present_query = "SELECT name, position FROM meeting_attendees WHERE meeting_id = ? AND attendance_status = 'also present'";
        $also_present_stmt = $conn->prepare($also_present_query);
        $also_present_stmt->bind_param("i", $meeting_id);
        $also_present_stmt->execute();
        $also_present_result = $also_present_stmt->get_result();

        $pdf->SetFont('Times', 'B', 12); 
        $pdf->Cell(30, 10, 'Also Present:', 0, 1);
        $pdf->SetFont('Times', '', 12); 

        while ($person = $also_present_result->fetch_assoc()) {
            $pdf->SetX(40);
            $pdf->Cell(60, 8, 'Hon. ' . $person['name'], 0, 0);  
            $pdf->Cell(50, 8, '.......................', 0, 0);  
            $pdf->Cell(0, 8, $person['position'], 0, 1);  
        }
        $pdf->Ln(5); 


        // Absent section
        $absent_query = "SELECT name, position FROM meeting_attendees WHERE meeting_id = ? AND attendance_status = 'absent'";
        $absent_stmt = $conn->prepare($absent_query);
        $absent_stmt->bind_param("i", $meeting_id);
        $absent_stmt->execute();
        $absent_result = $absent_stmt->get_result();

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(30, 10, 'Absent:', 0, 1);
        $pdf->SetFont('Times', '', 12);

        while ($person = $absent_result->fetch_assoc()) {
            $pdf->SetX(40); 
            $pdf->Cell(60, 8, 'Hon. ' . $person['name'], 0, 0); 
            $pdf->Cell(50, 8, '.......................', 0, 0);
            $pdf->Cell(0, 8, $person['position'], 0, 1); 
        }
        $pdf->Ln(10);  

        // Meeting sections
        $sections = [
            'A. CALL TO ORDER' => $row['call_to_order'],
            'B. INVOCATION AND SINGING OF THE NATIONAL ANTHEM' => $row['invocation'],
            'C. ROLL CALL' => $row['roll_call'],
            'D. READING AND APPROVAL OF THE PREVIOUS MINUTES' => $row['reading_minutes'],
            'G. ADJOURNMENT' => $row['adjournment']
        ];

        foreach ($sections as $title => $content) {
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(0, 10, $title, 0, 1, 'L');
            $pdf->SetFont('Times', '', 12);
            $pdf->MultiCell(0, 10, clean_text($content));
            $pdf->Ln(5);
        }

        // Agenda
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, 'E. AGENDA', 0, 1, 'L');
        $pdf->SetFont('Times', '', 12);
        
            $cleaned_agenda = clean_text($row['agenda']);
        
            preg_match_all('/\d+\.\s+.*?(?=\d+\.\s+|$)/s', $cleaned_agenda, $agenda_items);
        
            if (!empty($agenda_items[0])) {
                foreach ($agenda_items[0] as $item) {
                    $formatted_item = "          " . trim($item);
                    $pdf->MultiCell(0, 10, $formatted_item, 0, 'L'); 
                }
            }
            $pdf->Ln(5); 
        
        
        //Calendar of Business
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, 'F. CALENDAR OF BUSINESS', 0, 1, 'L');
        $pdf->SetFont('Times', 'B', 12);
        $calendar_of_business = $row['calendar_of_business'];
        $cleaned_calendar_of_business = html_entity_decode($calendar_of_business, ENT_QUOTES, 'UTF-8');
        $cleaned_calendar_of_business = str_replace(
            ["â€™", "â€œ", "â€", "â€˜", "&rsquo;", "&lsquo;", "â€¦"],
            ["'", '"', '"', "'", "'", "'", "..."],
            $cleaned_calendar_of_business
            );
        
        $pdf->Cell(0, 10, "Today's Business", 0, 1, 'L');
        $pdf->Ln(2);
        
        $pdf->SetFont('Times', '', 12);
        preg_match_all('/\d+\.\s+.*?(?=\d+\.\s+|$)/s', $cleaned_calendar_of_business, $business_items);
        
            if (!empty($business_items[0])) {
                foreach ($business_items[0] as $item) {
                    $formatted_item = "    " . trim($item);
                    $formatted_item = html_entity_decode($formatted_item, ENT_QUOTES, 'UTF-8');
                    $pdf->MultiCell(0, 10, $formatted_item, 0, 'L');
                }
                }
            $pdf->Ln(5);
        

        // Attested by section
        $pdf->SetX(120);
        $pdf->Cell(0, 10, 'Attested by:', 0, 1, 'L');
        $pdf->SetX(120);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, strtoupper($row['attested_by_name'] ?? 'Attesting Official Not Available'), 0, 1, 'C');
        $pdf->SetX(120);
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 10, $row['attested_by_position'] ?? 'Position not available', 0, 1, 'C');
        $pdf->Ln(10);

        // Prepared by section
        $pdf->SetX(120);
        $pdf->Cell(0, 10, 'Prepared by:', 0, 1, 'L');
        $pdf->SetX(120);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, strtoupper($row['prepared_by_name']), 0, 1, 'C');
        $pdf->SetX(120);
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 10, $row['prepared_by_position'], 0, 1, 'C');
        $pdf->Ln(10);


        $pdf->Output('I', 'meeting_minutes_' . $meeting_id . '.pdf');
    }
}

function clean_text($text) {
    return trim(preg_replace('/\s+/', ' ', $text));
}
?>
