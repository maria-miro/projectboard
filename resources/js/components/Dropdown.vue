<template>
	<div class="dropdown relative">

		<div @click="toggle">		
			<slot name="trigger"></slot>
		</div>
		
		<div class="dropdown-menu card absolute right-0 w-full flex flex-col items-end mt-2" v-if="isOpen" >
			<slot></slot>
		</div>	

	</div>
</template>	

<script>
	export default {
		data() {
			
			return {
				isOpen: false,
			};
		},

		methods: {
			toggle() {
				this.isOpen = !this.isOpen;
			}
		}
	}
</script>