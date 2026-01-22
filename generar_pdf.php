<?php
// Verificar si se recibió el contenido del ticket
if (isset($_POST['ticketContent'])) {
    // Crear un nuevo documento PDF
    require_once 'fpdf.php'; // Asegúrate de descargar e incluir la librería FPDF

    // Crear una instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar el contenido del ticket
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, $_POST['ticketContent']);

    // Generar el PDF
    $pdf->Output('ticket.pdf', 'D'); // 'D' indica que se descargará el PDF

    // Finalizar el script
    exit();
} else {
    // Si no se recibió el contenido del ticket, redirigir o mostrar un mensaje de error
    echo "Error: No se recibió el contenido del ticket.";
}
?>
