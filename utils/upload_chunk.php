<?php
include '../cn.php';

$tmpDir = "../uploads/tmp/";
$finalDir = "../uploads/productos/";

if (!file_exists($tmpDir)) mkdir($tmpDir, 0777, true);
if (!file_exists($finalDir)) mkdir($finalDir, 0777, true);

$fileId = $_POST['file_id'];
$chunkIndex = intval($_POST['chunk_index']);
$totalChunks = intval($_POST['total_chunks']);
$filename = basename($_POST['filename']);
$filename = preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", $filename);
$productId = intval($_POST['product_id']);

$tmpFilePath = $tmpDir . $fileId . "_" . $chunkIndex;

if (!move_uploaded_file($_FILES['chunk']['tmp_name'], $tmpFilePath)) {
    echo json_encode(["success" => false, "error" => "Error guardando chunk"]);
    exit;
}

// Verificar si llegaron todos los chunks
$allUploaded = true;
for ($i = 0; $i < $totalChunks; $i++) {
    if (!file_exists($tmpDir . $fileId . "_" . $i)) {
        $allUploaded = false;
        break;
    }
}

if ($allUploaded) {

    $finalPath = $finalDir . $fileId . "_" . $filename;
    $nomid = $fileId . "_" . $filename;
    $finalFile = fopen($finalPath, "wb");

    for ($i = 0; $i < $totalChunks; $i++) {
        $chunkFile = fopen($tmpDir . $fileId . "_" . $i, "rb");
        stream_copy_to_stream($chunkFile, $finalFile);
        fclose($chunkFile);
        unlink($tmpDir . $fileId . "_" . $i);
    }

    fclose($finalFile);

    $fileSize = filesize($finalPath);
    $fechar = date('Y-m-d H:i:s');
    // Guardar en BD
    mysqli_query($connection, "
        INSERT INTO a_producto_archivos
        (productoid, nombre, url, tamano, fechar)
        VALUES
        ('$productId', '$filename', '$nomid', '$fileSize', '$fechar')
    ");
}

echo json_encode(["success" => true]);
