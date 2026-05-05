
var app = $.spapp({
  defaultView: "#login",
  templateDir: "./pages/",
});
// app.route({
//   view: "register",
//   onCreate: function () {
//     console.log("Register view onCreate fired");
//       console.log("Form found?", document.getElementById("registrationForm"));

//     document
//       .getElementById("registrationForm")
//       .addEventListener("submit", function (event) {
//         event.preventDefault(); // Prevent form submission

//         let isValid = true;

//         // Regex patterns
//         const usernameRegex = /^[a-zA-Z0-9]{3,15}$/;
//         const fullNameRegex = /^[A-Z][a-z]+\s[A-Z][a-z]+$/;
//         const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
//         const phoneRegex = /^\d{7,15}$/;
//         const passwordRegex = /^(?=.*\d)[A-Za-z\d]{8,}$/;

//         // Getting input values
//         const username = document.getElementById("username").value.trim();
//         const fullName = document.getElementById("name").value.trim();
//         const email = document.getElementById("email").value.trim();
//         const phone = document.getElementById("phone").value.trim();
//         const password = document.getElementById("password").value.trim();

//         // Username validation
//         if (!usernameRegex.test(username)) {
//           isValid = false;
//           document.getElementById("usernameError").textContent =
//             "Username must be 3-15 alphanumeric characters.";
//         } else {
//           document.getElementById("usernameError").textContent = "";
//         }

//         // Full Name validation
//         if (!fullNameRegex.test(fullName)) {
//           isValid = false;
//           document.getElementById("nameError").textContent =
//             "Full Name must be in 'John Doe' format.";
//         } else {
//           document.getElementById("nameError").textContent = "";
//         }

//         // Email validation
//         if (!emailRegex.test(email)) {
//           isValid = false;
//           document.getElementById("emailError").textContent =
//             "Enter a valid email address.";
//         } else {
//           document.getElementById("emailError").textContent = "";
//         }

//         // Phone Number validation
//         if (!phoneRegex.test(phone)) {
//           isValid = false;
//           document.getElementById("phoneError").textContent =
//             "Phone number must be 7-15 digits.";
//         } else {
//           document.getElementById("phoneError").textContent = "";
//         }

//         // Password validation
//         if (!passwordRegex.test(password)) {
//           isValid = false;
//           document.getElementById("passwordError").textContent =
//             "Password must be at least 8 characters long and contain at least 1 number.";
//         } else {
//           document.getElementById("passwordError").textContent = "";
//         }
        
//         console.log("Is form valid?", isValid);

//         // If all inputs are valid, submit the form
//         if (isValid) {
//           alert("Registration successful!");
//           document.getElementById("username").value = "";
//           document.getElementById("name").value = "";
//           document.getElementById("email").value = "";
//           document.getElementById("phone").value = "";
//           document.getElementById("password").value = "";
//         }
//       });
//   },
// });

/* app.route({
  view: "login",
  onCreate: 
});
 */
app.route({
  view: "about",
  onCreate: function () {
    setTimeout(function () {
      const form = document.getElementById("myForm");
      if (form) {
        form.addEventListener("submit", function (event) {
          event.preventDefault();
          const formData = new FormData(this);
          setTimeout(function () {
            const message = document.getElementById("message");
            if (message) {
              message.innerText = "Data saved successfully!";
            }
          }, 1000);
        });
      } else {
        console.warn("Form #myForm not found on 'about' page (even after timeout).");
      }
    }, 100); // Wait 100ms before trying to access the DOM
  },
});


// app.route({
//   view: "adminpage",
//   onCreate: function () {
//     const token = localStorage.getItem("user_token");
//     if (!token) {
//       toastr.error("Unauthorized: Please log in.");
//       window.location.replace("#login");
//       return;
//     }

//     fetchBooks();
//     // Load all books from the backend
//     function fetchBooks() {
//       BookService.getAll(function (data) {
//         let tabela = $("#bookList tbody");
//         tabela.empty();
//         data.forEach(function (book) {
//           tabela.append(generateTableRow(book));
//         });
//       }, function (err) {
//         toastr.error("Failed to fetch books.");
//         console.error(err);
//       });
//     }

//     // Generate HTML table row
//     function generateTableRow(book) {
//       return `
//         <tr data-id="${book.id}">
//           <td class="book-title">${book.title}</td>
//           <td class="book-rent">${book.rent_price}</td>
//           <td class="book-buy">${book.buy_price}</td>
//           <td class="book-short">${book.short_description}</td>
//           <td class="book-long">${book.long_description}</td>
//           <td>
//             <button class="edit-btn btn btn-warning btn-sm">Edit</button>
//             <button class="delete-btn btn btn-danger btn-sm">Delete</button>
//           </td>
//         </tr>`;
//     }

//     // Add book
//     $("#addBookBtn").click(function () {
//       let title = prompt("Enter Book Title:");
//       let rentPrice = prompt("Enter Rent Price:");
//       let buyPrice = prompt("Enter Buy Price:");
//       let shortDesc = prompt("Enter Short Description:");
//       let longDesc = prompt("Enter Long Description:");

//       if (title && rentPrice && buyPrice && shortDesc && longDesc) {
//         let newBook = {
//           title: title,
//           rent_price: parseFloat(rentPrice),
//           buy_price: parseFloat(buyPrice),
//           short_description: shortDesc,
//           long_description: longDesc,
//         };

//         BookService.create(newBook, function () {
//           toastr.success("Book added successfully!");
//           fetchBooks();
//         }, function (err) {
//           toastr.error("Failed to add book.");
//           console.error(err);
//         });
//       } else {
//         alert("All fields are required!");
//       }
//     });

//     // Edit book
//     $(document).on("click", ".edit-btn", function () {
//       let row = $(this).closest("tr");
//       let bookId = row.data("id");

//       let current = {
//         title: row.find(".book-title").text().trim(),
//         rent_price: row.find(".book-rent").text().trim(),
//         buy_price: row.find(".book-buy").text().trim(),
//         short_description: row.find(".book-short").text().trim(),
//         long_description: row.find(".book-long").text().trim(),
//       };

//       let updated = {
//         title: prompt("Edit Title:", current.title),
//         rent_price: prompt("Edit Rent Price:", current.rent_price),
//         buy_price: prompt("Edit Buy Price:", current.buy_price),
//         short_description: prompt("Edit Short Description:", current.short_description),
//         long_description: prompt("Edit Long Description:", current.long_description),
//       };

//       if (
//         updated.title &&
//         updated.rent_price &&
//         updated.buy_price &&
//         updated.short_description &&
//         updated.long_description
//       ) {
//         updated.rent_price = parseFloat(updated.rent_price);
//         updated.buy_price = parseFloat(updated.buy_price);

//         BookService.update(bookId, updated, function () {
//           toastr.success("Book updated successfully!");
//           fetchBooks();
//         }, function (err) {
//           toastr.error("Failed to update book.");
//           console.error(err);
//         });
//       } else {
//         alert("All fields are required!");
//       }
//     });

//     // Delete book
//     $(document).on("click", ".delete-btn", function () {
//       let row = $(this).closest("tr");
//       let bookId = row.data("id");
//       let title = row.find(".book-title").text().trim();

//       if (confirm(`Delete book: ${title}?`)) {
//         BookService.delete(bookId, function () {
//           toastr.success("Book deleted.");
//           row.remove();
//         }, function (err) {
//           toastr.error("Failed to delete book.");
//           console.error(err);
//         });
//       }
//     });

//     fetchBooks(); // initial load
//   },
// });

app.run();
