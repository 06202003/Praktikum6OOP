<?php 
    $bookDao = new \dao\BookDao();
    $editedISBN = filter_input(INPUT_GET,'isbna');
    if(isset($editedISBN)){
        $book = $bookDao->fetchOneBook($editedISBN);
        $updatePressed = filter_input(INPUT_POST,'btnUpload');
        if(isset($updatePressed)){
            $isbn = filter_input(INPUT_GET,'isbna');
            $fileName = filter_input(INPUT_GET,'isbna');
            $targetDir = 'uploads/';
            $fileExtension = pathinfo($_FILES['txtFile']['name'],PATHINFO_EXTENSION);
            $fileNameExtension=$fileName.'.'.$fileExtension;
            $fileUploadPath = $targetDir.$fileName.'.'.$fileExtension;
            if($_FILES['txtFile']['size']>1024*8192){
                echo '<div>Uploaded file exceed 8MB</div>';
            }
            else{
                move_uploaded_file($_FILES['txtFile']['tmp_name'],$fileUploadPath);
                $coverUpdate = new \entity\Book();
                $coverUpdate->setCover($fileNameExtension);
                $coverUpdate->setISBN($isbn);
                $results = $bookDao->updateCoverToDb($coverUpdate);
                if($results){
                    header('location:index.php?menu=book');
                }else{
                    echo '
                    <div>
                        Failed to add data
                    </div>
                ';
                }
            }
        }
    }
?>

<div class="container" style="height:100vh">
   <div class="row d-flex text-start justify-content-center my-3">
        <div class="col-md-6 text-center">
            <h1>Change Cover</h1>
            <?php
            if ($book->getCover() != '') {
                echo '<img class="rounded-3" src="uploads/' . $book->getCover() . '" style="width:100%;height:auto;max-width:500px;max-height:500px; text-align:center;">';
            }
            else{
                echo '<img class="rounded-3" src="uploads/default.jpg" style="width:100%;height:auto;max-width:500px;max-height:500px; text-align:center;">';
            }
            ?>
            <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <input type="file" class="form-control my-3" name="txtFile" accept="image/jpg" required>
            </div>
            <button type="submit" class="btn btn-dark w-100 text-warning" name="btnUpload">Upload File to Server</button>
            
            </form>
        </div>
        
       
    </div>
</div>