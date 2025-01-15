export default {
    template: `
    <div id="gotopspace" :class="{visible:active}">
    <a href="#" id="gotop">
        <i class="fa-solid fa-angles-up fa-2xl"></i>
        <span>TOP</span>
    </a>
    </div>
    `,
    data() {
        return {
            active: false,
        };
    },
    methods: {
        handleScroll() {
            this.active = document.body.scrollTop > 100 || document.documentElement.scrollTop > 100;
        },
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.handleScroll);
    },
}