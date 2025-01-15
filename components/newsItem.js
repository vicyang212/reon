export default {
    template: `
    <div class="news-item">
        <a :href="href" style="display: block;">
            <div>
                <img :src="src" class="news-item-img">
            </div>
            <div class="news-item-body" v-html="content">
            </div>
        </a>
    </div>
    `,
    props:{
        href:String,
        src:String,
        content:String
    }
}



