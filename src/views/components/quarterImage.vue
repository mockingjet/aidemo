<template>
  <div class="v-cabinet my-5">
    <div class="origin">
      <img :src="inputImage" alt />
      <div class="focus"></div>
      <v-btn
        fab
        class="closeOriginal"
        style="position:absolute;z-index:1;left:calc(50% - 28px);top:calc(50% - 28px);display:none"
        @click="refresh"
      >
        <v-icon style="line-height:56px;">close</v-icon>
      </v-btn>
    </div>
    <div class="whole">
      <img class="theImage" :src="nowImage" width="512px" height="512px" />
      <img class="trueImage" :src="nowImage" style="display:none" />
      <div class="quarter" @click="quarter(1)"></div>
      <div class="quarter" @click="quarter(2)"></div>
      <div class="quarter" @click="quarter(3)"></div>
      <div class="quarter" @click="quarter(4)"></div>
      <img
        @click="traceback"
        style="position:absolute; right:-120px; width: 90px; height:90px; top:216px;"
        v-show="former[former.length-2]"
        :src="former[former.length-2] ? former[former.length-2] : former[former.length-1]"
      />
      <v-icon
        x-large
        @click="traceback"
        v-show="former[former.length-2]"
        style="position:absolute; right:-95px; top:240px"
      >restore</v-icon>
      <v-btn
        block
        color="secondary"
        style="margin:15px 5px 15px 5px; width:140px; color:white;position:absolute; bottom:-60px; "
        :disabled="record.length < 5 && !(record.length==0 && former.length==2)"
        @click="openSelector = !openSelector"
      >Modify</v-btn>
      <select-color
        :show="openSelector"
        style="position:absolute; bottom:-30px;left:123px"
        @returnColor="modifyImage"
      ></select-color>
      <v-btn
        block
        color="secondary"
        style="margin:15px 5px 15px 5px; width:140px; color:white;position:absolute; bottom:-60px;left:150px"
        @click="download($event,downloadImage)"
      >downlaod</v-btn>
      <v-btn
        x-large
        block
        color="secondary"
        style="margin:15px 5px 15px 5px; width:205px; color:white;position:absolute; bottom:-60px;left:300px"
        :disabled="record.length < 5 && !(record.length==0 && former.length==2)"
        @click="diagnoseByGland()"
      >Diagnose By GLand</v-btn>
    </div>
  </div>
</template>
<script>
import $ from "jquery";
import selectColor from "@/views/components/selectColor.vue";
export default {
  props: ["inputImage"],
  components: {
    selectColor
  },
  data: () => ({
    nowImage: null,
    former: [],
    record: [],
    openSelector: false,
    modified_type: "",
    downloadImage: ""
  }),
  mounted() {
    $(document).on("mouseenter", ".origin, .closeOriginal", function() {
      $(".closeOriginal").css("display", "block");
    });
    $(document).on("mouseleave", ".origin", function() {
      $(".closeOriginal").css("display", "none");
    });
    this.nowImage = this.inputImage;
    this.downloadImage = this.inputImage;
    this.former.push(this.inputImage);
    this.judgeColor();
  },
  methods: {
    quarter(coord) {
      this.swal({
        customClass: "loadingModal",
        allowOutsideClick: false,
        onOpen: () => {
          this.swal.showLoading();
        }
      });
      setTimeout(
        function() {
          this.proceed(coord);
        }.bind(this),
        100
      );
    },
    proceed(coord) {
      var img = document.querySelector(".trueImage"),
        c = document.createElement("canvas"),
        ctx = c.getContext("2d");
      c.width = img.naturalWidth / 2;
      c.height = img.naturalHeight / 2;
      if (c.width < 512 || c.height < 512) {
        this.swal.close();
        return;
      }
      switch (coord) {
        case 1:
          ctx.drawImage(
            img,
            0,
            0,
            img.naturalWidth / 2,
            img.naturalHeight / 2,
            0,
            0,
            img.naturalWidth / 2,
            img.naturalHeight / 2
          );
          break;
        case 2:
          ctx.drawImage(
            img,
            img.naturalWidth / 2,
            0,
            img.naturalWidth / 2,
            img.naturalHeight / 2,
            0,
            0,
            img.naturalWidth / 2,
            img.naturalHeight / 2
          );
          break;
        case 3:
          ctx.drawImage(
            img,
            0,
            img.naturalHeight / 2,
            img.naturalWidth / 2,
            img.naturalHeight,
            0,
            0,
            img.naturalWidth / 2,
            img.naturalHeight
          );
          break;
        case 4:
          ctx.drawImage(
            img,
            img.naturalWidth / 2,
            img.naturalHeight / 2,
            img.naturalWidth,
            img.naturalHeight,
            0,
            0,
            img.naturalWidth,
            img.naturalHeight
          );
          break;
      }
      var newImage = c.toDataURL();
      this.nowImage = newImage;
      this.former.push(newImage);
      if (this.record.length == 5) this.record = [];
      this.record.push(coord);
      this.focusOn(coord);
      this.judgeColor();
      this.swal.close();
    },
    focusOn(coord) {
      var focus = document.querySelector(".focus");
      focus.style.width = focus.offsetWidth / 2 + "px";
      focus.style.height = focus.offsetHeight / 2 + "px";
      switch (coord) {
        case 1:
          //原封不動
          break;
        case 2:
          //向右移動一個width
          focus.style.left = focus.offsetLeft + focus.offsetWidth + "px";
          break;
        case 3:
          //向下移動一個width
          focus.style.top = focus.offsetTop + focus.offsetHeight + "px";
          break;
        case 4:
          //向右跟下各移動一個width
          focus.style.left = focus.offsetLeft + focus.offsetWidth + "px";
          focus.style.top = focus.offsetTop + focus.offsetHeight + "px";
          break;
      }
    },
    traceback() {
      if (this.former.length == 1) return;
      else {
        this.nowImage = this.former[this.former.length - 2];
        this.former.pop();
        var coord = this.record.pop();
        this.judgeColor();
        if (this.record.length == 4 && this.former.length == 1) {
          var focus = document.querySelector(".focus");
          focus.style.width = 512 + "px";
          focus.style.height = 512 + "px";
          focus.style.top = 0 + "px";
          focus.style.left = 0 + "px";
          this.record = [];
        } else {
          this.focusOff(coord);
        }
      }
    },
    focusOff(coord) {
      var focus = document.querySelector(".focus");
      focus.style.width = focus.offsetWidth * 2 + "px";
      focus.style.height = focus.offsetHeight * 2 + "px";
      switch (coord) {
        case 1:
          //原封不動
          break;
        case 2:
          //向左移動半個width
          focus.style.left = focus.offsetLeft - focus.offsetWidth / 2 + "px";
          break;
        case 3:
          //向上移動半個width
          focus.style.top = focus.offsetTop - focus.offsetHeight / 2 + "px";
          break;
        case 4:
          //向左跟上各移動半個width
          focus.style.left = focus.offsetLeft - focus.offsetWidth / 2 + "px";
          focus.style.top = focus.offsetTop - focus.offsetHeight / 2 + "px";
          break;
      }
    },
    findSpot(isSendingAPI) {
      let coord = Number,
        record = Array.from(this.record),
        left = 1,
        right = 32,
        top = 1,
        bottom = 32;
      while (record[0]) {
        coord = record.shift();
        switch (coord) {
          case 1:
            right -= Math.ceil((right - left) / 2);
            bottom -= Math.ceil((bottom - top) / 2);
            break;
          case 2:
            left += Math.ceil((right - left) / 2);
            bottom -= Math.ceil((bottom - top) / 2);
            break;
          case 3:
            top += Math.ceil((bottom - top) / 2);
            right -= Math.ceil((right - left) / 2);
            break;
          case 4:
            left += Math.ceil((right - left) / 2);
            top += Math.ceil((bottom - top) / 2);
            break;
        }
      }
      if (isSendingAPI) return [top, bottom, left, right];
      else return { top, bottom, left, right };
    },
    judgeColor() {
      var { top, bottom, left, right } = this.findSpot(false);
      //先切成4塊
      let quarter1 = {
          top: top,
          bottom: bottom - Math.ceil((bottom - top) / 2),
          left: left,
          right: right - Math.ceil((right - left) / 2)
        },
        quarter2 = {
          top: top,
          bottom: bottom - Math.ceil((bottom - top) / 2),
          left: left + Math.ceil((right - left) / 2),
          right: right
        },
        quarter3 = {
          top: top + Math.ceil((bottom - top) / 2),
          bottom: bottom,
          left: left,
          right: right - Math.ceil((right - left) / 2)
        },
        quarter4 = {
          top: top + Math.ceil((bottom - top) / 2),
          bottom: bottom,
          left: left + Math.ceil((right - left) / 2),
          right: right
        };
      //判斷改變顏色
      this.findoutColor(quarter1, quarter2, quarter3, quarter4);
    },
    findoutColor(q1, q2, q3, q4) {
      const colors = this.$store.state.color;
      let q1_colors = [],
        q2_colors = [],
        q3_colors = [],
        q4_colors = [];
      //判斷顏色權重，從上到下，由左至右
      for (let i = q1.top; i <= q1.bottom; i++) {
        for (let j = q1.left; j <= q1.right; j++) {
          if (!q2_colors.includes(colors[i + "_" + j]))
            q1_colors.push(colors[i + "_" + j]);
        }
      }
      for (let i = q2.top; i <= q2.bottom; i++) {
        for (let j = q2.left; j <= q2.right; j++) {
          if (!q2_colors.includes(colors[i + "_" + j]))
            q2_colors.push(colors[i + "_" + j]);
        }
      }
      for (let i = q3.top; i <= q3.bottom; i++) {
        for (let j = q3.left; j <= q3.right; j++) {
          if (!q3_colors.includes(colors[i + "_" + j]))
            q3_colors.push(colors[i + "_" + j]);
        }
      }
      for (let i = q4.top; i <= q4.bottom; i++) {
        for (let j = q4.left; j <= q4.right; j++) {
          if (!q4_colors.includes(colors[i + "_" + j]))
            q4_colors.push(colors[i + "_" + j]);
        }
      }
      let q1_color = this.finalColor(q1_colors);
      let q2_color = this.finalColor(q2_colors);
      let q3_color = this.finalColor(q3_colors);
      let q4_color = this.finalColor(q4_colors);

      this.changeColor(q1_color, q2_color, q3_color, q4_color);
    },
    finalColor(q_colors) {
      let borderColor;
      if (q_colors.includes("black")) {
        borderColor = "black";
      } else if (q_colors.includes("red")) {
        borderColor = "#EC1C24";
      } else if (q_colors.includes("yellow")) {
        borderColor = "#FFF200";
      } else if (q_colors.includes("green")) {
        borderColor = "#0ED145";
      } else if (q_colors.includes("grey")) {
        borderColor = "#C3C3C3";
      } else {
        borderColor = "blue";
      }
      return borderColor;
    },
    changeColor(q1, q2, q3, q4) {
      // console.log(q1, q2, q3, q4);
      var quarters = document.getElementsByClassName("quarter");
      quarters[0].style.borderColor = q1;
      quarters[1].style.borderColor = q2;
      quarters[2].style.borderColor = q3;
      quarters[3].style.borderColor = q4;
    },
    modifyImage(type) {
      if (type === "x") {
        this.openSelector = false;
        return;
      }
      const [top, bottom, left, right] = this.findSpot(true);
      if (bottom == top && left == right) {
        let coord = top + "_" + right;
        let isOnlyView2 = this.$route.query.url ? false : true;
        this.swal({
          customClass: "loadingModal",
          allowOutsideClick: false,
          onOpen: () => {
            this.swal.showLoading();
          }
        });
        this.api
          .get(
            this.url.modifyImage +
              "?coord=" +
              coord +
              "?type=" +
              type +
              "?isOnlyView2=" +
              isOnlyView2
          )
          .then(response => {
            this.swal.close();
            this.$emit("returnOutput", response.data);
            this.$store.commit("getColor", response.data.color);
            this.downloadImage = response.data.image_file;
            this.former = [response.data.image_file, response.data.image_file];
            this.nowImage = response.data.thumb_file;
            this.judgeColor();
          });
        this.openSelector = false;
      } else {
        this.swal({
          type: "error",
          title: "抓取圖片位置錯誤"
        });
      }
    },
    diagnoseByGland() {
      const [top, bottom, left, right] = this.findSpot(true);
      if (bottom == top && left == right) {
        let coord = top + "_" + right;
        let isOnlyView2 = this.$route.query.url ? false : true;
        this.swal({
          customClass: "loadingModal",
          allowOutsideClick: false,
          onOpen: () => {
            this.swal.showLoading();
          }
        });
        this.api
          .get(
            this.url.diagnoseByGland +
              "?coord=" +
              coord +
              "?isOnlyView2=" +
              isOnlyView2
          )
          .then(response => {
            this.swal.close();
            window.open(response.data.url);
          });
      } else {
        this.swal({
          type: "error",
          title: "抓取圖片位置錯誤"
        });
      }
    },
    refresh() {
      window.location.reload();
    },
    download(e, url) {
      if (!url) return;
      var pom = document.createElement("a");
      var filename = Math.round(new Date().getTime() / 1000);
      pom.setAttribute("href", url);
      pom.setAttribute("download", filename);
      pom.style.display = "none";
      document.body.appendChild(pom);
      pom.click();
      document.body.removeChild(pom);
    }
  },
  watch: {
    record() {
      var quarters = document.getElementsByClassName("quarter");
      if (this.record.length >= 5) {
        for (let i = 0; i < quarters.length; i++) {
          quarters[i].hidden = true;
        }
      } else {
        for (let i = 0; i < quarters.length; i++) {
          quarters[i].hidden = false;
        }
      }
    },
    "$store.state.color": "judgeColor"
  }
};
</script>
<style>
.v-cabinet {
  width: 1024px + 90px;
  display: flex;
  flex-direction: row;
  margin-left: calc(50vw - 768px - 45px);
}
.whole {
  width: 512px;
  height: 512px;
  background-position: center;
  background-size: contain;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  position: relative;
  margin-left: 90px;
}
.theImage {
  position: absolute;
  z-index: 1;
}
.quarter {
  z-index: 2;
  border: 2px solid blue;
  width: 256px;
  height: 256px;
}
.quarter:hover {
  border: 10px solid darkblue;
}
.origin {
  width: 512px;
  height: 512px;
  position: relative;
}
.origin img {
  height: 512px;
  width: 512px;
  box-shadow: 1px 2px 3px 1px rgb(0, 0, 0, 0.5);
}
.focus {
  position: absolute;
  top: 0px;
  width: 512px;
  height: 512px;
  border: 3px dashed orangered;
}
.btn-restore {
  position: absolute;
  z-index: 999;
  right: 240px;
  top: 240px;
}
.closeOriginal {
  transition: all, 0s;
  opacity: 0.5;
}
.closeOriginal:hover {
  transition: all, 0s;
  opacity: 1;
}
</style>
