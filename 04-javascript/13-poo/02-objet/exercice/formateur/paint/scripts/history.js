"use strict";
import { PaintApp } from "./PaintApp.js";

const History = {
    undoList: [], redoList: [], lastAction: [],
    
    
    addAction(action)
    {
        
        this.lastAction.push(action);
    },
    
    saveAction()
    {
        if(!this.lastAction.length)return;
        const params = PaintApp.params;
        const undoAction = {
            usedTool: params.tool,
            actions: this.lastAction,
            color: params.color,
            size: params.size
        }
        this.undoList.push(undoAction);
        this.lastAction = [];
        this.checkDisabled();
    },
    
    /**
     * Cancel the last actions
     */
    undo(){
        if(!this.undoList.length)return;
        const {ctx, canvas} = PaintApp;
        let redoAction = this.undoList.pop();
        this.redoList.push(redoAction);
        ctx.clearRect(0,0,canvas.width, canvas.height);
        this.redraw(this.undoList);
        this.checkDisabled();
    },
    /**
     * Redo the last canceled actions
     */
    redo(){
        if(!this.redoList.length)return;
        let redoAction = this.redoList.pop();
        this.undoList.push(redoAction);
        this.redraw([redoAction]);
        this.checkDisabled();
    },
    /**
     * check if the undo and redo buttons have to be disabled.
     */
    checkDisabled()
    {
        PaintApp.btnUndo.disabled = !this.undoList.length
        PaintApp.btnRedo.disabled = !this.redoList.length
    },
    /**
     * draw the actions sent on parameter
     * @param {Array} tab Array of actions to do
     */
    redraw(tab){
        const {ctx} = PaintApp;
        tab.forEach(action =>{
            ctx.strokeStyle = action.color;
            ctx.lineWidth = action.size;
            let move;
            switch(action.usedTool)
            {
                case "pen":
                    ctx.beginPath();
                    action.actions.forEach(move=>{
                        ctx.lineTo(move.x, move.y);
                        ctx.stroke();
                        ctx.beginPath();
                        ctx.moveTo(move.x, move.y);
                    })
                    break;
                case "square":
                    move = action.actions[0];
                    ctx.strokeRect(move.x, move.y, move.width, move.height);
                    break;
                case "circle":
                    move = action.actions[0];
                    ctx.beginPath();
                    ctx.ellipse(move.x + move.width/2, move.y +move.height/2, move.width/2, move.height/2, 0, 0, Math.PI*2);
                    ctx.stroke();
                    break;
            }
            
        })
        ctx.beginPath();
    }

};

export {History};