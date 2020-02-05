"use strict"
let currentCity = document.querySelector("#currentCity");
const inputCity = document.querySelector("#inputCity");
const citySearchBtn = document.querySelector(".btn");

const hourlyWeatherDataList = document.querySelector("#hourlyWeatherData");
const dailyWeatherDataList = document.querySelector("#imageBackground div.scroll");
const nextDayBtn = document.querySelector("#nextDayBtn");

let fullWeatherData;
let dateElements = []
let selectedDay;

//Weather condition codes
const conditionCodes = {
    clearSunny: "wi wi-day-sunny",
    isolatedClouds: "wi wi-day-cloudy",
    scatteredClouds: "wi wi-day-cloudy",
    overcast: "wi wi-day-sunny-overcast",
    lightRain: "wi wi-rain",
    moderateRain: "wi wi-rain",
    heavyRain: "wi wi-showers",
    sleet: "wi wi-day-sleet",
    lightSnow: "wi wi-snow",
    moderateSnow: "wi wi-snow",
    heavySnow: "wi wi-snow",
    fog: "wi wi-fog",
    na: "unknown",
}

const getWeatherIconCode = (weatherCondition) => {
    switch(weatherCondition) {
        case "clear":
            return conditionCodes
        .clearSunny;
        case "isolated-clouds":
            return conditionCodes
        .isolatedClouds;
        case "scattered-clouds":
            return conditionCodes
        .scatteredClouds;
        case "overcast":
            return conditionCodes
        .overcast;
        case "light-rain":
            return conditionCodes
        .lightRain;
        case "moderate-rain":
            return conditionCodes
        .moderateRain;
        case "heavy-rain":
            return conditionCodes
        .heavyRain;
        case "sleet":
            return conditionCodes
        .sleet;
        case "light-snow":
            return conditionCodes
        .lightSnow;
        case "moderate-snow":
            return conditionCodes
        .moderateSnow;
        case "heavy-snow":
            return conditionCodes
        .heavySnow;
        case "fog":
            return conditionCodes
        .fog;
        case "na":
            return "NA";
    }
};

const getOrdinalNumberEnding = (number) => {
    number = parseInt(number);
    // if(isNaN(number)) {
    //     console.log("Given value is not a number");
    //     return;
    // }
    let j = number % 10;
    let k = number % 100;

    if(j === 1 && k !== 11) {
        return "st";
    }
    if(j === 2 && k !== 12) {
        return "nd";
    }
    if(j === 3 && k !== 13) {
        return "rd"
    }

    return "th";
};

const removeAllData = () => {
    while(hourlyWeatherDataList.firstChild) {
        hourlyWeatherDataList.removeChild(hourlyWeatherDataList.firstChild);
    }

    while(dailyWeatherDataList.firstChild) {
        dailyWeatherDataList.removeChild(dailyWeatherDataList.firstChild);
    }
};

const removeHours = () => {
    while(hourlyWeatherDataList.firstChild) {
        hourlyWeatherDataList.removeChild(hourlyWeatherDataList.firstChild);
    }
}

//Loads full weather data of an entered city when clicked
citySearchBtn.addEventListener("click", () => {
    loadFullWeatherData(inputCity.value);
});

nextDayBtn.addEventListener("click", () => {
    for(let i = 0; i < dateElements.length; i++) {
        if(dateElements[i].element.classList.contains("selectedDay")) {
            dateElements[i].element.classList.remove("selectedDay");
            if(i === dateElements.length - 1) {
                dateElements[0].element.classList.add("selectedDay");
                loadWeatherHourDataOfDate(dateElements[0].date)
            } else {
                dateElements[i+1].element.classList.add("selectedDay");
                loadWeatherHourDataOfDate(dateElements[i+1].date);
            }
            break;
        }
    }
});

const loadWeatherHourDataOfDate = (date) => {
    removeHours();
    const filteredDataHourly = fullWeatherData.forecastTimestamps
    .filter(element => element.forecastTimeUtc.includes(date));

    filteredDataHourly.forEach(data => {
        const weatherByHour = document.createElement("div");
        weatherByHour.classList.add("weatherByHour");
    
        const container = document.createElement("div");
        container.classList.add("container");
    
        const time = document.createElement("p");
        time.className = "hour mt-2";
        const hour = data.forecastTimeUtc.split(" ")[1];
        time.textContent = hour.split(":")[0] + hour.split(":")[1];
    
        const timeWeatherIcon = document.createElement("i");
        timeWeatherIcon.classList = getWeatherIconCode(data.conditionCode) + " weatherHourIcon";
    
        const temperature = document.createElement("p");
        temperature.classList = "temperature mt-2";
        temperature.innerHTML = Math.round(data.airTemperature) + "&deg;";;
    
        const rainIcon = document.createElement("i");
        rainIcon.classList = conditionCodes.lightRain + " precipitationIcon";

        const rainChance = document.createElement("p");
        rainChance.classList = "rainChance";
        rainChance.textContent = data.totalPrecipitation + " mm/h";
    
        const windSpeed = document.createElement("p");
        windSpeed.classList = "windSpeed mb-0";
        windSpeed.textContent = data.windSpeed + " m/s";
        const windIcon = document.createElement("i");
        windIcon.classList = `wi wi-wind towards-${data.windDirection}-deg`;

        container.appendChild(time);
        container.appendChild(timeWeatherIcon);
        container.appendChild(temperature);
        container.appendChild(rainIcon);
        container.appendChild(rainChance);
        container.appendChild(windSpeed);
        container.appendChild(windIcon);
        weatherByHour.appendChild(container);
        hourlyWeatherDataList.appendChild(weatherByHour);
    });
}

const loadWeatherDayDataOfDate = (dataOfDates) => {
    dataOfDates.forEach((element, index) => {
        const weatherByDay = document.createElement("div");
        weatherByDay.classList = "weatherByDay border-dark";

        const container = document.createElement("div");
        container.classList = "container";
    
        let day = document.createElement("p");
        if(index === 0) {
            day.textContent = "Today";
        } else {
            day.textContent = element.date.split("-")[2] + getOrdinalNumberEnding(element.date.split("-")[2]);
        }
        
        day.classList = "mb-0";
    
        const row = document.createElement("div");
        row.classList = "row align-items-center mb-3";
    
        const weatherIconDiv = document.createElement("div");
        weatherIconDiv.classList = "col-6";
    
        const weatherIcon = document.createElement("i");
        weatherIcon.classList = getWeatherIconCode(element.mostFrequentCondition);

        const temperatureDiv = document.createElement("div");
        temperatureDiv.classList = "col-6";
    
        const high = document.createElement("p");
        high.classList = "mb-0";
        high.innerHTML = element.max + "&deg;";
    
        const low = document.createElement("p");
        low.innerHTML = element.min + "&deg;";
    
        weatherIconDiv.appendChild(weatherIcon);
        temperatureDiv.appendChild(high);
        temperatureDiv.appendChild(low);
    
        row.appendChild(weatherIconDiv);
        row.appendChild(temperatureDiv);
        container.appendChild(day);
        container.appendChild(row);
        weatherByDay.appendChild(container);
        dailyWeatherDataList.appendChild(weatherByDay);

        const dateElement = {
            date: element.date,
            element: weatherByDay
        }

        if(selectedDay === undefined) {
            selectedDay = weatherByDay;
            selectedDay.classList.add("selectedDay");
        }

        dateElements.push(dateElement);

        weatherByDay.addEventListener("click", () => { // load new day when clicked
            loadWeatherHourDataOfDate(element.date);  
            
            selectedDay.classList.remove("selectedDay");
            selectedDay = weatherByDay; 
            selectedDay.classList.add("selectedDay");
                   
        });
    });

};

//Filters weather data to show daily weather max and min temperatures
const filterWeatherDaily = (weather) => {
    const dataOfDates = [];

    //Filters to show only dates
    const dates = weather.map((element) => {
        return element.forecastTimeUtc.split(" ")[0];
    });
    //Removes duplicate dates
    const filteredDates = dates.filter((value, index, self) => {
        return self.indexOf(value) === index;
    });

    //Finds max and min temperature of each day and the most frequent weather condition
    filteredDates.forEach(date => {
        let max = weather[0].airTemperature;
        let min = max;

        let weatherByHour = {}
        let mostFrequentCondition;
        let maxConditionCount = 0;

        weather.forEach(element => {
            if(element.forecastTimeUtc.split(" ")[0] === date) {
                //Finds max and min temepratures
                if(element.airTemperature > max) {
                    max = element.airTemperature;
                }
                if(element.airTemperature < min) {
                    min = element.airTemperature;
                }
                
                //Finds the most frequent weather condition
                if(weatherByHour[element.conditionCode] === undefined) {
                    weatherByHour[element.conditionCode] = 1;
                } else {
                    weatherByHour[element.conditionCode]++;
                }

                if(weatherByHour[element.conditionCode] > maxConditionCount) {
                    maxConditionCount = weatherByHour[element.conditionCode];
                    mostFrequentCondition = element.conditionCode;
                }
            }
        });

        max = Math.round(max);
        min = Math.round(min);
        
        const newData = {
            date, max, min, mostFrequentCondition
        }
        dataOfDates.push(newData);
        
    });

    return dataOfDates;
};

const fetchWeather = async(city) => {
    return await fetch(`https://api.meteo.lt/v1/places/${city.toLowerCase()}/forecasts/long-term`)
      .then(res => res.json());
};

const loadFullWeatherData = async (city = "kaunas") => {
    removeAllData();

    city = city.toLowerCase();
    city = city[0].toUpperCase() + city.substring(1);
    currentCity.textContent = city; 

    fullWeatherData = await fetchWeather(city);
    if(fullWeatherData.error) {
        currentCity.textContent = `Miestas ${city} nerastas`;
        return;
    }

    //Filtered data to show hours of a day
    const todayDate = new Date().toISOString().split('T')[0]; //yyyy--mm-dd
    loadWeatherHourDataOfDate(todayDate);

    //Filtered data to show days
    const filteredDateData = filterWeatherDaily(fullWeatherData.forecastTimestamps); 
    loadWeatherDayDataOfDate(filteredDateData);

    //Last time updated
    const updateTime = fullWeatherData.forecastCreationTimeUtc.split(" ")[1]; 
    document.querySelector("#updateTime").textContent = "Last updated at " +
    updateTime.split(":")[0] + ":" + updateTime.split(":")[1];
}

loadFullWeatherData();





