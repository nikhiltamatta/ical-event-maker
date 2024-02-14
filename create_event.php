<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventTitle = $_POST['eventTitle'];
    $eventStartDate = date('Ymd\THis', strtotime($_POST['eventStartDate']));
    $eventEndDate = date('Ymd\THis', strtotime($_POST['eventEndDate']));
    $allDay = $_POST['allDay'] == '1' ? true : false;
    $eventLocation = isset($_POST['eventLocation']) ? $_POST['eventLocation'] : '';
    $eventURL = isset($_POST['eventURL']) ? $_POST['eventURL'] : '';
    $eventDescription = $_POST['eventDescription'];

    // Generate iCAL file content
    $ical_content = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . uniqid() . "
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:" . $eventStartDate . "Z\n";

    if ($allDay) {
        $ical_content .= "DTEND:" . date('Ymd', strtotime($_POST['eventEndDate'])) . "Z\n";
    } else {
        $ical_content .= "DTEND:" . $eventEndDate . "Z\n";
    }

    $ical_content .= "SUMMARY:$eventTitle\n";

    if (!empty($eventLocation)) {
        $ical_content .= "LOCATION:$eventLocation\n";
    }

    if (!empty($eventURL)) {
        $ical_content .= "URL:$eventURL\n";
    }

    $ical_content .= "DESCRIPTION:$eventDescription
END:VEVENT
END:VCALENDAR";

    // Set headers for file download
    header('Content-Type: text/calendar');
    header('Content-Disposition: attachment; filename="event.ics"');

    // Output iCAL content
    echo $ical_content;
    exit();
}
?>
