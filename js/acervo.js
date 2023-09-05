function confirmarDelete(ID, Emprestado) {
    if (Emprestado >= 1) {
        swal("Livro não pode ser excluído", {
            text: "O livro está emprestado e precisa ser devolvido antes de ser excluído.",
            icon: "warning",
        });
    } else {
        swal({
            title: "Tem certeza?",
            text: "Se você apagar, não poderá recuperar o registro.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('delete' + ID).submit();
            } else {
                swal("Livro não foi apagado.");
            }
        });
    }
    console.log("ID:", ID);
    console.log("Emprestado:", Emprestado);
}

function Valida(QTD, QTDE, ID) {
    swal({
        title: "Tem certeza?",
        icon: "warning",
        buttons: true,
    })
        .then((willValide) => {
            if (willValide) {
                if (QTD >= (QTDE + 1)) {
                    document.getElementById('empresta' + ID).submit();
                } else {
                    swal("Quantidade de livros insuficientes para emprestar", {
                        icon: "warning"
                    });
                }
            } else {
                swal("O livro não foi emprestado");
            }
        });
}

// Adiciona um listener para o evento 'change' do elemento select
ordem.addEventListener('change', (event) => {
    // Obtém o valor selecionado
    const ordemValue = event.target.value;

    // Obtém o valor atual de 'ordem' da URL
    const url = new URL(window.location.href);
    const currentOrdem = url.searchParams.get('ordem') || "ASC";

    // Atualiza a URL com os novos valores de 'ordem'
    url.searchParams.set('ordem', ordemValue);

    window.history.pushState({}, '', url);
    window.location.reload(true);
})

// Adiciona um listener para o evento 'change' do elemento limit
select.addEventListener('change', (event) => {
    // Obtém o valor selecionado
    const selectedValue = parseInt(event.target.value);

    // Obtém o valor atual de 'start' e 'limit' da URL
    const url = new URL(window.location.href);
    const currentLimit = parseInt(url.searchParams.get('limit') || 25);

    // Atualiza a URL com os novos valores de 'limit'
    url.searchParams.set('limit', selectedValue);

    window.history.pushState({}, '', url);
    window.location.reload(true);
});

