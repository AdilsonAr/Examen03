<template>
  <div>
    <div class="container">
      <template v-if="!loading">
        <div class="row">
          <h1>Empleados</h1>
          <!-- Form -->
          <div class="col-md-4 d-none">
            <input class="form-control" type="text" v-model="empleado.id" />
          </div>

          <div class="col-md-4 pt-3">
            <label>nombre</label>
            <input class="form-control" type="text" v-model="empleado.nombre" />
          </div>
          <div class="col-md-4 pt-3">
            <label>edad</label>
            <input
              class="form-control"
              type="number"
              v-model="empleado.edad"
            />
          </div>
          <div class="col-md-4 pt-3">
            <label>direccion</label>
            <input class="form-control" type="text" v-model="empleado.direccion" />
          </div>
          <div class="col-md-4 pt-3">
            <label>sueldo base</label>
            <input
              class="form-control"
              type="number"
              step="0.1"
              v-model="empleado.sueldo_base"
            />
          </div>

          <div class="col-md-4 pt-3">
            <label>Sucursal</label>
            <select v-model="empleado.nombre_s" class="form-select">
              <option
                v-for="s in sucursals"
                :key="s.id"
                :value="s.nombre"
              >
                {{ s.nombre }}
              </option>
            </select>
          </div>
         
          
          <div class="col-md-12 pt-3">
            <a href="#" class="btn btn-success" @click="save()">
              <i class="fa fa-save"></i> {{ textButton }}</a
            >
          </div>

          <!-- Table -->
          <empleado-table
            :data="empleados"
            :headers="headers"
            @delete="deleteP($event)"
            @edit="edit($event)"
          />
        </div>
        <paginationLaravel
          :data="pagination"
          @pagination-change-page="getResults"
          :limit="1"
        ></paginationLaravel>
      </template>
      <template v-else>
        <alert />
      </template>
    </div>
  </div>
</template>

<script>
import ui from "../../libs/ui";
import axios from "axios";
import Swal from "sweetalert2";
import PaginationLaravel from "laravel-vue-pagination";

export default {
  components: { PaginationLaravel },
  data: () => {
    return {
      empleado: {
        id: "",
        nombre: "",
        edad: "",
        sueldo_base: "0.0",
        direccion: "",
        nombre_s: "",
        user_id: "",
      },
      sucursals: [],
      empleados: [],
      headers: [
        "#",
        "Nombre",
        "Edad",
        "Direccion",
        "Sueldo",
        "Sucursal",
        "Acciones",
      ],
      textButton: "Guardar",
      loading: false,
      pagination: {},
    };
  },

  mounted() {
    this.initialize();
  },

  methods: {
    async initialize() {
      this.loading = true;

      let res = await axios.get("api/empleado");
      this.empleados = res.data.empleados;
      this.pagination = res.data.empleados;

      res = await axios.get("api/sucursal");
      this.sucursals = res.data.sucursals;

      if (this.sucursals.length > 0) {
        this.empleado.nombre_s = res.data.sucursals[0].nombre;
      }

      this.loading = false;
    },

    async save() {
      let res;
      switch (this.textButton) {
        case "Guardar":
          res = await axios.post("api/empleado", this.empleado).catch((e) => {
            ui.alert("Registro no pudo ser guardado correctamente.", "error");
          });

          if (res.data.message == "success") {
            this.empleado = res.data.empleado;
            ui.alert("Registro creado correctamente.");
          }
          break;
        case "Modificar":
          res = await axios
            .put(`api/empleado/${this.empleado.id}`, this.empleado)
            .catch((e) => {
              ui.alert(
                "Registro no pudo ser actualizado correctamente.",
                "error"
              );
            });

          if (res.data.message == "success") {
            ui.alert("Registro modificado correctamente.");
          }
          break;
      }
      this.initialize();
      this.cleanInputs();
    },

    edit(id) {
      this.empleado = this.empleados.find((empleado) => empleado.id == id);
      this.textButton = "Modificar";
    },

    async deleteP(id) {
      Swal.fire({
        title: "¿Estás seguro de eliminar este registro?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Confimar",
      }).then(async (result) => {
        if (result.isConfirmed) {
          const res = await axios.delete(`api/empleado/${id}`).catch((e) => {
            ui.alert("Registro no pudo ser eliminado correctamente.", "error");
          });

          if (res.data.message == "success") {
            ui.alert("Registro eliminado correctamente.");
            this.initialize();
            this.cleanInputs();
          }
        }
      });
    },

    cleanInputs() {
      this.empleado = {
        id: "",
        nombre: "",
        edad: "",
        sueldo_base: "0.0",
        direccion: "",
        nombre_s: "",
        user_id: "",
      };
      this.textButton = "Guardar";
    },

    async getResults(page = 1) {
      const res = await axios.get(this.pagination.path + "?page=" + page);
      this.empleados = res.data.empleados;
      this.pagination = res.data.empleados;
    },
  },
};
</script>

<style>
</style>
