"use strict";

const canvas = document.querySelector("canvas");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

// class Ball
export default class Ball
{
    // x, y, velX, velY, color, size : les propriétés de la balles sont générées à l'interieur  du constructor
    constructor()
    {
        this.size = this.random(10, 20);
        // Prevoit un écart égal à la taille de la balle 
        this.x = this.random(this.size, canvas.width - this.size);
        this.y = this.random(this.size, canvas.height - this.size);
        // Ajout d'une petite marge pour éviter les erreurs sur le canvas
        this.velX = this.random(-7, 7);
        this.velY = this.random(-7, 7);
        this.color = this.randomColor();
    }
    
    // Méthode pour générer un nombre aléatoire
    random(min, max)
    {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    // Méthode pour générer une couleur aléatoire
    randomColor()
    {
        return `rgb(${this.random(0, 255)},${this.random(0, 255)},${this.random(0, 255)})`;
    }

    // on dessine Ball
    drawBall()
    {
        ctx.beginPath();
        ctx.fillStyle = this.color;
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
    }
    // Ball se déplace
    movingBall()
    {
        // Ball rebondi si elle touche un côté
        if (this.x + this.size >= canvas.width || this.x - this.size <= 0) {
            this.velX = -this.velX;
        }
        if (this.y + this.size >= canvas.height || this.y - this.size <= 0) {
            this.velY = -this.velY;
        }
        
        // la position de Ball se met à jour
        this.x += this.velX;
        this.y += this.velY;
    }
}