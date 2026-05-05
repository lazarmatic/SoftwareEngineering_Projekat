let AdminUserService = {
    init: function () {
        $("#addUserForm").validate({
            submitHandler: function (form) {
                const user = Object.fromEntries(new FormData(form).entries());
                AdminUserService.addUser(user);
                form.reset();
            },
        });

        $("#editUserForm").validate({
            submitHandler: function (form) {
                const user = Object.fromEntries(new FormData(form).entries());
                AdminUserService.editUser(user);
            },
        });

        AdminUserService.getAllUsers();

        $("#confirmDeleteUser").click(function () {
            AdminUserService.deleteUser();
        });
    },

    openAddModal: function () {
        const modal = new bootstrap.Modal(document.getElementById("addUserModal"));
        modal.show();
    },

    openEditModal: function (id) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        const modal = new bootstrap.Modal(document.getElementById("editUserModal"));
        modal.show();
        setTimeout(() => {
            AdminUserService.getUserById(id);
        }, 300);
    },

    closeModal: function () {
        const modals = ["addUserModal", "editUserModal", "deleteUserModal"];
        modals.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                const modalInstance = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                modalInstance.hide();
            }
        });
    },

    addUser: function (user) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.post("users", user, function () {
            toastr.success("User added successfully");
            $.unblockUI();
            AdminUserService.getAllUsers();
            AdminUserService.closeModal();
        }, function (response) {
            AdminUserService.closeModal();
            toastr.error(response.message);
        });
    },

    getAllUsers: function () {
        RestClient.get("users", function (data) {
            Utils.datatable("usersTable", [
                { data: "id", title: "ID" },
                { data: "username", title: "Username" },
                { data: "full_name", title: "Full Name" },
                { data: "email", title: "Email" },
                { data: "phone", title: "Phone" },
                { data: "role", title: "Role" },
                {
                    title: "Actions",
                    render: function (data, type, row, meta) {
                        const rowStr = encodeURIComponent(JSON.stringify(row));
                        return `
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-primary btn-sm" onclick="AdminUserService.openEditModal('${row.id}')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="AdminUserService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete</button>
                            </div>
                        `;
                    }
                }
            ], data, 10);
        }, function (xhr, status, error) {
            console.error("Error fetching users:", error);
        });
    },

    getUserById: function (id) {
        RestClient.get("users/" + id, function (data) {
            localStorage.setItem("selected_user", JSON.stringify(data));
            const $form = $("#editUserForm");
            $form.find("input[name='id']").val(data.id);
            $form.find("input[name='username']").val(data.username);
            $form.find("input[name='full_name']").val(data.full_name);
            $form.find("input[name='email']").val(data.email);
            $form.find("input[name='phone']").val(data.phone);
            $form.find("input[name='role']").val(data.role);
            $.unblockUI();
        }, function () {
            console.error("Error fetching user");
            $.unblockUI();
        });
    },

    editUser: function (user) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.put("users/" + user.id, user, function () {
            toastr.success("User updated successfully");
            AdminUserService.closeModal();
            $.unblockUI();
             AdminUserService.getAllUsers(); 
        }, function () {
            $.unblockUI();
            toastr.error("Failed to update user");
        });
    },

    openConfirmationDialog: function (user) {
        user = JSON.parse(user);
        $("#deleteUserModal").modal("show");
        $("#delete-user-body").html(
            "Do you want to delete user with ID: " + user.id +
            '<input type="hidden" id="delete_user_id" value="' + user.id + '">' 
        );
    },

    deleteUser: function () {
        RestClient.delete("users/" + $("#delete_user_id").val(), null, function (response) {
            AdminUserService.closeModal();
            toastr.success(response.message);
            AdminUserService.getAllUsers();
        }, function (response) {
            AdminUserService.closeModal();
            toastr.error(response.message);
        });
    }
};
