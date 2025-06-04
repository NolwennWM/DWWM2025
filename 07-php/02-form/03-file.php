<?php 
$error = $target_file = $target_name = $mime_type = $oldName = "";
// Path to the folder where files will be uploaded:
$target_dir = "./upload/";
// MIME types allowed for upload:
$types_permis = ["image/png", "image/jpeg", "image/gif", "application/pdf"];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['upload']))
{
    // echo '<pre>'.print_r($_FILES, 1).'</pre>';

    // I check that the file has actually been uploaded.
    if(!is_uploaded_file($_FILES["monFichier"]["tmp_name"]))
    {
        $error = "Please select a file.";
    }
    else
    {
        /* 
            Basename retrieves the last part of the file name.
            Example:
                if the file is named "pizza/margarita.png"
                we will only get "margarita.png"
        */
        $oldName = basename($_FILES["monFichier"]["name"]);
        /* 
            If two files have the same name,
            the newly uploaded one will replace the existing one.
            So we generate a unique name for each file.
            There are several ways to do this; here we're using "uniqid"
        */
        $target_name = uniqid(time()."-", true) . "-".$oldName;
        // var_dump($target_name);

        // I concatenate the upload folder path with the new file name.
        $target_file = $target_dir . $target_name;

        // I get the MIME type of the file:
        $mime_type = mime_content_type($_FILES["monFichier"]["tmp_name"]);

        // I check if a file with the same name already exists.
        if(file_exists($target_file))
        {
            $error = "This file already exists.";
        }

        /* 
            I check that the file is not too large.
            ! WARNING: PHP settings already impose a file size limit for uploads,
            and a limit for the size of POST data. (See php.ini file)
        */
        if($_FILES["monFichier"]["size"] > 500000)
        {
            $error = "File too large.";
        }
        // I check that the file uses an allowed type:
        if(!in_array($mime_type, $types_permis))
        {
            $error = "File type not allowed.";
        }

        if(empty($error))
        {
            /* 
                I move the file from the temporary location to the upload folder.
                The move_uploaded_file function returns a boolean indicating
                whether the move was successful.
            */
            if(move_uploaded_file($_FILES["monFichier"]["tmp_name"], $target_file))
            {
                // At this point, we could store the file info in the database.
            }else
            {
                $error = "Error during upload.";
            }
        }
    }// End of file validation
}

$title = " Upload ";
require("../ressources/template/_header.php");
?>
<form action="03-file.php" method="post" enctype="multipart/form-data">
    <label for="monFichier">Choose a file:</label>
    <input type="file" name="monFichier" id="monFichier">
    <input type="submit" value="Send" name="upload">
    <span class="error"><?= $error??"" ?></span>
</form>

<!-- Upload confirmation: -->
<?php if(isset($_POST["upload"]) && empty($error)):?>
    <p>
        Your file has been successfully uploaded with the name "<?= $target_name ?>". <br>
        You can download it 
        <a 
            href="<?= $target_file ?>" 
            download="<?= $oldName ?>"
            >
            HERE
        </a>
    </p>
<?php 
endif;
require("../ressources/template/_footer.php");
?>
