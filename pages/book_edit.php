<?php 
    $bookDao = new \dao\BookDao();
    $genreDao = new \dao\GenreDao();
    $editedISBN = filter_input(INPUT_GET,'isbn');
    if(isset($editedISBN)){
        $book =$bookDao->fetchOneBook($editedISBN);
    }
    $bookAwal = fetchJoinFromDb2();
    $updatePressed = filter_input(INPUT_POST,'btnUpdate');
    if(isset($updatePressed)){
        $ISBN = filter_input(INPUT_POST,'ISBN');
        $title = filter_input(INPUT_POST,'title');
        $author = filter_input(INPUT_POST,'author');
        $publisher = filter_input(INPUT_POST,'publisher');
        $publishYear = filter_input(INPUT_POST,'publishYear');
        $shortDesc = filter_input(INPUT_POST,'shortDesc');
        $idGenre = filter_input(INPUT_POST,'idGenre');
        if(trim($ISBN) == ''||trim($title) == ''||trim($author) == ''||trim($publisher) == ''||trim($shortDesc) == ''||trim($idGenre) == ''){
            echo '
            <div class="text-center">
                Please provide with a valid name
            </div>
            ';}else{
            $bookUpdate = new \entity\Book();
            $genreBook = new \entity\Genre();
            $bookUpdate->setISBN($book->getISBN());
            $bookUpdate->setTitle($title);
            $bookUpdate->setAuthor($author);
            $bookUpdate->setPublisher($publisher);
            $bookUpdate->setPublish_year($publishYear);
            $bookUpdate->setShort_description($shortDesc);
            $genreBook->setId($idGenre);
            $bookUpdate->setGenre($genreBook);
            $results = $bookDao->updateBookToDb($bookUpdate);
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

    $changePressed = filter_input(INPUT_POST,'coverUpload');
    if(isset($changePressed)){
        $fileName = filter_input(INPUT_GET,'isbn');
        $targetDir = 'uploads/';
        $fileExtension = pathinfo($_FILES['txtFile']['name'],PATHINFO_EXTENSION);
        $fileNameExtension=$fileName.'.'.$fileExtension;
        $fileUploadPath = $targetDir.$fileName.'.'.$fileExtension;
        if($_FILES['txtFile']['size']>1024*8192){
            echo '<div>Uploaded file exceed 8MB</div>';
        }
        else{
            move_uploaded_file($_FILES['txtFile']['tmp_name'],$fileUploadPath);
            $results = updateCoverToDb($editedISBN,$fileNameExtension);
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





?>

<div class="container" style="height:auto">
   <div class="row d-flex text-start justify-content-center my-3">
        <div class="col-md-6">
            <form method="post">
            <div class="mb-3">
                <label for="ISBNNum" class="form-label">ISBN</label>
                <input type="text" class="form-control" name="ISBN" id="ISBNNum" maxlength="13" readonly value="<?php echo($book->getISBN()); ?>" placeholder="ISBN">
            </div>
            <div class="mb-3">
                <label for="bookTitle" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="bookTitle" maxlength="100" required autofocus value="<?php echo($book->getTitle()); ?>" placeholder="Title">
            </div>
            <div class="mb-3">
                <label for="authorBook" class="form-label">Author</label>
                <input type="text" class="form-control" name="author" id="authorBook" maxlength="100" required autofocus value="<?php echo($book->getAuthor()); ?>" placeholder="Author">
            </div>
            <div class="mb-3">
                <label for="bookPublisher" class="form-label">Publisher</label>
                <input type="text" class="form-control" name="publisher" id="bookPublisher" maxlength="100" required autofocus value="<?php echo($book->getPublisher()); ?>" placeholder="Publisher">
            </div>
            <div class="mb-3">
                <label for="pubYear" class="form-label">Publish Year</label>
                <input type="number" class="form-control" name="publishYear" id="pubYear"  required autofocus value="<?php echo($book->getPublish_year()); ?>" placeholder="Publish Year">
            </div>
            <div class="mb-3">
                <label for="shortDesc" class="form-label">Short Description</label>
                <textarea  rows="4" type="textarea" class="form-control" name="shortDesc" id="shortDesc" maxlength="300" required autofocus >
                <?php echo($book->getShort_description()); ?>
                </textarea>
            </div>
            <div class="mb-3">
                <label for="IDgenre" class="form-label">Genre Name</label>
                <select class="form-select" name="idGenre" aria-label="Default select example" required>
                <?php
                    $genres = $genreDao->fetchGenreFromDb();
                    /**  @var $genre \entity\Genre */
                    foreach($genres as $genre ){
                        echo '<option value="'. $genre->getId().'">'.$genre->getName().'</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="btnUpdate">Update Data</button>
            
            </form>
            <div class="container" style="height:100vh">
                <div class="row d-flex text-start justify-content-center my-3">
                    <div class="col-md-6 text-center">
                        <h1>Change Cover</h1>
                        <?php
                        if ($book->getCover() != '') {
                            echo '<img class="rounded-3" src="uploads/' . $book->getCover() . '" style="width:100%;height:auto;max-width:500px;max-height:500px; text-align:center;">';
                        }
                        else{
                            echo '<img class="rounded-3" src="uploads/default.png" style="width:100%;height:auto;max-width:500px;max-height:500px; text-align:center;">';
                        }
                        ?>
                        <form method="post" enctype="multipart/form-data">

                            <div class="mb-3">
                                <input type="file" class="form-control my-3" name="txtFile" accept="image/jpg" required>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 text-warning" name="coverUpload">Change Cover</button>

                        </form>
                    </div>


                </div>
            </div>
        </div>
        
       
    </div>
</div>