const CRUD = {
  redirectToModuleRoute(route) {
    window.location.href = `${baseUrl}admin/${moduleKey}/${route}`;
  },

  importar() {
    this.redirectToModuleRoute("importar");
  },

  agregar() {
    this.redirectToModuleRoute("agregar");
  },

  editar(id) {
    this.redirectToModuleRoute(`${id}/editar`);
  },

  eliminar(id) {
    createModal({
      id: "deleteModal",
      title: "Confirmar Eliminación",
      body: `¿Estás seguro de que deseas eliminar este ${moduleKey}?`,
      buttons: [
        {
          text: "No, cancelar",
          class: "btn-secondary",
          action: function () {
            $("#deleteModal").modal("hide");
          },
        },
        {
          text: "Sí, eliminar",
          class: "btn-danger",
          action: function () {
            CRUD.performDelete(id);
          },
        },
      ],
    });
  },

  performDelete(id) {
    ajaxBase({
      url: `admin/${moduleKey}/${id}/eliminar`,
      method: "POST",
      successCallback: function (response) {
        if (response.status === "success") {
          alert(response.message);
          $("#main-datatable").DataTable().ajax.reload();
        } else {
          alert(response.message);
        }
        $("#deleteModal").modal("hide");
      },
      errorCallback: function (xhr) {
        alert("Hubo un problema al eliminar el registro.");
        $("#deleteModal").modal("hide");
      },
      redirectExpiredSess: "/admin/login",
    });
  },
};
