import { bootstrap, Vue, Sidebar, Navigation} from './app';

const app = new Vue({
    el: '#app',
    data: {
        message: 'Привет, Vue!'
    },
    delimiters: ['{[',']}'],
    components: { Navigation, Sidebar }
});

export { app, Vue };