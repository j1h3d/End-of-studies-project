import axios from "axios"
import { forEach } from "postcss-rtl/lib/affected-props";

export default ({
    state : {
        series: 
            {
              name: 'Visit source',
              type: 'pie',
              radius: ['50%', '70%'],
              avoidLabelOverlap: false,
              label: {
                show: false,
              },
              labelLine: {
                show: false,
              },
              data: [],
            },
          
    },
    actions:{
        getAllPourcentages({commit}){  
          const results = [];
         
            axios.get('/api/piechart').then(response=>{
               let table = response.data
               table.forEach(item => {
                results.push({
                   value: item.value,
                   name: item.name
                });
                                            
              });
              //  let obj = Object.assign({}, results);

              commit("getPourcentage",results); 
              });               
              console.log(results);                           
          },          

    } ,
    mutations: {
        getPourcentage(state,data){          
            state.series.data = data;            
          },
         
    }

})