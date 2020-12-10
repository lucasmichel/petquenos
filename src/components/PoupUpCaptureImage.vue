<template>
  <v-row justify="center">
    <v-dialog
      v-model="getValorAbrirJanelaImage"
      persistent
      scrollable
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-card-title>Cortar imagem</v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <center>
            <cropper
              class="cropper"
              :src="imageBase64Cortar"
              :touchResize="false"
              :mouseMove="false"
              ref="cropper"
              @change="changeCrooper"
            />
          </center>

          <center></center>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="blue darken-4" dark text v-on:click="onCapture()">
            Cortar image
            <v-icon>mdi-content-cut</v-icon>
          </v-btn>

          <v-btn
            color="blue darken-4"
            dark
            text
            v-on:click="closeModalImage(false)"
          >
            Cancel
            <v-icon right dark>mdi-camera</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import { Cropper } from "vue-advanced-cropper";
//https://norserium.github.io/vue-advanced-cropper/components/cropper.html
export default {
  components: {
    Cropper,
  },

  name: "PoupUpCaptureImage",

  props: {
    variavelShowModalImage: {
      required: true,
    },
    imageBase64Cortar: {
      required: true,
    },
  },

  data: () => ({
    /*CAM*/
    camera: null,
    deviceId: null,
    devices: [],
    /*CAM*/
  }),

  computed: {
    getValorAbrirJanelaImage: {
      get() {
        return this.variavelShowModalImage;
      },
      set(value) {
        this.$emit("update:varOpenDialog", value);
      },
    },
  },

  methods: {
    onCapture() {
      let value = this.$refs.cropper.getResult();
      let canvas = value.canvas;
      //console.log(canvas.toDataURL());
      this.$emit("setValueImageCroped", canvas.toDataURL());
      this.closeModalImage(false);
    },

    //CROP NOVO
    changeCrooper({ coordinates, canvas }) {
      console.log(coordinates, canvas);
    },
    //CROP NOVO

    closeModalImage: function (value) {
      this.$emit("closeModal", value);
    },
  },
};
</script>
<style>
.containerAqui {
  display: flex;
  overflow-x: auto;
}
.container img {
  margin-right: 15px;
}
.container::-webkit-scrollbar {
  display: none;
}
</style>
