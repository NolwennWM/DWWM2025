"use strict";

import Ball from "./bouncingBalls.js"

const canvas = document.querySelector("canvas");
const ctx = canvas.getContext("2d");

// Tableau de balles et gestion des clics
const balls = [];
canvas.addEventListener("click", () => balls.push(new Ball()));

// Animation
function animate() 
{
    // Nettoyage avec effet de traînée
    ctx.fillStyle = "rgba(0, 0, 0, 0.25)";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Mise à jour et dessin de toutes les balles
    balls.forEach(ball => {
        ball.movingBall();
        ball.drawBall();
    });

    requestAnimationFrame(animate);
}

// Démarrage de l'animation
animate();