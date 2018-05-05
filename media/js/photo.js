"use strict";

let photo = {
    init: function () {
        this.input = document.getElementById("photo");
        this.span = document.querySelector(".path");
        this.input.addEventListener("change",(e)=>{
            this.span.innerText = "";
            this.span.innerText = (e.target.value);
        });
    }
};
window.addEventListener("load",()=>photo.init());