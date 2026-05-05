let BookReviewService = {
    init: function () {
        $("#addReviewForm").validate({
            submitHandler: function (form) {
                const review = Object.fromEntries(new FormData(form).entries());
                BookReviewService.addReview(review);
                form.reset();
            },
        });

        $("#editReviewForm").validate({
            submitHandler: function (form) {
                const review = Object.fromEntries(new FormData(form).entries());
                BookReviewService.editReview(review);
            },
        });
        $("#inlineAddReviewForm").validate({
            submitHandler: function (form) {
                const review = Object.fromEntries(new FormData(form).entries());
                BookReviewService.addReviewInline(review);
                form.reset();
            }
        });
        

        BookReviewService.getAllReviews();

        $("#confirmDeleteReview").click(function () {
            BookReviewService.deleteReview();
        });
    },

    openAddModal: function () {
        const modal = new bootstrap.Modal(document.getElementById("addReviewModal"));
        modal.show();
    },

    openEditModal: function (id) {
        $.blockUI({ message: '<h3>Loading...</h3>' });
        const modal = new bootstrap.Modal(document.getElementById("editReviewModal"));
        modal.show();
        setTimeout(() => {
            BookReviewService.getReviewById(id);
        }, 300);
    },

    closeModal: function () {
        const modals = ["addReviewModal", "editReviewModal", "deleteReviewModal"];
        modals.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                const modalInstance = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                modalInstance.hide();
            }
        });
    },

    addReview: function (review) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.post("bookreviews", review, function () {
            toastr.success("Review added successfully");
            $.unblockUI();
            BookReviewService.getAllReviews();
            BookReviewService.closeModal();
        }, function (response) {
            $.unblockUI();
            toastr.error(response.message);
        });
    },
    addReviewInline: function (review) {
        $.blockUI({ message: '<h3>Adding Review...</h3>' });
        RestClient.post("bookreviews", review, function () {
            toastr.success("Review added successfully");
            $.unblockUI();
            BookReviewService.closeModal();

          /*   BookReviewService.openReviewsModal(review.book_id); */
        }, function (response) {
            $.unblockUI();
            toastr.error(response.message);
        });
    },

    getAllReviews: function () {
        RestClient.get("bookreviews", function (data) {
            Utils.datatable("bookReviewsTable", [
                { data: "id", title: "ID" },
                { data: "user_id", title: "User ID" },
                { data: "book_id", title: "Book ID" },
                { data: "review_text", title: "Review" },
                { data: "review_date", title: "Date" },
                {
                    title: "Actions",
                    render: function (data, type, row, meta) {
                        const rowStr = encodeURIComponent(JSON.stringify(row));
                        return `
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-primary btn-sm" onclick="BookReviewService.openEditModal('${row.id}')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="BookReviewService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete</button>
                            </div>
                        `;
                    }
                }
            ], data, 10);
        }, function (xhr, status, error) {
            console.error("Error fetching reviews:", error);
        });
    },

    getReviewById: function (id) {
        RestClient.get("bookReviewsByID/" + id, function (data) {
            localStorage.setItem("selected_review", JSON.stringify(data));
            const $form = $("#editReviewForm");
            $form.find("input[name='id']").val(data.id);
            $form.find("input[name='user_id']").val(data.user_id);
            $form.find("input[name='book_id']").val(data.book_id);
            $form.find("textarea[name='review_text']").val(data.review_text);
            $form.find("input[name='review_date']").val(data.review_date);
            $.unblockUI();
        }, function () {
            console.error("Error fetching review");
            $.unblockUI();
        });
    },

    editReview: function (review) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.put("bookreviews/" + review.id, review, function () {
            toastr.success("Review updated successfully");
            $.unblockUI();
            BookReviewService.closeModal();
            BookReviewService.getAllReviews();
        }, function () {
            $.unblockUI();
            toastr.error("Failed to update review");
        });
    },

    openConfirmationDialog: function (review) {
        review = JSON.parse(review);
        $("#deleteReviewModal").modal("show");
        $("#delete-review-body").html(
            "Do you want to delete review ID: " + review.id +
            '<input type="hidden" id="delete_review_id" value="' + review.id + '">' 
        );
    },
    openReviewsModal: function (bookId) {
        $('#reviews-list').html('<div class="text-center">Loading...</div>');
    
        // Set hidden input values dynamically
        document.getElementById('review_book_id').value = bookId;
        document.getElementById('review_user_id').value = localStorage.getItem("user_id");
        document.getElementById('review_date').value = new Date().toISOString().split('T')[0];
    
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

    deleteReview: function () {
        const id = $("#delete_review_id").val();
        RestClient.delete("bookreviews/" + id, null, function (response) {
            BookReviewService.closeModal();
            toastr.success(response.message || "Review deleted");
            BookReviewService.getAllReviews();
        }, function (response) {
            BookReviewService.closeModal();
            toastr.error(response.message);
        });
    }
};
