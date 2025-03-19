<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zwierzęta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
<h1 class="mb-3">Zwierzęta</h1>

<div id="error-message" class="alert alert-danger d-none"></div>

<!-- Formularz dodawania/edycji -->
<form id="pet-form" class="mb-3">
    <input type="hidden" id="pet-id">
    <input type="text" id="pet-name" placeholder="Nazwa" required class="form-control mb-2">
    <input type="text" id="pet-status" placeholder="Status" required class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Zapisz</button>
    <button type="button" onclick="cancelEdit()" class="btn btn-secondary d-none" id="cancel-edit">Anuluj</button>
</form>

<ul id="pets-list" class="list-group"></ul>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const axiosInstance = axios.create({
        headers: { 'Authorization': 'special-key' }
    });

    async function fetchPets() {
        try {
            const response = await axiosInstance.get('/api/pets');
            document.getElementById('pets-list').innerHTML = response.data.map(pet =>
                `<li class='list-group-item d-flex justify-content-between align-items-center'>
                    <span>${pet.name} (${pet.status})</span>
                    <div>
                        <button onclick="editPet(${pet.id}, '${pet.name}', '${pet.status}')" class="btn btn-warning btn-sm">Edytuj</button>
                        <button onclick="deletePet(${pet.id})" class="btn btn-danger btn-sm">Usuń</button>
                    </div>
                </li>`
            ).join('');
        } catch (error) {
            showError('Błąd pobierania zwierząt');
        }
    }

    document.getElementById('pet-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        const id = document.getElementById('pet-id').value;
        const name = document.getElementById('pet-name').value;
        const status = document.getElementById('pet-status').value;

        try {
            if (id) {
                await axiosInstance.put(`/api/pets/${id}`, { name, status });
            } else {
                await axiosInstance.post('/api/pets', { id: Math.floor(Math.random() * 100000), name, status });
            }
            resetForm();
            fetchPets();
        } catch (error) {
            showError('Błąd zapisu danych');
        }
    });
    function editPet(id, name, status) {
        document.getElementById('pet-id').value = id;
        document.getElementById('pet-name').value = name;
        document.getElementById('pet-status').value = status;
        document.querySelector('button[type="submit"]').textContent = 'Edytuj';
        document.getElementById('cancel-edit').classList.remove('d-none');
    }

    function cancelEdit() {
        resetForm();
    }

    async function deletePet(id) {
        try {
            await axios.delete(`/api/pets/${id}`);
            fetchPets();
        } catch (error) {
            showError('Błąd usuwania zwierzęcia');
        }
    }

    function resetForm() {
        document.getElementById('pet-id').value = '';
        document.getElementById('pet-name').value = '';
        document.getElementById('pet-status').value = '';
        document.querySelector('button[type="submit"]').textContent = 'Zapisz';
        document.getElementById('cancel-edit').classList.add('d-none');
    }

    function showError(message) {
        const errorDiv = document.getElementById('error-message');
        errorDiv.textContent = message;
        errorDiv.classList.remove('d-none');
        setTimeout(() => errorDiv.classList.add('d-none'), 3000);
    }

    fetchPets();
</script>
</body>
</html>
<?php /**PATH C:\Users\xkloc\test_project\pet-api\resources\views/pets/index.blade.php ENDPATH**/ ?>