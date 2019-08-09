<script>
import { Pie } from "vue-chartjs";
export default {
  extends: Pie,
  props: ["percentages"],
  mounted() {
    this.renderChart(
      {
        labels: ["Cancer", "Adenoma", "Hyperplastic", "Normal", "Unknown"],
        datasets: [
          {
            label: ["Cancer", "Adenoma", "Hyperplastic", "Normal", "Unknown"],
            backgroundColor: [
              "black",
              "#EC1C24",
              "#FFF200",
              "#0ED145",
              "#C3C3C3"
            ],
            data: this.percentages
          }
        ]
      },
      {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          labels: {
            // render 'label', 'value', 'percentage', 'image' or custom function, default is 'percentage'
            render: "percentage",
            // precision for percentage, default is 0
            precision: 0,
            // identifies whether or not labels of value 0 are displayed, default is false
            showZero: true,
            // font size, default is defaultFontSize
            fontSize: 16,
            // font color, can be color array for each data or function for dynamic color, default is defaultFontColor
            fontColor: "#fff",
            // font style, default is defaultFontStyle
            fontStyle: "normal",
            // font family, default is defaultFontFamily
            fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
            // draw text shadows under labels, default is false
            textShadow: true,
            // text shadow intensity, default is 6
            shadowBlur: 10,
            // text shadow X offset, default is 3
            shadowOffsetX: 3,
            // text shadow Y offset, default is 3
            shadowOffsetY: 3,
            // text shadow color, default is 'rgba(0,0,0,0.3)'
            shadowColor: "rgba(255,0,0,0.75)",
            // draw label in arc, default is false
            // bar chart ignores this
            arc: false,
            // position to draw label, available value is 'default', 'border' and 'outside'
            // bar chart ignores this
            position: "default",
            // draw label even it's overlap, default is true
            // bar chart ignores this
            overlap: true,
            // show the real calculated percentages from the values and don't apply the additional logic to fit the percentages to 100 in total, default is false
            showActualPercentages: true,
            // set images when `render` is 'image'
            images: [
              {
                src: "image.png",
                width: 16,
                height: 16
              }
            ],
            // add padding when position is `outside`
            // default is 2
            outsidePadding: 4,
            // add margin of text when position is `outside` or `border`
            // default is 2
            textMargin: 2
          }
        }
      }
    );
  }
};
</script>
