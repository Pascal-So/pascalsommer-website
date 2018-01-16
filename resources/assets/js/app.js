require('./bootstrap');

require('./deleteConfirmer');

window.Vue = require('vue');

import PhotoSelector from './components/PhotoSelector';

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
    el: '#photo-selector',
    template: '<PhotoSelector/>',
    components: { PhotoSelector }
});
