;"use strict";

let Ajax = {
    get: function (url) {
        return new Promise((resolve, reject) => {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState !== 4) return;
                if (xhr.status === 200) resolve(xhr.responseText);
                else reject(xhr.status)
            };
            xhr.send();
        });
    },
    post: function (url, object) {
        return new Promise((resolve, reject) => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState !== 4) return;
                if (xhr.status === 200) resolve(xhr.responseText);
                else reject(xhr.status)
            };
            let data = new FormData();
            for (let key in object) {
                data.append(key, object[key])
            }
            xhr.send(data);
        });
    }
};

let page = {
    init: function () {
        this.country = document.getElementById("country");
        this.citiesList = document.getElementById("city");
        this.country.addEventListener("change",e=> this.getCities(parseInt(e.target.value)));
    },
    getCities: function (country) {
        Ajax.get("http://blog/api/cities/"+country).then(responce=>
            this.createCitiesList(JSON.parse(responce))
        )
    },
    createCitiesList:function(array){
        this.citiesList.disabled = false;
        this.citiesList.innerHTML = "";
        let fragment = document.createDocumentFragment();
        array.forEach(elem=>{
            fragment.appendChild(this.createOption(elem));
        });
        this.citiesList.appendChild(fragment);
    },
    createOption: function (object) {
        let option = document.createElement("OPTION");
        option.value = object.id;
        option.innerText = object.name;
        return option;
    }
};
window.addEventListener("load", page.init.bind(page));
