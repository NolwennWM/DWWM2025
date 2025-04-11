import { History } from "./history.js";
import { PaintApp } from "./PaintApp.js";
import { Mouse } from "./mouse.js";


const Pen = {

    /**
     * Draw with the pen
     * @param {MouseEvent} e 
     */
    drawWithPen(e)
    {    
        const {ctx} = PaintApp;
        ctx.lineCap = "round";
        let mouse = Mouse.getMousePos(e);
        /* On dessine là où se trouve la souris. */
        ctx.lineTo(mouse.x, mouse.y);
        ctx.stroke();
        // on augmente un peu la fluidité avec ceci: (optionnelle)
        ctx.beginPath();
        ctx.moveTo(mouse.x, mouse.y);
        History.addAction({
            x: mouse.x,
            y: mouse.y
        });
    }
}
export {Pen};