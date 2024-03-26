<template>
  <b-card style="min-height: 570px">
    <div class="chart-container" v-if="totalClients !== 0">
      <div class="chart">
        <h2>Client's Statistics</h2>
        <br />

        <!-- Display user information -->
        <!-- ... Your existing code ... -->

        <apexchart
          type="bar"
          :options="barChartOptions"
          :series="barChartSeries"
          height="300"
        ></apexchart>
      </div>

      <div class="circle">
        <div class="circle-content">
          <div class="circle-value">{{ totalClients }}</div>
          <div class="circle-label">Total Clients</div>
        </div>
      </div>
    </div>

    <div class="chart-container" v-if="totalPartners !== 0">
      <div class="chart">
        <h2>Partner's Statistics</h2>
        <br />

        <!-- Display partner information -->
        <!-- ... Your partner information code ... -->

        <apexchart
          type="bar"
          :options="barChartOptionsPartners"
          :series="barChartSeriesPartners"
          height="300"
        ></apexchart>
      </div>

      <div class="circle">
        <div class="circle-content">
          <div class="circle-value">{{ totalPartners }}</div>
          <div class="circle-label">Total Partners</div>
        </div>
      </div>
    </div>

    <div class="chart-container" v-if="totalAgents !== 0">
      <div class="chart">
        <h2>Agents's Statistics</h2>
        <br />

        <!-- Display agent information -->
        <!-- ... Your agent information code ... -->

        <apexchart
          type="bar"
          :options="barChartOptionsAgents"
          :series="barChartSeriesAgents"
          height="300"
        ></apexchart>
      </div>

      <div class="circle">
        <div class="circle-content">
          <div class="circle-value">{{ totalAgents }}</div>
          <div class="circle-label">Total Agents</div>
        </div>
      </div>
    </div>

    <div class="export-button-container">
      <b-button variant="primary" @click="exportToPDF">Export Report</b-button>
    </div>
  </b-card>
</template>

<script>

import axios from 'axios';
import VueApexCharts from 'vue-apexcharts';
import html2pdf from 'html2pdf.js';

export default {
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      statistics: {
        transactions: 0,
        clients: 0,
        commercials: 0,
        partners: 0,
        services: 0,
      },
      barChartOptions: {
        // Customize the bar chart options for clients
        xaxis: {
          categories: Array.from({ length: 31 }, (_, i) => i + 1),
          title: {
            text: 'Day',
          },
        },
        yaxis: {
          title: {
            text: 'Number',
          },
          labels: {
            formatter: function (val) {
              return Math.floor(val);
            },
          },
        },
        chart: {
          foreColor: '#339FA1',
          toolbar: {
            show: false,
          },
        },
        colors: ['#339FA1'],
      },
      barChartSeries: [
        {
          name: 'Number of Clients',
          data: [],
        },
      ],
      totalClients: 0,

      barChartOptionsPartners: {
        // Customize the bar chart options for partners
        xaxis: {
          categories: Array.from({ length: 31 }, (_, i) => i + 1),
          title: {
            text: 'Day',
          },
        },
        yaxis: {
          title: {
            text: 'Number',
          },
          labels: {
            formatter: function (val) {
              return Math.floor(val);
            },
          },
        },
        chart: {
          foreColor: '#339FA1',
          toolbar: {
            show: false,
          },
        },
        colors: ['#339FA1'],
      },
      barChartSeriesPartners: [
        {
          name: 'Number of Partners',
          data: [],
        },
      ],
      totalPartners: 0,

      barChartOptionsAgents: {
        // Customize the bar chart options for agents
        xaxis: {
          categories: Array.from({ length: 31 }, (_, i) => i + 1),
          title: {
            text: 'Day',
          },
        },
        yaxis: {
          title: {
            text: 'Number',
          },
          labels: {
            formatter: function (val) {
              return Math.floor(val);
            },
          },
        },
        chart: {
          foreColor: '#339FA1',
          toolbar: {
            show: false,
          },
        },
        colors: ['#339FA1'],
      },
      barChartSeriesAgents: [
        {
          name: 'Number of Agents',
          data: [],
        },
      ],
      totalAgents: 0,
    };
  },
  mounted() {
    this.fetchClientData();
    this.fetchPartnerData();
    this.fetchAgentData();
  },
  methods: {
    async fetchClientData() {
      try {
        const responseClients = await axios.get('/api/clients');
        const clients = responseClients.data;
        const countsClients = Array(31).fill(0);
        let totalClients = 0;

        clients.forEach((client) => {
          const createdDate = new Date(client.created_at);
          const dayOfMonth = createdDate.getDate();
          countsClients[dayOfMonth - 1] += 1;
          totalClients += 1;
        });

        this.barChartSeries[0].data = countsClients;
        this.totalClients = totalClients;
        this.barChartOptions.xaxis.categories = Array.from({ length: 31 }, (_, i) => i + 1);

        // Update the client chart with the new data
        this.barChartOptions = { ...this.barChartOptions };
        this.barChartSeries = [...this.barChartSeries];
      } catch (error) {
        console.log(error);
      }
    },

    async fetchPartnerData() {
      try {
        const responsePartners = await axios.get('/api/partners');
        const partners = responsePartners.data;
        const countsPartners = Array(31).fill(0);
        let totalPartners = 0;

        partners.forEach((partner) => {
          const createdDate = new Date(partner.created_at);
          const dayOfMonth = createdDate.getDate();
          countsPartners[dayOfMonth - 1] += 1;
          totalPartners += 1;
        });

        this.barChartSeriesPartners[0].data = countsPartners;
        this.totalPartners = totalPartners;
        this.barChartOptionsPartners.xaxis.categories = Array.from({ length: 31 }, (_, i) => i + 1);

        // Update the partner chart with the new data
        this.barChartOptionsPartners = { ...this.barChartOptionsPartners };
        this.barChartSeriesPartners = [...this.barChartSeriesPartners];
      } catch (error) {
        console.log(error);
      }
    },

    async fetchAgentData() {
      try {
        const responseAgents = await axios.get('/api/agents');
        const agents = responseAgents.data;
        const countsAgents = Array(31).fill(0);
        let totalAgents = 0;

        agents.forEach((agent) => {
          const createdDate = new Date(agent.created_at);
          const dayOfMonth = createdDate.getDate();
          countsAgents[dayOfMonth - 1] += 1;
          totalAgents += 1;
        });

        this.barChartSeriesAgents[0].data = countsAgents;
        this.totalAgents = totalAgents;
        this.barChartOptionsAgents.xaxis.categories = Array.from({ length: 31 }, (_, i) => i + 1);

        // Update the agent chart with the new data
        this.barChartOptionsAgents = { ...this.barChartOptionsAgents };
        this.barChartSeriesAgents = [...this.barChartSeriesAgents];
      } catch (error) {
        console.log(error);
      }
    },
exportToPDF() {
  const chartContainers = document.querySelectorAll('.chart-container');
  const options = {
    margin: 10,
    filename: 'dashboard_report.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
  };

  const element = document.createElement('div');
  element.classList.add('export-container');

  // Create a clone of each chart container and append it to the export container
  chartContainers.forEach((container) => {
    const cloneContainer = container.cloneNode(true);
    element.appendChild(cloneContainer);
  });

  // Create a clone of each circle and append it to the export container
  const circles = document.querySelectorAll('.circle');
  circles.forEach((circle) => {
    const cloneCircle = circle.cloneNode(true);
    element.appendChild(cloneCircle);
  });

  // Export the PDF using the export container element
  html2pdf().set(options).from(element).save();
},

  },
};
</script>

<style>
.chart-container {
  margin-top: 10px;
  display: flex;
  justify-content: center;
  align-items: flex-start;
}

.chart {
  flex: 1;
}

.circle {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background-color: #339FA1;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.circle-content {
  text-align: center;
}

.circle-value {
  font-size: 36px;
  font-weight: bold;
  color: #ffffff;
}

.circle-label {
  font-size: 14px;
  margin-top: 10px;
  color: #ffffff;
}
</style>
