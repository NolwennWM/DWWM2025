/**
    1.Le champ nom d'utilisateur doit tourner au rouge si 
    il contient autre chose que des lettres, - ou _;

    2.Le champ téléphone doit passer au rouge si le ce qui est entré
    ne correspond pas à un numéro de téléphone.

    3.Le champ email doit passer au rouge si ce qui est entré ne 
    correspond pas à un email.

    4.Ajouter une barre de progression qui change de couleur
    et se rempli à chaque fois que l'utilisateur sécurise 
    un peu plus sont mdp :
        -lettre minuscule.
        -lettre majuscule.
        -chiffre.
        -caractère spécial.
        -au moins 8 caractère.
        
    5. le champ mdp bis doit tourner au rouge si il ne correspond 
    pas au champ mdp.
    (le changement au rouge peut être personalisé autrement,
    l'important est de montrer à l'utilisateur qu'il se trompe)
 */

const inputs = document.querySelectorAll('input:not([type="submit"])'),
pass = document.querySelector('#pass'),
progress = document.querySelector('.progress');

inputs.forEach(inp=>inp.addEventListener("change", verify));

function verify(e)
{
    let r;
    switch(e.target.id){
        case "user":
            r=/^[A-Za-z\-_]+$/;
            break;
        case "telephone":
            // r=/^\d+$/;
            r=/^(\+33|0)\d([\s\.\-]?\d{2}){4}$/;
            break;
        case "email":
            r=/^[a-z0-9\-_\.]+@[a-z0-9\-_\.]+\.[a-z]{2,4}$/;
            break;
        case "passBis":
            modify(e.target, e.target.value === pass.value);
            return;
    }
    modify(e.target, r && r.test(e.target.value));
}
function modify(target, bool) {
    if(bool){
        target.style.borderColor = "";
        target.style.backgroundColor = "";
    }
    else{
        target.style.borderColor = "red";
        target.style.backgroundColor = "rgba(255, 0, 0, 0.5)";
    }
}