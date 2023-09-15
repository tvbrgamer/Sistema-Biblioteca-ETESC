const Notify = (tipo) => {
    switch (tipo) {
        case "delete_livro":
            swal("Seu livro foi apagado", {
                icon: "success",
            }).then(() => resetUrl());
            break;
        case "delete_aluno":
            swal("O aluno foi apagado", {
                icon: "success",
            }).then(() => resetUrl());
            break;
        case "empresta":
            swal("Seu livro foi emprestado", {
                icon: "success",
            }).then(() => resetUrl());
            break;
        case "devolvido":
            swal("O livro do aluno foi devolvido", {
                icon: "success",
            }).then(() => resetUrl());
            break;
        case "edit_aluno":
            swal("O cadastro do aluno foi alterado com sucesso", {
                icon: "success",
            }).then(() => resetUrl());
            break;
        case "edit_livro":
            swal("O cadastro do livro foi alterado com sucesso", {
                icon: "success",
            }).then(() => resetUrl());
            break;
        case "devolva_antes":
            swal("Seu livro não foi emprestado", {
                text: "Você precisa devolver o livro anterior antes (botão devolver)",
                icon: "warning",
            }).then(() => resetUrl());
            break;
    }
}

const resetUrl = () =>{

    window.location.hash = '#mostrou';

    let url = new URL(window.location.href);

    // Remove o "tipo"
    url.searchParams.delete('tipo');

    // Atualiza o url no navegador sem o "tipo"
    window.history.replaceState({}, document.title, url.href);
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}