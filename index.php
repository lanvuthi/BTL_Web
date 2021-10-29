<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link rel="stylesheet prefetch" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"><script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="index.css">
    <title>Quản Lý</title>
</head>
<body>
    <div class="header">
        <nav class="navbar navbar-light bg-light">
            <h5>Ten User</h5>
            <a class="navbar-brand" href="#">
                <img src="img/logo.jpg" class="rounded-circle" width="60" height="60" alt="">
            </a>
        </nav>
    </div>
    <main>
        <div class="alert alert-primary" role="alert">
            Co cong viec "<a href="#" class="alert-link">abc</a>" can hoan thanh vao ngay 112
        </div>
        <div class="alert alert-success" role="alert">
            Co cong viec "<a href="#" class="alert-link">xyz</a>" can hoan thanh vao ngay 465
        </div>

        <div class="container">
            <div class="row">
              <div class="col-5">
                <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy"> 
                    <p>Chọn ngày: </p>
                    <input class="form-control" readonly="" type="text"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> 
                </div>
                <script type="text/javascript">
                    $(function () {  
                    $("#datepicker").datepicker({         
                    autoclose: true,         
                    todayHighlight: true 
                    }).datepicker('update', new Date());
                    });
                </script>
              </div>
              <div class="col-6">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                  </form>
              </div>
            </div>
          </div>
        
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tieu de</th>
                <th scope="col">Mieu ta</th>
                <th scope="col">Dealine</th>
                <th scope="col">Trang thai</th>
                <th scope="col">Hanh dong</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>fgnfnfn</td>
                <td>fnfnf</td>
                <td>gfnfnf</td>
                <td>gfnfnf</td>
                <td>gfnfnf</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>fnfnf</td>
                <td>oiiiuiou</td>
                <td>ukhkhk</td>
                <td>gfnfnf</td>
                <td>gfnfnf</td>
              </tr>
            </tbody>
          </table>
    </main>
</body>
</html>