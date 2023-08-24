function removeParams(sParam) {
    var url = window.location.href.split('?')[0] + '?';
    var sPageURL = decodeURIComponent(window.location.search.substring(1));
    var sHash = window.location.hash; // Armazena a âncora atual
    var sURLVariables = sPageURL.split('&');
    var sParameterName;

    for (var i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] != sParam) {
            url = url + sParameterName[0] + '=' + sParameterName[1] + '&';
        }
    }

    // Remove a âncora da URL processada
    url = url.substring(0, url.length - 1);

    // Adiciona a âncora de volta à URL (se existir)
    if (sHash) {
        url += sHash;
    }

    return url;
}

const Notify = (tipo) => {
    switch (tipo) {
        case "delete":
            swal("Seu livro foi apagado", {
                icon: "success",
            })
            .then((ok) => 
            window.location = removeParams('tipo')
            );
            break;
        case "empresta":
            swal("Seu livro foi emprestado :)", {
                icon: "success",
            })
            .then((ok) => 
            window.location = removeParams('tipo')
            );
            break;
        default:
            swal("O tipo de notificação não foi definido :(", {
                icon: "error",
            })
            .then((ok) => 
            window.location = removeParams('tipo')
            );
            break;
    }
}

function confirmarDelete(ID) {
    swal({
        title: "Tem certeza?",
        text: "Se você apagar, não pode recuperar o registro",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Seu livro foi apagado", {
                    icon: "success",
                });
                document.getElementById('delete' + ID).submit();
            } else {
                swal("Livro não Apagado");
            }
        });
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
                    swal("Quantidade de livros insuficientes para emprestar");
                }
            } else {
                swal("O livro não foi emprestado");
            }
        });
}

// Seleciona o elemento select pelo seu ID
const select = document.querySelector('#select');
const ordem = document.querySelector('#ordem');

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
