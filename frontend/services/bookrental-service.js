let BookRentalService = {
    init: function () {
        $("#addBookRentalForm").validate({
            submitHandler: function (form) {
                console.log("Add form submitted"); // 
                var rental = Object.fromEntries(new FormData(form).entries());
                BookRentalService.addRental(rental);
                form.reset();
            },
        });
        $("#editBookRentalForm").validate({
            submitHandler: function (form) {
                var rental = Object.fromEntries(new FormData(form).entries());
                BookRentalService.editRental(rental);
            },
        });
        BookRentalService.getAllRentals();
        $("#confirmDeleteRental").click(function () {
            BookRentalService.deleteRental();
        });
        
    },

    openAddModal: function () {
        const modal = new bootstrap.Modal(document.getElementById('addBookRentalModal'));
        modal.show();
    },

    addRental: function (rental) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.post('bookRentals', rental, function () {
            toastr.success("Rental added successfully");
            $.unblockUI();
            BookRentalService.getAllRentals();
            BookRentalService.closeModal();
        }, function (response) {
            BookRentalService.closeModal();
            toastr.error(response.message);
        });
    },

    getAllRentals: function () {
        RestClient.get("bookRentals", function (data) {
            Utils.datatable('bookRentalsTable', [
                { data: 'id', title: 'ID' },
                { data: 'user_id', title: 'User ID' },
                { data: 'book_id', title: 'Book ID' },
                { data: 'rental_date', title: 'Rental Date' },
                { data: 'return_date', title: 'Return Date' },
                { data: 'status', title: 'Status' },
                {
                    title: 'Actions',
                    render: function (data, type, row, meta) {
                        const rowStr = encodeURIComponent(JSON.stringify(row));
                        return `
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-primary btn-sm" onclick="BookRentalService.openEditModal('${row.id}')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="BookRentalService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete</button>
                            </div>
                        `;
                    }
                }
            ], data, 10);
        }, function (xhr, status, error) {
            console.error('Error fetching rentals:', error);
        });
    },

    getRentalById: function (id) {
        RestClient.get('bookRentalsByID/' + id, function (data) {
            localStorage.setItem('selected_rental', JSON.stringify(data));
            const $form = $('#editBookRentalForm');
            $form.find('input[name="id"]').val(data.id);
            $form.find('input[name="user_id"]').val(data.user_id);
            $form.find('input[name="book_id"]').val(data.book_id);
            $form.find('input[name="rental_date"]').val(data.rental_date);
            $form.find('input[name="return_date"]').val(data.return_date);
            $form.find('input[name="status"]').val(data.status);
            $.unblockUI();
        }, function () {
            console.error('Error fetching rental');
            $.unblockUI();
        });
    },

    openEditModal: function (id) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        const modal = new bootstrap.Modal(document.getElementById('editBookRentalModal'));
        modal.show();
        setTimeout(() => {
            BookRentalService.getRentalById(id);
        }, 300);
    },

    closeModal: function () {
        const modals = ['addBookRentalModal', 'editBookRentalModal', 'deleteBookRentalModal'];
        modals.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                const modalInstance = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                modalInstance.hide();
            }
        });
    },

    editRental: function (rental) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.put('bookRentals/' + rental.id, rental, function () {
            $.unblockUI();
            toastr.success("Rental edited successfully");
            BookRentalService.closeModal();
            BookRentalService.getAllRentals();
        }, function () {
            $.unblockUI();
            toastr.error("Failed to update rental");
        });
    },

    openConfirmationDialog: function (rental) {
        rental = JSON.parse(rental);
        $("#deleteBookRentalModal").modal("show");
        $("#delete-bookRental-body").html(
            "Do you want to delete rental with ID: " + rental.id +
            '<input type="hidden" id="delete_rental_id" value="' + rental.id + '">'
        );
    },

    deleteRental: function () {
        RestClient.delete('bookRentals/' + $("#delete_rental_id").val(), null, function (response) {
            BookRentalService.closeModal();
            toastr.success(response.message);
            BookRentalService.getAllRentals();
        }, function (response) {
            BookRentalService.closeModal();
            toastr.error(response.message);
        });
    }
};