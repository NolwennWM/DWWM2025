function start() {
    let tH = document.querySelector(".hour");
    let tM = document.querySelector(".minute");
    let tS = document.querySelector(".second");
    let time,h,m,s;

    setInterval(function(){
        time = new Date();
        h = time.getHours()*30;
        m = time.getMinutes()*6;
        s = time.getSeconds()*6;
        tS.style.transform = "rotate("+s+"deg)";
        tM.style.transform = "rotate("+m+"deg)";
        tH.style.transform = "rotate("+h+"deg)";
    },1000);
}
start();