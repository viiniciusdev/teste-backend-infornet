document.addEventListener('DOMContentLoaded', async () => {
  await inicializarAutenticacao(); // Garante login automático antes de tudo

  document.getElementById('formPrestador').addEventListener('submit', async function (event) {
    event.preventDefault();

    const dados = {
      nome: document.getElementById('nome').value,
      email: document.getElementById('email').value,
      telefone: document.getElementById('telefone').value,
      cpf: document.getElementById('cpf').value,
      cep: document.getElementById('cep').value,
      logradouro: document.getElementById('logradouro').value,
      numero: document.getElementById('numero').value,
      bairro: document.getElementById('bairro').value,
      cidade: document.getElementById('cidade').value,
      uf: document.getElementById('uf').value,
      situacao: 1
    };

    try {
      const response = await fetchComToken('http://127.0.0.1:8000/api/prestadores', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(dados)
      });

      const status = response.status;
      const body = await response.json();
      const msg = document.getElementById('mensagem');

      if (status === 201) {
        msg.innerHTML = '<p class="sucesso">Prestador cadastrado com sucesso!</p>';
        document.getElementById('formPrestador').reset();
      } else if (status === 422 && body.errors) {
        const erros = Object.values(body.errors).flat().join('<br>');
        msg.innerHTML = '<p class="erro">' + erros + '</p>';
      } else {
        msg.innerHTML = '<p class="erro">Erro inesperado ao cadastrar prestador.</p>';
      }

    } catch (error) {
      console.error("Erro completo:", error);
      document.getElementById('mensagem').innerHTML = '<p class="erro">Erro ao conectar com a API.</p>';
    }
  });
});

// Busca de endereço por CEP (ViaCEP)
function buscarEndereco() {
  const cep = document.getElementById('cep').value.replace(/\D/g, '');

  if (!cep || cep.length !== 8) {
    alert('Digite um CEP válido com 8 dígitos.');
    return;
  }

  fetch(`https://viacep.com.br/ws/${cep}/json/`)
    .then(response => response.json())
    .then(data => {
      if (data.erro) {
        alert('CEP não encontrado!');
        return;
      }

      document.getElementById('logradouro').value = data.logradouro || '';
      document.getElementById('bairro').value = data.bairro || '';
      document.getElementById('cidade').value = data.localidade || '';
      document.getElementById('uf').value = data.uf || '';
    })
    .catch(error => {
      console.error('Erro ao buscar o endereço:', error);
      alert('Erro ao buscar o endereço.');
    });
}
