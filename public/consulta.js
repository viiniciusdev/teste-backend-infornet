// CONFIGURAÇÕES GERAIS
const API_URL = "http://127.0.0.1:8000/api";
const AUTH_BASIC = 'Basic ' + btoa('teste-Infornet:c@nsulta-dad0s-ap1-teste-Infornet#24');

// CONSULTA DE PRESTADORES
document.getElementById('consultarBtn').addEventListener('click', async () => {
    const origemCidade = document.getElementById('origem_cidade').value.trim();
    const origemUF = document.getElementById('origem_uf').value.trim().toUpperCase();
    const destinoCidade = document.getElementById('destino_cidade').value.trim();
    const destinoUF = document.getElementById('destino_uf').value.trim().toUpperCase();
    const idServico = document.getElementById('servico_id').value;
    const quantidade = document.getElementById('quantidade').value || 10;
    const ordenar = document.getElementById('ordenar').value;

    if (!origemCidade || !origemUF || !destinoCidade || !destinoUF || !idServico) {
        alert('Preencha todos os campos obrigatórios.');
        return;
    }

    try {
        const origemEndereco = `${origemCidade}, ${origemUF}`;
        const destinoEndereco = `${destinoCidade}, ${destinoUF}`;

        const origemCoords = await buscarCoordenadasLocal(origemEndereco);
        const destinoCoords = await buscarCoordenadasLocal(destinoEndereco);

        const filtros = {
            endereco_origem: {
                cidade: origemCidade,
                uf: origemUF,
                latitude: origemCoords.latitude,
                longitude: origemCoords.longitude
            },
            endereco_destino: {
                cidade: destinoCidade,
                uf: destinoUF,
                latitude: destinoCoords.latitude,
                longitude: destinoCoords.longitude
            },
            id_servico: parseInt(idServico),
            quantidade: parseInt(quantidade),
            ordenar_por: [ordenar],
            filtros: []
        };

        const prestadores = await buscarPrestadores(filtros);
        await preencherTabela(prestadores);
    } catch (error) {
        console.error('Erro na consulta:', error);
        alert('Erro ao realizar a consulta. Verifique os dados e tente novamente.');
    }
});

// INTEGRA COM ENDPOINT LOCAL PARA GEOCODING (usa proxy Laravel)
async function buscarCoordenadasLocal(endereco) {
    const response = await fetchComToken(`${API_URL}/enderecos/geolocalizar`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ endereco })
    });

    if (!response.ok) throw new Error('Erro ao buscar coordenadas');

    const data = await response.json();
    return {
        latitude: parseFloat(data.latitude),
        longitude: parseFloat(data.longitude)
    };
}

async function buscarPrestadores(payload) {
    const response = await fetchComToken(`${API_URL}/prestadores/consulta`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    });

    if (!response.ok) throw new Error('Erro ao consultar prestadores');

    return await response.json();
}

async function buscarStatus(prestadoresIds) {
    const response = await fetch('https://nhen90f0j3.execute-api.us-east-1.amazonaws.com/v1/api/prestadores/online', {
        method: 'POST',
        headers: {
            'Authorization': AUTH_BASIC,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ prestadores: prestadoresIds })
    });

    if (!response.ok) throw new Error('Erro ao buscar status');

    return await response.json();
}

async function preencherTabela(prestadores) {
    const tabela = document.querySelector('#tabelaPrestadores tbody');
    tabela.innerHTML = '';

    if (!Array.isArray(prestadores) || prestadores.length === 0) {
        tabela.innerHTML = '<tr><td colspan="6" style="text-align:center;">Nenhum prestador encontrado.</td></tr>';
        return;
    }

    const ids = prestadores.map(p => p.id);
    const statusMap = await buscarStatus(ids);

    prestadores.forEach(p => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${p.nome}</td>
            <td>${p.cidade}</td>
            <td>${p.nome_servico || '-'}</td>
            <td>R$ ${p.valor_total?.toFixed(2) || '-'}</td>
            <td>${p.distancia_total?.toFixed(2) || '-'} km</td>
            <td>${statusMap[p.id] === true ? 'Online' : 'Offline'}</td>
        `;
        tabela.appendChild(row);
    });
}
