<template>
    <div class="app-content-container boxed-container pa-6">
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
                        <v-icon>fad fa-pencil</v-icon>
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