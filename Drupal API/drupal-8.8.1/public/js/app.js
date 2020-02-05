const mastersList = document.getElementById("mastersList");
const nameInput = document.getElementById("name");
const specializationSelect = document.getElementById("specialization");
const servicesSelect = document.getElementById("service");
const citiesSelect = document.getElementById("city");
const genderSelect = document.getElementById("gender");
const ratingSelect = document.getElementById("rating");

let data;
const filters = {
  name: "",
  specialization: "",
  service: "",
  city: "",
  gender: "",
  rating: ""
};

nameInput.addEventListener("input", (e) => {
  filters.name = e.target.value;
  createUsers();
});

specializationSelect.addEventListener("change", (e) => {
  filters.specialization = e.target.value;
  createUsers();
});

servicesSelect.addEventListener("change", (e) => {
  filters.service = e.target.value;
  createUsers();
});

citiesSelect.addEventListener("change", (e) => {
  filters.city = e.target.value;
  createUsers();
});

genderSelect.addEventListener("change", (e) => {
  filters.gender = e.target.value;
  createUsers();
});

ratingSelect.addEventListener("change", (e) => {
  filters.rating = e.target.value;
  createUsers();
});

fetchMasters = async () => {
  let data = await fetch("http://saulius.web-training.lt/api?_format=json")
    .then(res => res.json());

    return data;
};

getData = async() => {
    data = await fetchMasters();

    populateSpecializations();
    populateServices();
    populateCities();
    createUsers();

    console.log(data);
};

getData();


populateSpecializations = () =>  {
    const specializations = [];
    data.forEach(user => {
        if(!specializations.includes(user.field_specializacija[0].value)) {
          specializations.push(user.field_specializacija[0].value);

          const option = document.createElement("option");
          option.value = user.field_specializacija[0].value;
          option.textContent = user.field_specializacija[0].value;
          specializationSelect.appendChild(option);
        }
    });
};

populateServices = () => {
  const services = [];

  data.forEach(user => {
    if(!services.includes(user.field_servisas[0].value)) {
      services.push(user.field_servisas[0].value);

      const option = document.createElement("option");
      option.value = user.field_servisas[0].value;
      option.textContent = user.field_servisas[0].value;

      servicesSelect.appendChild(option);
    }
  });
};

populateCities = () => {
  const cities = [];
  data.forEach(user => {
    if(!cities.includes(user.field_miestas[0].value)) {
      cities.push(user.field_miestas[0].value);

      const option = document.createElement("option");
      option.value = user.field_miestas[0].value;
      option.textContent = user.field_miestas[0].value;

      citiesSelect.appendChild(option);
    }
  });
};


createUsers = async () => {
  deleteUsers();
  data.forEach(user => {

    if(compatible(user, filters)) {
      const li = document.createElement("li");
      const container = document.createElement("div");
      container.classList.add("container");

      const row = document.createElement("div");
      row.classList.add("row");


      const photoDiv = createPhotoArea(user);

      const infoDiv = createInfoArea(user);

      const ratingDiv = createRatingArea(user);


      row.appendChild(photoDiv);
      row.appendChild(infoDiv);
      row.appendChild(ratingDiv);
      container.appendChild(row);
      li.appendChild(container);
      mastersList.appendChild(li);
    }
  });

};

compatible = (user, filters) => {
  const fullName = user.field_vardas[0].value + " " + user.field_pavarde[0].value;

  if( (filters.name === "" || fullName.toLowerCase().includes(filters.name.toLowerCase())) &&
      (filters.specialization === "" || filters.specialization === user.field_specializacija[0].value) &&
      (filters.service === "" || filters.service === user.field_servisas[0].value) &&
      (filters.city === "" || filters.city === user.field_miestas[0].value) &&
      (filters.gender === "" || filters.gender === user.field_lytis[0].value) &&
      (filters.rating === "" || filters.rating >= user.field_reitingas[0].value)) {

    return true;
  }

  return false;
};

createPhotoArea = (user) => {
  const photoDiv = document.createElement("div");
  photoDiv.className = "col-12 col-md-2 d-flex";
  const img = document.createElement("img");
  img.src = user.field_nuotrauka[0].url;
  photoDiv.appendChild(img);
  return photoDiv;
};

createInfoArea = (user) => {
  const infoDiv = document.createElement("div");
  infoDiv.className = "col-12 col-md-5 mt-3 mt-md-0";

  const name = document.createElement("p");
  name.textContent = user.field_vardas[0].value + " " + user.field_pavarde[0].value;

  const specialization = document.createElement("p");
  specialization.textContent = user.field_specializacija[0].value;

  const service = document.createElement("p");
  service.textContent = user.field_servisas[0].value;

  const city = document.createElement("p");
  city.textContent = user.field_miestas[0].value;


  infoDiv.appendChild(name);
  infoDiv.appendChild(specialization);
  infoDiv.appendChild(service);
  infoDiv.appendChild(city);

  return infoDiv;
};

createRatingArea = (user) => {
  const ratingDiv = document.createElement("div");
  ratingDiv.className = "col-12 col-md-5 d-flex flex-column align-items-end justify-content-center";

  const rating = document.createElement("div");
  rating.className = "d-flex mr-2";

  const ratingText = document.createElement("p");
  ratingText.textContent = "Reitingas: ";

  const ratingStars = document.createElement("div");

  for(let i = 0; i < 5; i++) {
    const ratingStar = document.createElement("i");
    ratingStar.className = "far fa-star";
    ratingStars.appendChild(ratingStar);
  }
  ratingStars.className = "ml-3 mr-2";
  const ratingNumbers = document.createElement("p");
  ratingNumbers.textContent = `(${user.field_reitingas[0].value})`;

  rating.appendChild(ratingText);
  rating.appendChild(ratingStars);
  rating.appendChild(ratingNumbers);

  const circleLikeDiv = document.createElement("div");
  circleLikeDiv.className = "likeCircle d-flex align-items-center justify-content-center";
  circleLikeDiv.onclick = () => {
    console.log("CLICKED");
    circleLikeDiv.classList.add("liked");

    ratingNumbers.textContent = `(${user.field_reitingas[0].value + 1})`;
  };
  const likeButton = document.createElement("i");
  likeButton.className = "far fa-heart";
  circleLikeDiv.appendChild(likeButton);

  ratingDiv.appendChild(rating);
  ratingDiv.appendChild(circleLikeDiv);

  return ratingDiv;
};

deleteUsers = () => {
  while(mastersList.firstChild) {
      mastersList.removeChild(mastersList.firstChild);
  }
};
