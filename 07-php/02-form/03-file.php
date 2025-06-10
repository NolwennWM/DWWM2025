<?php 
$error = $target_file = $target_name = $mime_type = $oldName = "";
// ファイルをアップロードするフォルダへのパス：
$target_dir = "./upload/";
// アップロードを許可するMIMEタイプ：
$types_permis = ["image/png", "image/jpeg", "image/gif", "application/pdf"];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['upload']))
{
    // echo '<pre>'.print_r($_FILES, 1).'</pre>';

    // ファイルが正しくアップロードされたかを確認
    if(!is_uploaded_file($_FILES["monFichier"]["tmp_name"]))
    {
        $error = "ファイルを選択してください。";
    }
    else
    {
        /* 
            basename関数はファイル名の最後の部分を取得します。
            例：
                ファイル名が "pizza/margarita.png" の場合、
                "margarita.png" のみを取得します。
        */
        $oldName = basename($_FILES["monFichier"]["name"]);
        /* 
            同じ名前のファイルがすでに存在する場合、
            新しくアップロードされたファイルが既存のものを上書きしてしまいます。
            そのため、毎回一意のファイル名を生成します。
            ここでは "uniqid" 関数を使用しています。
        */
        $target_name = uniqid(time()."-", true) . "-".$oldName;
        // var_dump($target_name);

        // アップロード先のパスと新しいファイル名を連結
        $target_file = $target_dir . $target_name;

        // ファイルのMIMEタイプを取得
        $mime_type = mime_content_type($_FILES["monFichier"]["tmp_name"]);

        // 同じ名前のファイルがすでに存在していないか確認
        if(file_exists($target_file))
        {
            $error = "このファイルはすでに存在しています。";
        }

        /* 
            ファイルサイズが大きすぎないかを確認
            ※注意：PHPの設定には、アップロードできるファイルサイズの上限やPOSTデータのサイズ上限があります（php.iniを参照）。
        */
        if($_FILES["monFichier"]["size"] > 500000)
        {
            $error = "ファイルサイズが大きすぎます。";
        }
        // ファイルのMIMEタイプが許可されたものかを確認
        if(!in_array($mime_type, $types_permis))
        {
            $error = "許可されていないファイルタイプです。";
        }

        if(empty($error))
        {
            /* 
                一時フォルダからアップロードフォルダにファイルを移動します。
                move_uploaded_file関数は成功したかどうかを示すブール値を返します。
            */
            if(move_uploaded_file($_FILES["monFichier"]["tmp_name"], $target_file))
            {
                // 必要であれば、ここでファイルの情報をデータベースに保存できます。
            }else
            {
                $error = "アップロード中にエラーが発生しました。";
            }
        }
    }// ファイルの確認処理終了
}

$title = "アップロード";
require("../ressources/template/_header.php");
?>
<form action="03-file.php" method="post" enctype="multipart/form-data">
    <label for="monFichier">ファイルを選択してください：</label>
    <input type="file" name="monFichier" id="monFichier">
    <input type="submit" value="送信" name="upload">
    <span class="error"><?= $error??"" ?></span>
</form>

<!-- アップロードの確認メッセージ -->
<?php if(isset($_POST["upload"]) && empty($error)):?>
    <p>
        ファイルは「<?= $target_name ?>」という名前で正常にアップロードされました。<br>
        以下のリンクからダウンロードできます： 
        <a 
            href="<?= $target_file ?>" 
            download="<?= $oldName ?>"
            >
            こちら
        </a>
    </p>
<?php 
endif;
require("../ressources/template/_footer.php");
?>

