<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }   
       
    </style>
    
    <h1 style="text-align: center;text-decoration: underline;">User Form</h1>

    <div class="container">
        <form id="userForm" enctype="multipart/form-data">
            <input type="hidden" id="userId" name="id">
    
            <div class="form-group">                
                <label for="name">Name:</label>
                <input class="form-control" type="text" id="name" name="name" required>
            </div>
            <div class="form-group">                
                <label for="email">Email:</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>
            <div class="form-group">                
                <label for="contact_number">Contact Number:</label>
                <input class="form-control" type="text" id="contact_number" name="contactNumber" required>
            </div>
            <div class="form-group">                
                <label for="gender">Gender:</label>
                <input  type="radio" id="male" name="gender" value="male"> Male
                <input  type="radio" id="female" name="gender" value="female"> Female
            </div>
            <div class="form-group">                
                <label for="profile_pic">Profile Pic:</label>
                <input class="form-control" type="file" id="profile_pic" name="profilePic">
            </div>
            <div class="form-group"> 
                <label for="hobbies">Hobbies:</label>
                <select class="form-control select2" id="hobbies" name="hobbies[]" multiple required>
                    <!-- Dynamic options from the database -->
                     <option value=""></option>
                </select>
            </div>
            <div class="form-group">                
                <label for="state">State:</label>
                <select id="state" name="stateName" class="form-control">
                    <!-- Dynamic options from the database -->
                    <option value="">Select State Name</option>
                </select>
            </div>
            <div class="form-group"> 
                <label for="city">City:</label>
                <select id="city" name="cityName" class="form-control">
                    <!-- Dynamic options based on selected state -->
                    <option value="">Select City Name</option>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>   
        </form>
    </div>

    <!-- Table to display user data -->
    <h2 style="text-align: center;text-decoration: underline;">User Data List</h2>

    <table id="userTable" class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic content -->            
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $("#userForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    contactNumber: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    gender: {
                        required: true
                    },
                    profilePic: {
                        required: true,
                        extension: "jpg|jpeg|png|gif" 
                    },
                    "hobbies[]": {
                        required: true
                    },
                    stateName: {
                        required: true
                    },
                    cityName: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    contactNumber: {
                        required: "Please enter your contact number",
                        digits: "Please enter only digits",
                        minlength: "Contact number must be at least 10 digits",
                        maxlength: "Contact number cannot exceed 10 digits"
                    },
                    gender: {
                        required: "Please select your gender"
                    },
                    profilePic: {
                        required: "Please upload your profile picture",
                        extension: "Allowed file types are jpg, jpeg, png, gif"
                    },
                    "hobbies[]": {
                        required: "Please select at least one hobby"
                    },
                    stateName: {
                        required: "Please select a state"
                    },
                    cityName: {
                        required: "Please select a city"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "gender") {
                        error.insertAfter(element.closest("div"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    alert('Form is valid and ready for submission!');
                    var formData = new FormData(this);

                    $.ajax({
                        url: '/api/users',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            alert('User created successfully');
                            console.log(response);
                        },
                        error: function(response) {
                            console.log(response);
                            alert('Error: ' + response.responseJSON.message);
                        }
                    });
                        form.submit();
                    }
                });
           
                $.ajax({
                    url: '/api/states',
                    type: 'GET',
                    success: function(states) {
                        states.forEach(function(state) {
                            $('#state').append(`<option value="${state.id}">${state.stateName}</option>`);
                        });
                    }
                });

            // Load cities based on selected state
            $('#state').change(function() {
                var stateId = $(this).val();
                $('#city').empty(); 

                if (stateId) {
                    $.ajax({
                        url: '/api/cities/' + stateId,
                        type: 'GET',
                        success: function(cities) {
                            cities.forEach(function(city) {
                                $('#city').append(`<option value="${city.id}">${city.cityName}</option>`);
                            });
                        }
                    });
                }
            });

             // Fetch hobbies from the server
             $('.select2').select2();

            // Fetch data via AJAX
            $.ajax({
                url: '/api/hobbies',
                type: 'GET',
                success: function(hobbies) {
                    // Prepare data in Select2 format
                    let options = hobbies.map(function(hobby) {
                        return {
                            id: hobby.id,
                            text: hobby.hobbyName
                        };
                    });

                    // Set the data in Select2
                    $('#hobbies').select2({
                        data: options
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching hobbies:', error);
                }
            });
            
        });
    </script>
    

</body>
</html>
