const mastersList = document.getElementById("mastersList");
const nameInput = document.getElementById("name");
const specializationSelect = document.getElementById("specialization");
const servicesSelect = document.getElementById("service");
const citiesSelect = document.getElementById("city");
const genderSelect = document.getElementById("gender");
const ratingSelect = document.getElementById("rating");

let data;
let sortedData;

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
  createUsers(sortedData);
});

specializationSelect.addEventListener("change", (e) => {
  filters.specialization = e.target.value;
  createUsers(sortedData);
});

servicesSelect.addEventListener("change", (e) => {
  filters.service = e.target.value;
  createUsers(sortedData);
});

citiesSelect.addEventListener("change", (e) => {
  filters.city = e.target.value;
  createUsers(sortedData);
});

genderSelect.addEventListener("change", (e) => {
  filters.gender = e.target.value;
  createUsers(sortedData);
});

ratingSelect.addEventListener("change", (e) => {
  filters.rating = e.target.value;
  sortedData = data;

  if(e.target.value === "fromMin") {
      const mastersArray = Array.from(mastersList.children);
      sortedData = [...data].sort(fromMin);
  } else if(e.target.value === "fromMax") {
      sortedData = [...data].sort(fromMax);
  }

  createUsers(sortedData);
});

fromMin = (a, b) => {
  const aReitingas = parseInt(a.field_reitingas);
  const bReitingas = parseInt(b.field_reitingas);
  if (aReitingas > bReitingas) {
    return 1;
  } else if (aReitingas < bReitingas) {
    return -1;
  }

  return 0;
}

fromMax = (a, b) => {
  const aReitingas = parseInt(a.field_reitingas);
  const bReitingas = parseInt(b.field_reitingas);
  if (aReitingas > bReitingas) {
    return -1;
  } else if (aReitingas < bReitingas) {
    return 1;
  }

  return 0;
}

fetchMasters = async () => {
  let data = await fetch("http://saulius.web-training.lt/api?_format=json")
    .then(res => res.json());

    return data;
};

getData = async () => {
    data = await fetchMasters();
    sortedData = data;
    populateSpecializations();
    populateServices();
    populateCities();
    createUsers();
};

getData();


populateSpecializations = () =>  {
    const specializations = [];
    data.forEach(user => {
        if(!specializations.includes(user.field_specializacija)) {
          specializations.push(user.field_specializacija);

          const option = document.createElement("option");
          option.value = user.field_specializacija;
          option.textContent = user.field_specializacija;
          specializationSelect.appendChild(option);
        }
    });
};

populateServices = () => {
  const services = [];

  data.forEach(user => {
    if(!services.includes(user.field_servisas)) {
      services.push(user.field_servisas);

      const option = document.createElement("option");
      option.value = user.field_servisas;
      option.textContent = user.field_servisas;

      servicesSelect.appendChild(option);
    }
  });
};

populateCities = () => {
  const cities = [];
  data.forEach(user => {
    if(!cities.includes(user.field_miestas)) {
      cities.push(user.field_miestas);

      const option = document.createElement("option");
      option.value = user.field_miestas;
      option.textContent = user.field_miestas;

      citiesSelect.appendChild(option);
    }
  });
};


createUsers = async (newData = data) => {
  deleteUsers();
  newData.forEach(user => {

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
  const fullName = user.field_vardas + " " + user.field_pavarde;

  if( (filters.name === "" || fullName.toLowerCase().includes(filters.name.toLowerCase())) &&
      (filters.specialization === "" || filters.specialization === user.field_specializacija) &&
      (filters.service === "" || filters.service === user.field_servisas) &&
      (filters.city === "" || filters.city === user.field_miestas) &&
      (filters.gender === "" || filters.gender === user.field_lytis) &&
      (filters.rating === "" || filters.rating >= user.field_reitingas)) {

    return true;
  }

  return false;
};

createPhotoArea = (user) => {
  const photoDiv = document.createElement("div");
  photoDiv.className = "col-12 col-md-2 mt-3 mt-lg-0 d-flex";
  const img = document.createElement("img");
  img.src = user.field_nuotrauka;
  photoDiv.appendChild(img);
  return photoDiv;
};

createInfoArea = (user) => {
  const infoDiv = document.createElement("div");
  infoDiv.className = "col-12 col-md-4 mt-3 mt-md-0";

  const name = document.createElement("p");
  name.textContent = user.field_vardas + " " + user.field_pavarde;

  const specialization = document.createElement("p");
  specialization.textContent = user.field_specializacija;

  const service = document.createElement("p");
  service.textContent = user.field_servisas;

  const city = document.createElement("p");
  city.textContent = user.field_miestas;


  infoDiv.appendChild(name);
  infoDiv.appendChild(specialization);
  infoDiv.appendChild(service);
  infoDiv.appendChild(city);

  return infoDiv;
};

createRatingArea = (user) => {
  const ratingDiv = document.createElement("div");
  ratingDiv.className = "col-12 col-md-6 d-flex flex-column justify-content-center";

  const rating = document.createElement("div");
  rating.className = "row p-0 mr-2 align-self-md-end";

  const ratingText = document.createElement("p");
  ratingText.className = "col-12 col-md";
  ratingText.textContent = "Reitingas: ";

  const ratingStars = document.createElement("div");

  let filledStarsCount = filledStarsCountBasedOnRating(user.field_reitingas);


  for(let i = 0; i < 5; i++) {
    const ratingStar = document.createElement("i");
    if(i < filledStarsCount) {
      ratingStar.className = "fas fa-star text-warning";
    } else {
      ratingStar.className = "far fa-star text-warning";
    }
    ratingStars.appendChild(ratingStar);
  }

  ratingStars.className = "col-12 col-md mr-1 ml-md-1 pr-0 d-flex";
  const ratingNumbers = document.createElement("p");
  ratingNumbers.className = "ml-2";
  ratingNumbers.textContent = `(${user.field_reitingas})`;
  ratingStars.appendChild(ratingNumbers);

  rating.appendChild(ratingText);
  rating.appendChild(ratingStars);


  const circleLikeDiv = document.createElement("div");
  circleLikeDiv.className = "likeCircle align-self-end d-flex mb-3 mb-lg-0 align-items-center justify-content-center";
  
  circleLikeDiv.onclick = () => {
    if(circleLikeDiv.classList.contains("liked")) {
      return;
    };

    circleLikeDiv.classList.add("liked");
    const newRating = parseInt(user.field_reitingas) + 1;
    ratingNumbers.textContent = `(${newRating})`;

    if(filledStarsCount < filledStarsCountBasedOnRating(newRating)) {
      updateStars(ratingStars, filledStarsCount + 1);
    }

    patchUserRating(user.nid, user.type, newRating);

  }
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

filledStarsCountBasedOnRating = (rating) => {
  if (rating < 2) {
    return 0;
  } else if (rating < 4) {
    return 1;
  } else if (rating < 6) {
    return 2;
  } else if (rating < 8) {
    return 3;
  } else if (rating < 10) {
    return 4;
  } 

  return 5;
};

updateStars = (ratingStars, filledStarsCount) => {
  Array.from(ratingStars.children).forEach((star, index) => {
    if(index === filledStarsCount - 1) {
      star.classList.remove("far");
      star.classList.add("fas");
    }
  })
};

patchUserRating = (userNode, userType, newRating) => {
  fetch(`http://saulius.web-training.lt/node/${userNode}?_format=json`, {
    method: "PATCH",
    headers: {
      "Content-Type": "application/json",
      'X-CSRF-Token': 'ap4qotMRzS-odVAPwWCeyQM-5PKKxlhYQgIxDASx1A0'
    },
    body: JSON.stringify({
      "field_reitingas": [
        {
          "value": newRating
        }
      ],
      "type": [
        {
          "target_id": userType
        }
      ]
    })
  })
};

