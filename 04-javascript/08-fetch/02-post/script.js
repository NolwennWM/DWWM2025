"use strict";

const url = "https://api.thedogapi.com/v1/images/upload";
const api_key = "live_hwCYS1Nhyy5wGcboOlNvgHKazBhFWEz3L9kIIAhgycIF8ZYONRipbfqU4EhY0r3f";

const formulaire = document.querySelector('form');
const result = document.querySelector('.result');

formulaire.addEventListener("submit", uploadDog);

function uploadDog(e)
{
    e.preventDefault();
    const formData = new FormData(formulaire);
    result.textContent = "Chargement en cours";

    /* 
        Fetch peut prendre un second argument sous forme d'un objet
            On pourra y préciser la méthode à utiliser,
            le corps de la requête
            ou encore l'entête (headers) de la requête
    */
    fetch(url, {
        method: "POST",
        headers: {"x-api-key": api_key},
        body: formData
    }).then(checkResponse);
}
function checkResponse(response)
{
    result.textContent = "Chargement terminé !";
    if(response.ok)
    {
        response.json().then(data=>{
            // console.log(data);
            result.innerHTML += `<hr><img src="${data.url}" alt="image de chien" width="400">`;            
        });
    }else
    {
        response.text().then(data=>result.textContent = data)
    }
}