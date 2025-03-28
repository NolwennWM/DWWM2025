"use strict";
/* ------EX 1------- */

const optiontheme = document.querySelector('#themes');
// this is how you declare a value attribute ('[value="rose"]')
const rose = document.querySelector('[value="rose"]') 
const bleu = document.querySelector('[value="bleu"]')
const tortue = document.querySelector('[value="tortue"]')
const randColor = document.querySelector(".randColor")
// random
randColor.addEventListener("click", setRandColor)

optiontheme.addEventListener("change", settheme);

function settheme()
{
    // document.body.style.backgroundColor = "";
    document.body.classList.remove("rose", "bleu", "tortue") // this is to avoid the formation of value list in console. and then it will only take one value at a time.
    if(rose.selected){
        document.body.classList.toggle("rose", rose.selected);
        localStorage.setItem("themes", "rose");
    }

    else if(bleu.selected){
        document.body.classList.toggle("bleu", bleu.selected);
        localStorage.setItem("themes", "bleu");
    }
    else if(tortue.selected){
        document.body.classList.toggle("tortue", tortue.selected);
        localStorage.setItem("themes", "tortue");
    }
    // random
    // else if(optiontheme.value == random){

    // }
}
rose.selected = localStorage.getItem("themes") === "rose";
bleu.selected = localStorage.getItem("themes") === "bleu";
tortue.selected = localStorage.getItem("themes") === "tortue";
document.body.style.backgroundColor = localStorage.getItem("themes")
settheme();
console.log("themes");
// random
// console.log(randColor);

function setRandColor() 
{
    var r= Math.floor(Math.random()*255) // 255 is the total value of rgb each color of red, green , blue.
    var g= Math.floor(Math.random()*255)
    var b= Math.floor(Math.random()*255)

    document.body.style.backgroundColor = `rgb(${r},${g},${b})`;
    // document.body.style.backgroundColor = "rgb("+r+","+g+","+b+")";

    localStorage.setItem("themes", `rgb(${r},${g},${b})`);
}
