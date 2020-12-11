<template>
  <v-app>
    <v-main>
      <v-container
        class="fill-height"
        fluid
        v-bind:style="{ cursor: selectedCursor }"
      >
        <v-row align="center" justify="center">
          <v-col cols="12" xs="8" sm="8" md="8" lg="8" xl="8">
            <v-card class="elevation-12">
              <v-window v-model="step">
                <v-window-item :value="1" transition="fade-transition">
                  <v-row>
                    <v-col
                      cols="12"
                      xs="12"
                      sm="4"
                      md="4"
                      lg="4"
                      xl="4"
                      class="teal darken-4 rounded-l-lg"
                    >
                      <v-card-text class="white--text mt-2">
                        <h1 class="text-center display-1">Petquenos</h1>
                        <div class="text-center">
                          <v-avatar
                            class="my-3 elevation-12"
                            color="white"
                            size="150"
                          >
                            <img src="@/assets/logo.svg" />
                          </v-avatar>
                        </div>
                      </v-card-text>
                    </v-col>

                    <v-col
                      cols="12"
                      xs="12"
                      sm="8"
                      md="8"
                      lg="8"
                      xl="8"
                      class="white rounded-r-lg"
                    >
                      <v-card-text class="text--white mt-2">
                        <h3 class="text-center Heading 4">
                          Acesso ao sistema.
                        </h3>
                        <p class="text-center Heading 6">
                          Informe as credenciais para acessar o sistema!
                        </p>
                        <v-form
                          v-on:submit.prevent="logar(objFormLogin)"
                          ref="formLogin"
                          lazy-validation
                        >
                          <!--<v-text-field
                            label="Login"
                            name="login"
                            v-model="objFormLogin.login"
                            prepend-inner-icon="mdi-account"
                            type="text"
                            :rules="loginRules"
                          />-->
                          <v-select
                            :items="itensLogin"
                            label="Login"
                            v-model="objFormLogin.login"
                            prepend-inner-icon="mdi-account"
                            dense
                            outlined
                            :rules="loginRules"
                          ></v-select>

                          <v-text-field
                            label="Senha"
                            v-model="objFormLogin.senha"
                            prepend-inner-icon="mdi-form-textbox-password"
                            dense
                            outlined
                            :append-icon="
                              valuePassword ? 'mdi-eye-off' : 'mdi-eye'
                            "
                            @click:append="
                              () => (valuePassword = !valuePassword)
                            "
                            :type="valuePassword ? 'password' : 'text'"
                            :rules="passwordRules"
                          />
                          <div class="text-center mt3">
                            <v-btn @click="logar" color="teal darken-4" dark>
                              <v-icon left> mdi-login-variant </v-icon>
                              Logar
                            </v-btn>
                          </div>
                        </v-form>
                      </v-card-text>
                    </v-col>
                  </v-row>
                </v-window-item>

                <v-window-item :value="2" transition="scale-transition">
                  <v-row>
                    <v-col class="white rounded-lg">
                      <v-card-text class="text--white mt-2">
                        <h3 class="text-center Heading 4">
                          Cadastro de Exames.
                        </h3>
                        <p class="text-center Heading 6">
                          Informe os dados para gerar o pdf do exame.
                        </p>
                        <p
                          class="text-center Heading 6"
                          v-if="this.objForm.login === 'rita'"
                        >
                          Drª. Rita de Cássia do N. Silva.
                          <br />
                          CRMV-PE 3900
                        </p>
                        <p
                          class="text-center Heading 6"
                          v-else-if="this.objForm.login === 'angela'"
                        >
                          Drª. Ângela Roberta Batista da Silva.
                          <br />
                          CRMV-PE 5207
                        </p>
                        <p
                          class="text-center Heading 6"
                          v-else-if="this.objForm.login === 'suellen'"
                        >
                          Drª. Suellên Cris Regis da Silva Negrão.
                          <br />
                          CRMV-PE 4184
                        </p>
                        <p v-else>Nao encontrou login</p>

                        <v-form
                          v-on:submit.prevent="logar(objForm)"
                          ref="objForm"
                          lazy-validation
                        >
                          <v-row>
                            <v-col>
                              <v-text-field
                                label="Nome do tutor"
                                :counter="30"
                                outlined
                                dense
                                v-model="objForm.nomeTutor"
                                type="text"
                                :rules="regrasTutor"
                              />
                            </v-col> </v-row
                          ><v-row>
                            <v-col>
                              <v-text-field
                                label="Nome do animal"
                                :counter="30"
                                outlined
                                dense
                                v-model="objForm.nomeAnimal"
                                type="text"
                                :rules="regrasAnimal"
                              />
                            </v-col>
                          </v-row>
                          <v-row>
                            <v-col>
                              <v-select
                                :items="itensEspecies"
                                label="Espécie"
                                v-model="objForm.especie"
                                dense
                                outlined
                                :rules="regrasEspecie"
                              ></v-select>
                              <!--<v-text-field
                                label="Espécie LISTA"
                                v-model="objForm.especie"
                                type="text"
                                :rules="regrasEspecie"
                              />-->
                            </v-col>
                            <v-col>
                              <v-text-field
                                label="Raça"
                                v-model="objForm.raca"
                                type="text"
                                dense
                                outlined
                                :rules="regrasRaca"
                              />
                            </v-col>
                          </v-row>

                          <v-row>
                            <v-col>
                              <v-text-field
                                label="Idade"
                                v-model="objForm.idade"
                                type="text"
                                dense
                                outlined
                                :rules="regrasIdade"
                              />
                            </v-col>
                            <v-col>
                              <v-select
                                :items="itensGenero"
                                label="Gênero"
                                v-model="objForm.genero"
                                dense
                                outlined
                                :rules="regrasGenero"
                              ></v-select>
                            </v-col>
                          </v-row>
                          <v-row>
                            <v-col>
                              <v-menu
                                ref="menu"
                                v-model="menu"
                                :close-on-content-click="false"
                                :return-value.sync="date"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                              >
                                <template v-slot:activator="{ on, attrs }">
                                  <v-text-field
                                    v-model="dateFormated"
                                    label="Data do exame"
                                    readonly
                                    dense
                                    outlined
                                    v-bind="attrs"
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <v-date-picker
                                  locale="pt-br"
                                  v-model="date"
                                  no-title
                                  scrollable
                                >
                                  <v-spacer></v-spacer>
                                  <v-btn
                                    text
                                    color="primary"
                                    @click="menu = false"
                                  >
                                    Cancel
                                  </v-btn>
                                  <v-btn
                                    text
                                    color="primary"
                                    @click="$refs.menu.save(date)"
                                  >
                                    OK
                                  </v-btn>
                                </v-date-picker>
                              </v-menu>
                            </v-col>
                          </v-row>

                          <v-row>
                            <v-col>
                              <!-- <span>{{ new Date() | moment('DD/MM/YYYY') }}</span> -->
                              <v-textarea
                                label="Laudo/Observações"
                                v-model="objForm.laudo"
                                :counter="860"
                                dense
                                outlined
                                :rules="regrasLaudo"
                              ></v-textarea>
                            </v-col>
                          </v-row>

                          <v-tabs
                            v-model="tab"
                            background-color="teal darken-4"
                            dark
                            fixed-tabs
                          >
                            <v-tabs-slider></v-tabs-slider>

                            <v-tab v-for="i in itensTituloTabs" :key="i.id">
                              <!--<div>{{ i.nome }}</div>-->
                              <v-icon large>{{ i.icon }}</v-icon>
                            </v-tab>
                          </v-tabs>
                          <v-tabs-items class="elevation-5" v-model="tab">
                            <v-tab-item>
                              <v-row v-show="showCamera">
                                <v-col>
                                  <center>
                                    <div
                                      style="max-width: 60%; max-height: 60%"
                                    >
                                      <v-row>
                                        <p class="Heading 4">
                                          Capturar resultado do exame
                                        </p>

                                        <vue-web-cam
                                          ref="webcam"
                                          :device-id="deviceId"
                                          width="100%"
                                          @cameras="onCameras"
                                          @camera-change="onCameraChange"
                                          @started="onStarted"
                                          @stopped="onStopped"
                                          @error="onError"
                                        />
                                      </v-row>
                                      <v-row>
                                        <code v-if="device"
                                          >Câmera utilizada
                                          {{ device.label }}</code
                                        >
                                        <v-select
                                          label="Lista camera"
                                          item-text="label"
                                          item-value="deviceId"
                                          :items="devices"
                                          v-model="camera"
                                        ></v-select>
                                      </v-row>
                                      <v-row>
                                        <v-col>
                                          <v-btn
                                            color="teal darken-4"
                                            dark
                                            @click="onCapture"
                                            >Capture
                                            <v-icon>mdi-camera-iris</v-icon>
                                          </v-btn>
                                        </v-col>
                                        <!--<v-col>
                                          <v-btn
                                            color="teal darken-4"
                                            dark
                                            @click="onStop"
                                          >
                                            <v-icon>mdi-camera-off</v-icon>
                                            Stop
                                          </v-btn>
                                        </v-col>
                                        <v-col>
                                          <v-btn
                                            color="teal darken-4"
                                            dark
                                            @click="onStart"
                                          >
                                            <v-icon>mdi-camera-retake</v-icon>
                                            Start
                                          </v-btn>
                                        </v-col>-->
                                      </v-row>
                                    </div>
                                  </center>
                                </v-col>
                              </v-row>

                              <v-row v-show="showImagemFinal">
                                <v-col>
                                  <center>
                                    <div
                                      class="text-center mt3"
                                      style="max-width: 60%; max-height: 60%"
                                    >
                                      <p class="Heading 4">
                                        Imagem pronta para salvar
                                      </p>
                                      <p>
                                        <img
                                          :src="result"
                                          alt="no result"
                                          style="
                                            max-width: 60%;
                                            max-height: 60%;
                                          "
                                        />
                                      </p>
                                      <p>
                                        <v-btn
                                          @click.native="cancelarImagem"
                                          color="teal darken-4"
                                          dark
                                        >
                                          cancelar
                                          <v-icon>mdi-cancel</v-icon>
                                        </v-btn>
                                      </p>
                                    </div>
                                  </center>
                                </v-col>
                              </v-row>
                            </v-tab-item>
                          </v-tabs-items>

                          <v-row>
                            <v-col>
                              <div class="mt3 pa-5">
                                <center>
                                  <v-btn
                                    @click="gerarPDF"
                                    color="teal darken-4"
                                    dark
                                  >
                                    <v-icon left>mdi-file-pdf </v-icon>
                                    Baixar PDF
                                  </v-btn>
                                </center>
                              </div>
                            </v-col>
                          </v-row>
                        </v-form>
                      </v-card-text>
                    </v-col>
                  </v-row>
                </v-window-item>
              </v-window>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <PoupUpCaptureImage
      v-bind:variavelShowModalImage="varOpenDialogImagens"
      v-bind:imageBase64Cortar="varImagebase64Cortar"
      v-on:closeModal="closeDialogImagens"
      v-on:setValueImageCroped="getValueImageCroped"
      @update:varOpenDialogImagens="varOpenDialogImagens = $event"
      @update:varImagebase64Cortar="varImagebase64Cortar = $event"
    />
  </v-app>
</template>
<script>
import { WebCam } from "vue-web-cam";

//import { moment } from "vue-moment";

import moment from "moment";

import PoupUpCaptureImage from "./PoupUpCaptureImage";

export default {
  components: {
    "vue-web-cam": WebCam,
    //clipperFixed,clipperBasic,clipperRange,
    PoupUpCaptureImage,
  },
  data: () => ({
    date: new Date().toISOString().substr(0, 10),
    menu: false,
    itensLogin: ["rita", "angela", "suellen"],

    valuePassword: true,

    tab: null,
    inicializacao: true,

    /*DIALOGO IMAGENS COMODO*/
    varOpenDialogImagens: false,
    /*DIALOGO IMAGENS COMODO*/

    /*CAM*/
    camera: null,
    deviceId: null,
    devices: [],

    cameraInicial: null,
    deviceIdInicial: null,
    /*CAM*/

    selectedCursor: "",

    showCamera: true,

    showImagemFinal: false,

    //crope
    rotation: 0,
    imageBase64: "",
    src: "",
    result: "",
    //crope

    varImagebase64Cortar: "",

    itensEspecies: ["Canina", "Equina", "Felina"],
    itensGenero: ["Macho", "Fêmea"],

    itensTituloTabs: [{ id: 0, nome: "Câmera", icon: "mdi-camera" }],

    step: 1,
    overlay: false,

    objFormLogin: {
      login: "",
      senha: "",
    },

    objForm: {
      nomeTutor: "",
      nomeAnimal: "",
      especie: "",
      raca: "",
      idade: "",
      genero: "",
      laudo: "",
      login: "",
    },

    loginRules: [(v) => !!v || "Login é obrigatorio"],
    passwordRules: [(v) => !!v || "Senha é obrigatorio"],

    regrasTutor: [
      (v) => !!v || "nome do tutor e obrigatório",
      (v) => (v && v.length <= 30) || "O nome deve ter até de 30 caracteres",
    ],
    regrasAnimal: [
      (v) => !!v || "nome do animal e obrigatório",
      (v) => (v && v.length <= 30) || "O nome deve ter até de 30 caracteres",
    ],
    regrasEspecie: [(v) => !!v || "espécie do animal é obrigatório"],
    regrasRaca: [(v) => !!v || "raça do animal é obrigatório"],
    regrasIdade: [(v) => !!v || "idade do animal é obrigatório"],
    regrasGenero: [(v) => !!v || "gênero do animal é obrigatório"],
    regrasLaudo: [
      (v) => !!v || "laudo-observação do exame é obrigatório",
      (v) =>
        (v && v.length <= 860) ||
        "O laudo-observação deve ter até de 860 caracteres",
    ],
  }),

  computed: {
    dateFormated() {
      //return this.date;
      //return this.date | moment('DD/MM/YYYY');
      return moment(this.date).format("DD/MM/YYYY");
    },

    device: function () {
      let list = this.devices.find((n) => n.deviceId === this.deviceId);
      return list;
    },
  },

  watch: {
    camera: function (id) {
      this.deviceId = id;
    },
    devices: function () {
      // Once we have a list select the first one
      const [first] = this.devices;

      if (first) {
        let first2 = this.devices[this.devices.length - 1];
        this.camera = first2.deviceId;
        this.deviceId = first2.deviceId;
      }
    },
  },

  methods: {
    /*DIALOGO IMAGENS */
    openDialogImagens: function () {
      console.log("aqui");
      this.varOpenDialogImagens = true;
      console.log(this.varOpenDialogImagens);
    },
    closeDialogImagens: function (value) {
      console.log(value);
      this.varOpenDialogImagens = false;
    },

    getValueImageCroped: function (value) {
      this.showCamera = false;
      this.result = value;
      this.showImagemFinal = true;
    },

    /*DIALOGO IMAGENS COMODO*/

    //CROP NOVO
    //changeCrooper({ coordinates, canvas }) {
    //console.log(coordinates, canvas);
    //},
    //CROP NOVO

    /*imgLoad: function () {
      const imgRatio = this.$refs.clipper.imgRatio;
      if (imgRatio < 1) this.based = this.maxHeight * imgRatio;
      else this.based = this.maxWidth;
    },*/
    onCapture() {
      this.imageBase64 = this.$refs.webcam.capture();
      this.varImagebase64Cortar = this.imageBase64;
      this.openDialogImagens();

      //this.con();
    },
    onStarted(stream) {
      console.log("On Started Event", stream);
    },
    onStopped(stream) {
      console.log("On Stopped Event", stream);
    },
    onStop() {
      this.$refs.webcam.stop();
    },
    onStart() {
      this.$refs.webcam.start();
    },
    onError(error) {
      console.log("On Error Event", error);
    },
    onCameras(cameras) {
      this.devices = cameras;
      //console.log("On Cameras Event", cameras);
      let cam = this.devices[this.devices.length - 1];
      this.cameraInicial = cam.deviceId;
      this.deviceIdInicial = cam.deviceId;
    },
    onCameraChange(deviceId) {
      if (this.inicializacao) {
        let cam = this.devices[this.devices.length - 1];
        this.deviceId = cam.deviceId;
        this.camera = cam.deviceId;
        this.inicializacao = false;
      } else {
        this.deviceId = deviceId;
        this.camera = deviceId;
      }

      console.log("On Camera Change Event", deviceId);
    },

    con: function () {
      setTimeout(() => {
        (this.showCamera = false), this.definir();
      }, 200);
    },

    definir: function () {
      //this.$refs.clipper.setTL$.next({ left: 10, top: 0 }); // percentage 0%
      //this.$refs.clipper.setTL$.next({ right: 25, bottom: 0 });
      //this.$refs.clipper.setWH$.next({ width: 50, height: 100 });

      this.selectedCursor = "";
    },

    cortar: function () {
      /*const result = this.$refs.cropper.getResult();
      result.canvas.toDataURL("image/jpeg");

      const canvas = this.$refs.clipper.clip({ maxWPixel: 500 });
      this.result = canvas.toDataURL("image/png");

      this.showCamera = false;
      this.showImagemFinal = true;*/
    },

    cancelarImagem: function () {
      this.result = null;
      this.showCamera = true;
      this.showImagemFinal = false;
    },

    logar: function () {
      this.overlay = true;
      if (this.validateLogin()) {
        if (
          this.objFormLogin.login == "rita" ||
          this.objFormLogin.login == "angela" ||
          this.objFormLogin.login == "suellen"
        ) {
          if (this.objFormLogin.senha == "admin") {
            this.objForm.login = this.objFormLogin.login;
            this.step++;
            this.overlay = false;
          } else {
            this.overlay = false;
            this.$dialog.message.error("Usuario ou senha inválido", {
              position: "top-right",
              timeout: 5000,
            });
          }
        } else {
          this.overlay = false;
          this.$dialog.message.error("Usuario ou senha inválido", {
            position: "top-right",
            timeout: 5000,
          });
        }
      } else {
        this.overlay = false;
      }
    },

    limparCampos: function () {
      this.objForm.nomeTutor = "";
      this.objForm.nomeAnimal = "";
      this.objForm.especie = "";
      this.objForm.raca = "";
      this.objForm.idade = "";
      this.objForm.genero = "";
      this.objForm.laudo = "";
      this.date = new Date().toISOString().substr(0, 10);
      this.cancelarImagem();
    },

    gerarPDF: function () {
      this.overlay = true;
      if (this.validateGerarPDF()) {
        if (this.imageBase64.length > 0) {
          if (this.result.length > 0) {
            var objPost = {
              nomeTutor: this.objForm.nomeTutor,
              nomeAnimal: this.objForm.nomeAnimal,
              especie: this.objForm.especie,
              raca: this.objForm.raca,
              idade: this.objForm.idade,
              genero: this.objForm.genero,
              laudo: this.objForm.laudo,
              image: this.result,
              login: this.objForm.login,
              dataExame: moment(this.date).format("DD_MM_YYYY"),
            };
            let nomePdf =
              this.objForm.nomeAnimal +
              "_" +
              moment(this.date).format("DD_MM_YYYY") +
              ".pdf";

            this.$axios
              .post(
                "https://petquenos.com.br/apiPdf/public/generatepdf",
                objPost,
                {
                  responseType: "blob",
                }
              )
              .then(
                (response) => {
                  console.log(response);
                  if (response.status == 200) {
                    const url = window.URL.createObjectURL(
                      new Blob([response.data])
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute(
                      "download",
                      this.objForm.nomeAnimal +
                        "_" +
                        moment(this.date).format("DD_MM_YYYY") +
                        ".pdf"
                    ); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                    this.limparCampos();
                    this.$dialog.message.success(
                      nomePdf + " gerado com sucesso!!!!",
                      {
                        position: "top-right",
                        timeout: 5000,
                      }
                    );

                    this.resetValidation();
                    this.overlay = false;
                  } else {
                    this.overlay = false;
                    //console.log(response);
                    this.$dialog.message.error(response.toString(), {
                      position: "top-right",
                      timeout: 5000,
                    });
                  }
                },
                (error) => {
                  try {
                    this.$dialog.message.error(error.response.data.message, {
                      position: "top-right",
                      timeout: 5000,
                    });
                    this.overlay = false;
                  } catch (error) {
                    this.$dialog.message.error(error.response.data.message, {
                      position: "top-right",
                      timeout: 5000,
                    });
                    this.overlay = false;
                  }
                }
              );
          } else {
            this.$dialog.message.error(
              "É necessario cortar a imagem do exame pra gerar o PDF",
              {
                position: "top-right",
                timeout: 5000,
              }
            );
            this.overlay = false;
          }
        } else {
          this.$dialog.message.error(
            "É necessario capturar a imagem do exame pra gerar o PDF",
            {
              position: "top-right",
              timeout: 5000,
            }
          );
          this.overlay = false;
        }
      } else {
        this.$dialog.message.error(
          "Observe o formulário, existe campos inválidos",
          {
            position: "top-right",
            timeout: 5000,
          }
        );
        this.overlay = false;
      }
    },

    validateLogin: function () {
      return this.$refs.formLogin.validate();
    },

    validateGerarPDF: function () {
      return this.$refs.objForm.validate();
    },

    reset: function () {
      this.$refs.objForm.reset();
      this.objForm.login = "";
      this.objForm.senha = "";
    },

    resetValidation: function () {
      this.$refs.objForm.resetValidation();
    },
  },
};
</script>
<style>
</style>
