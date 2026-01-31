import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi'
const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',  // This makes mdi- prefixes work globally
    aliases,
    sets: {
      mdi,
    },
  },
})

export default vuetify