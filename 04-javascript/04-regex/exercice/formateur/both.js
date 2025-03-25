const   pass = document.querySelector('#pass'),
        rPass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

pass.addEventListener("input", check);

function check(e) {
    let v = 0;
    v += /[a-z]/.test(e.target.value)? 1:0;
    v += /[A-Z]/.test(e.target.value)? 1:0;
    v += /\d/.test(e.target.value)? 1:0;
    v += /[@$!%*?&]/.test(e.target.value)? 1:0;
    v += e.target.value.length>=8? 1:0;
    v -= /^[A-Za-z\d@$!%*?&]+$/.test(e.target.value)?0:1;
    switch(v){
        case -1:
        case 0:
            progress.style.width = "0";
            progress.style.backgroundColor = "";
            break;
        case 1:
            progress.style.width = "20%";
            progress.style.backgroundColor = "red";
            break;
        case 2:
            progress.style.width = "40%";
            progress.style.backgroundColor = "orangered";
            break;
        case 3:
            progress.style.width = "60%";
            progress.style.backgroundColor = "orange";
            break;
        case 4:
            progress.style.width = "80%";
            progress.style.backgroundColor = "yellow";
            break;
        case 5:
            progress.style.width = "100%";
            progress.style.backgroundColor = "green";
            break;
    }
}