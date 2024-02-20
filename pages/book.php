<?php
$BookDao=new \dao\BookDao();
$genreDao=new \dao\GenreDao();

$deletecmd = filter_input(INPUT_GET,'comd');
if(isset($deletecmd) && $deletecmd = 'dele'){
    $ISBNdel = filter_input(INPUT_GET,'idb');
    $book=$BookDao->fetchOneBook($ISBNdel);
    $cover = $book->getCover();
    if($cover != 'default.png'){
        unlink('uploads/'.$book->getCover());
    }
    $results =$BookDao->deleteBookFromDb($ISBNdel);

    if($results){
        echo '
        <div>
            Data Successfully added
        </div>
    ';
    }else{
        echo '
        <div>
            Failed to add data
        </div>
    ';
    }
}

$submitPressed = filter_input(INPUT_POST,'btnSave');
if(isset($submitPressed)){
    $ISBN = filter_input(INPUT_POST,'ISBN');
    $title = filter_input(INPUT_POST,'title');
    $author = filter_input(INPUT_POST,'author');
    $publisher = filter_input(INPUT_POST,'publisher');
    $publishYear = filter_input(INPUT_POST,'publishYear');
    $shortDesc = filter_input(INPUT_POST,'shortDesc');
    $cover = filter_input(INPUT_POST,'cover');
    $idGenre = filter_input(INPUT_POST,'idGenre');
    if(trim($ISBN) == ''||trim($title) == ''||trim($author) == ''||trim($publisher) == ''||trim($shortDesc) == ''||trim($idGenre) == ''){
        echo `
        <div class="text-center">
            Please provide with a valid name
        </div>
        `;
    }else{
        $bookAdd= new \entity\Book();
        $bookAdd->setIsbn($ISBN);
        $bookAdd->setTitle($title);
        $bookAdd->setAuthor($author);
        $bookAdd->setPublisher($publisher);
        $bookAdd->setPublish_year($publishYear);
        $bookAdd->setShort_description($shortDesc);
        $bookAdd->setCover($cover);
        $genreBook= new \entity\Genre();
        $genreBook->setId($idGenre);
        $bookAdd->setGenre($genreBook);
        $results = $BookDao->addNewBook($bookAdd);
    }
}


?>
<div class="container text-center mt-3 h-100 mb-5">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Tambah Data
    </button>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-12">    
            <div class="table-responsive">        
                <table class="table table-bordered table-hover responsive" style="width:100%" id="book">
                    <thead>
                    <tr>
                        <th class=" text-center" scope="col">ISBN</th>
                        <th class=" text-center" scope="col">Cover</th>
                        <th class=" text-center" scope="col">Title</th>
                        <th class=" text-center" scope="col">Author</th>
                        <th class=" text-center" scope="col">Publisher</th>
                        <th class=" text-center" scope="col">Publish Year</th>
                        <th class=" text-center" scope="col">Nama Genre</th>
                        <th class=" text-center w-25" scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody >
                    <?php
                    $result = $BookDao->fetchJoinFromDb();
                    /**  @var $book \entity\Book */
                    foreach($result as $book ){
                        echo '<tr >';
                        echo '<td>'. $book->getIsbn() . '</td>';
                        if ($book->getCover() != '') {
                            echo '<td class="py-2 px-2"> <img class="rounded-3" src="./uploads/'.$book->getCover().'" style="width:100%;height:auto;max-width:500px;max-height:500px;"></td>';

                        }
                        else {
                            echo '<td class="py-2 px-2"> <img class="rounded-3" src="./uploads/default.jpg" style="width:100%;height:auto;max-width:500px;max-height:500px;"></td>';
                        }
                        echo '<td >'. $book->getTitle() . '</td>';
                        echo '<td>'. $book->getAuthor() . '</td>';
                        echo '<td>'. $book->getPublisher() . '</td>';
                        echo '<td>'. $book->getPublish_year() . '</td>';
                        echo '<td>'. $book->getGenre()->getName() . '</td>';
                        echo '<td>
                        <button type="button" class="btn m-2 btn-success" onclick="editCover(\''.$book->getIsbn().'\')"><i class="fa-solid fa-image"></i></button>
                        <button type="button" class="btn m-2 btn-warning" onclick="editBook(\''.$book->getIsbn().'\')"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button type="button" class="btn m-2 btn-danger"  onclick="deleteBook(\''.$book->getIsbn().'\')" ><i class="fa-solid fa-trash"></i></button>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
       </div>
                
    


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post">
            <div class="mb-3">
                <label for="ISBNNum" class="form-label">ISBN</label>
                <input type="text" class="form-control" name="ISBN" id="ISBNNum" maxlength="13" required autofocus placeholder="ISBN">
            </div>
            <div class="mb-3">
                <label for="bookTitle" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="bookTitle" maxlength="100" required autofocus placeholder="Title">
            </div>
            <div class="mb-3">
                <label for="authorBook" class="form-label">Author</label>
                <input type="text" class="form-control" name="author" id="authorBook" maxlength="100" required autofocus placeholder="Author">
            </div>
            <div class="mb-3">
                <label for="bookPublisher" class="form-label">Publisher</label>
                <input type="text" class="form-control" name="publisher" id="bookPublisher" maxlength="100" required autofocus placeholder="Publisher">
            </div>
            <div class="mb-3">
                <label for="pubYear" class="form-label">Publish Year</label>
                <input type="number" class="form-control" name="publishYear" id="pubYear"  required autofocus placeholder="Publish Year">
            </div>
            <div class="mb-3">
                <label for="shortDesc" class="form-label">Short Description</label>
                <!-- <input type="textarea" class="form-control" name="shortDesc" id="shortDesc" maxlength="300" required autofocus > -->
                <textarea  rows="4" type="textarea" class="form-control" name="shortDesc" id="shortDesc" maxlength="300" required autofocus placeholder="Short Description" >
                </textarea>
            </div>
            <!-- <div class="mb-3">
                <label for="cover" class="form-label">Cover</label>
                <input type="text" class="form-control" name="cover" id="cover" maxlength="100"  autofocus placeholder="Cover">
            </div> -->
            <div class="mb-3">
                <label for="IDgenre" class="form-label">Genre Name</label>
                <select class="form-select" name="idGenre" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <?php
                    $genres = $genreDao->fetchGenreFromDb();
                    /**  @var $genre \entity\Genre */
                    foreach($genres as $genre ){
                        echo '<option value="'. $genre->getId().'">'.$genre->getName().'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary w-100" name="btnSave">Save Data</button>
              
            </div>
        </form>
    
      </div>
      
    </div>
  </div>
</div>
</div>
</div>

<script src="script/book_index.js"></script>