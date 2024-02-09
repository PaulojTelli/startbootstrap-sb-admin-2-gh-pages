<?php require  'pages/header.php' ?>
<?php require  'pages/sidebar.php' ?>

<?php

// Função para estabelecer conexão com o banco de dados
function conectarBanco()
{
    global $servername, $username, $password, $dbname;

    // Cria a conexão
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Verifica se houve erro na conexão
    if ($mysqli->connect_error) {
        die("Falha na conexão: " . $mysqli->connect_error);
    }

    return $mysqli;
}

// Conecte-se ao banco de dados
$mysqli = conectarBanco();

// Consulta para obter a soma dos pagamentos dos últimos 5 meses
$query = "
    SELECT DATE_FORMAT(data_pagamento, '%Y-%m') AS mes, SUM(quantia_paga) AS total_arrecadado
    FROM historico_pagamentos
    WHERE data_pagamento >= (SELECT MAX(data_pagamento) FROM historico_pagamentos) - INTERVAL 5 MONTH
    GROUP BY mes
    ORDER BY mes DESC
";

// Executar a consulta
if ($result = $mysqli->query($query)) {
    $meses = [];
    $totais_arrecadados = [];

    while ($row = $result->fetch_assoc()) {
        $meses[] = $row['mes'];
        $totais_arrecadados[] = $row['total_arrecadado'];
    }

    $result->free();



    // Não se esqueça de passar esses dados para o gráfico
} else {
    echo "Erro ao executar a consulta: " . $mysqli->error;
}

$mysqli->close();


// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Data de hoje
$today = date('Y-m-d');
$dayOfMonth = date('d');

// Consulta para aluguéis pagos
$pagos = $conn->query("SELECT COUNT(*) as total FROM apartamento WHERE pago = 1")->fetch_assoc()['total'];

// Consulta para aluguéis não pagos e dentro do vencimento
$naoPagosVencimento = $conn->query("SELECT COUNT(*) as total FROM apartamento WHERE pago = 0 AND vencimento_dia >= $dayOfMonth")->fetch_assoc()['total'];

// Consulta para aluguéis não pagos e vencidos
$naoPagosVencidos = $conn->query("SELECT COUNT(*) as total FROM apartamento WHERE pago = 0 AND vencimento_dia < $dayOfMonth")->fetch_assoc()['total'];

// Fechar conexão
$conn->close();

// Conecte-se ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para contar apartamentos alugados
$alugados = $conn->query("SELECT COUNT(*) as total FROM apartamento WHERE locado = 1")->fetch_assoc()['total'];

// Consulta para contar apartamentos vagos
$vagos = $conn->query("SELECT COUNT(*) as total FROM apartamento WHERE locado = 0")->fetch_assoc()['total'];

// Feche a conexão
$conn->close();

// Calcula a porcentagem de apartamentos alugados
$totalApartamentos = $alugados + $vagos;
$porcentagemAlugados = ($totalApartamentos > 0) ? ($alugados / $totalApartamentos) * 100 : 0;

// Conecte-se ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para contar todos os apartamentos
$totalApartamentosQuery = $conn->query("SELECT COUNT(*) as total FROM apartamento");
$totalApartamentos = $totalApartamentosQuery->fetch_assoc()['total'];

// Consulta para contar apartamentos com aluguéis pagos
$alugueisPagosQuery = $conn->query("SELECT COUNT(*) as total FROM apartamento WHERE pago = 1");
$alugueisPagos = $alugueisPagosQuery->fetch_assoc()['total'];

// Feche a conexão
$conn->close();

// Calcula a porcentagem de aluguéis pagos
$porcentagemAlugueisPagos = ($totalApartamentos > 0) ? ($alugueisPagos / $totalApartamentos) * 100 : 0;

// Conecte-se ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obter pagamentos com 3 ou mais meses atrasados
$query = "
    SELECT hp.id_apartamento, hp.id_inquilino, hp.meses_atrasados, a.apartamento, a.endereco, i.nome, i.sobrenome
    FROM historico_pagamentos AS hp
    JOIN apartamento AS a ON hp.id_apartamento = a.id
    JOIN inquilinos AS i ON hp.id_inquilino = i.id
    WHERE hp.meses_atrasados >= 3
";

$alertas = [];

if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $alertas[] = $row;
    }
    $result->free();
}

$conn->close();
?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<div class="container">
    <div class="row">
        <div class="col-12" id="titulodashboard">
            <h2>Dashboard</h2>
        </div>
    </div>
    <form method="post" id="novo_mes_form">
        <button type="submit" class="btn btn-primary mb-2" name="executar_funcao">Encerrar
            Mês <i class="fa-regular fa-calendar-check"></i></button>
    </form>
    <div class="row">
        <div class="col-12">
            <canvas id="profitChart"></canvas>
        </div>
    </div>
    <div class="row" id="graficos2">
        <div class="col-6">
            <canvas id="rentChart"></canvas>
        </div>
        <div class="col-6" id="barraapslocados">
            <h4>Apartamentos Locados</h4>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentagemAlugados; ?>%" aria-valuenow="<?php echo $porcentagemAlugados; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($porcentagemAlugados); ?>%</div>
            </div>
            <br>
            <h4>Aluguéis Pagos</h4>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentagemAlugueisPagos; ?>%" aria-valuenow="<?php echo $porcentagemAlugueisPagos; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($porcentagemAlugueisPagos); ?>%</div>
            </div>
        </div>
    </div>
</div>


<div class="container" id="alertaspag">
    <div class="row">
        <div class="col-12">
            <h4>Alertas de Pagamento</h4>
            <ul class="list-group">
                <?php foreach ($alertas as $alerta) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Aluguel mais de 3 meses atrasado!
                        <span class="badge bg-primary rounded-pill"><?php echo $alerta['nome'] . " " . $alerta['sobrenome']; ?> - <?php echo $alerta['meses_atrasados']; ?> meses atrasados - <?php echo $alerta['apartamento']; ?>, <?php echo $alerta['endereco']; ?></span>
                        <a href="https://api.whatsapp.com/send?phone=55312312312&text=Seu%20aluguel%20está%20a%20mais%20de%203%20meses%20atrasado,%20entre%20em%20contato%20para%20renegociar%20e%20evitar%20um%20despejo!"> <button class="btn btn-warning">Mandar Mensagem</button> </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <br><br><br><br>
    <div class="row">
        <div class="col-md-6">
            <h3>Lembretes</h3>
            <div class="card" id="anotacaocard">
                <div class="card-body" id="anotacoes">
                    <textarea class="form-control" id="note1" placeholder="Digite suas anotações aqui..."></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Úteis</h3>
            <div class="card" id="anotacaocard">
                <div class="card-body" id="anotacoes">
                    <textarea class="form-control" id="note2" placeholder="Digite suas anotações aqui..."></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Carregar as anotações salvas no LocalStorage
        $('#note1').val(localStorage.getItem('note1'));
        $('#note2').val(localStorage.getItem('note2'));

        // Salvar as anotações no LocalStorage quando elas mudarem
        $('#note1').on('input', function() {
            localStorage.setItem('note1', $(this).val());
        });

        $('#note2').on('input', function() {
            localStorage.setItem('note2', $(this).val());
        });
    });
</script>





<script>
    var meses = <?php echo json_encode($meses); ?>;
    var totaisArrecadados = <?php echo json_encode($totais_arrecadados); ?>;

    const ctxProfit = document.getElementById('profitChart').getContext('2d');
    const profitChart = new Chart(ctxProfit, {
        type: 'line',
        data: {
            labels: meses.reverse(),
            datasets: [{
                label: 'Ganhos Mensais',
                data: totaisArrecadados.reverse(),
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>

<script>
    // Os valores são passados do PHP para o JavaScript
    var dados = {
        pagos: <?php echo $pagos; ?>,
        naoPagosVencimento: <?php echo $naoPagosVencimento; ?>,
        naoPagosVencidos: <?php echo $naoPagosVencidos; ?>
    };

    // Criar o gráfico de donut
    const ctxRent = document.getElementById('rentChart').getContext('2d');
    const rentChart = new Chart(ctxRent, {
        type: 'doughnut',
        data: {
            labels: ['Aluguéis Pagos', 'Aluguéis Não Pagos (Dentro do Vencimento)', 'Aluguéis Não Pagos (Vencidos)'],
            datasets: [{
                label: 'Status dos Aluguéis',
                data: [dados.pagos, dados.naoPagosVencimento, dados.naoPagosVencidos],
                backgroundColor: [
                    'rgb(54, 162, 235)', // Azul para pagos
                    'rgb(75, 192, 192)', // Verde para não pagos dentro do vencimento
                    'rgb(255, 99, 132)' // Vermelho para não pagos vencidos
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>

<script type="text/javascript">
    document.getElementById("novo_mes_form").addEventListener("submit", function(event) {
        var result = confirm("Tem certeza que deseja encerrar o mês?");
        if (!result) {
            event.preventDefault();
        }
    });
</script>

<?php
if (isset($_POST['executar_funcao'])) {
    encerrarMes();
} ?>





<?php require 'pages/footer.php' ?>