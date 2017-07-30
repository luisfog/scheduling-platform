<?php
	ini_set('display_errors', '0');
	session_start();
	if(!isset($_SESSION['user'])){
		header('Location: ../index.html' );
		return;
	}
	
	function sendIcalEvent($uid, $from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location)
	{
		$mime_boundary = "----Meeting Booking----".MD5(TIME());

		$headers = "From: ".$from_name." <".$from_address.">\n";
		$headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
		$headers .= "Content-class: urn:content-classes:calendarmessage\n";
		
		$message = "--$mime_boundary\r\n";
		$message .= "Content-Type: text/html; charset=UTF-8\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= "<html>\n";
		$message .= "<body>\n";
		$message .= '<p>Dear '.$to_name.',</p>';
		$message .= '<p>'.$description.'</p>';
		$message .= "</body>\n";
		$message .= "</html>\n";
		$message .= "--$mime_boundary\r\n";

		$ical = 'BEGIN:VCALENDAR' . "\r\n" .
		'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
		'VERSION:2.0' . "\r\n" .
		'METHOD:REQUEST' . "\r\n" .
		'BEGIN:VTIMEZONE' . "\r\n" .
		'TZID:Eastern Time' . "\r\n" .
		'BEGIN:STANDARD' . "\r\n" .
		'DTSTART:20091101T020000' . "\r\n" .
		'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
		'TZOFFSETFROM:-0400' . "\r\n" .
		'TZOFFSETTO:-0500' . "\r\n" .
		'TZNAME:EST' . "\r\n" .
		'END:STANDARD' . "\r\n" .
		'BEGIN:DAYLIGHT' . "\r\n" .
		'DTSTART:20090301T020000' . "\r\n" .
		'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
		'TZOFFSETFROM:-0500' . "\r\n" .
		'TZOFFSETTO:-0400' . "\r\n" .
		'TZNAME:EDST' . "\r\n" .
		'END:DAYLIGHT' . "\r\n" .
		'END:VTIMEZONE' . "\r\n" .	
		'BEGIN:VEVENT' . "\r\n" .
		'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
		'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
		'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
		'UID:'.$uid."\r\n" .
		'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
		'DTSTART;TZID=Europe/Lisbon:'.date("Ymd\THis", $startTime). "\r\n" .
		'DTEND;TZID=Europe/Lisbon:'.date("Ymd\THis", $endTime). "\r\n" .
		'TRANSP:OPAQUE'. "\r\n" .
		'SEQUENCE:1'. "\r\n" .
		'SUMMARY:' . $subject . "\r\n" .
		'LOCATION:' . $location . "\r\n" .
		'CLASS:PUBLIC'. "\r\n" .
		'PRIORITY:5'. "\r\n" .
		'BEGIN:VALARM' . "\r\n" .
		'TRIGGER:-PT15M' . "\r\n" .
		'ACTION:DISPLAY' . "\r\n" .
		'DESCRIPTION:Reminder' . "\r\n" .
		'END:VALARM' . "\r\n" .
		'END:VEVENT'. "\r\n" .
		'END:VCALENDAR'. "\r\n";
		$message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $ical;

		$mailsent = mail($to_address, $subject, $message, $headers);

		return ($mailsent)?(true):(false);
	}
	
	function cancelIcalEvent($uid, $from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location)
	{
		$mime_boundary = "----Meeting Booking----".MD5(TIME());

		$headers = "From: ".$from_name." <".$from_address.">\n";
		$headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
		$headers .= "Content-class: urn:content-classes:calendarmessage\n";
		
		$message = "--$mime_boundary\r\n";
		$message .= "Content-Type: text/html; charset=UTF-8\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= "<html>\n";
		$message .= "<body>\n";
		$message .= '<p>Dear '.$to_name.',</p>';
		$message .= '<p>'.$description.'</p>';
		$message .= "</body>\n";
		$message .= "</html>\n";
		$message .= "--$mime_boundary\r\n";

		$ical = 'BEGIN:VCALENDAR' . "\r\n" .
		'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
		'VERSION:2.0' . "\r\n" .
		'METHOD:CANCEL' . "\r\n" .
		'BEGIN:VTIMEZONE' . "\r\n" .
		'TZID:Eastern Time' . "\r\n" .
		'BEGIN:STANDARD' . "\r\n" .
		'DTSTART:20091101T020000' . "\r\n" .
		'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
		'TZOFFSETFROM:-0400' . "\r\n" .
		'TZOFFSETTO:-0500' . "\r\n" .
		'TZNAME:EST' . "\r\n" .
		'END:STANDARD' . "\r\n" .
		'BEGIN:DAYLIGHT' . "\r\n" .
		'DTSTART:20090301T020000' . "\r\n" .
		'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
		'TZOFFSETFROM:-0500' . "\r\n" .
		'TZOFFSETTO:-0400' . "\r\n" .
		'TZNAME:EDST' . "\r\n" .
		'END:DAYLIGHT' . "\r\n" .
		'END:VTIMEZONE' . "\r\n" .	
		'BEGIN:VEVENT' . "\r\n" .
		'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
		'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
		'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
		'UID:'.$uid."\r\n" .
		'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
		'DTSTART;TZID=Europe/Lisbon:'.date("Ymd\THis", $startTime). "\r\n" .
		'DTEND;TZID=Europe/Lisbon:'.date("Ymd\THis", $endTime). "\r\n" .
		'TRANSP:OPAQUE'. "\r\n" .
		'SEQUENCE:2'. "\r\n" .
		'STATUS:CANCELLED'. "\r\n" .
		'SUMMARY:' . $subject . "\r\n" .
		'LOCATION:' . $location . "\r\n" .
		'CLASS:PUBLIC'. "\r\n" .
		'PRIORITY:5'. "\r\n" .
		'BEGIN:VALARM' . "\r\n" .
		'TRIGGER:-PT15M' . "\r\n" .
		'ACTION:DISPLAY' . "\r\n" .
		'DESCRIPTION:Reminder' . "\r\n" .
		'END:VALARM' . "\r\n" .
		'END:VEVENT'. "\r\n" .
		'END:VCALENDAR'. "\r\n";
		$message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $ical;

		$mailsent = mail($to_address, $subject, $message, $headers);

		return ($mailsent)?(true):(false);
	}
	
	function sendMail($from_name, $from_address, $to_name, $to_address, $subject, $message)
	{
		$headers = "From: ".$from_name." <".$from_address.">\n";
		$headers .= "Reply-To: ".$from_name." <".$from_address.">\n";		

		$mailsent = mail($to_address, $subject, $message, $headers);

		return ($mailsent)?(true):(false);
	}
?>