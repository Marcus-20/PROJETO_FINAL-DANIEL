<?php
$servicos = [
    "Corte de Cabelo Masculino" => [
        "Social - R$20,00",
        "Degradê - R$25,00",
        "Navalhado - R$30,00",
        "Militar - R$20,00"
    ],

    "Barba Tradicional" => [
        "Barba Cheia Clássica - R$20,00",
        "Barba Curta e Aparada - R$25,00",
        "Cavanhaque - R$15,00",
        "Barba Arredondada - R$25,00"
    ],

    "Barba Desenhada" => [
        "Barba Desenhada Clássica - R$30,00",
        "Barba Sombreada - R$35,00",
        "Barba Contorno Marcado - R$35,00",
        "Barba Raspada com Linha - R$35,00"
    ],

    "Combo Corte + Barba" => [
        "Social + Barba Clássica - R$40,00",
        "Degradê + Barba Clássica - R$50,00",
        "Navalhado + Barba Clássica - R$55,00",
        "Militar + Barba Clássica - R$40,00"
    ],

    "Tratamento Capilar" => [
        "Hidratação - R$50,00",
        "Nutrição - R$60,00",
        "Reconstrução - R$100,00",
        "Cronograma Capilar - R$120,00"
    ],

    "Limpeza de Pele Masculina" => [
        "Limpeza de Pele Tradicional - R$70,00",
        "Limpeza de Pele com Máscaras de Argila - R$80,00",
        "Limpeza de Pele Detox - R$100,00",
        "Limpeza de Pele para Acne - R$60,00"
    ],
];
?>

<!DOCTYPE html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<section id="servicos">
    <h2>Nossos Serviços</h2>

    <ul class="service-list">

        <?php foreach ($servicos as $titulo => $opcoes): ?>
            <li>
                <details class="details">
                    <summary class="summary"><?= $titulo ?></summary>
                    <ul>
                        <?php foreach ($opcoes as $item): ?>
                            <li><?= $item ?></li>
                        <?php endforeach; ?>
                    </ul>
                </details>
            </li>
        <?php endforeach; ?>

    </ul>
</section>

</body>
</html>
