"use strict";

import { Mouse } from "./mouse.js";
import { PaintApp } from "./PaintApp.js";
import { History } from "./history.js";


const Shape = {
    originalShapePos : {}, 
    snapshot: null,
    /**
     * draw with the square tool
     * @param {MouseEvent} e 
     * @param {string} state The value can be "start", "selection" or "end"
     */
    drawWithShape(e, state)
    {
        const {params, canvas, ctx} = PaintApp;
        if(!params.painting)return;
        const lastPos = Mouse.getMousePos(e);
        if(state === "start")
        {
            this.originalShapePos = lastPos;
            this.snapshot = ctx.getImageData(0,0,canvas.width, canvas.height);
            // shapeSelector.style.display = "block";
            return;
        }
        const shape = this.getShapeRect(this.originalShapePos, lastPos);
        ctx.putImageData(this.snapshot, 0,0);
        if(state === "selection")
        {
            this.drawShape(shape);
            return;
        }
        
        this.drawShape(shape);
        History.addAction(shape);
    },
    /**
     * draw the requested shape
     * @param {{x:number, y:number, width: number, height:number}} shape 
     */
    drawShape(shape)
    {
        const {params, ctx} = PaintApp;
        switch(params.tool)
        {
            case "square":
                ctx.strokeRect(shape.x, shape.y, shape.width, shape.height);
                break;
            case "circle":
                ctx.beginPath();
                ctx.ellipse(shape.x + shape.width/2, shape.y +shape.height/2, shape.width/2, shape.height/2, 0, 0, Math.PI*2);
                ctx.stroke();
                break;
        }
    },
    /**
     * Return the position and size of the shape
     * @param {{x:number, y:number}} originalPos Starting position of the shape
     * @param {{x:number, y:number}} lastPos last position of the shape
     * @returns {{x:number, y:number, width: number, height:number}}
     */
    getShapeRect(originalPos, lastPos) 
    {
        const shape = {};
        if(originalPos.x < lastPos.x)
        {
            shape.x = originalPos.x;
            shape.width = lastPos.x - originalPos.x;
        }
        else
        {
            shape.x = lastPos.x;
            shape.width = originalPos.x - lastPos.x;
        }
        if(originalPos.y < lastPos.y)
        {
            shape.y = originalPos.y;
            shape.height = lastPos.y - originalPos.y;
        }
        else
        {
            shape.y = lastPos.y;
            shape.height = originalPos.y - lastPos.y;
        }
        return shape;
    }
};

export {Shape};