<template>
  <div class="pt-5 container-fluid">
    <loading-modal :loading="loading"></loading-modal>
    <carousel
      ref="carousel"
      :responsive="{
        0:{items:1},
        1100:{items:2, mouseDrag:false,touchDrag:false}, 
        1300:{items:2, mouseDrag:false,touchDrag:false,margin:-100}, 
        1500:{items:2, mouseDrag:false,touchDrag:false,margin:-200}, 
        1700:{items:2, mouseDrag:false,touchDrag:false,margin:-300},
      }"
      :nav="false"
      :dots="false"
      :rewind="false"
    >
      <div class="slide-wrapper">
        <div class="slide">
          <div class="imgblock" @click="uploadImage">
            <div v-if="!inputUrl" style="cursor:pointer">
              Click
              <u>
                <b>
                  <i>here</i>
                </b>
              </u> to upload
            </div>
            <form id="upload-file" method="post" enctype="multipart/form-data">
              <input
                type="file"
                name="file"
                id="imageUpload"
                style="display:none"
                accept=".png, .jpg, .jpeg, .tif"
                @change="previewImage"
              />
            </form>
            <img class="imgshow original" v-if="inputUrl" :src="inputUrl" alt />
            <v-btn
              fab
              class="closeOriginal"
              style="position:absolute;z-index:1;left:calc(50% - 28px);top:calc(50% - 28px)"
              v-if="inputUrl"
              @click="refresh"
            >
              <v-icon style="line-height:56px;">close</v-icon>
            </v-btn>
          </div>
          <div class="row no-gutters">
            <div class="col-6 pa-1">
              <v-btn block color="secondary" :disabled="!inputUrl" @click="selectParam">Select</v-btn>
            </div>
            <div class="col-6 pa-1">
              <v-btn block color="secondary" :disabled="!inputUrl" @click="diagnoseImage">Diagnose</v-btn>
            </div>
          </div>
        </div>
      </div>
      <div class="slide-wrapper">
        <div class="slide">
          <div class="imgblock" id="testImage">
            <div v-if="!output.image_file">Analysis Result</div>
            <img class="imgshow" v-if="output.image_file" :src="output.image_file" alt />
          </div>
          <div class="row no-gutters">
            <div class="col-6 pa-1">
              <v-btn
                block
                color="secondary"
                :disabled="!output.image_file"
                @click="download(output.image_file)"
              >Download</v-btn>
            </div>
            <div class="col-3 pa-1">
              <v-btn
                block
                color="secondary"
                :disabled="!output.image_file"
                @click="openview('./view1')"
              >View1</v-btn>
            </div>
            <div class="col-3 pa-1">
              <v-btn
                block
                color="secondary"
                :disabled="!output.image_file"
                @click="openview('./view2')"
              >View2</v-btn>
            </div>
          </div>
        </div>
      </div>
    </carousel>
    <select-box :options="options" @returnSelect="getSelect"></select-box>
    <div class="container mt-3">
      <div class="row" v-if="output.image_file">
        <div class="col-md-4">
          <predict-set :predictsets="output.data"></predict-set>
        </div>
        <div class="col-md-4">
          <predict-pie :percentages="output.predicts"></predict-pie>
        </div>
        <div class="col-md-4">
          <img src="@/assets/view2index.png" alt style="max-width:100%;" />
        </div>
      </div>
      <!-- <show-dbset :dbset="output.dbset" id="dbset"></show-dbset> -->
    </div>
  </div>
</template>

<script>
import $ from "jquery";
import carousel from "vue-owl-carousel";
import loadingModal from "@/views/components/loadingModal.vue";
import selectBox from "@/views/components/selectBox.vue";
import predictSet from "@/views/components/predictSet.vue";
import predictPie from "@/views/components/predictPie.vue";
// import showDbset from "@/views/components/showDbset.vue";
export default {
  components: {
    loadingModal,
    carousel,
    selectBox,
    predictSet,
    predictPie
    // showDbset
  },
  data: () => ({
    inputUrl: null,
    options: [],
    parameter: null,
    loading: 0,
    output: {
      data: "",
      image_file: "",
      color: {},
      predicts: {},
      image_circles: []
    },
    modified_cricles: [],
    modified: {
      image_file: ""
    },
    modal: false
    // dbset: null
  }),
  mounted() {
    $(document).on("mouseenter", ".original, .closeOriginal", function() {
      $(".closeOriginal").css("display", "block");
    });
    $(document).on("mouseleave", ".original", function() {
      $(".closeOriginal").css("display", "none");
    });
  },
  methods: {
    openview(url) {
      const link =
        this.$router.resolve({ path: url }).href +
        "?url=" +
        this.output.image_file;
      window.open(link, "_blank");
    },
    refresh() {
      window.location.reload();
    },
    uploadImage() {
      $("#imageUpload").click();
    },
    previewImage(e) {
      const file = e.target.files[0];
      this.inputUrl = URL.createObjectURL(file);
    },
    selectParam() {
      if (!this.inputUrl) return;
      this.swal({
        customClass: "loadingModal",
        allowOutsideClick: false,
        onOpen: () => {
          this.swal.showLoading();
        }
      });
      this.api.get(this.url.selectParam).then(response => {
        this.options = response.data;
      });
      this.swal.close();
    },
    getSelect(value) {
      this.parameter = value;
    },
    diagnoseImage() {
      if (!this.inputUrl) return;
      this.loading = 1;
      var loopID = window.setInterval(
        function() {
          this.api.get(this.url.getProgress).then(response => {
            this.loading = response.data;
          });
        }.bind(this),
        1000
      );
      const formData = new FormData($("#upload-file")[0]);
      formData.append("parameter", this.parameter);
      this.api
        .post(this.url.diagnoseImage, formData, {
          headers: {
            accept: "application/json",
            "Accept-Language": "en-US,en;q=0.8",
            "Content-Type": `multipart/form-data; boundary=${formData._boundary}`
          }
        })
        .then(response => {
          this.output = response.data;
          this.$store.commit("getColor", this.output.color);
          setTimeout(function() {
            window.clearInterval(loopID);
          }, 100);
          this.loading = 0;
        })
        .catch(error => {
          this.swal({
            type: "error",
            title: "好像發生甚麼問題...",
            text: error
          });
          window.clearInterval(loopID);
          this.loading = 0;
        });
    },
    download(url) {
      var pom = document.createElement("a");
      var filename = url.replace(/^.*[\\/]/, "");
      filename = filename.replace(".", "_result.");
      pom.setAttribute("href", url);
      pom.setAttribute("download", filename);
      pom.style.display = "none";
      document.body.appendChild(pom);
      pom.click();
      document.body.removeChild(pom);
    },
    sendConfirm() {
      this.swal({
        title: "Are you sure?",
        text: "We will save all the results and changes into the database!",
        showCancelButton: true,
        cancelButtonText: "Not now",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Do it!",
        cancelButtonColor: "#d33"
      }).then(result => {
        if (result.value) {
          this.swal({
            customClass: "loadingModal",
            allowOutsideClick: false,
            onOpen: () => {
              this.swal.showLoading();
            }
          });
          this.api
            .get(this.url.sendConfirm)
            .then(response => {
              this.swal.close();
              this.dbset = response.data;
              this.modal = true;
              $("html,body").animate(
                {
                  scrollTop: $("#dbset").offset().top
                },
                "slow"
              );
            })
            .catch(error => {
              this.swal.close();
              this.swal({
                type: "error",
                title: "好像發生甚麼問題...",
                text: error
              });
            });
        }
      });
    }
  }
};
</script>
<style >
.loadingModal {
  background: transparent !important;
}
.slide-wrapper {
  padding: 8px 8px 0px 8px;
  display: flex;
  justify-content: center;
}
.imgblock {
  border: 1px solid lightgrey;
  border-radius: 4px;
  box-shadow: 0 0 5px 2px rgba(0, 0, 0, 0.3);
  height: 512px;
  width: 512px;
  display: flex;
  justify-content: center;
  line-height: 512px;
  font-size: 24px;
}
.imgblock:hover {
  transition: all 0.2s;
  box-shadow: 2px 2px 6px 4px rgba(0, 0, 0, 0.3);
}
.imgshow {
  width: 100%;
  height: 100%;
}
.closeOriginal {
  opacity: 0.5;
}
.closeOriginal:hover {
  opacity: 1;
}
@media (max-width: 567px) {
  .slide-wrapper,
  .slide,
  .imgblock {
    width: 100%;
  }
}
</style>
