<?php 
namespace Classes\Trait;

trait Debug
{
    /**
     * 引数として渡された値を見やすく表示します。
     *
     * @param any[] ...$values 任意の値（複数可）
     * @return void
     */
    public function dump(...$values)
    {
        // highlight_string の表示色を設定
        ini_set("highlight.comment","#008000");
        ini_set("highlight.default","#000000");
        ini_set("highlight.html","#808080");
        ini_set("highlight.keyword","#0000BB; font-weight: bold");
        ini_set("highlight.string","#DD0000");

        // preタグのCSSスタイルを設定
        $style = 
        "background-color: #DDDDDD;
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
     * 引数を表示し、その後スクリプトの実行を停止します。
     *
     * @param any[] ...$values 任意の値（複数可）
     * @return void
     */
    public function dieAndDump(...$values)
    {
        $this->dump(...$values);
        die;
    }
}
