import { PaintApp } from "./PaintApp.js";

const PaintInterface = {
    /**
     * Check if the tool exist and change it
     */
    changeTool()
    {
        const 
            selectedTool = this.dataset.tool,
            {toolList, params, canvas} = PaintApp;
        if(!toolList.includes(selectedTool))return;
        params.tool = selectedTool
        canvas.dataset.tool = selectedTool;
    },
    /**
     * Load a new draw in the canvas
     */
    load(){
        // je crée un nouvel element input
        let input = document.createElement("input");
        // je lui donne le type file
        input.setAttribute("type", "file");
        // je le clique
        input.click();
        // Quand je rentre un fichier.
        input.oninput = function(e){
            // Je crée un lecteur de fichier.
            let reader = new FileReader();
            // quand je charge un fichier dans mon lecteur
            reader.onload = function(event){
                //je crée une nouvelle image.
                let img = new Image();
                // quand mon image est chargé:
                img.onload = function(){
                    const {ctx, canvas} = PaintApp;
                    // je vide mon canvas
                    ctx.clearRect(0,0,canvas.width, canvas.height);
                    //J'ajoute ma nouvelle image
                    ctx.drawImage(img, 0,0);
                }
                /* J'ajoute à la source de mon image ce que me retourne
                mon lecteur */
                img.src = event.target.result;
            }
            // Je donne à mon lecteur, le fichier selectionné.
            reader.readAsDataURL(e.target.files[0]);
        }
    },
    /**
     * Download the current draw
     */
    save(){
        /* On change les données du canvas en donnée png sous forme de
        string */
        let png = PaintApp.canvas.toDataURL("image/png");
        /* On vient remplacer son type mime par un autre plus apte
        au transfère de donnée. */
        png.replace("image/png", "application/octet-stream");
        // Je crée un lien
        let link = document.createElement("a");
        // Je viens lui ajouter l'attribut download avec le nom du fichier.
        link.setAttribute("download", "SauvegardeCanvas.png");
        // On lui ajoute son href avec mon image en valeur.
        link.setAttribute("href", png);
        // et on le clique
        link.click();
    },
    /**
     * set the current color
     */
    chooseColor(){
        // je donne sa valeur à ma variable color.
        PaintApp.params.color = PaintApp.inputColor.value;
        PaintApp.setContext();   
    },
    /**
     * Change size of the lines
     */
    handleSetSize()
    {
        const {inputSize, minSize, maxSize, params} = PaintApp;
        let size = inputSize.value;
        if(size < minSize) size=minSize; 
        else if(size > maxSize) size=maxSize; 
        params.size = size;
        inputSize.value = size;
        PaintApp.setContext();
    }

};

export {PaintInterface};