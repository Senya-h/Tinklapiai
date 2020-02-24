const addGenreBtn = document.getElementById("addGenreBtn");
const table = document.getElementsByClassName("table")[0];

const movieRows = Array.from(document.getElementsByClassName("genre-data"));

let index = 0;
addGenreBtn.addEventListener("click", () => {
    createNewGenre(index);
    index++;
});

movieRows.forEach(row => {
    const removeButton = row.lastElementChild.lastElementChild;

    let typeOfChange = row.firstElementChild.lastElementChild;

    removeButton.addEventListener("click", () => {
        row.style.display = "none";
        typeOfChange.value = "delete";
    });
});

createNewGenre = (index) => {
    const row = table.insertRow();
    row.classList.add("genre-data");
    row.style.backgroundColor = "#72f500";

    const hidden = row.insertCell(0);
    hidden.classList.add("d-none");

    let typeOfChange = document.createElement("input");
    typeOfChange.type = "hidden";
    typeOfChange.value = "create";
    typeOfChange.name = `genres[newGenre][${index}][change]`;

    hidden.appendChild(typeOfChange);

    const genre = row.insertCell(1);
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = `genres[newGenre][${index}][genre]`;
    input.value = "Naujas žanras";

    const div = document.createElement("div");
    div.textContent = "Naujas žanras";
    div.setAttribute("contenteditable", "true");
    setTimeout(() => {
        div.focus();
        const selection = window.getSelection();
        const range = document.createRange();
        range.selectNodeContents(div);
        selection.removeAllRanges();
        selection.addRange(range);
    }, 0);

    div.oninput = () => {
        input.value = div.textContent.trim();
    };

    genre.appendChild(input);
    genre.appendChild(div);

    const actions = row.insertCell(2);
    actions.classList.add("change");

    const removeButton = document.createElement("a");
    removeButton.href = "#";
    removeButton.classList.add("btn", "btn-danger");
    removeButton.textContent = "Pašalinti";

    removeButton.addEventListener("click", () => {
        row.style.display = "none";
        typeOfChange.value = "delete";
    });

    actions.appendChild(removeButton);
};
