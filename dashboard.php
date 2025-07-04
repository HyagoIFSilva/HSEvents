<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
$nome = $_SESSION['nome'];
$foto_perfil = $_SESSION['foto']; 
$caminho_foto_perfil = 'uploads/' . $foto_perfil; 

try {
    $stmtEventos = $con->prepare("SELECT COUNT(*) FROM tbcadevento WHERE idUsuario = ?");
    $stmtEventos->execute([$idUsuario]);
    $totalEventos = $stmtEventos->fetchColumn();

    $stmtFaturamento = $con->prepare("SELECT SUM(valorTotal) FROM tbpedidos WHERE idUsuario = ?");
    $stmtFaturamento->execute([$idUsuario]);
    $faturamentoTotal = $stmtFaturamento->fetchColumn() ?: 0;

    $stmtIngressos = $con->prepare("
        SELECT SUM(tpi.quantidade) 
        FROM tbpedidos_itens tpi
        JOIN tbpedidos tp ON tpi.idPedido = tp.idPedido
        WHERE tp.idUsuario = ?
    ");
    $stmtIngressos->execute([$idUsuario]);
    $ingressosVendidos = $stmtIngressos->fetchColumn() ?: 0;

    $ticketMedio = ($ingressosVendidos > 0) ? ($faturamentoTotal / $ingressosVendidos) : 0;

    $stmtGraficoLinha = $con->prepare("
        SELECT DATE_FORMAT(dataPedido, '%b') as mes, SUM(valorTotal) as total 
        FROM tbpedidos 
        WHERE idUsuario = ? AND YEAR(dataPedido) = YEAR(CURDATE())
        GROUP BY DATE_FORMAT(dataPedido, '%Y-%m')
        ORDER BY MIN(dataPedido)
    ");
    $stmtGraficoLinha->execute([$idUsuario]);
    $faturamentoMensal = $stmtGraficoLinha->fetchAll(PDO::FETCH_ASSOC);

    $labelsMeses = [];
    $dadosMeses = [];
    foreach ($faturamentoMensal as $fm) {
        $labelsMeses[] = $fm['mes'];
        $dadosMeses[] = $fm['total'];
    }

    $stmtGraficoBarras = $con->prepare("
        SELECT tce.nomeCadEvento, SUM(tpi.quantidade) as qtd
        FROM tbpedidos_itens tpi
        JOIN tbcadevento tce ON tpi.idCadEvento = tce.idCadEvento
        JOIN tbpedidos tp ON tpi.idPedido = tp.idPedido
        WHERE tp.idUsuario = ?
        GROUP BY tce.nomeCadEvento
        ORDER BY qtd DESC
        LIMIT 5
    ");
    $stmtGraficoBarras->execute([$idUsuario]);
    $vendasPorEvento = $stmtGraficoBarras->fetchAll(PDO::FETCH_ASSOC);
    
    $labelsEventos = [];
    $dadosEventos = [];
    foreach ($vendasPorEvento as $ve) {
        $labelsEventos[] = $ve['nomeCadEvento'];
        $dadosEventos[] = $ve['qtd'];
    }

} catch (PDOException $e) {
    die("Erro ao consultar dados para a dashboard: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./Styles/dashboard-novo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="profile">
                <img src="<?php echo htmlspecialchars($caminho_foto_perfil); ?>" alt="Foto de Perfil" class="profile-pic">
                <h3><?php echo htmlspecialchars($nome); ?></h3>
            </div>
            <h2>Menu</h2>
            <nav>
                <ul>
                    <li><a href="dashboard.php" class="active"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
                    <li><a href="cadastrar_evento.php"><i class="fas fa-plus-square"></i> Cadastrar Evento</a></li>
                    <li><a href="meus_eventos.php"><i class="fas fa-folder-open"></i> Meus Eventos</a></li>
                    <li><a href="galeria.php"><i class="fas fa-images"></i> Galeria Pública</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </aside>

        <main class="main-content">
            <h1>Painel de Análise</h1>
            <p>Visão geral dos seus eventos e performance de vendas.</p>
            
            <div class="dashboard-grid">
                <div class="stat-card" style="--animation-delay: 0.1s;">
                    <div class="color-1 stat-icon"><i class="fas fa-dollar-sign"></i></div>
                    <div class="stat-info">
                        <p>Faturamento Total</p>
                        <h3 class="counter" data-target="<?= $faturamentoTotal ?>">R$ 0,00</h3>
                    </div>
                </div>
                <div class="stat-card" style="--animation-delay: 0.2s;">
                    <div class="color-2 stat-icon"><i class="fas fa-ticket-alt"></i></div>
                    <div class="stat-info">
                        <p>Ingressos Vendidos</p>
                        <h3 class="counter" data-target="<?= $ingressosVendidos ?>">0</h3>
                    </div>
                </div>
                <div class="stat-card" style="--animation-delay: 0.3s;">
                    <div class="color-3 stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-info">
                        <p>Eventos Criados</p>
                        <h3 class="counter" data-target="<?= $totalEventos ?>">0</h3>
                    </div>
                </div>
                 <div class="stat-card" style="--animation-delay: 0.4s;">
                    <div class="color-4 stat-icon"><i class="fas fa-chart-pie"></i></div>
                    <div class="stat-info">
                        <p>Ticket Médio</p>
                        <h3 class="counter" data-target="<?= $ticketMedio ?>">R$ 0,00</h3>
                    </div>
                </div>
                
                <div class="chart-card large-card" style="--animation-delay: 0.5s;">
                    <h3>Faturamento Mensal (Ano Atual)</h3>
                    <div class="chart-container">
                        <canvas id="faturamentoChart"></canvas>
                    </div>
                </div>

                <div class="chart-card large-card" style="--animation-delay: 0.6s;">
                     <h3>Top 5 Eventos (Ingressos Vendidos)</h3>
                    <div class="chart-container">
                        <canvas id="vendasChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    const animateCounters = () => {
        const counters = document.querySelectorAll('.counter');
        const animationDuration = 1000; 

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const isCurrency = counter.innerText.includes('R$');
            
            let startTime = null;
            const animation = (currentTime) => {
                if (!startTime) startTime = currentTime;
                const progress = Math.min((currentTime - startTime) / animationDuration, 1);
                let currentValue = progress * target;
                
                if (isCurrency) {
                    counter.innerText = 'R$ ' + currentValue.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                } else {
                    counter.innerText = Math.ceil(currentValue).toLocaleString('pt-BR');
                }
                
                if (progress < 1) {
                    requestAnimationFrame(animation);
                } else {
                    if (isCurrency) {
                        counter.innerText = 'R$ ' + target.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    } else {
                        counter.innerText = target.toLocaleString('pt-BR');
                    }
                }
            };
            requestAnimationFrame(animation);
        });
    };
    
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#64748b';
    Chart.defaults.plugins.legend.display = false;
    Chart.defaults.responsive = true;
    Chart.defaults.maintainAspectRatio = false;

    const createFaturamentoChart = () => {
        const ctx = document.getElementById('faturamentoChart')?.getContext('2d');
        if (!ctx) return;

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(106, 13, 173, 0.4)');
        gradient.addColorStop(1, 'rgba(106, 13, 173, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labelsMeses); ?>,
                datasets: [{
                    label: 'Faturamento',
                    data: <?php echo json_encode($dadosMeses); ?>,
                    backgroundColor: gradient,
                    borderColor: 'rgba(106, 13, 173, 1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgba(106, 13, 173, 1)',
                    pointHoverRadius: 7,
                    pointHoverBorderWidth: 2,
                    pointRadius: 5,
                }]
            },

            options: {
                scales: { 
                    y: { beginAtZero: true, grid: { color: '#e2e8f0' } }, 
                    x: { grid: { display: false } } 
                },
                plugins: {
                    tooltip: {
                        backgroundColor: '#111827',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    };
    
    const createVendasChart = () => {
        const ctx = document.getElementById('vendasChart')?.getContext('2d');
        if (!ctx) return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labelsEventos); ?>,
                datasets: [{
                    label: 'Ingressos Vendidos',
                    data: <?php echo json_encode($dadosEventos); ?>,
                    backgroundColor: 'rgba(106, 13, 173, 0.7)',
                    borderColor: 'rgba(106, 13, 173, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                scales: { 
                    x: { beginAtZero: true, grid: { color: '#e2e8f0' } }, 
                    y: { grid: { display: false } } 
                },
                plugins: {
                    tooltip: {
                        backgroundColor: '#111827',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false
                    }
                }
            }
        });
    };

    if (document.getElementById('faturamentoChart')) createFaturamentoChart();
    if (document.getElementById('vendasChart')) createVendasChart();
    animateCounters();
});
</script>
</body>
</html>