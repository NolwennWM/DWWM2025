<?php 
namespace Classes\Trait;

trait Debug
{
    /**
     * Displays the provided arguments in a prettier way
     *
     * @param any[] ...$values
     * @return void
     */
    public function dump(...$values)
    {
        // highlight_string settings
        ini_set("highlight.comment","#008000");
        ini_set("highlight.default","#000000");
        ini_set("highlight.html","#808080");
        ini_set("highlight.keyword","#0000BB; font-weight: bold");
        ini_set("highlight.string","#DD0000");
        // CSS for the <pre> tag
        $style = 
        "background-color:gray;
        color: white;
        width: fit-content;
        padding: 1rem;
        border: 2px solid green;
        margin: 1rem auto;";

        foreach($values as $v)
        {
            $varexport = var_export($v, true);
            $message = highlight_string("<?php \n $varexport \n?>",true);
            echo "<pre style='$style'>$message</pre>";
        }
    }

    /**
     * Displays the provided arguments and then stops execution
     *
     * @param any[] ...$values
     * @return void
     */
    public function dd(...$values)
    {
        $this->dump(...$values);
        die;
    }
}
