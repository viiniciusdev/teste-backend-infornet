document.addEventListener('DOMContentLoaded', async () => {
  const tbody = document.querySelector('#tabelaPrestadores tbody');
  const mensagem = document.getElementById('mensagem');
  tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Carregando...</td></tr>';

  try {
    const response = await fetchComToken('http://127.0.0.1:8000/api/prestadores');

    if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);

    const data = await response.json();
    const prestadores = data.data || data;

    if (!Array.isArray(prestadores) || prestadores.length === 0) {
      tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Nenhum prestador encontrado.</td></tr>';
      return;
    }

    tbody.innerHTML = '';

    prestadores.forEach(prestador => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${prestador.nome}</td>
        <td>${prestador.email}</td>
        <td>${prestador.telefone}</td>
        <td>${prestador.cidade || '-'}</td>
        <td>${prestador.uf || '-'}</td>
      `;
      tbody.appendChild(row);
    });

  } catch (error) {
    console.error('Erro ao carregar prestadores:', error);
    tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color: red;">Erro ao carregar prestadores.</td></tr>';
    mensagem.textContent = 'Falha ao carregar dados. Verifique o backend ou o token.';
  }
});
