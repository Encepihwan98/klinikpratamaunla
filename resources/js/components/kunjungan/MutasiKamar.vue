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
        
        </v-col>
      </v-row>
    
    <!-- tabel -->
        <v-simple-table>
            <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">
                        No
                    </th>
                    <th class="text-left">
                        Kamar
                    </th>
                    <th class="text-left">
                        Masuk
                    </th>
                     <th class="text-left">
                        Keluar
                    </th>
                    <th class="text-left">
                        Tarif Sarana
                    </th>
                    <th class="text-left">
                        Tarif Pelayanan
                    </th>
                    <th class="text-left">
                        Tarif BHP
                    </th>
                    <th class="text-left">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>08786</td>
                    <td>Maman</td>
                    <td>Maman</td>
                    <td>Dahlian</td>
                    <td>Dahlian</td>
                    <td>Dahlian</td>
                    <td>
                      <v-btn icon :to="{name:'rawat-jalan-detail'}">
                        <v-icon small>far fa-trash</v-icon>
                      </v-btn>
                       <v-btn icon :to="{name:'rawat-jalan-detail'}">
                        <v-icon small>far fa-pencil</v-icon>
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
        <!-- tabel -->
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