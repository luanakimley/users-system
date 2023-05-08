<?php
include('../authentication/start_session.php');

// if( $_SESSION['login'] == TRUE){

// database connection

include("../db_connect.php");
	$query = "SELECT * FROM users";
	$result = mysqli_query($conn, $query);


    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $name = $_POST['user_id'];
  
        $query = "UPDATE users SET is_active ='$isActive' WHERE user_id = $_user_id";
        $result = mysqli_query($conn, $query);
    }
  
  ?>

<style>
.table-button
{
  width: 90%;
}

.table-column
{
  text-align: center;
}
</style>


<!DOCTYPE html>
<html lang="en">
<?php
include('../includes/header.php');
?>
<main>
<div class="container mt-4">
  <div class="row">
    <div class="col-12">
      <h2 class="text-center">User List</h2>
    </div>
  </div>
  
  <div class="row">
    <div class="col-12">
      <table class="table table-striped table-bordered">
        <thead>
          <tr class= "table-dark">
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Birth Date</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
            <td><?php echo $row["user_id"]; ?></td>
            <td><?php echo $row["user_name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["birth_date"]; ?></td>
           
            <td class = "table-column">
  <?php if ($row["is_active"] == 1) { ?>
    <a href="activate_user.php?user_id=<?php echo $row["user_id"]; ?>&is_active=0" class="btn btn-danger btn-sm table-button">DISABLE</a>
  <?php } else { ?>
    <a href="activate_user.php?user_id=<?php echo $row["user_id"]; ?>&is_active=1" class="btn btn-success btn-sm table-button">ENABLE</a>
  <?php } ?>  
</td>

            <td class = "table-column"><a href="edit_user_form.php?user_id=<?php echo $row["user_id"];?>" class="btn btn-primary btn-sm table-button">EDIT</a></td>
            <td class = "table-column"><a href="delete_user.php?user_id=<?php echo $row["user_id"]; ?>" class="btn btn-danger btn-sm table-button">DELETE</a></td>
            </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
include('../includes/footer.php');
?>
</main>
</body>
</html>

<?php
// close connection
//}
mysqli_close ($conn);   
?>
