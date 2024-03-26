<template>
  <b-card title="Interventions">
    <div class="d-flex justify-content-between flex-wrap">
      <div class="mb-1 mb-sm-0">
        <span class="text-muted">Nombre d'intervention effectuées</span>
      </div>
      <div class="d-flex align-content-center mb-1 mb-sm-0">
        <h1 class="font-weight-bolder ">
          $ 183,382
        </h1>
        
      </div>
    </div>

    <!-- echart -->
    <app-echart-line :option-data="option" />

  </b-card>
</template>

<script>
import { BCard, BBadge } from 'bootstrap-vue'
import AppEchartLine from '@core/components/charts/echart/AppEchartLine.vue'
import axios from 'axios'

export default {
  components: {
    BCard,
    AppEchartLine,
    BBadge,
  },
  data() {
    return {
      option: {
        xAxisData: [],
        series: [],
      },
    }
  },
  mounted(){
    axios.get('api/interventionsperday').then((response)=>{
      response.data.forEach(item => {                
        this.option.xAxisData.push(item.date);
        this.option.series.push(item.count);  
                        
      });
      
    });
    console.log(this.option.xAxisData, this.option.series);    
  }


}

</script>
