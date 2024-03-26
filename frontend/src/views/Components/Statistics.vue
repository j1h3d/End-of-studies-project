<template>
  <b-card v-if="data" no-body class="card-statistics">
    <b-card-header>
      <b-card-title>Dashboard</b-card-title>
      <div class="switch-button float-sm-right">
        <b-form-group>
          <b-form-radio-group id="btn-radios-1" v-model="selected" button-variant="outline-primary" :options="radioOption"
            buttons size="sm" name="radios-btn-default" />
        </b-form-group>
      </div>
    </b-card-header>




    <b-card-body class="statistics-body">

      <b-row>
        <b-col v-for="item in items" :key="item.icon" xl="3" sm="6" :class="item.customClass">
          <b-media no-body>
            <b-media-aside class="mr-2">
              <b-avatar size="48" :variant="item.color">
                <feather-icon size="24" :icon="item.icon" />
              </b-avatar>
            </b-media-aside>
          </b-media>
        </b-col>
      </b-row>
    </b-card-body>
  </b-card>
</template>

<script>
import axios from 'axios';
import {
  BCard, BCardHeader, BCardTitle, BCardText, BCardBody, BRow, BCol, BMedia, BMediaAside, BAvatar, BMediaBody, BFormRadioGroup,
  BFormGroup,
} from 'bootstrap-vue'

export default {
  computed: {
    items() {
      return this.$store.state.statistics.statisticsItems;
    }

  },
  mounted() {
    this.$store.dispatch('getAllDemandes');
    this.$store.dispatch('getNumberClients');
    this.$store.dispatch('getChiffre');
    this.$store.dispatch('getAllServices');

  },
  components: {
    BRow,
    BCol,
    BCard,
    BCardHeader,
    BCardTitle,
    BCardText,
    BCardBody,
    BMedia,
    BAvatar,
    BMediaAside,
    BMediaBody,
    BFormRadioGroup,
    BFormGroup,
  },
  props: {
    data: {
      type: Array,
      default: () => [],

    },
  },
  data() {
    return {
      selected: 'radio1',
      radioOption: [
        { text: 'Daily', value: 'radio1' },
        { text: 'Monthly', value: 'radio2' },
        { text: 'Yearly', value: 'radio4' },
      ],
    }
  }
}
</script>
