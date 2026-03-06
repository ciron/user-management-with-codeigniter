<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - User Management System</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root {
    --primary: #0f172a;
    --primary-hover: #1e293b;
    --bg: #f1f5f9;
    --card-bg: #ffffff;
    --text-main: #0f172a;
    --text-muted: #64748b;
}

body {
    font-family: 'Inter', sans-serif;
    background-color: var(--bg);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;
}

.login-card {
    background: var(--card-bg);
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
    padding: 2.5rem;
}

.btn-primary{
    background: var(--primary);
    border:none;
}

.btn-primary:hover{
    background: var(--primary-hover);
}
</style>

</head>
<body>

<div class="login-card">

<h4 class="text-center mb-4">Admin Login</h4>

<form id="adminLoginForm">

<div class="mb-3">
<label class="form-label">Admin Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-4">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" class="btn btn-primary w-100">Login</button>

</form>

</div>

<script>

$(document).ready(function(){

$("#adminLoginForm").submit(function(e){

e.preventDefault();

let formData = $(this).serialize();

$.ajax({

url: "/admin/login/authenticate",
type: "POST",
data: formData,
dataType: "json",

success:function(response){

if(response.status === "success"){

Swal.fire({
icon: "success",
title: "Login Successful",
text: response.message,
timer: 1500,
showConfirmButton:false
});

setTimeout(function(){
window.location.href = response.redirect;
},1500);

}else{

Swal.fire({
icon: "error",
title: "Login Failed",
text: response.message
});

}

},

error:function(){

Swal.fire({
icon: "error",
title: "Server Error",
text: "Something went wrong"
});

}

});

});

});

</script>

</body>
</html>