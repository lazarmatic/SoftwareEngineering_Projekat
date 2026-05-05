let BookService = {
    init: function () {
        $("#addBookForm").validate({
            submitHandler: function (form) {
              var book = Object.fromEntries(new FormData(form).entries());
              BookService.addBook(book);
              form.reset();
            },
          });
        $("#editBookForm").validate({
            submitHandler: function (form) {
              var book = Object.fromEntries(new FormData(form).entries());
              console.log("Book object being submitted:", book);
              BookService.editBook(book);
          
            },
        });
        BookService.getAllBooks();
        BookService.getAllBooksTwo();
    },
    openAddModal : function() {
        $('#addBookModal').show();
    },
    addBook: function (book) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.post('books', book, function(response){
            toastr.success("Book added successfully")
            $.unblockUI();
            BookService.getAllBooks();
            BookService.closeModal();
        }, function(response){
            BookService.closeModal()
            toastr.error(response.message);
        })
    },
    getAllBooksTwo: function () {
        RestClient.get("books", function (data) {
            const container = $('#books-container');
            container.empty();
    
            data.forEach(book => {
                const card = `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">${book.title}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${book.author}</h6>
                                <p class="card-text"><strong>Rent:</strong> €${book.rent_price}<br>
                                <strong>Buy:</strong> €${book.buy_price}<br>
                                <strong>Stock:</strong> ${book.stock_quantity}<br>
                                <strong>Rentable:</strong> ${book.available_for_rent ? "Yes" : "No"}<br>
                                <strong>Purchasable:</strong> ${book.available_for_purchase ? "Yes" : "No"}</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">

                                <button class="btn btn-primary btn-sm" onclick="BookService.makeReservationDirect('${book.id}')">Make Reservation</button>

                                <button class="btn btn-primary btn-sm" onclick="BookService.makePurchaseDirect('${book.id}')">Make Purchase</button>

                                <button class="btn btn-secondary btn-sm" onclick="BookService.openViewMore('${book.id}')">View</button>

                                <button class="btn btn-info btn-sm" onclick="BookReviewService.openReviewsModal('${book.id}')">View Reviews</button>



                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        }, function (xhr, status, error) {
            console.error('Error fetching books:', error);
        });
    },
    makeReservationDirect: function(bookId) {
        const rental = {
            user_id: localStorage.getItem("user_id"),
            book_id: bookId,
            rental_date: new Date().toISOString().split('T')[0],
            return_date: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
            status: 'Rented'
        };
        BookRentalService.addRental(rental);
    },
    makePurchaseDirect: function(bookId) {
        const purchase = {
            user_id: localStorage.getItem("user_id"),
            book_id: bookId,
            purchase_date: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
            quantity: 1,
            total_price: 15.99
        };
        BookPurchaseService.addPurchase(purchase);
    },
    openReviewsModal: function (bookId) {
        $('#reviews-list').html('<div class="text-center">Loading...</div>');
        const modal = new bootstrap.Modal(document.getElementById('bookReviewsModal'));
        modal.show();
    
        RestClient.get("bookreviews", function (data) {
            const reviews = data.filter(r => r.book_id == bookId);
            if (reviews.length === 0) {
                $('#reviews-list').html('<div class="alert alert-info">No reviews for this book yet.</div>');
                return;
            }
    
            const listItems = reviews.map(r => `
                <div class="list-group-item">
                    <h6>User ID: ${r.user_id} <small class="text-muted float-end">${r.review_date}</small></h6>
                    <p>${r.review_text}</p>
                </div>
            `).join('');
    
            $('#reviews-list').html(listItems);
        }, function (xhr, status, error) {
            $('#reviews-list').html('<div class="alert alert-danger">Error loading reviews.</div>');
            console.error("Error loading reviews:", error);
        });
    },
    
    getAllBooks: function () {
        RestClient.get("books", function (data) {
            Utils.datatable('books-table', [
                { data: 'title', title: 'Title' },
                { data: 'author', title: 'Author' },
                { data: 'rent_price', title: 'Rent Price (€)' },
                { data: 'buy_price', title: 'Buy Price (€)' },
                { data: 'stock_quantity', title: 'In Stock' },
                { data: 'available_for_rent', title: 'For Rent',
                  render: function (data) {
                    return data ? 'Yes' : 'No';
                  }
                },
                { data: 'available_for_purchase', title: 'For Purchase',
                  render: function (data) {
                    return data ? 'Yes' : 'No';
                  }
                },
                {
                    title: 'Actions',
                    render: function (data, type, row, meta) {
                        const rowStr = encodeURIComponent(JSON.stringify(row));
                        return `
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-primary btn-sm" onclick="BookService.openEditModal('${row.id}')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="BookService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete</button>
                                <button class="btn btn-secondary btn-sm" onclick="BookService.openViewMore('${row.id}')">View</button>
                            </div>
                        `;
                    }
                }
            ], data, 10);
        }, function (xhr, status, error) {
            console.error('Error fetching books:', error);
        });
    },
    getBookById : function(id) {
        RestClient.get('booksByID/'+id, function (data) {
            console.log("Full book data returned from backend:", data);             localStorage.setItem('selected_book', JSON.stringify(data))
            const $form = $('#editBookForm');

            $form.find('input[name="id"]').val(data.id); 
            console.log("Set book ID:", data.id);
        console.log("Form input value:", $form.find('input[name="id"]').val()); 
            $form.find('input[name="title"]').val(data.title);
            $form.find('input[name="author"]').val(data.author);
            $form.find('input[name="rent_price"]').val(data.rent_price);
            $form.find('input[name="buy_price"]').val(data.buy_price);
            $form.find('input[name="description_short"]').val(data.description_short);
            $form.find('input[name="description_long"]').val(data.description_long);
            $form.find('input[name="stock_quantity"]').val(data.stock_quantity);
            $form.find('input[name="available_for_rent"]').val(data.available_for_rent);
            $form.find('input[name="available_for_purchase"]').val(data.available_for_purchase);
    
            console.log("ID field populated:", $form.find('input[name="id"]').val());
            $.unblockUI();
        }, function (xhr, status, error) {
            console.error('Error fetching data');
            $.unblockUI();
        });
    },
    openViewMore: function(id) {
        $.blockUI({ message: '<h3>Loading book...</h3>' });
      
        BookService.getBookById(id);
      
        setTimeout(function() {
          const book = JSON.parse(localStorage.getItem('selected_book'));
      
          if (!book) {
            toastr.error("Book not found.");
            $.unblockUI();
            return;
          }
      
          BookService.populateViewMore();
          const modal = new bootstrap.Modal(document.getElementById('viewMoreModal'));
    modal.show();
          $.unblockUI();
        }, 300); 
      }
      ,
    populateViewMore: function () {
        let book = JSON.parse(localStorage.getItem('selected_book'));
        if (!book) {
            console.error("No book data found in localStorage");
            return;
        }
        $("#book-title").text(book.title);
        $("#book-author").text(book.author);
        $("#book-rent-price").text(`€${book.rent_price}`);
        $("#book-buy-price").text(`€${book.buy_price}`);
        $("#book-short-description").text(book.description_short);
        $("#book-long-description").text(book.description_long);
        $("#book-stock").text(book.stock_quantity);
        $("#book-rentable").text(book.available_for_rent ? "Yes" : "No");
        $("#book-purchasable").text(book.available_for_purchase ? "Yes" : "No");
    }
    ,
    openEditModal: function(id) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        const modal = new bootstrap.Modal(document.getElementById('editBookModal'));
        modal.show();
        setTimeout(() => {
            BookService.getBookById(id);
        }, 300); 
    },
    closeModal : function() {
        $('#editBookModal').hide();
        $("#deleteBookModal").modal("hide");
        $('#addBookModal').hide();
        $('#viewMoreModal').hide();
    },
    editBook : function(book){
        console.log("Submitting book:", book);
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.put('books/' + book.id, book, function (data) {
            console.log("kgjrnd");
            toastr.success("Book edited successfully")
            BookService.closeModal()
            $.unblockUI();
            BookService.getAllBooks();
        }, function (xhr, status, error) {
            $.unblockUI();
            console.error('Error');
        });
    },
    openConfirmationDialog: function (book) {
        book = JSON.parse(book)
        $("#deleteBookModal").modal("show");
        $("#delete-book-body").html(
        "Do you want to delete book: " + book.name
        );
        $("#delete_book_id").val(book.id);
    },
    deleteBook: function () {
        RestClient.delete('books/' + $("#delete_book_id").val(), null, function(response){
            BookService.closeModal()
            toastr.success(response.message);
            BookService.getAllBooks();
        }, function(response){
            BookService.closeModal()
            toastr.error(response.message);
        })
    }
 }
 