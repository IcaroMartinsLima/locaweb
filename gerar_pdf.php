<?php

require_once "conexao.php";
require_once "fpdf.php";

header("Content-Type: application/pdf");

$data_inicio = trim($_GET["data_inicio"] ?? "");
$data_fim = trim($_GET["data_fim"] ?? "");
$produto_id = trim($_GET["produto_id"] ?? "");
$produto_tipo_id = trim($_GET["produto_tipo_id"] ?? "");
$cliente_id = trim($_GET["cliente_id"] ?? "");

$where = [];
$params = [];

if ($data_inicio) {
    $where[] = "f.datahora >= ?";
    $params[] = $data_inicio;
}
if ($data_fim) {
    $where[] = "f.datahora <= ?";
    $params[] = $data_fim;
}
if ($produto_id) {
    $where[] = "f.produto_id = ?";
    $params[] = $produto_id;
}
if ($produto_tipo_id) {
    $where[] = "p.produto_tipo_id = ?";
    $params[] = $produto_tipo_id;
}
if ($cliente_id) {
    $where[] = "f.cliente_id = ?";
    $params[] = $cliente_id;
}

$sql_where = $where ? "WHERE " . implode(" AND ", $where) : "";

$sql = "
    SELECT f.feedback_id, f.nota, f.observacao, f.datahora,
           p.nome AS produto_nome, p.descricao AS produto_descricao,
           t.descricao AS tipo_descricao,
           pes.nome AS cliente_nome, pes.cpf AS cliente_cpf
    FROM tbFeedBack f
    INNER JOIN tbProdutos p ON f.produto_id = p.produto_id
    LEFT JOIN tbProdutoTipo t ON p.produto_tipo_id = t.material_tipo_id
    LEFT JOIN tbPessoas pes ON f.cliente_id = pes.pessoa_id
    $sql_where
    ORDER BY f.datahora DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$feedbacks = $stmt->fetchAll();

$total = count($feedbacks);
$somaNotas = 0;
$produtosAvaliados = [];
foreach ($feedbacks as $f) {
    $somaNotas += (int)$f["nota"];
    $produtosAvaliados[$f["produto_nome"]] = true;
}
$mediaNotas = $total > 0 ? round($somaNotas / $total, 1) : 0;
$qtdProdutos = count($produtosAvaliados);

class PDF extends FPDF
{
    private $data_inicio;
    private $data_fim;

    public function setFiltros($data_inicio, $data_fim)
    {
        $this->data_inicio = $data_inicio;
        $this->data_fim = $data_fim;
    }

    public function Header()
    {
        $this->SetFillColor(55, 48, 163);
        $this->Rect(0, 0, 210, 42, "F");

        $this->SetTextColor(255, 255, 255);
        $this->SetFont("Helvetica", "B", 20);
        $this->SetXY(10, 8);
        $this->Cell(0, 10, "UniversalScore", 0, 0, "L");

        $this->SetFont("Helvetica", "", 10);
        $this->SetXY(10, 22);
        $this->Cell(0, 8, utf8_decode("Relatório de Avaliações"), 0, 0, "L");

        $filtroTexto = "Todos os períodos";
        if ($this->data_inicio && $this->data_fim) {
            $filtroTexto = date("d/m/Y", strtotime($this->data_inicio)) . " a " . date("d/m/Y", strtotime($this->data_fim));
        } elseif ($this->data_inicio) {
            $filtroTexto = "A partir de " . date("d/m/Y", strtotime($this->data_inicio));
        } elseif ($this->data_fim) {
            $filtroTexto = "Até " . date("d/m/Y", strtotime($this->data_fim));
        }
        $this->SetFont("Helvetica", "", 9);
        $this->SetXY(10, 30);
        $this->Cell(0, 6, utf8_decode("Período: " . $filtroTexto), 0, 0, "L");

        $this->SetFont("Helvetica", "", 8);
        $this->SetXY(10, 36);
        $this->Cell(0, 5, utf8_decode("Gerado em: " . date("d/m/Y H:i")), 0, 0, "L");

        $this->Ln(44);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont("Helvetica", "I", 8);
        $this->SetTextColor(120, 113, 108);
        $this->Cell(0, 10, utf8_decode("Página ") . $this->PageNo() . "/{nb}", 0, 0, "C");
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->setFiltros($data_inicio, $data_fim);
$pdf->SetAutoPageBreak(true, 25);
$pdf->AddPage();

$pdf->SetFont("Helvetica", "B", 12);
$pdf->SetTextColor(28, 25, 23);
$pdf->Cell(0, 10, utf8_decode("Resumo"), 0, 1, "L");
$pdf->Ln(4);

$cardW = 55;
$cardH = 30;
$cardY = $pdf->GetY();
$colors = [
    [55, 48, 163],
    [5, 150, 105],
    [217, 119, 6],
];
$labels = [
    utf8_decode("Total de Avaliações"),
    utf8_decode("Média das Notas"),
    utf8_decode("Produtos Avaliados"),
];
$values = [
    (string)$total,
    $total > 0 ? $mediaNotas . " / 5.0" : "N/A",
    (string)$qtdProdutos,
];

for ($i = 0; $i < 3; $i++) {
    $x = 10 + ($i * ($cardW + 8));
    $pdf->SetFillColor($colors[$i][0], $colors[$i][1], $colors[$i][2]);
    $pdf->Rect($x, $cardY, $cardW, $cardH, "F");

    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont("Helvetica", "", 9);
    $pdf->SetXY($x, $cardY + 4);
    $pdf->Cell($cardW, 6, $labels[$i], 0, 0, "C");

    $pdf->SetFont("Helvetica", "B", 18);
    $pdf->SetXY($x, $cardY + 12);
    $pdf->Cell($cardW, 12, $values[$i], 0, 0, "C");
}

$pdf->SetY($cardY + $cardH + 10);

$pdf->SetFont("Helvetica", "B", 12);
$pdf->SetTextColor(28, 25, 23);
$pdf->Cell(0, 10, utf8_decode("Listagem Detalhada"), 0, 1, "L");
$pdf->Ln(4);

$colW = [8, 48, 40, 12, 72];
$header = ["#", utf8_decode("Produto"), utf8_decode("Cliente"), utf8_decode("Nota"), utf8_decode("Observação")];

$pdf->SetFont("Helvetica", "B", 9);
$pdf->SetFillColor(55, 48, 163);
$pdf->SetTextColor(255, 255, 255);
for ($i = 0; $i < 5; $i++) {
    $pdf->Cell($colW[$i], 8, $header[$i], 1, 0, "C", true);
}
$pdf->Ln();

$pdf->SetTextColor(28, 25, 23);
$fill = false;
foreach ($feedbacks as $idx => $f) {
    if ($pdf->GetY() > 250) {
        $pdf->AddPage();
        $pdf->SetFont("Helvetica", "B", 9);
        $pdf->SetFillColor(55, 48, 163);
        $pdf->SetTextColor(255, 255, 255);
        for ($i = 0; $i < 5; $i++) {
            $pdf->Cell($colW[$i], 8, $header[$i], 1, 0, "C", true);
        }
        $pdf->Ln();
        $pdf->SetTextColor(28, 25, 23);
    }

    if ($fill) {
        $pdf->SetFillColor(248, 247, 244);
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }
    $fill = !$fill;

    $notaEstrelas = (int)$f["nota"] . " / 5";
    $obsTexto = $f["observacao"] ? substr($f["observacao"], 0, 40) : "-";
    $obs = utf8_decode($obsTexto);

    $pdf->SetFont("Helvetica", "", 8);
    $pdf->Cell($colW[0], 7, $idx + 1, 1, 0, "C", true);
    $pdf->Cell($colW[1], 7, utf8_decode(substr($f["produto_nome"], 0, 22)), 1, 0, "L", true);
    $pdf->Cell($colW[2], 7, utf8_decode(substr($f["cliente_nome"] ?? "-", 0, 18)), 1, 0, "L", true);
    $pdf->Cell($colW[3], 7, $notaEstrelas, 1, 0, "C", true);
    $pdf->Cell($colW[4], 7, $obs, 1, 0, "L", true);
    $pdf->Ln();
}

$pdf->Ln(8);

$pdf->SetFont("Helvetica", "I", 8);
$pdf->SetTextColor(120, 113, 108);
$pdf->Cell(0, 6, utf8_decode("Total de registros: " . $total), 0, 1, "L");

$pdf->Output("D", "relatorio_avaliacoes_" . date("Ymd_His") . ".pdf");
