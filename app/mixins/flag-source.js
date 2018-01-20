
const FLAG_PATH = '/packages/bixie/languagemanager/assets/flags';

export default {

    data: () => ({
        languages: {},
    }),

    methods: {
        getFlagSource(language) {
            if (this.languages[language] && this.languages[language].flag) {
                return this.$url(FLAG_PATH + '/' + this.languages[language].flag);
            }
            return '';
        },
    },

    computed: {
        flag_path() {
            return FLAG_PATH;
        },
    },

};