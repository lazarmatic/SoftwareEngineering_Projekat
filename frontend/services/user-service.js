  var UserService = {

      init: function () {
        
        var token = localStorage.getItem("user_token");
        if (token && token !== undefined) {
          window.location.hash= "#about";
        }
        else{

          window.location.hash= "#login";
        
        document
          .getElementById("loginForm")
          .addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent form submission
    
            let isValid = true;
    
            //Regex patterns
            const usernameRegex = /^[a-zA-Z0-9]{3,15}$/;
            const passwordRegex = /^(?=.*\d)[A-Za-z\d]{7,}$/;
    
            //Getting input values
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();
    
            //Username validation
            if (!usernameRegex.test(username)) {
              isValid = false;
              document.getElementById("usernameError").textContent =
                "Username must be 3-15 alphanumeric characters.";
            } else {
              document.getElementById("usernameError").textContent = "";
            }
    
            //Password validation
            if (!passwordRegex.test(password)) {
              isValid = false;
              document.getElementById("passwordError").textContent =
                "Password must be at least 7 characters long and contain at least 1 number.";
            } else {
              document.getElementById("passwordError").textContent = "";
            }
            //var entity = Object.fromEntries(new FormData(form).entries());
            const entity = {
              username: $("#username").val(),
              passw: $("#password").val(),
            };
            //If all inputs are valid, submit the form
            if (isValid) {
               UserService.login(entity);
              document.getElementById("username").value = "";
              document.getElementById("password").value = "";
            }
          }); 
        }
      },

      initRegister: function () {
        document
        .getElementById("registrationForm").addEventListener("submit", function (event) {
          event.preventDefault(); // Prevent form submission
  
          let isValid = true;
  
          // Regex patterns
          const usernameRegex = /^[a-zA-Z0-9]{3,15}$/;
          const fullNameRegex = /^[A-Z][a-z]+\s[A-Z][a-z]+$/;
          const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
          const phoneRegex = /^\d{7,15}$/;
          const passwordRegex = /^(?=.*\d)[A-Za-z\d]{8,}$/;
  
          // Getting input values
          const username = document.getElementById("username").value.trim();
          const fullName = document.getElementById("name").value.trim();
          const email = document.getElementById("email").value.trim();
          const phone = document.getElementById("phone").value.trim();
          const password = document.getElementById("password").value.trim();
  
          // Username validation
          if (!usernameRegex.test(username)) {
            isValid = false;
            document.getElementById("usernameError").textContent =
              "Username must be 3-15 alphanumeric characters.";
          } else {
            document.getElementById("usernameError").textContent = "";
          }
  
          // Full Name validation
          if (!fullNameRegex.test(fullName)) {
            isValid = false;
            document.getElementById("nameError").textContent =
              "Full Name must be in 'John Doe' format.";
          } else {
            document.getElementById("nameError").textContent = "";
          }
  
          // Email validation
          if (!emailRegex.test(email)) {
            isValid = false;
            document.getElementById("emailError").textContent =
              "Enter a valid email address.";
          } else {
            document.getElementById("emailError").textContent = "";
          }
  
          // Phone Number validation
          if (!phoneRegex.test(phone)) {
            isValid = false;
            document.getElementById("phoneError").textContent =
              "Phone number must be 7-15 digits.";
          } else {
            document.getElementById("phoneError").textContent = "";
          }
  
          // Password validation
          if (!passwordRegex.test(password)) {
            isValid = false;
            document.getElementById("passwordError").textContent =
              "Password must be at least 8 characters long and contain at least 1 number.";
          } else {
            document.getElementById("passwordError").textContent = "";
          }
          
          console.log("Is form valid?", isValid);
          const entity = {
            username: $("#username").val(),
            full_name: $("#name").val(),
            email: $("#email").val(),
            phone: $("#phone").val(),
            passw: $("#password").val(),
          };
  
          // If all inputs are valid, submit the form
          if (isValid) {
            alert("Registration successful!");
            console.log("Registering user:", entity);
              UserService.register(entity);
            document.getElementById("username").value = "";
            document.getElementById("name").value = "";
            document.getElementById("email").value = "";
            document.getElementById("phone").value = "";
            document.getElementById("password").value = "";
          }
        });
      },
      

      login: function (entity) {
        $.ajax({
          url: Constants.PROJECT_BASE_URL + "auth/login",
          type: "POST",
          data: JSON.stringify(entity),
          contentType: "application/json",
          dataType: "json", 
          success: function (result) {
            alert("Login successful!"); 
            console.log(entity);
            console.log(result);
            localStorage.setItem("user_token", result.data.token);
            const decoded = Utils.parseJwt(result.data.token);
            if (decoded && decoded.user && decoded.user.id) {
              localStorage.setItem("user_id", decoded.user.id);
            }
            location.reload();
          window.location.hash= "#about"; 
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("Login unsuccessful!");
            toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
          },
        });
      },

      register: function (entity) {
        $.ajax({
          url: Constants.PROJECT_BASE_URL + "auth/register",
          type: "POST",
          data: JSON.stringify(entity),
          contentType: "application/json",
          dataType: "json",
          success: function (result) {
            toastr.success("Registration successful! Please log in.");
            window.location.hash = "#login";
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            const errorMsg = XMLHttpRequest?.responseText
              ? XMLHttpRequest.responseText
              : "Registration failed.";
            toastr.error(errorMsg);
          },
        });
      },      
    
      logout: function () {
        localStorage.clear();
        window.location.hash = "#login";

        location.reload();

      },

      generateMenuItems: function() {
        const token = localStorage.getItem("user_token");
        const parsed = Utils.parseJwt(token);
        console.log("Token from localStorage:", token);
        console.log("Parsed JWT:", parsed);

      
        if (parsed && parsed.user && parsed.user.role) {
          const user = parsed.user;
          console.log("User role:", user.role);
          $(".navbar-nav").find(".dynamic-menu").remove();
      
          let nav = "";
          let main = "";
      
          switch(user.role) {
            case Constants.USER_ROLE:
              nav = '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#books">Books</a>'+
                    '</li>'+
                    '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#about">About</a>'+
                    '</li>'+
                    '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#team">Team</a>'+
                    '</li>'+
                    '</li>'+
                    '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#contact">Contact</a>'+
                    '</li>'+
                    '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#" onclick="UserService.logout()">Logout</a>'+
                    '</li>';
                    console.log("Appending nav for role:", user.role)
              $(".navbar-nav").append(nav);
      
              main =
                '<section id="books"  data-load="books.html"></section>'+
                '<section id="about"  data-load="about.html"></section>'+
                '<section id="team" data-load="team.html"></section>'+
                '<section id="login" data-load="login.html"></section>'+
                '<section id="contact" data-load="contact.html"></section>';
              $("#spapp").html(main);
              break;
      
            case Constants.ADMIN_ROLE:
              nav = '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#books">Books</a>'+
                    '</li>'+
                    '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#about">About</a>'+
                    '</li>'+
                    '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#team">Team</a>'+
                    '</li>'+
                    '</li>'+
                    '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#contact">Contact</a>'+
                    '</li>'+
                    '<li class="nav-item dynamic-menu">'+
                      '<a class="nav-link" href="#adminpage">AdminPage</a>'+
                    '</li>'+
                    '<li class="nav-item dynamic-menu">'+
                      '<button class="btn btn-primary" onclick="UserService.logout()">Logout</button>'+
                    '</li>';
              $(".navbar-nav").append(nav);
      
              main =
                '<section id="books"  data-load="books.html"></section>'+
                '<section id="about"  data-load="about.html"></section>'+
                '<section id="team" data-load="team.html"></section>'+
                '<section id="login" data-load="login.html"></section>'+
                '<section id="adminpage" data-load="adminpage.html"></section>'+
                '<section id="contact" data-load="contact.html"></section>';
              $("#spapp").html(main);
              break;
      
            default:
              $(".navbar-nav").find(".dynamic-menu").remove();
              $("#spapp").html(""); 
          }
        } else {
          //window.location.replace("login.html");
        }
  } }
    