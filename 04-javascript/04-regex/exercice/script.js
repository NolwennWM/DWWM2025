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


   /*  const tel = /^[^a-z]{10}$/ */

    const tel = /^[0-9]{10}$/;

    const inputtel = document.getElementById("tel")

    inputtel.addEventListener("change", checktel)
    //  inputtel.addEventListener("change", function(){})
    //  inputtel.addEventListener("change", ()=>{})


function checktel()
{
    if(tel.test(inputtel.value)){
        inputtel.style.backgroundColor = ""
    }else
    {
        inputtel.style.backgroundColor = "red"
    }
}

const mail = /^[a-z_\-]+@[a-z_\-]+\.[a-z]{2,}$/;

const inputmail = document.getElementById("mail")

inputmail.addEventListener("input", checkmail)

function checkmail()

{

    if(mail.test(inputmail.value)){
    inputmail.style.backgroundColor = ""
    }else
    {
    inputmail.style.backgroundColor = "red"
    }
}



const login = /^[A-Za-z-_]+$/;

const inputlogin = document.getElementById("Name")

inputlogin.addEventListener("input", checklogin)

function checklogin()
{
    if(login.test(inputlogin.value)){
        inputlogin.style.backgroundColor = ""
    }else
    {
        inputlogin.style.backgroundColor = "red"
    }
}


//const min = /[a-z]/;
//const maj = /[A-Z]/;
//const chiffre = /[0-9]/;
//const barreprogress = document.querySelector("span")
//const mdp = document.querySelector("#mdp")
//mdp.addEventListener("input", checkmin)
//function checkmin()


    // if(min.test(mdp.value) && maj.test(mdp.value) && chiffre.test(mdp.value)){
    //     barreprogress.style.backgroundColor = "green"
    //     barreprogress.style.scale = "1 1"
    // }
    // else if((min.test(mdp.value) && maj.test(mdp.value)) || (min.test(mdp.value) && chiffre.test(mdp.value)) || (chiffre.test(mdp.value) && maj.test(mdp.value)))
    // {
    //     barreprogress.style.backgroundColor = "orange"
    //     barreprogress.style.scale = "0.5 1"
    // }
    // else if(min.test(mdp.value) || maj.test(mdp.value) || chiffre.test(mdp.value))
    // {
    //     barreprogress.style.backgroundColor = "red"
    //     barreprogress.style.scale = "0.25 1"
    // }

   
   /*
    if(min.test(mdp.value))
    {
        barreprogress.style.backgroundColor = "red"
        barreprogress.style.scale = "0.25 1"
        if(maj.test(mdp.value))
        {
            barreprogress.style.backgroundColor = "orange"
            barreprogress.style.scale = "0.5 1"
            if(chiffre.test(mdp.value))
            {
                barreprogress.style.backgroundColor = "green"
                barreprogress.style.scale = "1 1"
            }
        }
    }
} */

    const mdp = document.querySelector("#mdp")
    mdp.addEventListener("input", barreprogress)

    function barreprogress(){

        const password = document.querySelector("#mdp").value;
        let score = 0
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score ++;
        if (/\d/.test(password)) score ++;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) score++; 
        if (password.length >= 8) score++;
    

        const progressbarre = document.querySelector("span");
        progressbarre.style.width = (score * 20) + "%";

        if (score === 5) {
            progressbarre.style.backgroundColor = "green";
        } else if (score >= 3) {
            progressbarre.style.backgroundColor = "yellow";
        } else {
            progressbarre.style.backgroundColor = "red";
        }
    }




        const mdp1 = document.querySelector("#mdp")
        const mdp2 = document.querySelector("#mdp2")
        mdp2.addEventListener("input", checkpasswords)
        function checkpasswords()
        {
            if (mdp1.value !== mdp2.value)
                // EST DIFFERENT !
                {
                mdp2.style.backgroundColor = "red";
            } else {
                mdp2.style.backgroundColor = ""
            }

        }
        
        
    




 //<label for="mdp2">Confirmation du Mot de Passe :</label>
       // <br>
       // <input type="password" id="mdp2"></input>