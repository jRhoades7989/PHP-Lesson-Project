<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php $layout_context = "admin"; ?>
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->
<nav id="navigation" class="group">
    <br />
    <a href="admins.php">&laquo; Main Menu</a>
</nav>
<main id = "page">
   <article>
      <?php echo message(); ?>
        <h2>Manage Admins</h2>
        <table>
            <tr>
                <th>Username:</th>
                <th>Actions:</th>
            </tr>
            <?php
                $admins_set = find_all_admins();
                while ($admin = mysqli_fetch_assoc($admins_set)) {
                    $output = '<tr>';
                    $output .= '<td>';
                    $output .= htmlentities($admin["username"]);
                    $output .= '</td>';
                    $output .= '<td><a href="#">Edit</a> <a href="#">Delete</a></td>';
                    $output .= '</tr>';
                }
                echo $output;
            ?>
        </table><br />
        <a href="#">Add New Admin</a>
   </article>
</main>
<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->
