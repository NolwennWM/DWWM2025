"use strict"

clock();

function clock() {
    // Objet date avec la date et l'heure actuelle
    const date = new Date();
    // extrait l'heure de l'objet date
    const hours = ((date.getHours() + 11) % 12 + 1);
    /*
        extrait l'heure de l'objet date grâce à ce calcul :
            date.getHours() renvoie l'heure actuelle en format 24h (0-23)
            + 11 est ajouté pour décaler la plage à -1 à 22
            % 12 effectue une division modulo par 12, ramenant la plage à 0-11
            + 1 est ajouté à la fin pour obtenir une plage de 1 à 12
    */
    const minutes = date.getMinutes();
    const seconds = date.getSeconds();
    // 12 heures = 360°, donc 1 heure = 30°
    const hour = hours * 30;
    // 60 minutes = 360°, donc 1 minute = 6°
    const minute = minutes * 6;
    // 60 secondes = 360°, donc 1 seconde = 6°
    const second = seconds * 6;
    
    document.querySelector('.heure').style.transform = `rotate(${hour}deg)`;

    document.querySelector('.minute').style.transform = `rotate(${minute}deg)`;

    document.querySelector('.seconde').style.transform = `rotate(${second}deg)`;
}

setInterval(clock, 1000);