<template>
	<modal name="new-project" classes="p-8 bg-card rounded-lg" height="auto">
            <h1 class="text-center mb-8 text-xl font-normal">Create a New Project</h1>
            <div class="flex">
                <div class="flex-1 mr-4">                  
                     <div class="field mb-6">
					    <label class="block text-sm mb-2" for="title">Title</label>
					    <input type="text" 
					    	id="title"
					    	name="title"
					    	class="shadow appearance-none border rounded w-full p-2 leading-tight focus:outline-none focus:shadow-outline"
					    	:class="form.errors.has('title') ? 'border-error' : 'border-muted-light' "
					    	v-model="form.title">
					    <span 
					    	class="text-center text-xs font-normal text-error"
					    	v-if="form.errors.has('title')"
					    	v-text="form.errors.get('title')">
					    </span>
					</div>
					<div class="field mb-6">
					    <label class="block text-sm mb-2" for="description">Description</label>
					    <textarea rows="10"
					    	class="shadow appearance-none border rounded w-full p-2 border-muted-light leading-tight focus:outline-none focus:shadow-outline"
					    	:class="form.errors.has('description') ? 'border-error' : 'border-muted-light' "
					    	id="description"
					    	name="description"
					    	v-model="form.description"></textarea>
					    <span 
					    	class="text-center text-xs font-normal text-error"
					    	v-if="form.errors.has('description')"
					    	v-text="form.errors.get('description')">
					    </span>
					</div>            
                </div>
                <div class="flex-1 ml-4">
                    <div class="field mb-6">
                        <label class="block text-sm mb-2">Add new tasks</label>
                        <input type="text" 
                        	class="shadow appearance-none border rounded w-full p-2 mb-4 border-muted-light leading-tight focus:outline-none focus:shadow-outline" 
                        	placeholder="New task"
                        	v-for="task in form.tasks"
                        	v-model="task.body">             
                    </div>
                    <a href="" @click.prevent="addTaskField">Add new task field</a>
                </div>
                
            </div>
            <div class="field flex justify-end items-baseline">
                    <button @click.prevent="submit" type="submit" class="button mr-2">Create</button>
                    <a href="" @click.prevent = "hide">Cancel</a>
            </div> 
    </modal>
</template>

<script>
	export default {
		data() {
			return {				
				form : new Form ({
					title: '',
					description: '',
					tasks: [
						{body: ''},
					],
				}),
			}
		},

		methods: {

		
			addTaskField() {
				this.form.tasks.push({body: ''});
			},

			show() {
				this.$modal.show('new-project');
			},

			hide() {
				this.$modal.hide('new-project');
				this.form.reset();
			},

			submit() {

				this.form.post('/projects')
					.then(response => {
						this.hide;
						location = response.data.redirect
					});
				
			}

		}

	}
</script>