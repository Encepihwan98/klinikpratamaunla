<template>
   
            <div class="app-content-container boxed-container pa-6">
            <v-container>
            <v-row>
                <v-col
                    class="d-flex"
                    cols="12"
                    sm="2"
                >
                <v-select 
                :items="items"
                label="Tampilkan"
                dense
                outlined
                ></v-select>
                </v-col>

                <v-col
                class="d-flex"
                cols="12"
                sm="8"
                >
                <v-text-field
                    outlined
                    label="Search"
                    append-icon="mdi-magnify"
                    small
                    dense
                ></v-text-field>
                </v-col>
            </v-row>
            </v-container>
                <v-simple-table>
                    <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left">
                                No
                            </th>
                            <th class="text-left">
                                Jenis
                            </th>
                            <th class="text-left">
                                Logistik
                            </th>
                            <th class="text-left">
                                Apotek
                            </th>
                            <th class="text-left">
                                Jumlah
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Alat Kesehatan (Alkes)</td>
                            <td>ABO Test Golongan Darah (Nongenerik)</td>
                            <td>Kitt/8</td>
                            <td>9000</td>
                        </tr>
                        <!-- <tr
                        v-for="item in desserts"
                        :key="item.name"
                        >
                        <td>{{ item.name }}</td>
                        <td>{{ item.calories }}</td>
                        </tr> -->
                    </tbody>
                    </template>
                </v-simple-table>
                
            </div>
</template>

<script>
  import { ref } from "@vue/composition-api";
  import {
  mdiMagnify,
  mdiBellOutline,
  mdiGithub
} from "@mdi/js";

export default {
  setup() {
    const isDrawerOpen = ref(null);

    return {
      isDrawerOpen,

      // Icons
      icons: {
        mdiMagnify,
        mdiBellOutline,
        mdiGithub
      },
    };
  },

   data: vm => ({
      dialog: false,
      items: ['5', '10', '15', '20','25','30','50'],
      picker: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      dateFormatted: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
      menu1: false,
      menu2: false,
    }),

    computed: {
      computedDateFormatted () {
        return this.formatDate(this.date)
      },
    },

    watch: {
      date (val) {
        this.dateFormatted = this.formatDate(this.date)
      },
    },

    methods: {
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${month}/${day}/${year}`
      },
      parseDate (date) {
        if (!date) return null

        const [month, day, year] = date.split('/')
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      },
    },
};

</script>



<style lang="scss" scoped>
@import './resources/js/plugins/vuetify/default-preset/preset/variables.scss';

.v-app-bar ::v-deep {
  .v-toolbar__content {
    padding: 0;

    .app-bar-search {
      .v-input__slot {
        padding-left: 18px;
      }
    }
  }
}

.boxed-container {
  max-width: 1440px;
  margin-left: auto;
  margin-right: auto;
}

.user-profile-menu-content {
  .v-list-item {
    min-height: 2.5rem !important;
  }
}
</style>
