<template>
  <b-card title="Doughnut Chart">
    <div class="pie-text text-center">
      <h2 class="font-weight-bolder">
        $23,994
      </h2>
      <span class="font-weight-bold">Total</span>
    </div>

    <!-- echart -->
    <app-echart-doughnut :series="items.series" />

  </b-card>
</template>
<script>
import { BCard } from 'bootstrap-vue'
import AppEchartDoughnut from '@core/components/charts/echart/AppEchartDoughnut.vue'

export default {
  components: {
    BCard,
    AppEchartDoughnut,
  },
  computed: {
      items(){
          return this.$store.state.donut;
      }
  },
  beforeCreate(){     
            this.$store.dispatch('getAllPourcentages');

    },
  mount(){
      axios.get('api/countinterventions').then((response)=>{
      console.log(response.data);                            
      });
   }
}
</script>

<style lang="scss">
.card-body{
  position: relative;
  .pie-text{
    width: 105px;
    position:absolute;
    margin: auto;
    left: 0;
    right: 0;
    top: 44%;
    bottom: 0;
  }
  }
</style>