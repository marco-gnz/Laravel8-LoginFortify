<template>
  <div>
    <form role="form">
      <div class="form-group row">
        <label for="last_name" class="col-md-4 col-form-label text-md-right"
          >RUT</label
        >
        <div class="col-md-6">
          <div :class="{ 'has-error': error != '' }">
            <input
              v-model="rut"
              class="form-control"
              name="rut"
              ref="rut"
              id="rut"
              type="text"
              @blur="validateRut"
              placeholder="12.345.678-0"
              minlength="12"
              maxlength="12"
              autocomplete="off"
              required
              autofocus
            />
          </div>
          <br>
          <div v-if="error != ''" class="alert alert-danger">{{error}}</div>
          <div v-if="errores && !$v.rut.required" class="alert alert-danger"> El campo rut es obligatorio</div>
          <div v-if="errores && !$v.rut.maxLength" class="alert alert-danger"> Son 12 carcateres como max</div>
          <div v-if="errores && !$v.rut.minLength" class="alert alert-danger"> Son 12 carcateres como min</div>
        </div>
      </div>
      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-5">
          <el-button
          type="success"
          icon="el-icon-check"
          circle
          @click.prevent="almacenarRut"
          v-loading.fullscreen.lock="fullscreenLoading"
        ></el-button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";

import { required, minLength, maxLength } from 'vuelidate/lib/validators'

export default {
  data() {
    return {
      fullscreenLoading: false,
      rut: "",
      error: "",
      errores: false
    };
  },
  watch: {
    rut: function (val) {
      this.rut = this.cleanRut(this.rut);
      let len = this.rut.length - 1;
      if (len > 3) {
        let dv = this.rut[len];
        let beforeDv = this.rut
          .substring(0, len)
          .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        this.rut = beforeDv + "-" + dv;
      }
    },
  },
  methods: {
    cleanRut(value) {
      return value.replace(/^0+|[^0-9kK]+/g, "").toUpperCase();
    },
    validateRut() {
      let rut = this.cleanRut(this.rut);
      let digito_verificador = this.rut.substr(-1);

      rut = rut.substr(0, rut.length - 1);

      let serie = 0;
      let producto = 0;

      do {
        producto += (rut % 10) * ((serie % 6) + 2);
        serie++;
      } while ((rut = Math.floor(rut / 10)));

      let resto = producto % 11;
      let resultado = 11 - resto;

      if (resultado == 11) {
        resultado = 0;
      } else if (resultado == 10) {
        resultado = "K";
      }

      if (digito_verificador != resultado) {
        this.errorInRut();
      } else {
        this.error = "";
      }
    },
    errorInRut() {
      this.error = "Rut inválido";
      this.$refs.rut.focus();
    },
    //metodo para almacenar rut del usuario
    PostGuardarRut() {
      this.fullscreenLoading = true;
      var url = "/home/rut";
      axios
        .post(url, {
          rut: this.rut,
        })
        .then((response) => {
          if(response.data.ok){
            console.log(response.data.ok);
          }
          //prpiedad para redireccionar a la ruta home despues de enviar los parametros.
          window.location.href = "/home";
        })
        .catch((error) => {
          console.log(error);
        });
    },
    almacenarRut(){
      this.errores = true;
      this.$v.$touch();
      if(this.$v.$invalid){
        return false;
      }else{
        this.PostGuardarRut();
      }
    }
  },
  validations:{
    rut:  {
            required,
            minLength: minLength(12),
            maxLength: maxLength(12)
          }
  }

};
</script>

<style>
</style>