import Vue from 'vue'
import Vuetify from 'vuetify'
// import Vuetify from 'vuetify/lib'
import 'vuetify/dist/vuetify.min.css'
import preset from './vuetify/default-preset/preset'

Vue.use(Vuetify)

export default new Vuetify({
  preset,
  icons: {
    iconfont: 'mdiSvg',
  },
  theme: {
    options: {
      customProperties: true,
      variations: false,
    },
  },
})
