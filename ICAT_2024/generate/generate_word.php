<?php
ob_start(); // Start output buffering

// Include library
require('TCPDF/tcpdf.php');
$conn = mysqli_connect("localhost", "root", "", "rohanne");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = isset($_POST['id']) ? $_POST['id'] : '';

if (!empty($id)) {

    class MYPDF extends TCPDF
    {
        // Page header
        public function Header()
        {
            // Logo
            $this->Ln(10);

            $this->SetFont('Times', '', 9);
            $this->Cell(180, 1, 'Republic of the Philippines', 0, 1, 'C');
            $this->Cell(180, 1, 'ILOCOS SUR POLYTECHNIC STATE COLLEGE', 0, 1, 'C');
            $this->Cell(180, 1, 'Tagudin Ilocos Sur', 0, 1, 'C');

            $this->SetFont('Times', '', 9);
            $this->Cell(180, 1, 'ISPSC College Admission Test (ICAT) Results', 0, 1, 'C');
            $this->Cell(180, 1, 'A.Y. 2024-2025', 0, 1, 'C');
            $this->Ln(10);

            // Add box with content
        $this->SetY(10); // Position to add box
        $this->SetX(130); // Position to add box
        $this->SetFillColor(255, 255, 255); // Set box fill color (white)
        $this->SetDrawColor(0, 0, 0); // Set box border color (black)
        $this->SetLineWidth(0.2); // Set box border width
        $this->Cell(70, 8, 'Student Copy to be Submitted to the College Dean', 1, 0, 'C', true); // Draw box with content
        }
        // Page footer
        public function Footer()
        {
            $this->setY(-15);
        }
    }

    $pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set document information
    $pdf->setCreator(PDF_CREATOR);
    $pdf->setAuthor('Unknown');
    $pdf->setTitle('Word');
    $pdf->setSubject('TCPDF Offline');
    $pdf->setKeywords('TCPDF, PDF, example, test, guide');

    // Set default header data
    $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // Set default monospaced font
    $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // Set margins
    $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);

    // Set auto page breaks
    $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------
// SQL query to retrieve applicants with the selected strand
$applicantQuery = "SELECT * FROM tbl_applicants WHERE id ='$id'";
$result = $conn->query($applicantQuery);

while ($applicant = $result->fetch_assoc()) {
    // Add a page
    $pdf->AddPage();
    $pdf->Ln(10);

    // Set font
    $pdf->SetFont('times', '', 9);

    // Get page dimensions
    $pageWidth = $pdf->getPageWidth();
    $pageHeight = $pdf->getPageHeight();

    // Calculate the position for centering the logo
    $logoWidth = 100; // Adjust this according to the resized logo width
    $logoHeight = 100; // Adjust this according to the resized logo height
    $logoX = ($pageWidth - $logoWidth) / 2;
    $logoY = ($pageHeight - $logoHeight) / 5;

    // Set background image with adjusted size and centered position
    $pdf->Image('../background/logo.jpg', $logoX, $logoY, $logoWidth, $logoHeight, '', '', '', false, 100, '', false, false, 0);

    // Extract applicant information
    $firstname = $applicant['firstname'];
    $midname = $applicant['midname'];
    $lastname = $applicant['lastname'];
    $sex = $applicant['sex'];
    $strand = $applicant['strand'];
    $course = $applicant['course'];
    $genAbility = $applicant['genAbility'];
    $verbal = $applicant['verbal'];
    $numerical = $applicant['numerical'];
    $s_patial = $applicant['s_patial'];
    $p_erceptual = $applicant['p_erceptual'];
    $m_anDexterity = $applicant['m_anDexterity'];
    $date_taken = $applicant['date_taken'];

        // Create table for the applicant information
        $pdf->Cell(75, 5, "$lastname", 'LTR', 0, 'C');
        $pdf->Cell(75, 5, "$firstname", 'LTR', 0, 'C');
        $pdf->Cell(30, 5, "$midname", 'LTR', 1, 'C');

        $pdf->Cell(75, 5, "(Family Name)", 'LRB', 0, 'C'); // Remove top border
        $pdf->Cell(75, 5, "(First Name)", 'LRB', 0, 'C'); // Remove top border
        $pdf->Cell(30, 5, "(Middle Name)", 'LRB', 0, 'C'); // Remove top border

        $pdf->Ln(9);

        $pdf->Cell(75, 5, "$strand", 'LTR', 0, 'C');
        $pdf->Cell(75, 5, "$course", 'LTR', 0, 'C');
        $pdf->Cell(30, 5, " ", 'LTR', 1, 'C');

        $pdf->Cell(75, 5, "(SHS Strand)", 'LRB', 0, 'C');
        $pdf->Cell(75, 5, "(Course)", 'LRB', 0, 'C');
        $pdf->Cell(30, 5, "(Remark)", 'LRB', 0, 'C');

        $pdf->Ln(9);

        // Write HTML content
        $pdf->writeHTML("
            <style>
                h5 {
                    margin-top: 50px;
                }

                p {
                    text-align: justify;
                    text-indent: 70px;
                }
            </style>
            <h5> Greetings from ISPSC! </h5>
            <p>We are happy to inform you that you got the following ratings in the ICAT that you have taken last <B><U>$date_taken</U></B> (Date of Examination)</p>
        ");

        $pdf->Ln(5);

        // Write HTML content for abilities
        $pdf->Cell(40, 5, 'General Ability', 1, 0, 'C');
        $pdf->Cell(20, 5, $genAbility, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Verbal Aptitude', 1, 0, 'C');
        $pdf->Cell(20, 5, $verbal, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Numerical Aptitude', 1, 0, 'C');
        $pdf->Cell(20, 5, $numerical, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Spatial Aptitude', 1, 0, 'C');
        $pdf->Cell(20, 5, $s_patial, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Perceptual Aptitude', 1, 0, 'C');
        $pdf->Cell(20, 5, $p_erceptual, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Manual Dexterity', 1, 0, 'C');
        $pdf->Cell(20, 5, $m_anDexterity, 1, 1, 'C');
        // Rest of the ability cells...

        $pdf->Ln(2);

        // Write additional HTML content
        $pdf->writeHTML("
            <style>
                h1, h3 {
                    text-align: center;
                }

                h5 {
                    margin-top: 50px;
                }

                p {
                    text-align: justify;
                    text-indent: 50px;
                }
            </style>
            <p>Present this result upon enrollment to your enrollment officer.</p>
            <h5> Welcome to ISPSC! </h5>
            <h5>Truly Yours <br> _________________________</h5>
        ");

        $pdf->Ln(5);

        // Draw a visible break line
$pdf->SetLineWidth(0.1); // Set line width
$pdf->SetDrawColor(0, 0, 0); // Set line color (black)
$pdf->Line(15, $pdf->getY(), 195, $pdf->getY()); // Draw a line from left to right at current Y position
$pdf->Ln(2); // Add some space after the line

$pdf->SetFont('Times', '', 9);
$pdf->Cell(31, 8, '', 0, 0, 'C'); // Draw box with content
$pdf->SetX($pdf->GetX() + 123); // Move the position to the right
$pdf->Cell(31, 8, 'Guidance Office Copy', 1, 0, 'C'); // Draw box with content
$pdf->Ln(2);




        // Header content...
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(180, 1, 'Republic of the Philippines', 0, 1, 'C');
            $pdf->Cell(180, 1, 'ILOCOS SUR POLYTECHNIC STATE COLLEGE', 0, 1, 'C');
            $pdf->Cell(180, 1, 'Tagudin Ilocos Sur', 0, 1, 'C');
            $pdf->Cell(179, 1, 'ISPSC College Admission Test (ICAT) Results', 0, 1, 'C');
            $pdf->Cell(179, 1, 'A.Y. 2024-2025', 0, 1, 'C');
            $pdf->Ln(2);

            // Get page dimensions
    $secondpageWidth = $pdf->getPageWidth();
    $secondpageHeight = $pdf->getPageHeight();

    // Calculate the position for centering the logo
    $secondlogoWidth = 100; // Adjust this according to the resized logo width
    $secondlogoHeight = 100; // Adjust this according to the resized logo height
    $secondlogoX = ($secondpageWidth - $secondlogoWidth) / 2;
    $secondlogoY = ($secondpageHeight - $secondlogoHeight) * 0.85;

    // Set background image with adjusted size and centered position
    $pdf->Image('../background/logo.jpg', $secondlogoX, $secondlogoY, $secondlogoWidth, $secondlogoHeight, '', '', '', false, 300, '', false, false, 0);

        // Create table for the applicant information
        $pdf->Cell(75, 5, "$lastname", 'LTR', 0, 'C');
        $pdf->Cell(75, 5, "$firstname", 'LTR', 0, 'C');
        $pdf->Cell(30, 5, "$midname", 'LTR', 1, 'C');

        $pdf->Cell(75, 5, "(Family Name)", 'LRB', 0, 'C'); // Remove top border
        $pdf->Cell(75, 5, "(First Name)", 'LRB', 0, 'C'); // Remove top border
        $pdf->Cell(30, 5, "(Middle Name)", 'LRB', 0, 'C'); // Remove top border

        $pdf->Ln(10);

        $pdf->Cell(75, 5, "$strand", 'LTR', 0, 'C');
        $pdf->Cell(75, 5, "$course", 'LTR', 0, 'C');
        $pdf->Cell(30, 5, " ", 'LTR', 1, 'C');

        $pdf->Cell(75, 5, "(SHS Strand)", 'LRB', 0, 'C');
        $pdf->Cell(75, 5, "(Course)", 'LRB', 0, 'C');
        $pdf->Cell(30, 5, "(Remark)", 'LRB', 0, 'C');

        $pdf->Ln(9);

        // Write HTML content
        $pdf->writeHTML("
            <style>
                h5 {
                    margin-top: 50px;
                }

                p {
                    text-align: justify;
                    text-indent: 50px;
                }
            </style>
            <h5> Greetings from ISPSC! </h5>
            <p>We are happy to inform you that you got the following ratings in the ICAT that you have taken last <B><U>$date_taken</U></B> (Date of Examination)</p>
        ");

        $pdf->Ln(5);

        // Write HTML content for abilities
        $pdf->Cell(40, 5, 'General Ability', 1, 0, 'C');
        $pdf->Cell(20, 5, $genAbility, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Verbal Aptitude', 1, 0, 'C');
        $pdf->Cell(20, 5, $verbal, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Numerical Aptitude', 1, 0, 'C');
        $pdf->Cell(20, 5, $numerical, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Spatial Aptitude', 1, 0, 'C');
        $pdf->Cell(20, 5, $s_patial, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Perceptual Aptitude', 1, 0, 'C');
        $pdf->Cell(20, 5, $p_erceptual, 1, 1, 'C');
        $pdf->Cell(40, 5, 'Manual Dexterity', 1, 0, 'C');
        $pdf->Cell(20, 5, $m_anDexterity, 1, 1, 'C');
        // Rest of the ability cells...

        $pdf->Ln(2);

        // Write additional HTML content
        $pdf->writeHTML("
            <style>
                h1, h3 {
                    text-align: center;
                }

                h5 {
                    margin-top: 50px;
                }

                p {
                    text-align: justify;
                    text-indent: 70px;
                }
            </style>
            <p>Present this result upon enrollment to your enrollment officer.</p>
            <h5>Welcome to ISPSC!</h5>
            <h5>Truly Yours <br> _________________________</h5>
        ");

        // Add spacing between duplicated contents
        if ($i < 1) {
            $pdf->Ln(20);
        }
    }
    // Clean the output buffer
    ob_end_clean();

    // Output the PDF
    $pdf->Output();
} else {
    echo "Error: Strand ID not provided.";
    exit(); // Stop further execution
}

mysqli_close($conn);
?>