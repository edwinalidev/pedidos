// apiLoader.js
function cargarCategoriasEnSelect(url, selectId) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById(selectId);
            // Limpiar opciones anteriores
            select.innerHTML = "";

            data.forEach(categoria => {
                const option = document.createElement("option");
                option.value = categoria.idCategoria;
                option.text = categoria.Detalle;
                select.appendChild(option);
            });
        })
        .catch(error => console.error("Error al obtener datos de la API:", error));
}

function insertarCategoria(url, nuevaCategoria) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(nuevaCategoria),
    })
    .then(response => response.json())
    .then(data => console.log("Datos insertados:", data))
    .catch(error => console.error("Error al insertar datos:", error));
}

function actualizarCategoria(url, datosActualizados) {
    return fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datosActualizados),
    })
    .then(response => response.json())
    .then(data => console.log("Datos actualizados:", data))
    .catch(error => console.error("Error al actualizar datos:", error));
}

function delCategoria(url, idCategoria) {
    const headers = new Headers();
    headers.append('Content-Type', 'application/json');
    headers.append('Origin', window.location.origin); // Incluye la cabecera Origin

    return fetch(url, {
        method: 'DELETE',
        headers: headers,
        body: JSON.stringify({ idCategoria: idCategoria }),
    })
    .then(response => response.json())
    .then(data => console.log("Categoría eliminada:", data))
    .catch(error => console.error("Error al eliminar categoría:", error));
}
