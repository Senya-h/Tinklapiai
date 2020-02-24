window.addEventListener("DOMContentLoaded", () => {
    const movieRows = Array.from(document.getElementsByClassName("movie-data"));

    movieRows.forEach(row => {
        const editButton = row.lastElementChild.firstElementChild;
        const removeButton = row.lastElementChild.lastElementChild;

        let typeOfChange = row.firstElementChild.lastElementChild;

        editButton.addEventListener("click", (buttonEvent) => {
            // row.addEventListener("click", (rowEvent) => { //clicked row
            //     rowEvent.stopPropagation();
            // });
            // buttonEvent.stopPropagation();

            typeOfChange.value = "edit";
            row.style.backgroundColor = "yellow";

            Array.from(row.children).forEach(cell => {
                if(cell !== row.firstElementChild && cell !== row.lastElementChild) { //Jeigu ne redagavimo mygtukai arba keitimas
                    if(cell.classList.contains("genre")) {
                        if(cell.firstElementChild.hasAttribute("disabled")) {
                            cell.firstElementChild.removeAttribute("disabled");
                        }
                    } else {
                        let cellChildren = {};
                        Array.from(cell.children).forEach(data => {
                            if(data.nodeName === "INPUT") {
                                cellChildren.input = data;
                            } else {
                                cellChildren.content = data;
                            }
                        });
                        cellChildren.content.setAttribute("contenteditable", "true");
                        cellChildren.content.oninput = () => {
                            cellChildren.input.value = cellChildren.content.textContent.trim();
                        }
                    }
                }         
            });
        });

        removeButton.addEventListener("click", () => {
            row.style.display = "none";
            typeOfChange.value = "delete";
        });
    });
});