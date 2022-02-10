
<?php 
       require_once('../includes/classes/config.php');
       require_once('../includes/classes/FormSanitizer.php');
       $title = "Users";
       $limit = 20;
       $page = isset($_GET['page']) ? $_GET['page'] :1;
       $start = ($page -1) * $limit;
       $query = $conn->prepare("SELECT * FROM users LIMIT $start, $limit");
       $query->execute();
       $users = $query->fetchAll();
       if(isset($_GET['search'])){
           $search = $_GET['search'];
           $search = FormSanitizer::sanitizeInput($search);
           $query = $conn->prepare("SELECT * FROM users  WHERE firstName LIKE '%$search%'
                                    OR email LIKE '%$search%'
                                    OR username LIKE '%$search%'");
           $query->execute();
           $users = $query->fetchAll();
       }
       $totalFetch = count($users);
       $query = $conn->prepare("SELECT count('id') AS id FROM users ");
       $query->execute();
       $total = $query->fetchAll();
       $total = $total[0]["id"];
       $previous = $page > 1 ? $page -1:1;
       $next = $page +1;
       $totalPages = ceil($total/$limit);
       
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
        <!-- <link rel="shortcut icon" type="image/png" href="img/favicon.png"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/style.css">
        <title>Admin Dashboard</title>
    </head>
    <body>
        <div class="layout-container">
            <?php include 'side-nav.inc.php'; ?>
            <div class="main">
                <?php include 'header.inc.php'; ?>
           
                <main class="user-info">
                    <h2 class="title py-4">Manage Users</h2>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Username</th>						
                                <th>Email</th>
                                <th>Created</th>
                                <th>Role</th>
                                <th>Status</th>
                                </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php foreach ($users as $user):?>
                                <td><?= $user["id"]?></td>
                                <td><?= $user["username"]?></td>
                                <td><?= $user["email"]?></td>
                                <td><?= date( 'Y-M-D', strtotime($user["signUpDate"])) ?></td>                        
                                <td><?= ucfirst($user["role"]) ?></td>
                                <?php $ban = $user["ban"] == 1 ?>
                                <td class="status-content"><span class="status <?php echo $ban? "text-danger":"text-success" ?>">&bull;</span><?php echo  $ban ?  "Suspended": "Active";?></td>
                                <td>
                                    <a href="deleteUser.php?id=<?= $user["id"]?>" class="delete" title="<?php echo $ban ? "unban":"ban" ?>" data-toggle="tooltip"><i class="fa <?php echo $ban ? "fa-unlock":"fa-lock" ?>" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
        <div class="clearfix">
            <div class="hint-text">Showing <b> <?= $totalFetch ?> </b> out of <b><?= $total ?></b> entries</div>
            <ul class="pagination">
            <?php for($i = 1; $i <= $totalPages;$i++): ?>
                <li class="page-item <?php if($previous == 1) echo "disabled"  ?>"  ><a href="index.php?page=<?= $previous ?>">Previous</a></li>
                    <li class="page-item <?php  if($i == $_GET['page']) echo "active" ?>"><a href="index.php?page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
                <li class="page-item"><a href="index.php?page=<?= $next ?>" class="page-link">Next</a></li>
                <?php endfor; ?>
            </ul>
        </div>
                    

                </main>
            </div>
        </div>
    </body>
    <script src="js/script.js"></script>
</html>
