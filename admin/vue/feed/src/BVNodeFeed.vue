<template>
<div v-if="Object.keys(this.posts).length == 0">
					
<svg class="bvnode-loader" version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
  viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
  <circle fill="#3bb3e8" stroke="none" cx="6" cy="50" r="6">
    <animate
      attributeName="opacity"
      dur="1s"
      values="0;1;0"
      repeatCount="indefinite"
      begin="0.1"/>    
  </circle>
  <circle fill="#3bb3e8" stroke="none" cx="26" cy="50" r="6">
    <animate
      attributeName="opacity"
      dur="1s"
      values="0;1;0"
      repeatCount="indefinite" 
      begin="0.2"/>       
  </circle>
  <circle fill="#3bb3e8" stroke="none" cx="46" cy="50" r="6">
    <animate
      attributeName="opacity"
      dur="1s"
      values="0;1;0"
      repeatCount="indefinite" 
      begin="0.3"/>     
  </circle>
</svg>
	</div>
				<article class="feed__item" v-for="post in this.posts" :key="post.title.rendered">
						<a  class="feed__item-link" :href="post.link" target="_blank">
							<img class="feed__item-thumb" :src="plugin_url + post.featured_image" />
							<span class="feed__item-title">{{post.title.rendered}}</span>
						</a>
					</article>
				
</template>

<script>
  
  export default {
    name: 'BVNodeFeed',
    props: ['feed_url', 'plugin_url'],
    components: {
    },
								data() {
									return {
										posts: []
									}
								},
								methods: {
								},
								created() {
									fetch(this.feed_url)
									.then(response => response.json())
									.then(response => {
										if (response.data) {
											this.posts = response.data
										}
										
										}, error => {
										console.log(error);
									})
								},
								setup() {
								
								return {
									
								}
								}
  }
</script>

<style>
</style>
