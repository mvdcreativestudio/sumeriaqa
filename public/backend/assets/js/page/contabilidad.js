"use-strict"

document.addEventListener("DOMContentLoaded", function() {
    const sortButtons = Array.from(document.querySelectorAll(".sort-button"));
    const contabilidadTable = document.getElementById("contabilidadTable");

    sortButtons.forEach(button => {
        button.addEventListener("click", function() {
            const column = this.getAttribute("data-column");
            const sortOrder = this.getAttribute("data-order");

            const rows = Array.from(contabilidadTable.querySelectorAll("tbody tr"));
            const sortedRows = sortRows(rows, column, sortOrder);

            updateTableRows(sortedRows);

            // Actualizar el atributo data-order del botón
            this.setAttribute("data-order", sortOrder === "asc" ? "desc" : "asc");

            // Cambiar la clase CSS del botón según el orden
            this.classList.toggle("asc", sortOrder === "asc");
            this.classList.toggle("desc", sortOrder === "desc");
        });
    });

    function sortRows(rows, column, sortOrder) {
        return rows.sort((a, b) => {
            let valA = a.querySelector(`td:nth-child(${getColumnIndex(column)})`).innerText.trim();
            let valB = b.querySelector(`td:nth-child(${getColumnIndex(column)})`).innerText.trim();

            if (column === "monto") {
                // Eliminar el signo de moneda y el punto usado para separar miles
                valA = valA.replace(/[$.]/g, '');
                valB = valB.replace(/[$.]/g, '');
            }

            // Comparar como cadenas si los valores no son números, de lo contrario comparar como números
            if (isNaN(valA) || isNaN(valB)) {
                return sortOrder === "asc" ? valA.localeCompare(valB) : valB.localeCompare(valA);
            } else {
                return sortOrder === "asc" ? Number(valA) - Number(valB) : Number(valB) - Number(valA);
            }
        });
    }

    function getColumnIndex(column) {
        const headers = Array.from(contabilidadTable.querySelectorAll("th"));
        return headers.findIndex(header => header.getAttribute("data-column") === column) + 1;
    }

    function updateTableRows(rows) {
        const tbody = contabilidadTable.querySelector("tbody");
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }

        rows.forEach(row => {
            tbody.appendChild(row);
        });
    }
});
