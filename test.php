<?php
session_start();
if (empty($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

$api_key = '';
$ai_response = '';
$domanda_corrente = '';

require_once 'assets/fpdf/fpdf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['domanda']) && !empty($_POST['domanda'])) {
        $domanda = htmlspecialchars($_POST['domanda']);
        $domanda_corrente = $domanda;
        $_SESSION['domanda_corrente'] = $domanda;

        // Prepara la richiesta per Cohere usando la domanda dal form
        $url = "https://api.cohere.com/v2/chat";
        $data = [
            "model" => "command-r-plus-08-2024",
            "messages" => [
                ["role" => "user", "content" => $domanda]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $api_key",
            "Content-Type: application/json",
            "Accept: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            $ai_response = "Errore nella richiesta cURL.";
        } else {
            $response_data = json_decode($response, true);
            if (isset($response_data['message']['content'][0]['text'])) {
                $ai_response = $response_data['message']['content'][0]['text'];
            } else {
                $ai_response = "Errore nella risposta dell'API: " . json_encode($response_data);
            }
        }
    } elseif (isset($_POST['salva_pdf']) && !empty($_POST['risposta_ai'])) {
        $risposta_ai = $_POST['risposta_ai'];
        $domanda = isset($_SESSION['domanda_corrente']) ? $_SESSION['domanda_corrente'] : '';

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(20, 20, 20);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Risposta AI', 0, 1, 'C');
        $pdf->Ln(5);

        if (!empty($domanda)) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, 'Domanda:', 0, 1);
            $pdf->SetFont('Arial', '', 12);
            if (function_exists('iconv')) {
                $domanda_iso = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $domanda);
            } else {
                $domanda_iso = mb_convert_encoding($domanda, 'ISO-8859-1', 'UTF-8');
            }
            $pdf->MultiCell(0, 8, $domanda_iso);
            $pdf->Ln(5);
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'Risposta:', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        if (function_exists('iconv')) {
            $risposta_ai_iso = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $risposta_ai);
        } else {
            $risposta_ai_iso = mb_convert_encoding($risposta_ai, 'ISO-8859-1', 'UTF-8');
        }
        $pdf->MultiCell(0, 8, $risposta_ai_iso);

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="risposta_ai.pdf"');
        $pdf->Output('D', 'risposta_ai.pdf');
        exit;
    }
}
?>

<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Domanda AI - LearnTogether</title>
    <meta name="description" content="Domanda AI - LearnTogether">
    <meta name="author" content="Nikita Bolognesi">
    <link rel="icon" href="images/logo.png" type="image/png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php include("includes/navbar.php"); ?>

    <main>
        <section class="section-padding section-bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12 mx-auto">
                        <div class="custom-text-box text-center">
                            <h2 class="mb-2">Fai una domanda all'AI</h2>
                            <p class="mb-4">Scrivi la tua domanda qui sotto e ricevi una risposta generata dall'intelligenza artificiale.</p>
                            <form method="post" class="mb-4">
                                <div class="mb-3 text-start">
                                    <label for="domanda" class="form-label">Domanda</label>
                                    <textarea name="domanda" id="domanda" class="form-control" rows="4" required><?php echo isset($_POST['domanda']) ? htmlspecialchars($_POST['domanda']) : ''; ?></textarea>
                                </div>
                                <button type="submit" class="custom-btn btn w-100">Invia</button>
                            </form>
                            <?php if (!empty($ai_response)): ?>
                                <hr>
                                <?php
                                    $alert_class = (stripos($ai_response, 'errore') !== false) ? 'alert-danger' : 'alert-info';
                                ?>
                                <div class="alert <?php echo $alert_class; ?> mt-4" id="risposta_ai">
                                    <strong>Risposta:</strong><br>
                                    <?php echo nl2br(htmlspecialchars($ai_response)); ?>
                                </div>
                                <form method="post" class="mt-3">
                                    <input type="hidden" name="risposta_ai" value="<?php echo htmlspecialchars($ai_response); ?>">
                                    <button type="submit" name="salva_pdf" class="custom-btn btn btn-success w-100">Salva in PDF</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include("includes/footer.php"); ?>
    <script src="js/click-scroll.js"></script>
</body>
</html>