<?php
include('../authentication/start_session.php');

if ($_SESSION['login'] == true) {

  if ($_SESSION['userType'] != "manager") {
    header('Location: ../user/user_profile.php?user_id=' . $_SESSION['userId']);
  }

  // database connection

  include("../db_connect.php");

  function sortUsers(&$operatorName)
  {
    switch ($operatorName) {
      case "ascending-name":
        $query = "SELECT * FROM users ORDER BY user_name ASC";
        break;

      case "descending-name":
        $query = "SELECT * FROM users ORDER BY user_name DESC";
        break;

      case "ascending-email":
        $query = "SELECT * FROM users ORDER BY email ASC";
        break;

      case "descending-email":
        $query = "SELECT * FROM users ORDER BY email DESC";
        break;

      case "ascending-birthday":
        $query = "SELECT * FROM users ORDER BY birth_date ASC";
        break;

      case "descending-birthday":
        $query = "SELECT * FROM users ORDER BY birth_date DESC";
        break;

      default:
        break;
    }

    return $query;
  }

  function filterUsers(&$filterType)
  {
    return $query = "SELECT * FROM users WHERE user_type = '$filterType'";
  }

  $query = "SELECT * FROM users";

  if (isset($_POST['submit-order'])) {
    $operatorName = $_POST['operation'];

    if ($operatorName !== "") {
      $query = sortUsers($operatorName);
    }
  }

  if (isset($_POST['submit-filter'])) {
    $filterType = $_POST['filter'];

    if ($filterType !== "") {
      $query = filterUsers($filterType);
    }
  }

  if (isset($_POST['search-term'])) {
    $searchQuery = $_POST['search-term'];

    $query = "SELECT * FROM users WHERE user_id LIKE'%$searchQuery%' OR user_name LIKE'%$searchQuery%' OR email LIKE'%$searchQuery%'";
  }

  if (isset($_POST['Clear'])) {
    $query = "SELECT * FROM users";
  }

  $result = mysqli_query($conn, $query);

?>

  <style>
    .table-button {
      width: 130px;
    }

    .table-column {
      text-align: center;
    }

    .input-group {
      max-width: 330px;
      /* Or whatever width you want the input group to be */
    }
  </style>


  <!DOCTYPE html>
  <html lang="en">
  <?php
  include('../includes/header.php');
  ?>

  <div class="d-flex align-items-center flex-column justify-content-center bg-primary w-100 p-4 mb-5">
    <h1 style="color: white;">Users List</h1>
  </div>

  <main class="container mt-4">

    <div class="row">
      <div class="col-sm-1">
        <form action="../authentication/logout.php" method="post">
          <input class="btn btn-primary" type="submit" value="Sign Out">
        </form>
      </div>
      <div class="col-sm-2">
        <a href="add_user_form.php" class="btn btn-success">Add User</a>
      </div>


      <div class="col-sm-1">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <input class="btn btn-danger" type="submit" value="Clear">
        </form>
      </div>

      <div class="col-sm-3">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <div class="form-group">
            <div class="input-group">
              <select name="operation" id="operation" class="form-control" style="width: 100px;">
                <option value="">Choose an order</option>
                <option value="ascending-name">Name A-Z</option>
                <option value="descending-name">Name Z-A</option>
                <option value="ascending-email">Email A-Z</option>
                <option value="descending-email">Email Z-A</option>
                <option value="ascending-birthday">Birthdate oldest to youngest</option>
                <option value="descending-birthday">Birthdate youngest to oldest</option>
              </select>
              <div class="input-group-append">
                <input type="submit" name="submit-order" value="Order" class="btn btn-outline-success my-2 my-sm-0">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-sm-2">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <div class="form-group">
            <div class="input-group">
              <select name="filter" id="filter" class="form-control" style="width: 100px;">
                <option value="">Filter by type</option>
                <option value="user">User</option>
                <option value="manager">Manager</option>
              </select>
              <div class="input-group-append">
                <input type="submit" name="submit-filter" value="Filter" class="btn btn-outline-success my-2 my-sm-0">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-sm-3">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-inline my-2 my-lg-0">
          <div class="input-group">
            <input class="form-control mr-sm-2" type="text" name="search-term" placeholder="Search">
            <div class="input-group-append">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    </div>

    <div class="row">
      <div class="col-12">
        <table class="table table-striped table-bordered">
          <thead>
            <tr class="table-dark">
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Birth Date</th>
              <th>User Type</th>
              <th></th>
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
                <td><?php echo $row["user_type"]; ?></td>

                <td class="table-column">
                  <?php if ($row["is_active"] == 1) { ?>
                    <a href="activate_user.php?user_id=<?php echo $row["user_id"]; ?>&is_active=0" class="btn btn-danger btn-sm table-button">DISABLE</a>
                  <?php } else { ?>
                    <a href="activate_user.php?user_id=<?php echo $row["user_id"]; ?>&is_active=1" class="btn btn-success btn-sm table-button">ENABLE</a>
                  <?php } ?>
                </td>

                <td class="table-column"><a href="user_profile.php?user_id=<?php echo $row["user_id"]; ?>" class="btn btn-primary btn-sm table-button">VIEW</a></td>
                <td class="table-column"><a href="edit_user_form.php?user_id=<?php echo $row["user_id"]; ?>" class="btn btn-primary btn-success btn-sm table-button">EDIT</a></td>
                <td class="table-column"><a href="delete_user.php?user_id=<?php echo $row["user_id"]; ?>" class="btn btn-danger btn-sm table-button">DELETE</a></td>
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

  mysqli_close($conn);
} else {
  header('Location: ../authentication/login_form.php');
}
?>