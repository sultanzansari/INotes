<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'notepad';
$insert = false;
$update = false;
$delete = false;

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    die("Sorry We Failed To Connect".mysqli_connect_error());
};

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM `note_info` WHERE `note_info`.`id` = $id;";
        $res = mysqli_query($conn,$sql);
    
        if($res){
            $delete = true;
        }else{
            echo "The Record has'nt Been Deleted Successfully".mysqli_error();
        }
}else{
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['idEdit'])){
            $idEdit = $_POST['idEdit'];
            $titleEdit = $_POST['titleEdit'];
            $descriptionEdit = $_POST['descriptionEdit'];
        
            $sql = "UPDATE `note_info` SET `title` = '$titleEdit', `description` = '$descriptionEdit' WHERE `note_info`.`id` = $idEdit;";
            $res = mysqli_query($conn,$sql);
        
            if($res){
                $update = true;
            }else{
                echo "The Record has'nt Been inserted Successfully".mysqli_error();
            }
        }else{
            $title = $_POST['title'];
            $description = $_POST['description'];
        
            $sql = "INSERT INTO `note_info`(`title`, `description`) VALUES ('$title','$description')";
            $res = mysqli_query($conn,$sql);
        
            if($res){
                $insert = true;
            }else{
                echo "The Record has'nt Been inserted Successfully".mysqli_error();
            }
        }
    };
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
     rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
     crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <title>NotePad</title>
</head>
<body>
<!-- Edit Modal -->
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit This Notes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="notePad.php" method="POST">
            <input type="hidden" name="idEdit" id="idEdit">
                <div class="mb-3">
                    <label for="titleEdit" class="form-label">Note Title</label>
                    <input type="text" class="form-control" id="titleEdit" name="titleEdit">
                </div>
                <div class="mb-3">
                    <label for="descriptionEdit" class="form-label">Note Description</label>
                    <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="4"></textarea>
                </div>
                <div class="modal-footer d-block mr-auto">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Nav -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="PHP.svg" alt="PHP" width='100px' height='50px'></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <?php 
        if($insert){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> Your Note Has Been Inserted Successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                 </div>";
        }
    ?>
    <?php 
        if($update){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> Your Note Has Been Updated Successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
    ?>
        <?php 
        if($delete){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> Your Note Has Been Deleted Successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
    ?>
    <div class="container my-3">
        <h1>Add Notes</h1>
        <form action="notePad.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Notes</button>
        </form>
    </div>
    
    <div class="container my-3">
        <table class="table">
            <table id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM note_info";
                    $res = mysqli_query($conn,$sql);
                    $sno = 0;
                    while($row = mysqli_fetch_assoc($res)){
                        $sno = $sno+1;
                        echo   "<tr>
                                    <td scope='row'>".$sno."</td>
                                    <td>".$row['title']."</td>
                                    <td>".$row['description']."</td>
                                    <td><button class='edit btn btn-sm btn-primary' id=".$row['id'].">Edit</button> 
                                    <button class='del btn btn-sm btn-primary' id=".$row['id'].">Delete</button></td>
                                </tr>";
                                // Anything in double quotes the variable inside will be interpolated or evaluated.
                    };
                ?>
                </tbody>
            </table>
        </table>
        <hr>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="NotePad.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</body>
</html>