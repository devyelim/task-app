// Confirmação de exclusão SweetAlert2
function confirmDelete(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá desfazer isso depois!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}


// Dark mode
function toggleDark() {
    document.body.classList.toggle("dark");
    localStorage.setItem("dark", document.body.classList.contains("dark"));
}
// Carrega a preferência do usuário
if (localStorage.getItem("dark") === "true") {
    document.body.classList.add("dark");
}




// Drag and Drop das tasks
let dragged = null;

// Inicia o drag
document.addEventListener("dragstart", e => {
    if (e.target.classList.contains("card")) {
        dragged = e.target;
        e.target.style.opacity = "0.5";
    }
});

// Restaura a opacidade ao terminar o drag
document.addEventListener("dragend", () => {
    if (dragged) dragged.style.opacity = "1";
});

// Configura os eventos de dragover e drop para as colunas
document.querySelectorAll(".column").forEach(column => {
    column.addEventListener("dragover", e => e.preventDefault());

    column.addEventListener("drop", async e => {
        e.preventDefault();

        const status = column.dataset.status;
        const taskId = dragged.dataset.id;

        try {
            const response = await fetch(`/tasks/${taskId}/status`, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),
                    "Accept": "application/json"
                },
                credentials: "same-origin",
                body: JSON.stringify({ status })
            });


            if (!response.ok) throw new Error();

            column.appendChild(dragged);

            // sincroniza o status do formulário
            const form = dragged.querySelector('.card-edit');
            if (form) {
                const hidden = form.querySelector('[data-status-hidden]');
                const select = form.querySelector('[data-status-select]');

                if (hidden) hidden.value = status;
                if (select) select.value = status;
            }

        } catch {
            alert("Erro ao atualizar status da tarefa.");
        }
    });
});

// Inicializa os estados vazios
document.addEventListener('DOMContentLoaded', refreshEmptyStates);

// Função para atualizar os estados vazios das colunas
function refreshEmptyStates() {
    document.querySelectorAll('.column').forEach(column => {
        const cards = column.querySelectorAll('.card');
        const empty = column.querySelector('.empty-column');

        if (cards.length > 0) {
            empty.style.display = 'none';
        } else {
            empty.style.display = 'block';
        }
    });
}

// Atualiza os estados vazios após um drop
document.querySelectorAll(".column").forEach(column => {
    column.addEventListener("drop", () => {
        setTimeout(refreshEmptyStates, 100);
    });
});



// Criar nova task
function openCreateCard(button) {
    const column = button.closest('.column');
    const status = column.dataset.status;
    const body = column.querySelector('.column-body');

    // evita múltiplos cards de criação
    if (column.querySelector('.card.creating')) return;

    const template = document.getElementById('create-card-template').innerHTML;

    const wrapper = document.createElement('div');
    wrapper.innerHTML = template.trim();

    const card = wrapper.firstChild;

    // seta o status da coluna
    card.querySelector('input[name="status"]').value = status;

    body.prepend(card);

    // foco automático
    setTimeout(() => {
        card.querySelector('input[name="title"]').focus();
    }, 50);
}

// Cancelar criação de task
function cancelCreate(button) {
    const card = button.closest('.card');
    card.remove();
}




// Editar task
function toggleEdit(button) {
    const card = button.closest('.card');
    const view = card.querySelector('.card-view');
    const edit = card.querySelector('.card-edit');

    const isEditing = edit.style.display === 'block';

    if (isEditing) {
        // sair do modo edição
        edit.style.display = 'none';
        view.style.display = 'block';
        card.setAttribute('draggable', 'true');
        card.classList.remove('editing');
    } else {
        // entrar no modo edição
        edit.style.display = 'block';
        view.style.display = 'none';
        card.setAttribute('draggable', 'false');
        card.classList.add('editing');
    }
}

// Sincroniza o select de status com o input hidden nos formulários de edição
document.querySelectorAll('.card-edit').forEach(form => {
    const select = form.querySelector('[data-status-select]');
    const hidden = form.querySelector('[data-status-hidden]');

    // Sempre que mudar no select, atualiza o input hidden
    // Evita que input capture status da posição do card e vice-versa
    select.addEventListener('change', () => {
        hidden.value = select.value;
    });
});
