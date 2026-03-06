<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Signup</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    font-family: Arial, sans-serif;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.signup-container{
    background:#fff;
    padding:30px;
    width:400px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.signup-container h2{
    text-align:center;
    margin-bottom:20px;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:5px;
}

.form-group input,
.form-group textarea{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:5px;
}

button{
    width:100%;
    padding:10px;
    border:none;
    background:#007bff;
    color:white;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#0056b3;
}

.message{
    margin-top:10px;
    text-align:center;
}
</style>

</head>

<body>

<div class="signup-container">

<h2>Create Account</h2>

<form id="signupForm">

<div class="form-group">
<label>Full Name</label>
<input type="text" name="name" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone">
</div>

<div class="form-group">
<label>Address</label>
<textarea name="address"></textarea>
</div>

<div class="form-group">
<label>Password</label>
<input type="password" name="password" required>
</div>

<button type="submit">Create Account</button>

<div class="message" id="message"></div>

</form>

</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    $("#signupForm").submit(function(e){

        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "/signup/register",
            type: "POST",
            data: formData,
            dataType: "json",

            success:function(response){

                if(response.status === "success"){

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            window.location.href = '/login';
                        }
                    });

                    $("#signupForm")[0].reset();

                }else{

                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: response.message,
                        confirmButtonColor: '#f39c12'
                    });

                }

            },

            error:function(){

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#e74c3c'
                });

            }

        });

    });

});
</script>

</body>
</html>