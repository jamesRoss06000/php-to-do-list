<?PHP
// get connection to db
require_once('conn.php');
// declare error variable
$error = '';
// when submit clicked
if (isset($_POST['submit'])) {
  $task = $_POST['task'];
  // if empty give error
  if ($task === '') {
    $error = 'Task field cannot be empty';
  }
  // if not empty, add to db
  else {
    $add = $conn->prepare("INSERT INTO `to-do-list`(`task`) VALUES (:task)");
    $add->execute([':task' => $task]);
    header('location: index.php');
  }
}
// get data from db
$getTask = $conn->prepare("SELECT id, task FROM `to-do-list`");
$getTask->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PHP SQL To Do List</title>
  <link rel="stylesheet" href="main.css">
</head>

<body>
  <div class='container'>
    <h1 class='heading'>To Do List</h1>
    <form action="index.php" method='post'>
      <!-- Error message if set by empty sumission -->
      <?php
      if (isset($error)) {
        ?><p><?php echo $error; ?></p>
      <?php } ?>
      <!-- Standard form  -->
      <input type="text" name="task" class="task">
      <input type="submit" name='submit' class='submit' value="Add To List">
    </form>
    <br>
    <br>
    <!-- List will be shown in table format -->
    <table>
      <thead>
        <tr>
          <th>Number</th>
          <th>Task</th>
          <th>Done?</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // The $i variable is used to number the list and reset with each addition/deletion 
        $i = 1;
        // while loop to iterate through object returned from SQL SELECT
        while ($row = $getTask->fetch(PDO::FETCH_ASSOC)) { ?>
          <tr>
            <!-- echo the iterator/task number -->
            <td style='width: 30px;'><?php echo $i ?></td>
            <!-- echo 'task' value from each row  -->
            <td><?php echo $row['task'] ?></td>
            <!-- delete button for each row uses row id from db -->
            <td class='delete'><a href='delete.php?id=<?php echo $row["id"] ?>'>
                <img src="images/tick-transparent.png" alt="tick" height="15" width="15">
              </a></td>
          </tr>
          <!-- task number goes up by one for each task in the list  -->
        <?php $i = $i + 1;
        }
        ?>
      </tbody>
    </table>
  </div>
  <div>
    <p class='credit'>Photo by Guillaume Meurice from Pexels</p>
  </div>
</body>

</html>