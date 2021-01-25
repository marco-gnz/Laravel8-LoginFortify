<template>
  <div>
    <form role="form">
      <div class="form-group row">
        <label for="last_name" class="col-md-4 col-form-label text-md-right"
          >RUT</label
        >
        <div class="col-md-3">
          <input type="text" class="form-control" v-model="almacenarRut.rut" />
          <span class="invalid-feedback" role="alert"> </span>
        </div>
        -
        <div class="col-md-2">
          <input
            type="text"
            class="form-control"
            v-model="almacenarRut.digito"
          />
        </div>
      </div>
      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
          <button
            class="btn btn-flat btn-info"
            @click.prevent="PostGuardarRut"
            v-loading.fullscreen.lock="fullscreenLoading"
          >
            Registrar
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      almacenarRut: {
        rut: "",
        digito: "",
      },
      fullscreenLoading: false,
    };
  },
  methods: {
      //metodo para almacenar rut del usuario
    PostGuardarRut() {
      this.fullscreenLoading = true;
      var url = "/home/rut";
      axios
        .post(url, {
          rut: this.almacenarRut.rut,
          digito: this.almacenarRut.digito,
        })
        .then((response) => {
            //prpiedad para redireccionar a la ruta home despues de enviar los parametros.
          window.location.href = "/home";
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style>
</style>