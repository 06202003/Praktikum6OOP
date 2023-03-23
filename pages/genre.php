<?php
$genreDao = new \dao\GenreDao();
$deleteCommand = filter_input(INPUT_GET,'cmd');
if(isset($deleteCommand) && $deleteCommand = 'del'){
    $genreId = filter_input(INPUT_GET,'gid');
    $results = $genreDao->deleteGenreFromDb($genreId);
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
    $name = filter_input(INPUT_POST,'textName');
    if(trim($name) == ''){
        echo '
        <div class="text-center">
            Please provide with a valid name
        </div>
        ';
    }else{
        $genre = new \entity\Genre();
        $genre->setName($name);
        $results = $genreDao->addNewGenre($genre);
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
}


?>

<div class="container text-center mt-4" style="height:auto">
<div class="row d-flex text-start justify-content-center my-3 align-items-center">
<div class="col-md-8">
            <div class="table-responsive">        
                <table class="table table-hover   table-bordered border-danger table-sm" id="genre">            
                    <thead>
                        <tr>
                            <th class=" text-center" scope="col">ID</th>
                            <th class=" text-center" scope="col">NAME</th>
                            <th class=" text-center" scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody >
                        <?php
                        $results = $genreDao->fetchGenreFromDb();
                        /**@var $genre \entity\Genre */
                        foreach($results as $genre ){
                            echo '<tr>';
                            echo '<td class="darkmode text-center">'. $genre->getId() . '</td>';
                            echo '<td class="darkmode text-center">'. $genre->getName() . '</td>';
                            echo '<td class="text-center ">
                                <button type="button" class="btn my-1 btn-warning" onclick="editGenre('.$genre->getId().')"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn my-1 btn-danger" onclick="deleteGenre('.$genre->getId().')"><i class="fa-solid fa-trash"></i></button>
                            </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary mt-5 w-75" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Tambah Data Genre
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form method="post">
                <div class="mb-3">
                    <label for="namaGenre" class="form-label">Genre Name</label>
                    <input type="text" class="form-control" name="textName" id="namaGenre" maxlength="45" required autofocus placeholder="Genre Name">
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

    <div class="row d-flex justify-content-center mb-5 mb-3">
       </div>
</div>
<script src="script/genre_index.js"></script>