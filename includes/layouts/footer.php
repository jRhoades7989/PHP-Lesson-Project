<footer id = "footer"> <!--This footer will go on all pages-->
         <p>Copyright 20xx, Widget Corp</p>
      </footer>
      <script src = "js/scripts.js"></script>
   </body>
</html>
<?php
   //5. Close database connection
if (isset($connection)) {
   mysqli_close($connection);
}
?>
