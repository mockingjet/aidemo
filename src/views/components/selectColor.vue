<template>
    <div class="options" v-show="show">
      <div class="option" v-for="(option, index) in options" :key="index">
        <v-list-tile-title
          small
          style="text-align:center"
          @click="change($event,option.color)"
        >{{ option.text }}</v-list-tile-title>
      </div>
    </div>
</template>
<script>
export default {
  props:["show"],
  data: () => ({
    color: "white",
    options: [
      { text: "x", color: "white" },
      { text: "Cancer", color: "black" },
      { text: "Adenoma", color: "#FB000A" },
      { text: "Hyperplastic", color: "#FFF200" },
      { text: "Normal", color: "#26E32C" },
      { text: "Unknown", color: "lightgrey" }
    ]
  }),
  methods: {
    change(e, color) {
      if (color) {
        this.color = color;
        var type = "";
        for (var i = 0; i < 6; i++) {
          if (this.options[i].color == color) type = this.options[i].text;
        }
        this.$emit("returnColor", type);
      }
    }
  }
};
</script>
<style>
.options {
  background: white;
  border-radius: 2px;
  box-shadow: 1px 1px 10px black;
  z-index:9;
}
.option {
  padding: 3px 8px;
  font-size: 14px;
  position: relative;
}
.option:hover {
  background-color: rgba(0, 0, 0, 0.1);
  transition: all 0.2s;
}
</style>
