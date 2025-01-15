import newsItem from "./newsItem.js";

export default {
    components: {
        newsItem
    },
    template: `
    <div class="news-list">
        <newsItem 
        v-for="news in news"
        :href="news.href"
        :src="news.img"
        :content="news.content"
        >
        </newsItem>
    </div>
    `,
    data() {
        return {
            news: [
                { img: "images/room.jpg", content: "勤美門市即將開幕！延續REON活潑風格！<br>2024/08/22", href:"#"},
                { img: "images/50percentoff.jpg", content: "慶祝REON五歲了！多樣商品五折優惠！<br>2024/08/19", href:"#" },
                { img: "images/news3.jpg", content: "LENS TOWN進駐REON啦！多款系列任挑！<br>2024/07/30", href:"#" }
            ]
        }
    },
}
