<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.css"> 
        <style>
            a { text-decoration: none;}
        </style>
        <title>AdminPage</title>
    </head>
    <body>
        <header id="header">
           <div class="navbar bg-dark navbar-dark">
               <div class="container-fluid">
                    <a class="navbar-brand" href=#>
                        <img src="../icons/book.svg" width="40" height="40" alt="">   
                        Library
                    </a>
                    <a href="../index.php" class="btn btn-primary" role="button">Sign-Out</a>
                </div>
            </div>
        </header>
        <br>
        <main id="main">
            <div class="container-fluid">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="Books/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Members/members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Issue_Return/issue_return.php">Issue/Return</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Records/records.php">Records</a>
                    </li>
                </ul>
            </div>
        </main>
        <script type="text/javascript" src="../../js/bootstrap.js"></script>
    </body>
</html>