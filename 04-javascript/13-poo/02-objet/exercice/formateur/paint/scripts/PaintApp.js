"use strict";

import { History } from "./history.js";
import { PaintInterface } from "./interface.js";
import { Mouse } from "./mouse.js";

const PaintApp = {
    minSize : 1, 
    maxSize : 100,
    toolList : ["pen", "square", "circle"],
    canvas : document.querySelector('canvas'),
    ctx : null,
    inputColor : document.querySelector(".btn-color"),
    inputSize : document.querySelector(".btn-size"),
    btnUndo : document.querySelector(".btn-undo"),
    btnRedo : document.querySelector(".btn-redo"),
    btnSave : document.querySelector(".btn-save"),
    btnLoad : document.querySelector(".btn-load"),
    btnsTool : document.querySelectorAll(".btn-tool"),
    params : {
        painting : false,
        tool : "pen", 
        color : "black", 
        size : 10
    },

    /**
     * Initialize the paint app with default values and events
     */
    init()
    {
        this.ctx = this.canvas.getContext("2d");
        this.inputColor.value = this.params.color;
        this.inputSize.value = this.params.size;

        this.resize();
        window.addEventListener("resize", this.resize.bind(this));
        
        // On commence à dessiner quand on enfonce le bouton de la souris
        this.canvas.addEventListener("mousedown", Mouse.startPosition.bind(Mouse));
        // On arrête quand on le relève.
        window.addEventListener("mouseup", Mouse.finishedPosition.bind(Mouse));
        // On dessine quand on déplace la souris.
        this.canvas.addEventListener("mousemove", Mouse.draw.bind(Mouse));
        // quand on appui sur une touche du clavier
        document.addEventListener("keypress", this.keyboard.bind(this));
        this.inputColor.addEventListener("change", PaintInterface.chooseColor);
        this.inputSize.addEventListener("change", PaintInterface.handleSetSize);
        this.btnUndo.addEventListener("click", History.undo.bind(History));
        this.btnRedo.addEventListener("click", History.redo.bind(History));
        this.btnSave.addEventListener("click", PaintInterface.save);
        this.btnLoad.addEventListener("click", PaintInterface.load);
        this.btnsTool.forEach(btn => {
            btn.addEventListener("click",PaintInterface.changeTool);
        });
    },
    /**
     * Handle keyboard actions
     * @param {KeyboardEvent} e 
     */
    keyboard(e){
        e.preventDefault();
        if(!e.shiftKey)return;
        
        // Selon la touche pressé je lance différente fonctions.
        switch(e.key.toLowerCase()){
            case "s":
                save();
                break;
            case "l":
                load();
                break;
            case "c":
                this.inputColor.click();
                break;
            case "z":
                undo();
                break;
            case "y":
                redo();
                break;
            case "+":
                this.inputSize.value++;
                setSize();
                break;
            case "-":
                this.inputSize.value--;
                setSize();
                break;
            case "1":
            case "2":
            case "3":
                this.btnsTool[e.key-1].click();
                break;
        }
        /*
            paramètre le contexte une fois que les autres actions l'ont modifié
            (par exemple les modifications apportés par le undo/redo)
        */
        this.setContext();
    },
    /**
     * resize Canvas when the page size change
     */
    resize(){
        let snapshot = this.ctx.getImageData(0,0, this.canvas.width, this.canvas.height)
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
        this.ctx.putImageData(snapshot, 0, 0)
        this.setContext();
    },
    
    /**
     * Change width and color context
     */
    setContext()
    {
        this.ctx.lineWidth = this.params.size;
        this.ctx.strokeStyle = this.params.color;
    }
}

export {PaintApp};