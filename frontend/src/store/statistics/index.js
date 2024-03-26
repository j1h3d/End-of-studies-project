import axios from "axios"

export default({
    state :{
      
        statisticsItems: [
    {
      icon: 'TrendingUpIcon',
      color: 'light-primary',
      title: '230k',
      subtitle: 'Demandes',
      customClass: 'mb-2 mb-xl-0',
    },
    {
      icon: 'UserIcon',
      color: 'light-info',
      title: '8.549k',
      subtitle: 'Clients',
      customClass: 'mb-2 mb-xl-0',
    },
    {
      icon: 'BoxIcon',
      color: 'light-danger',
      title: '1.423k',
      subtitle: 'Services',
      customClass: 'mb-2 mb-sm-0',
    },
    {
      icon: 'DollarSignIcon',
      color: 'light-success',
      title: '$9745',
      subtitle: "Chiffre d'affaire",
      customClass: '',
    },
],
revenue: {
  years: ['2020', '2019', '2018'],
  price: '25,852',
  budget: '56,800',
  revenueReport: {
    series: [
      {
        name: 'Earning',
        data: [95, 177, 284, 256, 105, 63, 168, 218, 72],
      },
      {
        name: 'Expense',
        data: [-145, -80, -60, -180, -100, -60, -85, -75, -100],
      },
    ],
  },
  budgetChart: {
    series: [
      {
        data: [61, 48, 69, 52, 60, 40, 79, 60, 59, 43, 62],
      },
      {
        data: [20, 10, 30, 15, 23, 0, 25, 15, 20, 5, 27],
      },
    ],
  },
},
},
actions:{
  getAllDemandes({commit}){
    
    axios.get('/api/CountDemands').then(response=>{
      console.log(response.data);
      commit("getDemandes",response.data);
      })
  },
  getNumberClients({commit}){ 
    console.log("hello from action statistics");   
    axios.get('/api/nbclients').then(response=>{
      console.log(response.data);
      commit("getClients",response.data);
      })
  },
  getChiffre({commit}){
    axios.get('/api/ca').then(response =>{
      commit('getCa',response.data);
    })
  },
  getAllServices({commit}){
    axios.get('/api/countservices').then(response=>{
      commit("getServices", response.data)
    })
  }
},
mutations:{
  getDemandes:(state,data) =>
{  
  state.statisticsItems[0].title=data;},

  getClients:(state,data) => 
  {
    state.statisticsItems[1].title= data;
  },
  getCa(state,data){
    state.statisticsItems[3].title = data+'DT'
  },
  getServices(state,data){
    state.statisticsItems[2].title = data
  }
},




})
