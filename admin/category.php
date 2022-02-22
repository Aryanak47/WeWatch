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
        $msg = "
        <script>
        swal('Success!', 'Updated Successfully!', 'success')
        </script>";
      
    }
    if(isset($_POST['deleteBtn'])){
        $id = $_POST["deleteBtn"];
        $query = $conn->prepare("DELETE FROM  categories   where id =:id");
        $query->bindValue(':id', $id);
        $query->execute();
            $msg = "<script>
            swal('Success!', 'Deleted Successfully!', 'success')
            </script>";
    }
    if(isset($_POST["submit"])){
        $category = $_POST["category"];
        $category = ucfirst($category);
        $query = $conn->prepare("INSERT INTO categories (name) VALUES(:category)");
        $query->bindValue(':category', $category);
        $query->execute();
        if( $query->rowCount() > 0 ) {
            $msg =  "
            <script>
            swal('Success!', 'New Category Added Successfully!', 'success')
            </script>";
            
            ;
        }
     
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



    <?php include 'top.inc.php'; ?>
    <div class="layout-container category">
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
                        <a href="video.php" class="dropdown-item"> 
                            <i class="fa fa-upload" aria-hidden="true"></i> <span>Upload Video</span>
                        </a>
                        <a href="userProfile.php" class="dropdown-item">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Logout</span>
                        
                        </a>
                        </div>
                    </div>

                </nav>
            </header>
            <?php if (isset($msg)) {
                echo $msg;
            } ?>
              
            <h2>Add Category</h2>
                <div class="row  mt-5">
                    <div class="col-md-4">
                        <div class="box">
                           
                                <h3 class="box-title">Category Form</h3>
                            <form class="form" method="post">
                                <div class="box-body">
                                        <label for="category"></label>
                                        <input type="text" id="category" required name="category" class="form-control" value=<?php getInputValue() ?> >
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