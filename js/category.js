const url = "../Api/v1/categorias.php";
const selectId = "selectCategory";
const formCategory = document.getElementById("formCategory");
const modCategory = document.getElementById("modCategory");
let dataCategories = [];
document.addEventListener("DOMContentLoaded", function () {
  cargarCategoriasEnSelect(url, "selectCategory");
});

function CategoryFill(data) {
  const select = document.getElementById(selectId);
  // Limpiar opciones anteriores
  select.innerHTML = "";
  data.forEach((category) => {
    const option = document.createElement("option");
    option.value = category.idCategoria;
    option.text = category.Detalle;
    select.appendChild(option);
  });
}

function addCategory() {
  formCategory.reset();
  var miModal = new bootstrap.Modal(modCategory);
  miModal.show();
  modalTitle = document.getElementById("titleCategory");
  modalTitle.textContent = "Nueva Categoría";
  //var txtDetalle = document.getElementById("catDetalle");
}
formCategory.onsubmit = function (event) {
  event.preventDefault();
  const formData = new FormData(formCategory);
  fetch(url, { method: "POST", body: formData })
    .then((response) => response.json())
    .then((data) => {
      cargarCategoriasEnSelect();
    })
    .catch((error) => {
      console.log("Error", error);
    });
  var modal = bootstrap.Modal.getInstance(modCategory);
  modal.hide();
  return true;
};
function editCategory() {
  formCategory.reset();
  var miModal = new bootstrap.Modal(modCategory);
  miModal.show();
  modalTitle = document.getElementById("titleCategory");
  modalTitle.textContent = "Modificar Categoría";
  var catDetalle = document.getElementById("catDetalle");
  var idCategory = document.getElementById("idCategory");
  var catOrden = document.getElementById("catOrden");
  var selectElement = document.getElementById("selectCategory");
  var nIndex = selectElement.selectedIndex;
  var selectText = selectElement.options[nIndex].text;
  idCategory.value = selectElement.value;
  catDetalle.value = selectText;
  catOrden.value = "0";
}

function delCategory() {
  const select = document.getElementById("selectCategory");
  var idCategory = select.value;
  const headers = new Headers();
  headers.append("Content-Type", "application/json");
  headers.append("Origin", window.location.origin); // Incluye la cabecera Origin
  alert(idCategory);
  return fetch(url, {
    method: "DELETE",
    headers: headers,
    body: JSON.stringify({ idCategoria: idCategory }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Categoría eliminada:", data);
      cargarCategoriasEnSelect();
    })
    .catch((error) => console.error("Error al eliminar categoría:", error));
}
function cargarCategoriasEnSelect() {
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      CategoryFill(data);
    })
    .catch((error) =>
      console.error("Error al obtener datos de la API:", error)
    );
}
