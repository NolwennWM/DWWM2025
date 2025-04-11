import { History } from "./history.js";
import { PaintApp } from "./PaintApp.js";
import { Pen } from "./pen.js";
import { Shape } from "./shape.js";

const Mouse = {
    /**
     * Return the position of the cursor in the canvas
     * @param {MouseEvent} evt 
     * @returns {{x:number, y:number}}
     */
    getMousePos(evt) {
        const rect = PaintApp.canvas.getBoundingClientRect();
        return {
            x: evt.clientX - rect.left,
            y: evt.clientY - rect.top
        };
    },
    
    /**
     * Start the draw.
     * @param {MouseEvent} e 
     */
    startPosition(e){
        // setPainting(true);
        PaintApp.params.painting = true;
        switch(PaintApp.params.tool)
        {
            case "pen":
                // pour faire des points au clique
                this.draw(e);
                break;
            case "circle":
            case "square":
                Shape.drawWithShape(e, "start");
                break;
    
        }
    },
    /**
     * Finish the draw
     * @param {MouseEvent} e 
     */
    finishedPosition(e){
        const params = PaintApp.params;
        switch(params.tool)
        {
            case "pen":
                params.painting = false;
                this.draw(e);
                break;
            case "circle":
            case "square":
                Shape.drawWithShape(e, "end");
                params.painting = false;
                break;
        }
    
        PaintApp.ctx.beginPath();
        History.saveAction();
    },
    
    /**
     * draw with the selected tool
     * @param {MouseEvent} e 
     */
    draw(e){
        // Si on n'est pas en train de dessiner, on arrête la fonction.
        
        if(!PaintApp.params.painting) return;
        switch(PaintApp.params.tool)
        {
            case "pen":
                Pen.drawWithPen(e);
                break;
            case "circle":
            case "square":
                Shape.drawWithShape(e, "selection");
                break;
                
        }
    }

}

export {Mouse};