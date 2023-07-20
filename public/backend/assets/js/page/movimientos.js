"use-strict"

        document.addEventListener("DOMContentLoaded", function() {
            const sortButtons = Array.from(document.querySelectorAll(".sort-button"));
            const movimientosTable = document.getElementById("movimientosTable");
    
            sortButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const column = this.getAttribute("data-column");
                    const sortOrder = this.getAttribute("data-order");
    
                    const rows = Array.from(movimientosTable.querySelectorAll("tbody tr"));
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
                    const valA = a.querySelector(`td:nth-child(${getColumnIndex(column)})`).innerText.trim();
                    const valB = b.querySelector(`td:nth-child(${getColumnIndex(column)})`).innerText.trim();
    
                    if (isNaN(valA) && isNaN(valB)) {
                        return sortOrder === "asc" ? valA.localeCompare(valB) : valB.localeCompare(valA);
                    } else {
                        return sortOrder === "asc" ? parseFloat(valA) - parseFloat(valB) : parseFloat(valB) - parseFloat(valA);
                    }
                });
            }
    
            function getColumnIndex(column) {
                const headers = Array.from(movimientosTable.querySelectorAll("th"));
                return headers.findIndex(header => header.getAttribute("data-column") === column) + 1;
            }
    
            function updateTableRows(rows) {
                const tbody = movimientosTable.querySelector("tbody");
                while (tbody.firstChild) {
                    tbody.removeChild(tbody.firstChild);
                }
    
                rows.forEach(row => {
                    tbody.appendChild(row);
                });
            }
        });
