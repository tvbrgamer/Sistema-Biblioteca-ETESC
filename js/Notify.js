const Notify = (tipo) => {
    switch (tipo) {
        case "delete_livro":
            swal("Seu livro foi apagado", {
                icon: "success",
            });
            break;
        case "delete_aluno":
            swal("O aluno foi apagado", {
                icon: "success",
            });
            break;
        case "empresta":
            swal("Seu livro foi emprestado", {
                icon: "success",
            });
            break;
        case "devolvido":
            swal("O aluno foi apagado", {
                icon: "success",
            });
            break;
        case "devolva_antes":
            swal("Seu livro não foi emprestado", {
                text: "Você precisa devolver o livro anterior antes (botão devolver)",
                icon: "warning",
            });
            break;
    }
}