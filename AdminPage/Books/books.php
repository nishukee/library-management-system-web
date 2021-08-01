<?php
include_once 'php/connect.php';
$session_username = $_SESSION['adminname'];
if(empty($_SESSION['adminname'])){
    header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script type="text/javascript" src="js/download_excel.js"></script>
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
                        <i class="bi bi-book-fill"></i> Library
                    </a>
                    <a href="../../index.php" class="btn btn-primary" role="button">Sign-Out</a>
                </div>
            </div>
        </header>
        <br>
        <main id="main">
            <div class="container-fluid">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="../Issue_Return/issue_return.php">Issue/Return</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Members/members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Records/records.php">Records</a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid py-3">
                <div class="d-flex justify-content-between">   
                    <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#addBook'><i class="bi bi-plus-square"></i> Add Book</button>
                    <button type='button' class='btn btn-secondary' onClick="exportData()"><i class="bi bi-download"></i> Download Table</button>
                </div>
            </div>
            <div class="container-fluid table-responsive">
                <table class="table table-striped caption-top" id="books_table">
                    <caption>List of Books</caption>
                    <thead>
                        <tr>
                            <th scope="col">Book ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Copies</th>
                            <th scope="col">Author</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Price(₹)</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM books";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0){
                                $rows = $result->fetch_all(MYSQLI_ASSOC);
                                foreach ($rows as $row) {
                                    $id = $row['bookId'];
                                    $bookName = $row['bookName'];
                                    $bookGenre = $row['bookGenre'];
                                    $no_of_copies = $row['no_of_copies'];
                                    $author = $row['author'];
                                    $isbn = $row['isbn'];
                                    $price = $row['price'];
                                    $status = $row['status'];
                            ?>
                        <tr>
                            <td>
                                <?php echo $id; ?>
                            </td>
                            <td>
                                <?php echo $bookName; ?>
                            </td>
                            <td>
                                <?php echo $bookGenre; ?>
                            </td>
                            <td>
                                <?php echo $no_of_copies; ?>
                            </td>
                            <td>
                                <?php echo $author; ?>
                            </td>
                            <td>
                                <?php echo $isbn; ?>
                            </td>
                            <td>
                                <?php echo $price; ?>
                            </td>
                            <td>
                                <?php echo $status; ?>
                            </td>
                            <td>
                                <button type='button' class='btn btn-warning btn-md' data-bs-toggle='modal' data-bs-target='#edit<?php echo $id;?>'><i class='bi bi-pencil-square'></i></button>
                                <button type='button' class='btn btn-danger btn-md' data-bs-toggle='modal' data-bs-target='#delete<?php echo $id;?>'><i class='bi bi-trash'></i></button>
                            </td>
                            <div id="edit<?php echo $id;?>" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="title">Edit Book</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <form method="POST">
                                                    <div class="mb-3">
                                                        <label for="bookId" class="form-label">Book Id</label>
                                                        <input type="number" name="bookId" class="form-control" id="bookID" value="<?php echo $id?>" placeholder="Book Id" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="bookName" class="form-label">Book Name</label>
                                                        <input type="text" name="bookName" class="form-control" id="bookName" value="<?php echo $bookName?>" placeholder="Book Name" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="bookGenre" class="form-label">Book Genre</label>
                                                        <select class="form-select" name="bookGenre" aria-label="Select Book Genre">
                                                            <option value="<?php echo $bookGenre?>" selected><?php echo $bookGenre?></option>
                                                            <optgroup label="Fiction">
                                                                <option value="Action and adventure">Action and adventure</option>
                                                                <option value="Alternate history">Alternate history</option>
                                                                <option value="Anthology">Anthology</option>
                                                                <option value="Children's">Children's</option>
                                                                <option value="Classic">Classic</option>
                                                                <option value="Comic book">Comic book</option>
                                                                <option value="Crime">Crime</option>
                                                                <option value="Drama">Drama</option>
                                                                <option value="Fairytale">Fairytale</option>                                                    
                                                                <option value="Fantasy">Fantasy</option>
                                                                <option value="Graphic novel">Graphic novel</option>
                                                                <option value="Historic fiction">Historic fiction</option>
                                                                <option value="Horror">Horror</option>
                                                                <option value="Mystery">Mystery</option>
                                                                <option value="Picture Book">Picture Book</option>
                                                                <option value="Poetry">Poetry</option>
                                                                <option value="Romance">Romance</option>
                                                                <option value="Science Fiction">Science Fiction</option>
                                                                <option value="Short Story">Short Story</option>
                                                                <option value="Suspense">Suspense</option>
                                                            <option value="Thriller">Thriller</option>
                                                                <option value="Young Adult">Young Adult</option>
                                                            </optgroup>
                                                            <optgroup label="Non-Fiction">
                                                                <option value="Art/architecture">Art/architecture</option>
                                                                <option value="Autobiography">Autobiography</option>                                                    
                                                                <option value="Biography">Biography</option>
                                                                <option value="Business/economics">Business/economics</option>
                                                                <option value="Crafts/hobbies">Crafts/hobbies</option>
                                                                <option value="Cookbook">Cookbook</option>
                                                                <option value="Dictionary">Dictionary</option>
                                                                <option value="Encyclopedia">Encyclopedia</option>
                                                                <option value="Guide">Guide</option>
                                                                <option value="Health/fitness">Health/fitness</option>
                                                                <option value="History">History</option>
                                                                <option value="Home and garden">Home and garden</option>
                                                                <option value="Humor">Humor</option>                                                    
                                                                <option value="Journal">Journal</option>
                                                                <option value="Math">Math</option>
                                                                <option value="Memoir">Memoir</option>
                                                                <option value="Philosophy">Philosophy</option>
                                                                <option value="Religion, spirituality, and new age">Religion, spirituality, and new age</option>
                                                                <option value="Textbook">Textbook</option>
                                                                <option value="True crime">True crime</option>
                                                                <option value="Review">Review</option>
                                                                <option value="Science">Science</option>
                                                                <option value="Self help">Self help</option>
                                                                <option value="Sports and leisure">Sports and leisure</option>
                                                                <option value="Travel">Travel</option>
                                                            </optgroup>
                                                                <option value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="no_of_copies" class="form-label">Number of Copies</label>
                                                        <input type="number" name="no_of_copies" class="form-control" id="no_of_copies" value="<?php echo $no_of_copies?>" placeholder="No. of Copies" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="author" class="form-label">Author</label>
                                                        <input type="text" name="author" class="form-control" id="author" value="<?php echo $author?>" placeholder="Author" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="isbn" class="form-label">ISBN</label>
                                                        <input type="text" name="isbn" class="form-control" id="isbn" value="<?php echo $isbn?>" placeholder="ISBN" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="price" class="form-label">Price</label>
                                                        <input type="number" name="price" class="form-control" id="price" value="<?php echo $price?>" placeholder="Price" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-select" name="status" arial-label="Select Book Status">
                                                            <option value="<?php echo $status?>" selected><?php echo $status?></option>
                                                            <option value="Available">Available</option>
                                                            <option value="Issued">Issued All</option>
                                                            <option value="Damaged/Lost">Damaged/Lost</option>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex p-3 justify-content-end">
                                                        <button type="submit" class="btn btn-primary" name="edit_book">Edit Book</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="delete<?php echo $id;?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="title">Delete Book</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <div class="container-fluid">
                                                    <input type="hidden" name="delete_id" value="<?php echo $id;?>">
                                                    <p>
                                                        Are you sure you want to delete this book?<br/>
                                                        <b>Book Id</b>   : <?php echo $id;?><br/>
                                                        <b>Book Name</b> : <?php echo $bookName?>
                                                    </p>
                                                </div>
                                                <div class="d-flex p-3 justify-content-end">
                                                    <button type="submit" class="btn btn-danger" name="delete_book">Delete Book</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </tr>
                        <?php
                                }
                            }
                            if(isset($_POST['add_book'])){
                                $bookName = $_POST['bookName'];
                                $bookGenre = $_POST['bookGenre'];
                                $no_of_copies = $_POST['no_of_copies'];
                                $author = $_POST['author'];
                                $isbn = $_POST['isbn'];
                                $price = $_POST['price'];
                            
                                $query = "INSERT INTO books (bookID, bookName, bookGenre, no_of_copies, author, isbn, price, status) VALUES (DEFAULT,?,?,?,?,?,?,DEFAULT)";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("ssissi", $bookName, $bookGenre, $no_of_copies, $author, $isbn, $price);
                            
                                if($stmt->execute()){
                                    echo "<script language='javascript'>alert('Data Successfully added');</script>";
                                    echo "<script language='javascript'>location.href = 'books.php';</script>";
                                }
                                else{
                                    echo "<script language='javascript'>alert('Could not enter data.\n Check if databse exists with table in server.');</script>";
                                    echo "<script language='javascript'>location.href = 'books.php';</script>";
                                }
                            }
                            
                            if(isset($_POST['edit_book'])){
                                $bookId = $_POST['bookId'];
                                $bookName = $_POST['bookName'];
                                $bookGenre = $_POST['bookGenre'];
                                $no_of_copies = $_POST['no_of_copies'];
                                $author = $_POST['author'];
                                $isbn = $_POST['isbn'];
                                $price = $_POST['price'];
                                $status = $_POST['status'];
                            
                                $query = "UPDATE books SET bookName=?, bookGenre=?, no_of_copies=?, author=?, isbn=?, price=?, status=? WHERE bookId=?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("ssissisi",$bookName,$bookGenre,$no_of_copies,$author,$isbn,$price,$status,$bookId);
                            
                                if($stmt->execute()){
                                    echo "<script language='javascript'>alert('Data Successfully Updated');</script>";
                                    echo "<script language='javascript'>location.href = 'books.php';</script>";
                                }
                                else{
                                    echo "<script language='javascript'>alert('Could not update data.\n Check if databse exists with table in server.');</script>";
                                    echo "<script language='javascript'>location.href = 'books.php';</script>";
                                }
                            }
                            
                            if(isset($_POST['delete_book'])){
                                $delete_id = $_POST['delete_id'];
                                $query = "DELETE FROM books WHERE bookId=?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i",$delete_id);
                            
                                if($stmt->execute()){
                                    echo "<script language='javascript'>alert('Data Successfully Deleted');</script>";
                                    echo "<script language='javascript'>location.href = 'books.php';</script>";
                                }
                                else{
                                    echo "<script language='javascript'>alert('Could not delete data.\n Check if databse exists with table in server.');</script>";
                                    echo "<script language='javascript'>location.href = 'books.php';</script>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="addBook" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h2 class="title">Add Book</h2>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">   
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="bookName" class="form-label">Book Name</label>
                                        <input type="text" name="bookName" class="form-control" id="bookName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="memberName" class="form-label">Book Genre</label>
                                        <select class="form-select" name="bookGenre" aria-label="Select Book Genre" required>
                                            <option selected>Select Option</option>
                                            <optgroup label="Fiction">
                                                <option value="Action and adventure">Action and adventure</option>
                                                <option value="Alternate history">Alternate history</option>
                                                <option value="Anthology">Anthology</option>
                                                <option value="Children's">Children's</option>
                                                <option value="Classic">Classic</option>
                                                <option value="Comic book">Comic book</option>
                                                <option value="Crime">Crime</option>
                                                <option value="Drama">Drama</option>
                                                <option value="Fairytale">Fairytale</option>                                                    
                                                <option value="Fantasy">Fantasy</option>
                                                <option value="Graphic novel">Graphic novel</option>
                                                <option value="Historic fiction">Historic fiction</option>
                                                <option value="Horror">Horror</option>
                                                <option value="Mystery">Mystery</option>
                                                <option value="Picture Book">Picture Book</option>
                                                <option value="Poetry">Poetry</option>
                                                <option value="Romance">Romance</option>
                                                <option value="Science Fiction">Science Fiction</option>
                                                <option value="Short Story">Short Story</option>
                                                <option value="Suspense">Suspense</option>
                                               <option value="Thriller">Thriller</option>
                                                <option value="Young Adult">Young Adult</option>
                                            </optgroup>
                                            <optgroup label="Non-Fiction">
                                                <option value="Art/architecture">Art/architecture</option>
                                                <option value="Autobiography">Autobiography</option>                                                    
                                                <option value="Biography">Biography</option>
                                                <option value="Business/economics">Business/economics</option>
                                                <option value="Crafts/hobbies">Crafts/hobbies</option>
                                                <option value="Cookbook">Cookbook</option>
                                                <option value="Dictionary">Dictionary</option>
                                                <option value="Encyclopedia">Encyclopedia</option>
                                                <option value="Guide">Guide</option>
                                                <option value="Health/fitness">Health/fitness</option>
                                                <option value="History">History</option>
                                                <option value="Home and garden">Home and garden</option>
                                                <option value="Humor">Humor</option>                                                    
                                                <option value="Journal">Journal</option>
                                                <option value="Math">Math</option>
                                                <option value="Memoir">Memoir</option>
                                                <option value="Philosophy">Philosophy</option>
                                                <option value="Religion, spirituality, and new age">Religion, spirituality, and new age</option>
                                                <option value="Textbook">Textbook</option>
                                                <option value="True crime">True crime</option>
                                                <option value="Review">Review</option>
                                                <option value="Science">Science</option>
                                                <option value="Self help">Self help</option>
                                                <option value="Sports and leisure">Sports and leisure</option>
                                                <option value="Travel">Travel</option>
                                            </optgroup>
                                                <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_of_copies" class="form-label">Number of Copies</label>
                                        <input type="number" name="no_of_copies" class="form-control" id="no_of_copies" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Author</label>
                                        <input type="text" name="author" class="form-control" id="author" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="isbn" class="form-label">ISBN</label>
                                        <input type="text" name="isbn" class="form-control" id="isbn" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" name="price" class="form-control" id="price" required>
                                    </div>
                                    <div class="d-flex p-3 justify-content-end">
                                        <button type="submit" class="btn btn-primary" name="add_book">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>