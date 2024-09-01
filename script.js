document
  .getElementById("personalForm")
  .addEventListener("submit", async function (event) {
    event.preventDefault(); // Prevenir el envío del formulario por defecto

    // Crear un nuevo objeto FormData con los datos del formulario
    let formData = new FormData(this);

    try {
      // Realizar la solicitud fetch
      let response = await fetch(
        "http://localhost/pedidos/api/v1/personal.php",
        {
          method: "POST",
          body: formData,
        }
      );

      // Verificar si la respuesta es exitosa
      if (response.ok) {
        let data = await response.json(); // Parsear la respuesta JSON
        let tableBody = document.querySelector("#personalTable tbody");
        tableBody.innerHTML = ""; // Clear existing data

        data.forEach((personal) => {
          let row = document.createElement("tr");
          row.innerHTML = `
                <td>${personal.idPersonal}</td>
                <td>${personal.fecha}</td>
                <td>${personal.nombre}</td>
                <td>${personal.ci}</td>
                <td>${personal.celular}</td>
                <td>${personal.monto}</td>
                <td>${personal.idUser}</td>
            `;
          tableBody.appendChild(row);
        });
      } else {
        throw new Error("Error en la solicitud: " + response.statusText);
      }
    } catch (error) {
      // Manejar errores
      console.error("Error:", error);
      document.getElementById("result").innerText = "Error: " + error.message;
    }
  });
