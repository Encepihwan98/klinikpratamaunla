<template>
    <div class="app-content-container boxed-container pa-6">
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
          chips
          small-chips
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

        <v-col
          class="d-flex"
          cols="12"
          sm="2"
        >
          <v-dialog
            v-model="dialog"
            persistent
            max-width="500px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="primary"
                dark
                v-bind="attrs"
                v-on="on"
              >
                Tambah Data
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">Rujuk Ke Fasilitas Penunjang</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                   <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="12"
                    >
                      <v-select
                        :items="['salesma', 'cacingeun', '30-54', '54+']"
                        label="Jenis"
                        dense
                      ></v-select>
                    </v-col>
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="12"
                    >
                      <v-select
                        :items="['salesma', 'cacingeun', '30-54', '54+']"
                        label="Fasilitas Tujuan"
                        dense
                      ></v-select>
                    </v-col>
                    <v-col
                      cols="12"
                      lg="12"
                    >
                      <v-menu
                        ref="menu1"
                        v-model="menu1"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="dateFormatted"
                            label="Waktu Rujukan"
                            persistent-hint
                            prepend-icon="mdi-calendar"
                            v-bind="attrs"
                            @blur="date = parseDate(dateFormatted)"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="date"
                          no-title
                          @input="menu1 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>
                  </v-row>
                </v-container>
                <small>*indicates required field</small>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="dialog = false"
                >
                  Close
                </v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="dialog = false"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
      </v-row>

        <v-simple-table>
            <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">
                        No
                    </th>
                    <th class="text-left">
                        Waktu
                    </th>
                    <th class="text-left">
                        Fasilitas
                    </th>
                    <th class="text-left">
                        Catatan
                    </th>
                    <th class="text-left">
                        Lihat
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>08786</td>
                    <td>Maman</td>
                    <td>Dahlian</td>
                    <td>
                      <v-btn icon :to="{name:'rawat-jalan-detail'}">
                        <v-icon>far fa-search-plus</v-icon>
                      </v-btn>
                    </td>
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
  export default {

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

    
  }
</script>