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

      </v-row>

        <v-simple-table>
            <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">
                        No
                    </th>
                    <th class="text-left">
                        Uraian
                    </th>
                    <th class="text-left">
                        Ubah Tarif
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>O2 / Jam</td>
                    <td>
        <v-dialog
            v-model="dialog"
            persistent
            max-width="800px"
        >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="primary"
                dark
                v-bind="attrs"
                v-on="on"
                small
              >
                <v-icon small>far fa-edit</v-icon>
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h6">Ubah Tarif</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="12"
                    >
                        <v-text-field
                            label="Ank VIP :"
                            placeholder="Anak VIP"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    </v-row>
                    <hr class="mt-n6">
                       <!-- <v-baner>Kelas VIP</v-baner> -->
                        <span class="font-weight-bold mt-n4 mb-2">Tarif Umum</span>
                    <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                        
                    >
                        <v-text-field
                            label="Tarif Sarana"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif Pelayanan"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif BPH"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                  </v-row>

                  <hr class="mt-n6">
                       <!-- <v-baner>Kelas VIP</v-baner> -->
                        <span class="font-weight-bold mt-n4 mb-2">Tarif Kelas I</span>
                    <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                        
                    >
                        <v-text-field
                            label="Tarif Sarana"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif Pelayanan"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif BPH"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                  </v-row>
                  <hr class="mt-n6">
                       <!-- <v-baner>Kelas VIP</v-baner> -->
                        <span class="font-weight-bold mt-n4 mb-2">Tarif Kelas II</span>
                    <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                        
                    >
                        <v-text-field
                            label="Tarif Sarana"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif Pelayanan"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif BPH"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                  </v-row>
                  <hr class="mt-n6">
                       <!-- <v-baner>Kelas VIP</v-baner> -->
                        <span class="font-weight-bold mt-n4 mb-2">Tarif Kelas III</span>
                    <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                        
                    >
                        <v-text-field
                            label="Tarif Sarana"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif Pelayanan"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif BPH"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                  </v-row>
                  <hr class="mt-n6">
                       <!-- <v-baner>Kelas VIP</v-baner> -->
                        <span class="font-weight-bold mt-n4 mb-2">Kelas VIP</span>
                    <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                        
                    >
                        <v-text-field
                            label="Tarif Sarana"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif Pelayanan"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif BPH"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                  </v-row>
                  <hr class="mt-n6">
                       <!-- <v-baner>Kelas VIP</v-baner> -->
                        <span class="font-weight-bold mt-n4 mb-2">Kelas VVIP</span>
                    <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                        
                    >
                        <v-text-field
                            label="Tarif Sarana"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif Pelayanan"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif BPH"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                  </v-row>
                  <hr class="mt-n6">
                       <!-- <v-baner>Kelas VIP</v-baner> -->
                        <span class="font-weight-bold mt-n4 mb-2">Kelas Khusus</span>
                    <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                        
                    >
                        <v-text-field
                            label="Tarif Sarana"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif Pelayanan"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tarif BPH"
                            placeholder="234324"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
                
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