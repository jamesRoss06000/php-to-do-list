<?php
require_once("conn.php");

// delete task gets id from href link
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $req = $conn->prepare("DELETE FROM `to-do-list` WHERE `id` = :id");
  $req->execute([':id' => $id]);
  header("Location: index.php");
}