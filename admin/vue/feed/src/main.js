import { createApp } from 'vue'
import BVNodeFeed from './BVNodeFeed.vue'

Array.from(document.querySelectorAll('[data-bvnode-feed]')).forEach((feed) => {
    createApp(BVNodeFeed, {
        "feed_url": feed.getAttribute('data-bvnode-feed'),
        "plugin_url": feed.getAttribute('data-bvnode-plugin')
    }).mount(feed);
})


