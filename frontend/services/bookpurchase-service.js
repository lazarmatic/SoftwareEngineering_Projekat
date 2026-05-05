let BookPurchaseService = {
    init: function () {
        $("#addBookPurchaseForm").validate({
            submitHandler: function (form) {
                console.log("Add form submitted");
                var purchase = Object.fromEntries(new FormData(form).entries());
                BookPurchaseService.addPurchase(purchase);
                form.reset();
            },
        });
        $("#editBookPurchaseForm").validate({
            submitHandler: function (form) {
                var purchase = Object.fromEntries(new FormData(form).entries());
                BookPurchaseService.editPurchase(purchase);
            },
        });
        BookPurchaseService.getAllPurchases();
        $("#confirmDeletePurchase").click(function () {
            BookPurchaseService.deletePurchase();
        });
    },

    openAddModal: function () {
        const modal = new bootstrap.Modal(document.getElementById('addBookPurchaseModal'));
        modal.show();
    },

    addPurchase: function (purchase) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.post('bookPurchases', purchase, function () {
            toastr.success("Purchase added successfully");
            $.unblockUI();
            BookPurchaseService.getAllPurchases();
            BookPurchaseService.closeModal();
        }, function (response) {
            BookPurchaseService.closeModal();
            toastr.error(response.message);
        });
    },

    getAllPurchases: function () {
        RestClient.get("bookPurchases", function (data) {
            Utils.datatable('bookPurchasesTable', [
                { data: 'id', title: 'ID' },
                { data: 'user_id', title: 'User ID' },
                { data: 'book_id', title: 'Book ID' },
                { data: 'purchase_date', title: 'Purchase Date' },
                { data: 'quantity', title: 'Quantity' },
                { data: 'total_price', title: 'Total Price' },
                {
                    title: 'Actions',
                    render: function (data, type, row, meta) {
                        const rowStr = encodeURIComponent(JSON.stringify(row));
                        return `
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-primary btn-sm" onclick="BookPurchaseService.openEditModal('${row.id}')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="BookPurchaseService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete</button>
                            </div>
                        `;
                    }
                }
            ], data, 10);
        }, function (xhr, status, error) {
            console.error('Error fetching purchases:', error);
        });
    },

    getPurchaseById: function (id) {
        RestClient.get('bookPurchasesByID/' + id, function (data) {
            localStorage.setItem('selected_purchase', JSON.stringify(data));
            const $form = $('#editBookPurchaseForm');
            $form.find('input[name="id"]').val(data.id);
            $form.find('input[name="user_id"]').val(data.user_id);
            $form.find('input[name="book_id"]').val(data.book_id);
            $form.find('input[name="purchase_date"]').val(data.purchase_date);
            $form.find('input[name="quantity"]').val(data.quantity);
            $form.find('input[name="total_price"]').val(data.total_price);
            $.unblockUI();
        }, function () {
            console.error('Error fetching purchase');
            $.unblockUI();
        });
    },

    openEditModal: function (id) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        const modal = new bootstrap.Modal(document.getElementById('editBookPurchaseModal'));
        modal.show();
        setTimeout(() => {
            BookPurchaseService.getPurchaseById(id);
        }, 300);
    },

    closeModal: function () {
        const modals = ['addBookPurchaseModal', 'editBookPurchaseModal', 'deleteBookPurchaseModal'];
        modals.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                const modalInstance = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                modalInstance.hide();
            }
        });
    },

    editPurchase: function (purchase) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.put('bookPurchases/' + purchase.id, purchase, function () {
            $.unblockUI();
            toastr.success("Purchase edited successfully");
            BookPurchaseService.closeModal();
            BookPurchaseService.getAllPurchases();
        }, function () {
            $.unblockUI();
            toastr.error("Failed to update purchase");
        });
    },

    openConfirmationDialog: function (purchase) {
        purchase = JSON.parse(purchase);
        $("#deleteBookPurchaseModal").modal("show");
        $("#delete-bookPurchase-body").html(
            "Do you want to delete purchase with ID: " + purchase.id +
            '<input type="hidden" id="delete_purchase_id" value="' + purchase.id + '">'
        );
    },

    deletePurchase: function () {
        RestClient.delete('bookPurchases/' + $("#delete_purchase_id").val(), null, function (response) {
            BookPurchaseService.closeModal();
            toastr.success(response.message);
            BookPurchaseService.getAllPurchases();
        }, function (response) {
            BookPurchaseService.closeModal();
            toastr.error(response.message);
        });
    }
};
