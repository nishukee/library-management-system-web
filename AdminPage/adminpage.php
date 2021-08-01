<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
                        <i class="bi bi-book-fill"></i>    
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
                        <a class="nav-link" href="Issue_Return/issue_return.php">Issue/Return</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Books/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Members/members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Records/records.php">Records</a>
                    </li>
                </ul>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>