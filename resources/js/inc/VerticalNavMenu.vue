<template>
  <v-navigation-drawer
    :value="isDrawerOpen"
    app
    floating
    width="260"
    class="app-navigation-menu"
    :right="$vuetify.rtl"
    @input="(val) => $emit('update:is-drawer-open', val)"
  >
    <!-- Navigation Header -->
    <div class="vertical-nav-header d-flex items-center ps-6 pe-5 pt-5 pb-2">
      <router-link to="/" class="d-flex align-center text-decoration-none">
        <v-img
          src="/assets/images/logos/logo.svg"
          max-height="30px"
          max-width="30px"
          alt="logo"
          contain
          eager
          class="app-logo me-3"
        ></v-img>
        <v-slide-x-transition>
          <h2 class="app-title text--primary">MATERIO</h2>
        </v-slide-x-transition>
      </router-link>
    </div>

    <!-- Navigation Items -->
    <v-list
      v-for="module in modules"
      :key="module.name"
      expand
      shaped
      class="vertical-nav-menu-items pr-5"
    >
      <nav-menu-link
        v-if="!module.is_parent && module.parent_id == 0"
        :title="module.name"
        :to="{ path: module.path }"
        :icon="module.icon"
      ></nav-menu-link>

      <nav-menu-group
        v-else-if="module.is_parent && module.parent_id == 0"
        small
        :title="module.name"
        :icon="module.icon"
      >
        <div v-for="childs in modules" :key="childs.name">
          <nav-menu-link
            v-if="
              childs.parent_id != 0 &&
              childs.parent_id == module.id &&
              !childs.is_parent
            "
            :title="`${childs.name}`"
            :to="{ path: childs.path }"
          ></nav-menu-link>
          <nav-menu-group
            v-else-if="childs.parent_id == module.id && childs.is_parent"
            small
            :title="childs.name"
            :icon="childs.icon"
          >
            <div v-for="child in modules" :key="child.name">
              <nav-menu-link
                v-if="
                  child.parent_id != 0 &&
                  child.parent_id == childs.id &&
                  !child.is_parent
                "
                :title="`${child.name}`"
                :to="{ path: child.path }"
              ></nav-menu-link>
            </div>
          </nav-menu-group>
        </div>
      </nav-menu-group>
    </v-list>
    <!-- <v-list expand shaped class="vertical-nav-menu-items pr-5">
      <nav-menu-link
        title="Dashboard"
        :to="{ name: 'dashboard' }"
        icon="far fa-home"
      ></nav-menu-link>

      <nav-menu-section-title title="MAIN NAVIGATOR"></nav-menu-section-title>
      <nav-menu-group
        small
        title="Daftar Kunjungan"
        :icon="icons.mdiFileOutline"
      >
        <nav-menu-link
          title="Rawat Jalan"
          :to="{ name: 'rawat-jalan' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Rawat Inap"
          :to="{ name: 'rawat-inap' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Rawat Darurat (IGD)"
          :to="{ name: 'rawat-darurat' }"
        ></nav-menu-link>
      </nav-menu-group>

      <nav-menu-group title="Keuangan" :icon="icons.mdiFileOutline">
        <nav-menu-link
          title="Kasir Umum"
          :to="{ name: 'keuangan' }"
        ></nav-menu-link>
      </nav-menu-group>

      <nav-menu-group title="Registrasi" :icon="icons.mdiFileOutline">
        <nav-menu-link
          title="Reg. Rawat Jalan"
          :to="{ name: 'reg-rawat-jalan' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Reg. Rawat Inap"
          :to="{ name: 'reg-rawat-inap' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Reg. Rawat Darurat"
          :to="{ name: 'reg-rawat-darurat' }"
        ></nav-menu-link>
      </nav-menu-group>

      <nav-menu-group title="Penunjang" :icon="icons.mdiFileOutline">
        <nav-menu-link
          title="Laboratorium"
          :to="{ name: 'laboratorium' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Radiologi"
          :to="{ name: 'radiologi' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Operasi"
          :to="{ name: 'operasi' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Insenerator"
          :to="{ name: 'insenerator' }"
        ></nav-menu-link>
        <nav-menu-link title="UTDRS" :to="{ name: 'utdrs' }"></nav-menu-link>
        <nav-menu-link
          title="Kamar Jenazah"
          :to="{ name: 'kamar-jenazah' }"
        ></nav-menu-link>
      </nav-menu-group>

      <nav-menu-group title="Farmasi & Logsistik" :icon="icons.mdiFileOutline">
        <nav-menu-link
          title="Apotek"
          :to="{ name: 'user-management' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Logistik"
          :to="{ name: 'rawat-inap' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Stock"
          :to="{ name: 'roles-management' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Suplier"
          :to="{ name: 'roles-management' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Penerimaan"
          :to="{ name: 'roles-management' }"
        ></nav-menu-link>
      </nav-menu-group>

      <nav-menu-section-title title="ADMIN AREA"></nav-menu-section-title>
      <nav-menu-link
        title="Daftar Pasien"
        :icon="icons.mdiFileOutline"
        :to="{ name: 'daftar-pasien' }"
      ></nav-menu-link>
      <nav-menu-group title="Daftar Pegawai" :icon="icons.mdiFileOutline">
        <nav-menu-link
          title="Daftar Pegawai"
          :to="{ name: 'daftar-pegawai' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Jabatan"
          :to="{ name: 'jabatan' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Kategori Kualifikasi"
          :to="{ name: 'kategori-kualifikasi' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Kualifikasi"
          :to="{ name: 'kualifikasi' }"
        ></nav-menu-link>
      </nav-menu-group>
      <nav-menu-link
        title="Daftar Tarif"
        :icon="icons.mdiFileOutline"
        :to="{ name: 'tarif' }"
      ></nav-menu-link>

      <nav-menu-group title="Poliklinik/Ruangan" :icon="icons.mdiFileOutline">
        <nav-menu-link
          title="Poliklinik"
          :to="{ name: 'poliklinik' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Ruangan"
          :to="{ name: 'ruangan' }"
        ></nav-menu-link>
        <nav-menu-link title="Kamar" :to="{ name: 'kamar' }"></nav-menu-link>
        <nav-menu-link
          title="Ranjang"
          :to="{ name: 'ranjang' }"
        ></nav-menu-link>
      </nav-menu-group>

      <nav-menu-group title="Master Data" :icon="icons.mdiFileOutline">
        <nav-menu-link
          title="Daftar Agama"
          :to="{ name: 'daftar-agama' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Cara Pembayaran"
          :to="{ name: 'daftar-cara-pembayaran' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Gizi"
          :to="{ name: 'daftar-gizi' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Insenerator"
          :to="{ name: 'daftar-insenerator' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Kasus"
          :to="{ name: 'daftar-kasus' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Kegiatan"
          :to="{ name: 'daftar-kegiatan' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Oksigen"
          :to="{ name: 'daftar-oksigen' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Pekerjaan"
          :to="{ name: 'daftar-pekerjaan' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Pemeriksaan Jenazah"
          :to="{ name: 'daftar-pemeriksaan-jenazah' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Pemeriksaan Umum"
          :to="{ name: 'daftar-pemeriksaan-umum' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Pendidikan"
          :to="{ name: 'daftar-pendidikan' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Perawatan Khusus"
          :to="{ name: 'daftar-perawatan-khusus' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Penyakit"
          :to="{ name: 'daftar-penyakit' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Prosedure"
          :to="{ name: 'daftar-prosedure' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Suku"
          :to="{ name: 'daftar-suku' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Tindakan"
          :to="{ name: 'daftar-tindakan' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Tindakan Operasi"
          :to="{ name: 'daftar-tindakan-operasi' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Type Diagnosa"
          :to="{ name: 'daftar-type-diagnosa' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar UTDRS"
          :to="{ name: 'daftar-utdrs' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Wilayah"
          :to="{ name: 'roles-management' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Identitas"
          :to="{ name: 'daftar-identitas' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Laundry"
          :to="{ name: 'daftar-laundry' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Logistik"
          :to="{ name: 'daftar-logistik' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Poliklinik"
          :to="{ name: 'daftar-poliklinik' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Registrasi"
          :to="{ name: 'daftar-registrasi' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Daftar Rujukan"
          :to="{ name: 'daftar-rujukan' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Jenis Visite"
          :to="{ name: 'jenis-visite' }"
        ></nav-menu-link>
      </nav-menu-group>

      <nav-menu-section-title title="SYSTEM"></nav-menu-section-title>
      <nav-menu-group title="System" icon="far fa-cogs">
        <nav-menu-link
          title="User Management"
          :to="{ name: 'user-management' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Role Management"
          :to="{ name: 'roles-management' }"
        ></nav-menu-link>
        <nav-menu-link
          title="Menu Management"
          :to="{ name: 'menu-management' }"
        ></nav-menu-link>
      </nav-menu-group>
    </v-list> -->
  </v-navigation-drawer>
</template>

<script>
import { mdiHomeOutline, mdiFileOutline } from "@mdi/js";

export default {
  props: {
    isDrawerOpen: false,
    modules: [],
  },
  setup() {
    return {
      icons: {
        mdiHomeOutline,
        mdiFileOutline,
      },
    };
  },
};
</script>

<style lang="scss" scoped>
// @import '~vuetify/src/styles/styles.sass';
@import "./resources/js/plugins/vuetify/default-preset/preset/variables.scss";

.app-title {
  font-size: 1.25rem;
  font-weight: 700;
  font-stretch: normal;
  font-style: normal;
  line-height: normal;
  letter-spacing: 0.3px;
}

// ? Adjust this `translateX` value to keep logo in center when vertical nav menu is collapsed (Value depends on your logo)
.app-logo {
  transition: all 0.18s ease-in-out;
  .v-navigation-drawer--mini-variant & {
    transform: translateX(-4px);
  }
}

@include theme(app-navigation-menu) using ($material) {
  background-color: map-deep-get($material, "background");
}

.app-navigation-menu {
  .v-list-item {
    &.vertical-nav-menu-link {
      ::v-deep .v-list-item__icon {
        .v-icon {
          transition: none !important;
        }
      }
    }
  }
}

// You can remove below style
// Upgrade Banner
.app-navigation-menu {
  .upgrade-banner {
    position: absolute;
    bottom: 13px;
    left: 50%;
    transform: translateX(-50%);
  }
}
</style>
