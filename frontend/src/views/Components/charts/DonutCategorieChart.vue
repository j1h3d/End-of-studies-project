<template>
  <b-card>
    <b-card-title class="mb-1">
      Catégories
    </b-card-title>
    <b-card-sub-title class="mb-2">
      Revenu sur plusieurs categories de service
    </b-card-sub-title>

    <vue-apex-charts
      type="donut"
      height="350"
      :options="items.chartOptions"
      :series="items.series"
    />
    {{this.$store.state.piechart.donutChart.chartOptions.labels}}
  </b-card>
</template>

<script>
import {
  BCard, BCardTitle, BCardSubTitle,
} from 'bootstrap-vue'
import VueApexCharts from 'vue-apexcharts'


export default {
  components: {
    VueApexCharts,
    BCard,
    BCardTitle,
    BCardSubTitle,
  },
   computed : {
        items(){
            return this.$store.state.piechart.donutChart;
        }
        
    },
    mounted(){
      
      // this.$store.dispatch('getAllCategories');
      // this.$store.dispatch('getCountInterventions');
      
      
    },
    beforeCreate(){
      // if (this.$store.state.donutChart.chartOptions.labels) {
        
      // }
            //this.$store.dispatch('getAllPourcentages');

    }
}
</script>