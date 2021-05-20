<?php include('connect.php');
$delete = false;
$update = false;
$insert = false;

//Delete
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `note` WHERE `note`.`sno` = $sno;";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    header('Location: /crud/index.php');
  } else {
    $delete = false;
  }
}

//Edit & Insert
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_GET['update'])) {
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];

    $sql = "UPDATE `note` SET `title` = '$title', `description` = '$description' WHERE `note`.`sno` = $sno;";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      $update = true;
    } else {
      $update = false;
    }
  } 
  //Insert
  else {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO `note` (`title`, `description`) VALUES ('$title', '$description');";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      $insert = true;
    } else {
      $insert = false;
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

  <title>Crud</title>
</head>

<body>

  <!--Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/crud/index.php?update=true" method="POST" id="editForm">
            <input type="hidden" id="snoEdit" name="snoEdit">
            <div class="mb-3">
              <label for="titleEdit" class="form-label">Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit">
            </div>
            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"></textarea>
            </div>
            
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" form="editForm" class="btn btn-primary">Update Note</button>
        </div>
      </div>
    </div>
  </div>
 <!-- NAV BAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/crud/index.php">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/crud/index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://yash.sgtyug.com" target="_blank">About Me</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <?php
    //Alerts

  if ($insert == true) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been added successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  } elseif (mysqli_error($conn)) {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> There is some technical issue, Please Try Again.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  }

  ?>

<?php
  if ($update == true) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been updated successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  } elseif (mysqli_error($conn)) {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> There is some technical issue, Please Try Again.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  }

  ?>

<?php
  if ($delete == true) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been deleted successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  } elseif (mysqli_error($conn)) {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> There is some technical issue, Please Try Again.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  }

  ?>
<!-- InsertForm -->
  <div class="container my-4">
    <form action="/crud/index.php" method="POST">
      <h2>Add a Note</h2>
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" required name="title" placeholder="Add a title here">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" required placeholder="Add a description here" id="description" name="description"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>


 <!-- Data Table -->
  <div class="container">
    <table class="table" id="noteTable">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //View Data-Tables
        $sql = "SELECT * FROM `note`";
        $result = mysqli_query($conn, $sql);
        $sno = 1;
        while ($row = mysqli_fetch_assoc($result)) {
        ?>

          <tr>
            <th scope="row"><?php echo $sno; ?></th>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><button class="edit btn btn-primary" id="<?php echo $row['sno']; ?>" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button> <button class="delete btn btn-primary" id="d<?php echo $row['sno']; ?>">Delete</button></td>
          </tr>



        <?php
          $sno++;
        }
        ?>
      </tbody>
    </table>
  </div>

  <div class="container-fluid bg-dark text-white text-center p-3">
    Copyright © - All rights are reserved by <a class="link-warning"  href="https://yash.sgtyug.com/">Yash Kumar Sahu
  </div>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#noteTable').DataTable();
    });
  </script>

  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit", );
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete", );
        sno = e.target.id.substr(1,);
       if(confirm("Are you sure to Delete this note")){
         console.log('yes');
         window.location = `/crud/index.php?delete=${sno}`;
       }
       else{
         console.log('no');
       }
      })
    })
  </script>
</body>

</html>