    <!-- boostrap -->
    <script type="text/javascript" src="plugin/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <!-- jqery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- 行動版選單 -->
    <script src="./navbar-mobile.js"></script>

    <script type="module">
        import gotopbtn from "./components/gotopbtn.js";
        import contact_modal from "./components/contact_modal.js";
        import newslist from "./components/newslist.js";

        Vue.createApp(gotopbtn).mount('#gotopbtn');
        Vue.createApp(contact_modal).mount('#contact_modal');
        Vue.createApp(newslist).mount('#newslist');
    </script>

