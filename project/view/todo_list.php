<?php
session_start();
require_once('../modul/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$conn = dbConnect();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM todo_list WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

$tasks = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_task'])) {
        $task_text = $_POST['task_text'];
        if (!empty($task_text)) {
            $insert_sql = "INSERT INTO todo_list (user_id, task) VALUES ($user_id, '$task_text')";
            mysqli_query($conn, $insert_sql);
            header("Location: todo_list.php");
            exit;
        }
    } elseif (isset($_POST['remove_task'])) {
        $task_id = $_POST['remove_task'];
        $delete_sql = "DELETE FROM todo_list WHERE id = $task_id";
        mysqli_query($conn, $delete_sql);
        header("Location: todo_list.php");
        exit;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
</head>
<body>
    <h1>To-Do List</h1>
    <fieldset style='width: 600px; padding: 20px;' >
        <legend>Add Task</legend>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="task_text">Task:</label>
            <input type="text" id="task_text" name="task_text">
            <input type="submit" name="add_task" value="Add Task">
        </form>
    </fieldset>
    <?php if (!empty($tasks)) : ?>
        <fieldset style='width: 600px; padding: 20px;'>
            <legend>Tasks</legend>
            <ul>
                <?php foreach ($tasks as $task) : ?>
                    <li><?php echo $task['task']; ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:inline;">
                            <input type="hidden" name="remove_task" value="<?php echo $task['id']; ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </fieldset>
    <?php else : ?>
        <p>No tasks found.</p>
    <?php endif; ?>
</body>
</html>
