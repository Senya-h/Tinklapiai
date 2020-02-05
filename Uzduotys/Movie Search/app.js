const searchInput = document.querySelector("#searchInput");
const searchBtn = document.querySelector("#searchBtn");
const tableBody = document.querySelector("#tableBody");
const notFound = document.querySelector("#notFound");

const narrowTable = {
    titleTr: document.querySelector("#title"),
    plotTr: document.querySelector("#plot"),
    imdbTr: document.querySelector("#imdb"),
    lengthTr: document.querySelector("#length"),
    directorTr: document.querySelector("#director")
};

class MovieData {
    constructor(title, plot, imdbRating, runtime, director) {
        this.title = title;
        this.plot = plot;
        this.imdbRating = imdbRating;
        this.runtime= runtime;
        this.director = director;
    }
}

searchBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    const fetchedData = await getData(searchInput.value);

    if(fetchedData.Error) {
        notFound.style.display = "block";
    } else {
        notFound.style.display = "none";
        createMovie(fetchedData);
    }

    searchInput.value = "";
});

const createMovie = (fetchedData) => {
    removeOldData();
    const tr = document.createElement("tr");

    const {Title, Plot, imdbRating, Runtime, Director} = fetchedData;
    const movieData = new MovieData(Title, Plot, imdbRating, Runtime, Director);

    const title = document.createElement("td");
    title.textContent = movieData.title;

    const plot = document.createElement("td");
    plot.textContent = movieData.plot;

    const IMDB = document.createElement("td");
    IMDB.textContent = movieData.imdbRating;

    const length = document.createElement("td");
    length.textContent = movieData.runtime;

    const director = document.createElement("td");
    director.textContent = movieData.director;

    //Wide table
    tr.appendChild(title);
    tr.appendChild(plot);
    tr.appendChild(IMDB);
    tr.appendChild(length);
    tr.appendChild(director);
    tableBody.appendChild(tr);

    //Narrow table
    narrowTable.titleTr.appendChild(title.cloneNode(true));
    narrowTable.plotTr.appendChild(plot.cloneNode(true));
    narrowTable.imdbTr.appendChild(IMDB.cloneNode(true));
    narrowTable.lengthTr.appendChild(length.cloneNode(true));
    narrowTable.directorTr.appendChild(director.cloneNode(true));

};

const removeOldData = () => {
    if(tableBody.firstChild) {
        tableBody.removeChild(tableBody.firstChild);
    }
    const {titleTr, plotTr, imdbTr, lengthTr, directorTr} = narrowTable;
    if(titleTr.lastChild) {
        titleTr.removeChild(titleTr.lastChild);
    }
    if(plotTr.lastChild) {
        plotTr.removeChild(plotTr.lastChild);
    }
    if(imdbTr.lastChild) {
        imdbTr.removeChild(imdbTr.lastChild);
    }
    if(lengthTr.lastChild) {
        lengthTr.removeChild(lengthTr.lastChild);
    }
    if(directorTr.lastChild) {
        directorTr.removeChild(directorTr.lastChild);
    }
};

const getData = async (movieName) => {
  return await fetch(`https://www.omdbapi.com/?apikey=e4db3ced&t=${movieName}`)
      .then(res => res.json());
};
