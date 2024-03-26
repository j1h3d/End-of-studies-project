<template>

    <div >


        <b-row height="100px" class="">

        <b-col
        xl="8"
        md="6"
      >
      <ecommerce-statistics  />
      <revenue-report  :data="data.revenue" />
      </b-col>
      <b-col
        xl="4"
        md="6"
      >
      <intervention-chart />
      </b-col>

      </b-row>
      <b-row class="match-height">
        <b-col
        xl="4"
        md="6"
      >
        <donut />
        </b-col>
        <b-col
        xl="8"
        md="6"
      >
      <apex-line-area />
      </b-col>

        </b-row>
    </div>



</template>

<script>
import { BRow, BCol,  BCard, BCardText, BLink,BButton, BFormRadioGroup, BFormGroup } from 'bootstrap-vue'
import EcommerceStatistics from './Components/Statistics.vue'
import donutCategorie from './Components/charts/DonutCategorieChart.vue'
import ApexLineArea from './Components/charts/ApexlineAeaRevenue.vue'
import RevenueReport from './Components/charts/RevenueReport.vue'
import InterventionChart from './Components/charts/InterventionLineChart.vue'
import donut from './Components/charts/donut.vue'

export default {
  components: {
    BButton,
    BCard,
    BCardText,
    BLink,
    BRow,
    BCol,
    BFormRadioGroup,
    BFormGroup,
    EcommerceStatistics,
    donutCategorie,
    ApexLineArea,
    RevenueReport,
    InterventionChart,
    donut

  },
  data() {
    return {
      data: {}
    }
  },
  beforeCreate(){
      console.log('before create')
  },
  created() {
    // data
     this.$http.get('/ecommerce/data')
      .then(response => {
        this.data = response.data

      })
  },


}
</script>

<style lang="scss" >
@import '@core/scss/vue/libs/vue-flatpicker.scss';
@import '@core/scss/vue/libs/chart-apex.scss';
</style>
