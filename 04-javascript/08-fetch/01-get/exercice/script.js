const urlHero = "./hero.json"
const heroSquad = document.querySelector("h1");
const homeTown = document.getElementById("homeTown")
const formed = document.getElementById("formed");
const secretBase = document.getElementById("secretBase");
const active = document.getElementById("active");
const members = document.getElementById("heroes");
const heroID = document.getElementById("heroID")
const card = document.getElementsByClassName('hero-card')[0]


fetch(urlHero).then(getHero);

function getHero(response) 
{
    if (response.ok) 
    {
        response.json()
            .then(function(data)
        {
            console.log(data);
            heroSquad.textContent = "Squad : " + data.squadName;
            homeTown.textContent = "City : " + data.homeTown;
            formed.textContent = "Since : " + data.formed;
            secretBase.textContent = "Secret base : " + data.secretBase;
            active.textContent = data.active;
            data.members.forEach(carac => {
                members.innerHTML+=
                `<option>${carac.name}</option>`;
                console.log(carac);
                heroID.innerHTML+=
                `<li>age : ${carac.age}</li>
                <li>name : ${carac.secretIdentity}</li>
                <li>super powers : ${carac.powers}</li>`
                const newUl = heroID.cloneNode(true)
                card.append(newUl)
                heroID.innerHTML = "";
                newUl.classList.add(carac.name.replace(" ", "-"));
                console.log(heroID);
                
            });
        })
    } 
}

members.addEventListener("change", function(){
    switchHero(this.value);
})

function switchHero(members) {
    console.log(members);
    document.querySelectorAll(".hero-card ul").forEach(ul=>ul.style.display="");
    // Utiliser un switch pour ajouter la classe appropriée
    switch(members) {

        case "Molecule Man":
            document.querySelector(".Molecule-Man").style.display = "block"
            // localStorage.setItem("theme","rose");
            break;
        case "Madame Uppercut":
            document.querySelector(".Madame-Uppercut").style.display = "block"
            // localStorage.setItem("theme","bleu");
            break;
        case "Eternal Flame":
            document.querySelector(".Eternal-Flame").style.display = "block"
            // localStorage.setItem("theme","tortue");
            break;
        case "Super Maurice":
            document.querySelector(".Super-Maurice").style.display = "block"


        // default:
            // document.body.classList.remove('Molecule-Man', 'Madame-Uppercut', 'Eternal-Flame','Super-Maurice');
            // localStorage.clear()
    }
}
// <!-- ====================== Exercice 2 ====================== -->

fetch('languages.json')
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur lors du chargement du fichier JSON');
        }
        return response.json();
    })
    .then(languages => {
        afficherLangues(languages); // Affiche la liste des langues
        chargerLangueParDefaut(languages); // Charge la langue par défaut
    })
    .catch(error => console.error('Erreur:', error));


    function afficherLangues(languages) {
        const select = document.getElementById('langues');
        languages.forEach(lang => {
            const option = document.createElement('option');
            option.value = lang.lang;
            option.textContent = lang.lang.toUpperCase(); // Affiche les codes de langue (ex : FR, EN)
            select.appendChild(option);
        });
    
        // Ajoute un événement pour changer la langue
        select.addEventListener('change', () => {
            const selectedLang = select.value;
            const langueChoisie = languages.find(lang => lang.lang === selectedLang);
            changerLangue(langueChoisie);
            localStorage.setItem('selectedLang', selectedLang); // Sauvegarde dans localStorage
        });
    }
    function changerLangue(langue) {
        const titre = document.getElementById('titre');
        const description = document.getElementById('description');
        
        titre.textContent = langue.titre;
        description.textContent = langue.description;
    }
    

function chargerLangueParDefaut(languages)
{
    const savedLanguage = localStorage.getItem("selectedLang");
    if(!savedLanguage)return;
    const select = document.getElementById('langues');
    select.value = savedLanguage;
    const langueChoisie = languages.find(lang => lang.lang === savedLanguage);
    changerLangue(langueChoisie);
}










// <!-- ====================== Exercice 3 ====================== -->
fetch('https://api.thecatapi.com/v1/images/search')
    .then(response => response.json())
    .then(data => {
        console.log(data); // Affichez les données reçues.
        afficherImagesChiens(data);
    })
    .catch(error => console.error('Erreur:', error));
    function afficherImagesChiens(images) {
        const container = document.getElementById('dog-images') || document.createElement('div');
        container.id = 'dog-images';
        images.forEach(imageData => {
            const img = document.createElement('img');
            img.src = imageData.url;
            img.alt = `Image de chien de l'exercice 3`;
            container.appendChild(img);
        });
        document.body.appendChild(container);
    }
    