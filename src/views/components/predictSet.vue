<template>
  <v-card>
    <v-card-title class="subheading font-weight-bold">Result:</v-card-title>
    <v-divider></v-divider>
    <v-list >
      <v-list-tile>
        <v-list-tile-content>Cancer:</v-list-tile-content>
        <v-list-tile-content class="align-end">
          {{predictsets.Cancer.split('|')[0]}}/{{predictsets.Total}} = {{predictsets.Cancer.split('|')[1]}}%
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile>
        <v-list-tile-content>Adenoma:</v-list-tile-content>
        <v-list-tile-content class="align-end">
          {{predictsets.Adenoma.split('|')[0]}}/{{predictsets.Total}} = {{predictsets.Adenoma.split('|')[1]}}%
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile>
        <v-list-tile-content>Hyperplastic:</v-list-tile-content>
        <v-list-tile-content class="align-end">
          {{predictsets.Hyperplastic.split('|')[0]}}/{{predictsets.Total}} = {{predictsets.Hyperplastic.split('|')[1]}}%
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile>
        <v-list-tile-content>Normal:</v-list-tile-content>
        <v-list-tile-content class="align-end">
          {{predictsets.Normal.split('|')[0]}}/{{predictsets.Total}} = {{predictsets.Normal.split('|')[1]}}%
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile>
        <v-list-tile-content>Unknown:</v-list-tile-content>
        <v-list-tile-content class="align-end">
          {{predictsets.Unknown.split('|')[0]}}/{{predictsets.Total}} = {{predictsets.Unknown.split('|')[1]}}%
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-card>
</template>
<script>
export default {
  props:['predictsets']
}
</script>

