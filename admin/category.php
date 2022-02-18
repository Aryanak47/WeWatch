<?php 
    require_once('../includes/config.php');
    require_once('../includes/checkAdmin.php');
    if(isset($_POST['update'])){
        $id = $_POST["updateId"];
        $category = $_POST["category"];
        $category = ucfirst($category);
        $query = $conn->prepare("UPDATE categories  SET name=:nam  where id =:id");
        $query->bindValue(':nam', $category);
        $query->bindValue(':id', $id);
        $query->execute();
        header("Refresh:0");
        die();
    }
    if(isset($_POST['deleteBtn'])){
        $id = $_POST["deleteBtn"];
        $query = $conn->prepare("DELETE FROM  categories   where id =:id");
        $query->bindValue(':id', $id);
        $query->execute();
        header("Refresh:0");
        die();
    }
    if(isset($_POST["submit"])){
        $category = $_POST["category"];
        $category = ucfirst($category);
        $query = $conn->prepare("INSERT INTO categories (name) VALUES(:category)");
        $query->bindValue(':category', $category);
        $query->execute();
        header("Refresh:0");
        die();
    }
    $query = $conn->prepare("SELECT * FROM categories");
    $query->execute();
    $categories = $query->fetchAll();
    $totalCategories = count($categories);

    function getInputValue()
    {
        if(isset($_POST['editBtn'])){
            echo $_POST['updateCategory']; 
        }
    }


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .box{
            border-top: 4px solid #00ED82;
            margin: 0 10px;
        }
        .row{
            margin: 0
        }
        table{
            overflow-y: scroll;
            display: block;
            height: 50vh;

        }
 
  
    }
    </style>
</head>
<body>
    <div class="layout-container">
        
        <?php include 'side-nav.inc.php'; ?>
        <div class="main ">
            <header class="header d-flex justify-content-end ">
                <nav class="user-nav">
                    <div class="user-nav__user dropdown">
                        <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/user-1.jpg" alt="User photo" class="user-nav__user-photo">
                            <span class="user-nav__user-name">Admin</span>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a href="userProfile.php" class="dropdown-item">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>Profile</span>
                            
                            </a>
                            <a href="uploadMovie.php" class="dropdown-item"> 
                                <i class="fa fa-upload" aria-hidden="true"></i> <span>Upload Movie</span>
                            </a>
                            <a href="uploadSeries.php" class="dropdown-item">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                <span>Upload Series</span>
                            </a>
                        </div>
                    </div>

                </nav>
            </header>
              
            <h2>Add Category</h2>
                <div class="row  mt-5">
                    <div class="col-md-4">
                        <div class="box">
                           
                                <h3 class="box-title">Category Form</h3>
                            <form class="form" method="post">
                                <div class="box-body">
                                        <label for="category"></label>
                                        <input type="text" id="category" name="category" class="form-control" value=<?php getInputValue() ?> >
                                        <?php if(isset($_POST['editBtn'])){ $id = $_POST['editBtn']; ?>
                                            <input class='mt-4 btn btn-success' name='update' type='submit' value='Update'>
                                            <input type='hidden' name='updateId' value=<?php echo $_POST["editBtn"] ?> 
                                        <?php }else{?>
                                            <input class="mt-4 btn btn-success" name="submit" type="submit" value="Submit">
                                        <?php } ?> 
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2>Total <?= $totalCategories + 1 ?></h2>
                    <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>						
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($categories as $cats):?>
                            <td><?= $cats["id"]?></td>
                            <td><?= $cats["name"]?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="updateCategory" value="<?= $cats["name"]?>">
                                    <button name="editBtn" value="<?= $cats["id"]?> ?>" class="btn btn-success">Edit</button>
                                    <button name="deleteBtn" value="<?= $cats["id"]?>" class="btn btn-danger">Delete</button>
                                
                                </form>
                                </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                </div>
          
        </div>  
        
    </div>
   
    
</body>
</html>